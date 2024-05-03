<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $query = trim($request->get('search'));

            // Cambio la consulta para usar un builder de consultas
            $sales = DB::table('sales as s')
                ->join('customers as c', 's.customer_id', '=', 'c.id')
                ->join('sale_details as sade', 'sade.sale_id', '=', 's.id')
                ->select('s.id', 's.date_time', 'c.name', 's.proof_type', 's.proof_number', 's.tax_fee', 's.status', 's.sale_total')
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('s.proof_number', 'LIKE', '%' . $query . '%')
                        ->orWhere('s.proof_type', 'LIKE', '%' . $query . '%')
                        ->orWhere('c.name', 'LIKE', '%' . $query . '%')
                        ->orWhereDate('s.date_time', '=', $query); // Buscar por fecha
                })
                ->groupBy('s.id', 's.date_time', 'c.name', 's.proof_type', 's.proof_number', 's.tax_fee', 'sale_total', 's.status')
                ->orderBy('s.id', 'desc')
                ->paginate(5);

            return view('sales.index', ["incomes" => $sales, "search" => $query]);
        } else {
            // Si no hay parámetro de búsqueda, simplemente obtener todos los ingresos
            $sales = DB::table('sales as s')
                ->join('customers as c', 's.customer_id', '=', 'c.id')
                ->join('sale_details as sade', 'sade.sale_id', '=', 's.id')
                ->select('s.id', 's.date_time', 'c.name', 's.proof_type', 's.proof_number', 's.tax_fee', 's.status', 's.sale_total')
                ->groupBy('s.id', 's.date_time', 'c.name', 's.proof_type', 's.proof_number', 's.tax_fee', 'sale_total', 's.status')
                ->orderBy('s.id', 'desc')
                ->paginate(5);

            return view('sales.index', ["sales" => $sales]);
        }
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
                DB::raw('avg(inde.sale_price) as avg_price')
            )
            ->leftJoin('income_details as inde', 'inde.product_id', '=', 'prod.id')
            ->where('prod.status', '=', 'Available')
            ->where('prod.stock', '>', '0')
            ->groupBy('Product', 'prod.id', 'prod.stock')
            ->get();

        foreach ($products as $product) {
            $product->income_details = DB::table('income_details')
                ->where('product_id', $product->id)
                ->get();
        }

        return view("sales.insert", ["customers" => $customers, "products" => $products]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $sales = new Sale;
            $sales->customer_id = $request->get('customer_id');
            $sales->proof_type = $request->get('proof_type');
            $sales->proof_number = $request->get('proof_number');
            $sales->date_time = Carbon::now('America/Guayaquil')->toDateTimeString();
            $sales->tax_fee = '12';
            $sales->status = 'Successful';

            $sales->save();

            $product_id = $request->get('idArticle');
            $cant = $request->get('cant');
            $sale_price = $request->get('sale_price');
            $discount = $request->get('discount');

            $cont = 0;

            while ($cont < count($product_id)) {
                $details = new SaleDetail();
                $details->sale_id = $sales->id;
                $details->product_id = $product_id[$cont];
                $details->cant = $cant[$cont];
                $details->sale_price = $sale_price[$cont];
                $details->discount = $discount[$cont];
                $details->save();

                // Actualizar el stock de productos
                $product = Product::find($product_id[$cont]);
                $product->stock -= $cant[$cont];
                $product->save();

                $cont++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        return redirect()->route('sales.index')->with('success', 'Sale closeout successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sales = DB::table('sales as s')
            ->join('customers as c', 's.customer_id', '=', 'c.id')
            ->join('sale_details as sade', 'sade.sale_id', '=', 's.id')
            ->select('s.id', 's.date_time', 'c.name', 's.payment_proof', 's.proof_number', 's.tax_fee', 's.status', 's.sale_total')
            ->where('i.id', '=', $id)
            ->groupBy('s.id', 's.date_time', 'c.name', 's.payment_proof', 's.proof_number', 's.tax_fee', 's.status')
            ->orderBy('s.id', 'desc')
            ->first();

        $details = DB::table('sale_details as sade')
            ->join('products as prod', 'sade.product_id', '=', 'prod.id') // Corregir la columna de join
            ->select('prod.title as product', 'sade.cant', 'sade.sale_price', 'sade.discount')
            ->where('sade.sale_id', '=', $id)
            ->get();

        return view('sales.details', ["sale" => $sales, "details" => $details]);
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
}
