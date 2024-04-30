<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        $query = $request->input('search');

        $incomes = Income::where(function ($q) use ($query) {
            $q->where('payment_proof', 'like', "%$query%")
                ->orWhere('proof_number', 'like', "%$query%")
                ->orWhere('date_time', 'like', "%$query%")
                ->orWhere('status', 'like', "%$query%");
        })
            ->paginate(6);

        foreach ($incomes as $income) {
            $income->total = IncomeDetail::where('income_id', $income->id)
                ->sum(DB::raw('cant * purchase_price'));
        }

        return view('incomes.index', compact('incomes'));
    }

    /**
     * Create a new resource in storage.
     */
    public function create()
    {
        $incomes = Income::all();
        $products = DB::table('products')
            ->select(DB::raw('products.title, products.id, products.stock'))
            ->where('products.status', '=', 'Available')
            ->get();
        return view('incomes.insert', ['products' => $products, 'incomes' => $incomes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Crear el ingreso principal
            $income = new Income;
            $income->provider_id = $request->get('provider_id');
            $income->payment_proof = $request->get('payment_proof');
            $income->proof_number = $request->get('proof_number');
            $income->date_time = Carbon::now('America/Guayaquil')->toDateTimeString();
            $income->fee_tax = '12';
            $income->status = 'Incoming';
            $income->save();
            // Crear los detalles del ingreso
            $product_ids = $request->get('product_id');
            $cants = $request->get('cant');
            $purchase_prices = $request->get('purchase_price');
            $sale_prices = $request->get('sale_price');

            foreach ($product_ids as $index => $product_id) {
                $detail = new IncomeDetail();
                $detail->income_id = $income->id;
                $detail->product_id = $product_id;
                $detail->cant = $cants[$index]; // Asegurarse de que se obtenga correctamente
                $detail->purchase_price = $purchase_prices[$index];
                $detail->sale_price = $sale_prices[$index];
                $detail->save();
            }

            DB::commit();
            return redirect()->route('incomes.index')->with('success', 'Income created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $income = DB::table('incomes as i')
            ->leftJoin('income_details as inde', 'i.id', '=', 'inde.income_id')
            ->select('i.id', 'i.date_time', 'i.payment_proof', 'i.proof_number', 'i.fee_tax', 'i.status', DB::raw('sum(inde.cant * inde.purchase_price) as total'))
            ->where('i.id', '=', $id)
            ->groupBy('i.id', 'i.date_time', 'i.payment_proof', 'i.proof_number', 'i.fee_tax', 'i.status')
            ->first();

        $details = DB::table('income_details as d')
            ->join('products as prod', 'd.product_id', '=', 'prod.id')
            ->select('prod.title as product', 'd.cant', 'd.purchase_price', 'd.sale_price')
            ->where('d.income_id', '=', $id)
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
    public function destroy(string $id)
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
}
