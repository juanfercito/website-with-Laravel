<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\IncomeDetail;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use App\Services\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productData = $request->only(['id', 'title', 'sale_price', 'cant']);

        Cart::add($productData);

        return redirect()->back()->with('success', 'Product ' . $productData['title'] . ' added to cart');
    }


    public function getCartCount()
    {
        return response()->json(['count' => Cart::count()]);
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        $productIds = array_column($cart, 'id');

        // Recupera los detalles de ingresos basados en los IDs de los productos en el carrito
        $incomeDetails = IncomeDetail::whereIn('product_id', $productIds)->get()->keyBy('product_id');

        // Recupera todos los customers
        $customers = DB::table('customers')->get();

        //dd($customers, $cart, $incomeDetails);
        return view('main.shoppingCart', [
            'cart' => $cart,
            'incomeDetails' => $incomeDetails,
            'customers' => $customers
        ]);
    }


    public function removeFromCart(Request $request)
    {
        $productId = $request->input('rmRow');
        if (isset($productId)) {
            Cart::remove($productId);
            return redirect()->back()->with('success', 'Product deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Could not delete product');
        }
    }
    public function clearCart()
    {
        session()->forget('cart');

        return redirect()->back()->with('success', 'Cart cleared successfully');
    }

    public function searchByDni(Request $request)
    {
        $dni = $request->get('dni');
        $customer = Customer::where('dni', $dni)->first();

        if ($customer) {
            return response()->json(['success' => true, 'name' => $customer->name, 'email' => $customer->email, 'telephone' => $customer->telephone]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function savePurchase(Request $request)
    {
        try {
            DB::beginTransaction();

            // Obtener los datos del cliente del formulario
            $dni = $request->input('dni');
            $name = $request->input('customer_name');
            $email = $request->input('email');
            $telephone = $request->input('telephone');

            // Verificar si alguno de los campos del cliente está vacío
            if (empty($dni) || empty($name) || empty($email) || empty($telephone)) {
                return redirect()->back()->with('error', 'Por favor, complete todos los campos del cliente.');
            }

            $customer = Customer::where('dni', $dni)->first();
            if (!$customer) {
                $customer = new Customer;
                $customer->dni = $dni;
                $customer->name = $name;
                $customer->email = $email;
                $customer->telephone = $telephone;
                $customer->save();
            }

            $subtotal = 0;
            $totalDiscount = 0;

            $productIds = $request->input('idArticle');
            $quantities = $request->input('quantity');
            $salePrices = $request->input('sale_price');
            $discountAmounts = $request->input('discountAmount');

            foreach ($productIds as $key => $productId) {
                $subtotal += $quantities[$key] * $salePrices[$key];
            }

            $discountPercentage = 0;
            $totalQuantity = array_sum($quantities);
            if ($totalQuantity >= 5 && $totalQuantity <= 10) {
                $discountPercentage = 5;
            } elseif ($totalQuantity > 10 && $totalQuantity <= 20) {
                $discountPercentage = 10;
            } elseif ($totalQuantity > 20) {
                $discountPercentage = 15;
            }
            $totalDiscount = ($subtotal * $discountPercentage) / 100;

            $saleTotal = $subtotal - $totalDiscount;

            $sale = new Sale;
            $sale->customer_id = $customer->id;
            $sale->proof_type = $request->input('proof_type');
            $sale->proof_number = $request->input('proof_number');
            $sale->date_time = Carbon::now('America/Guayaquil')->toDateTimeString();
            $sale->tax_fee = 12;
            $sale->status = 'Successful';
            $sale->sale_total = $saleTotal;
            $sale->save();

            foreach ($productIds as $key => $productId) {
                $details = new SaleDetail();
                $details->sale_id = $sale->id;
                $details->product_id = $productId;
                $details->cant = $quantities[$key];
                $details->discount = ($salePrices[$key] * $discountPercentage) / 100;
                $details->sale_price = $salePrices[$key];
                $details->save();

                $product = Product::find($productId);
                if ($product) {
                    $product->stock -= $quantities[$key];
                    $product->save();
                }
            }

            session()->forget('cart');

            DB::commit();
            return redirect()->back()->with('success', 'Venta realizada con éxito');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
