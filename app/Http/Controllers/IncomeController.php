<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Income;
use App\Models\IncomeDetail;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\Response;

class IncomeController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:watch-incomes|insert-income|modify-income|delete-income', ['only' => ['index']]);
        $this->middleware('permission:insert-income', ['only' => ['create', 'store']]);
        $this->middleware('permission:modify-income', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-income', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $query = trim($request->get('search'));

            // Cambio la consulta para usar un builder de consultas
            $incomes = DB::table('incomes as i')
                ->join('providers as p', 'i.provider_id', '=', 'p.id')
                ->join('income_details as inde', 'inde.income_id', '=', 'i.id')
                ->select('i.id', 'i.date_time', 'p.name', 'i.payment_proof', 'i.proof_number', 'i.fee_tax', 'i.status', DB::raw('sum(inde.cant*inde.purchase_price) as total'))
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('i.proof_number', 'LIKE', '%' . $query . '%')
                        ->orWhere('i.payment_proof', 'LIKE', '%' . $query . '%')
                        ->orWhere('p.name', 'LIKE', '%' . $query . '%')
                        ->orWhereDate('i.date_time', '=', $query); // Buscar por fecha
                })
                ->groupBy('i.id', 'i.date_time', 'p.name', 'i.payment_proof', 'i.proof_number', 'i.fee_tax', 'i.status')
                ->orderBy('i.id', 'desc')
                ->paginate(5);

            return view('incomes.index', ["incomes" => $incomes, "search" => $query]);
        } else {
            // Si no hay parámetro de búsqueda, simplemente obtener todos los ingresos
            $incomes = DB::table('incomes as i')
                ->join('providers as p', 'i.provider_id', '=', 'p.id')
                ->join('income_details as inde', 'inde.income_id', '=', 'i.id')
                ->select('i.id', 'i.date_time', 'p.name', 'i.payment_proof', 'i.proof_number', 'i.fee_tax', 'i.status', DB::raw('sum(inde.cant*inde.purchase_price) as total'))
                ->groupBy('i.id', 'i.date_time', 'p.name', 'i.payment_proof', 'i.proof_number', 'i.fee_tax', 'i.status')
                ->orderBy('i.id', 'desc')
                ->paginate(5);

            return view('incomes.index', ["incomes" => $incomes]);
        }
    }

    /**
     * Create a new resource in storage.
     */
    public function create()
    {
        $providers = DB::table('providers')->get();
        $incomes = Income::all();

        $products = DB::table('products as prod')
            ->select(DB::raw('CONCAT(prod.id, " ", prod.title) AS Product'), 'prod.id', 'prod.stock')
            ->get();

        return view("incomes.insert", ["providers" => $providers, "products" => $products, "incomes" => $incomes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $incomes = new Income;
            $incomes->provider_id = $request->get('provider_id');
            $incomes->payment_proof = $request->get('payment_proof');
            $incomes->proof_number = $request->get('proof_number');
            $incomes->date_time = Carbon::now('America/Guayaquil')->toDateTimeString();
            $incomes->fee_tax = '12';
            $incomes->status = 'Incoming';

            $incomes->save();

            $product_id = $request->get('idArticle');
            $cant = $request->get('cant');
            $purchase_price = $request->get('purchase_price');
            $sale_price = $request->get('sale_price');

            $cont = 0;

            while ($cont < count($product_id)) {
                $details = new IncomeDetail();
                $details->income_id = $incomes->id;
                $details->product_id = $product_id[$cont];
                $details->cant = $cant[$cont];
                $details->purchase_price = $purchase_price[$cont];
                $details->sale_price = $sale_price[$cont];
                $details->save();

                // Actualizar el stock de productos
                $product = Product::find($product_id[$cont]);
                $product->stock += $cant[$cont];
                $product->save();

                $cont++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        return redirect()->route('incomes.index')->with('success', 'Income created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $income = DB::table('incomes as i')
            ->join('providers as p', 'i.provider_id', '=', 'p.id') // Corregir la columna de join
            ->join('income_details as inde', 'i.id', '=', 'inde.income_id')
            ->select('i.id', 'i.date_time', 'p.name', 'i.payment_proof', 'i.proof_number', 'i.fee_tax', 'i.status', DB::raw('sum(inde.cant * inde.purchase_price) as total'))
            ->where('i.id', '=', $id)
            ->groupBy('i.id', 'i.date_time', 'p.name', 'i.payment_proof', 'i.proof_number', 'i.fee_tax', 'i.status') // Incluir p.name en el GROUP BY
            ->orderBy('i.id', 'desc')
            ->first();

        $details = DB::table('income_details as inde')
            ->join('products as prod', 'inde.product_id', '=', 'prod.id') // Corregir la columna de join
            ->select('prod.title as product', 'inde.cant', 'inde.purchase_price', 'inde.sale_price')
            ->where('inde.income_id', '=', $id)
            ->get();

        return view('incomes.details', ["income" => $income, "details" => $details]);
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
    public function destroy(Income $income)
    {
        $income->incomeDetails()->delete();
        $income->delete();

        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully');
    }

    public function cancel($id)
    {
        try {
            $income = Income::findOrFail($id);
            $income->status = 'cancelled';
            $income->save();

            return redirect()->route('incomes.index')->with('success', 'Income cancelled successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error cancelling income: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $income = Income::withTrashed()->findOrFail($id);
            $income->restore();
            return redirect()->route('incomes.index')->with('success', 'Income restored successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error restoring income: ' . $e->getMessage());
        }
    }
}
