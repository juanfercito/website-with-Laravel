<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        if (empty($product))
            //dd($product);
            return redirect()->back()->with('success', 'Product added' . $product->title);
        Cart::add(
            $product
        );
    }

    public function getCartCount()
    {
        return response()->json(['count' => Cart::count()]);
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('main.shoppingCart', compact('cart'));
    }
}
