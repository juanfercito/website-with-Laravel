<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IncomeDetail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // WelcomeController.php
    public function index()
    {
        $latestProducts = Product::orderBy('created_at', 'desc')->take(6)->get(['id', 'title', 'image']);
        $bestSellingProducts = Product::join('sale_details', 'products.id', '=', 'sale_details.product_id')
            ->select('products.id', 'products.title', 'products.description', 'products.image', DB::raw('SUM(sale_details.cant) as total_sold'))
            ->groupBy('products.id', 'products.title', 'products.description', 'products.image')
            ->orderByDesc('total_sold')
            ->take(6)
            ->get();

        return view('welcome', compact('latestProducts', 'bestSellingProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $product = Product::with(['incomeDetails' => function ($query) {
            $query->orderBy('id', 'desc');
        }])->findOrFail($id);

        $incomeDetail = $product->incomeDetails->first();

        return view('main.productDetails', compact('product', 'incomeDetail'));
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

    /*
    * Other methods for interacting with the landing page
     */
    public function shoppingCart()
    {
        return view('main.ShoppingCart');
    }

    public function showAllProducts(Request $request)
    {
        $sort = $request->input('sort', 'latest'); // Por defecto, ordenar por los últimos añadidos
        $perPage = 10; // Número de productos por página

        if ($sort === 'bestselling') {
            $products = Product::join('sale_details', 'products.id', '=', 'sale_details.product_id')
                ->select('products.id', 'products.title', 'products.description', 'products.image', DB::raw('SUM(sale_details.cant) as total_sold'))
                ->groupBy('products.id', 'products.title', 'products.description', 'products.image')
                ->orderByDesc('total_sold')
                ->paginate($perPage);
        } else {
            // Ordenar por los últimos añadidos
            $products = Product::orderBy('created_at', 'desc')->paginate($perPage, ['id', 'title', 'description', 'image']);
        }

        return view('main.allProducts', compact('products', 'sort'));
    }
}
