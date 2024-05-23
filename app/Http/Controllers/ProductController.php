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
    public function index(Request $request)
    {
        $query = $request->input('search');

        $products = Product::where(function ($q) use ($query) {
            $q->where('title', 'like', "%$query%")
                ->orWhereHas('productClass', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                })
                ->orWhereHas('productCategory', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                })
                ->orWhereHas('productType', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                });
        })
            ->paginate(7);


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
            'product_class_id' => 'required',
            'product_category_id' => 'required',
            'product_type_id' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,svg|max:1024',
            'stock' => 'required',
        ]);

        // getting all form data
        $productData = $request->all();
        if ($image = $request->file('image')) {
            $saveImgRoute = 'product-img/';
            $productImg = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($saveImgRoute, $productImg);
            $productData['image'] = $productImg;
        }

        // create the product with the form data
        $product = Product::create($productData);

        // Update the tables relationship
        $product->product_class_id = $request->product_class_id;
        $product->product_category_id = $request->product_category_id;
        $product->product_type_id = $request->product_type_id;

        // Save the product and its relations
        $product->save();

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $products = Product::findOrFail($id);

        return view('welcome', ['product' => $products]);
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
        // Validating the required fields
        $request->validate([
            'title' => 'required',
            'product_class_id' => 'required',
            'product_category_id' => 'required',
            'product_type_id' => 'required',
            'description' => 'required',
            'stock' => 'required',
        ]);

        // Validating image onli if upload a new image
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,svg|max:1024',
            ]);

            // Guardar la nueva imagen
            $saveImgRoute = 'product-img/';
            $productImg = date('YmdHis') . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($saveImgRoute, $productImg);

            // Asignar la nueva imagen al producto
            $product->image = $productImg;
        }

        // Update the product data
        $product->update($request->except('image'));

        // Updating the product relations with tables
        $product->product_class_id = $request->product_class_id;
        $product->product_category_id = $request->product_category_id;
        $product->product_type_id = $request->product_type_id;

        // Save the changes
        $product->status = ($product->stock > 0) ? 'Available' : 'Unavailable';
        $product->save();

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

    /*
    * Other methods for getting a list of products
    */
    public function welcome()
    {
        $latestProducts = Product::latest()->take(5)->get();

        return view('welcome', compact('latestProducts'));
    }

    public function getProducts(Request $request)
    {
        $latestProducts = Product::orderBy('created_at', 'desc')->take(3)->get(['title', 'image']);
        dd($latestProducts);

        return view('welcome', compact('productsToShow', 'latestProducts'));
    }
}
