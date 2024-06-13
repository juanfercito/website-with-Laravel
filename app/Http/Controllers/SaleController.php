<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SaleController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:watch-sales|insert-sale|modify-sale|delete-sale', ['only' => ['index']]);
        $this->middleware('permission:insert-sale', ['only' => ['create', 'store']]);
        $this->middleware('permission:modify-sale', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-sale', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');
        $sales = Sale::where(function ($q) use ($query) {
            $q->where('customer_id', 'like', "%$query%")
                ->orWhere('proof_type', 'like', "%$query%")
                ->orWhere('proof_number', 'like', "%$query%")
                ->orWhere('date_time', 'like', "%$query%");
        })
            ->paginate(7);
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = DB::table('customers')->get();

        $products = DB::table('products as prod')
            ->select(
                DB::raw('CONCAT(prod.id, " ", prod.title) AS Product'),
                'prod.id',
                'prod.stock',
                DB::raw('ROUND(avg(sade.sale_price), 2) as avg_price')
            )
            ->leftJoin('income_details as sade', 'sade.product_id', '=', 'prod.id')
            ->where('prod.status', '=', 'Available')
            ->where('prod.stock', '>', '0')
            ->groupBy('Product', 'prod.id', 'prod.stock')
            ->get();

        return view("sales.insert", ["customers" => $customers, "products" => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

            foreach ($request->cant as $key => $value) {
                $subtotal += $value * $request->sale_price[$key];
                $totalDiscount += $value * $request->discount[$key];
            }

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
            $product_id = $request->get('idArticle');
            $cant = $request->get('cant');
            $discount = $request->get('discount');
            $sale_price = $request->get('sale_price');

            $cont = 0;

            while ($cont < count($product_id)) {
                $details = new SaleDetail();
                $details->sale_id = $sale->id;
                $details->product_id = $product_id[$cont];
                $details->cant = $cant[$cont];
                $details->discount = $discount[$cont];
                $details->sale_price = $sale_price[$cont];
                $details->save();
                $cont = $cont + 1;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        return redirect()->route('sales.index')->with('success', 'Venta realizada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sales = DB::table('sales as s')
            ->join('customers as c', 's.customer_id', '=', 'c.id')
            ->join('sale_details as sade', 'sade.sale_id', '=', 's.id')
            ->select('s.id', 's.date_time', 'c.name', 's.proof_type', 's.proof_number', 's.tax_fee', 's.status', 's.sale_total')
            ->where('s.id', '=', $id)
            ->groupBy('s.id', 's.date_time', 'c.name', 's.proof_type', 's.proof_number', 's.tax_fee', 's.sale_total', 's.status')
            ->first();

        $details = DB::table('sale_details as sade')
            ->join('products as prod', 'sade.product_id', '=', 'prod.id') // Corregir la columna de join
            ->select('prod.title as product', 'sade.cant', 'sade.sale_price', 'sade.discount')
            ->where('sade.sale_id', '=', $id)
            ->get();

        return view('sales.details', ["sales" => $sales, "details" => $details]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->saleDetails()->delete();
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'sale deleted successfully');
    }

    /*
     *  cancel the specified resource of sale
     */
    public function cancel($id)
    {
        try {
            $sale = sale::findOrFail($id);
            $sale->status = 'cancelled';
            $sale->save();

            return redirect()->route('sales.index')->with('success', 'sale cancelled successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error cancelling sale: ' . $e->getMessage());
        }
    }

    /* Other functions for Products */
    public function searchCustomer(Request $request)
    {
        $dni = $request->get('dni');
        $customer = Customer::where('dni', $dni)->first();

        if ($customer) {
            return response()->json(['success' => true, 'customer' => $customer]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function productDetails($id)
    {
        $product = Product::findOrFail($id);
        return view('main.productDetails', compact('product'));
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Lógica para agregar el producto al carrito.
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $product = Product::find($productId);
            $cart[$productId] = [
                "title" => $product->title,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        session()->put('cart', $cart);

        return redirect()->route('product.details', $productId)->with('success', 'Producto agregado al carrito');
    }
}
