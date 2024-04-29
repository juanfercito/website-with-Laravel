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
            ->paginate(10);

        return view('incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $incomes = Income::all();
        $products = DB::table('products')
            ->select(DB::raw('products.title, products.id, products.stock'))
            ->get();
        return view('incomes.insert', ['products' => $products, 'incomes' => $incomes]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
