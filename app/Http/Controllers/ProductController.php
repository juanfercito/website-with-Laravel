<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:watch-products|insert-product|modify-product|delete-product', ['only' => ['index']]);
        $this->middleware('permission:insert-product', ['only' => ['create', 'store']]);
        $this->middleware('permission:modify-product', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(5);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.insert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'class' => 'required',
            'category' => 'required',
            'type' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,svg|max:1024',
            'price' => 'required',
            'cant' => 'required',
        ]);

        $product = $request->all();
        if ($image = $request->file('image')) {
            $saveImgRoute = 'product-img/';
            $productImg = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($saveImgRoute, $productImg);
            $product['image'] = $productImg;
        }
        Product::create($product);
        return redirect()->route('products.index');
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
    public function edit(Product $product)
    {
        return view('products.modify', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        request()->validate([
            'title' => 'required',
            'class' => 'required',
            'category' => 'required',
            'type' => 'required',
            'description' => 'required',
            'image' => 'required',
            'price' => 'required',
            'cant' => 'required',
        ]);
        $product->update($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
