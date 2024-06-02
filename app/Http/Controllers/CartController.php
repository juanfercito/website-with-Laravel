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
        $cart = session()->get('cart', []);

        // Debugging
        Log::info('Request ID: ' . $request->id);
        Log::info('Cart before removal: ' . print_r($cart, true));

        foreach ($cart as $key => $item) {
            if ($item['id'] == $request->id) {
                unset($cart[$key]);
                break;
            }
        }

        session()->put('cart', array_values($cart)); // Reindex the array

        // Debugging
        Log::info('Cart after removal: ' . print_r($cart, true));

        return redirect()->back()->with('success', 'Product removed from cart');
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

            // Verificar si el cliente ya existe en la base de datos, de lo contrario, crear un nuevo cliente
            $customer = Customer::where('dni', $dni)->first();
            if (!$customer) {
                $customer = new Customer;
                $customer->dni = $dni;
                $customer->name = $name;
                $customer->email = $email;
                $customer->telephone = $telephone;
                $customer->save();
            }

            // Calcular el subtotal, el descuento total y el total de la venta
            $subtotal = 0;
            $totalDiscount = 0;

            $cart = session()->get('cart', []);
            $incomeDetails = []; // Definimos la variable $incomeDetails

            foreach ($cart as $product) {
                $incomeDetail = $incomeDetails[$product['id']] ?? null;
                if ($incomeDetail) {
                    $productTotal = $product['quantity'] * $incomeDetail->sale_price;
                    $subtotal += $productTotal;
                }
            }

            $totalQuantity = array_sum(array_column($cart, 'quantity'));
            $discount = 0;
            if ($totalQuantity >= 5 && $totalQuantity <= 10) {
                $discount = 5;
            } elseif ($totalQuantity > 10 && $totalQuantity <= 20) {
                $discount = 10;
            } elseif ($totalQuantity > 20) {
                $discount = 15;
            }
            $totalDiscount = ($subtotal * $discount) / 100;
            $saleTotal = $subtotal - $totalDiscount;

            // Crear una nueva venta
            $sale = new Sale;
            $sale->customer_id = $customer->id;
            $sale->proof_type = $request->input('proof_type');
            $sale->proof_number = $request->input('proof_number');
            $sale->date_time = Carbon::now('America/Guayaquil')->toDateTimeString();
            $sale->tax_fee = 12;
            $sale->status = 'Successful';
            $sale->sale_total = $saleTotal;
            $sale->save();

            // Guardar los detalles de la venta y actualizar el stock de productos
            foreach ($cart as $product) {
                $incomeDetail = $incomeDetails[$product['id']] ?? null;
                if ($incomeDetail) {
                    $details = new SaleDetail();
                    $details->sale_id = $sale->id;
                    $details->product_id = $product['id'];
                    $details->cant = $product['quantity'];
                    $details->discount = ($product['quantity'] * $incomeDetail->sale_price * $discount) / 100;
                    $details->sale_price = $incomeDetail->sale_price;
                    $details->save();

                    // Actualizar el stock del producto
                    $productModel = Product::find($product['id']);
                    if ($productModel) {
                        $productModel->stock -= $product['quantity'];
                        $productModel->save();
                    }
                }
            }

            DB::commit();

            // Limpiar el carrito
            session()->forget('cart');

            // Mostrar el modal de éxito
            return redirect()->route('main.shoppingCart')->with('success', 'Venta realizada con éxito');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al realizar la compra: ' . $e->getMessage());
        }
    }
}
