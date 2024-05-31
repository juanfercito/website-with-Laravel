<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IncomeDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\Cart;

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

        return view('main.shoppingCart', [
            'cart' => $cart,
            'incomeDetails' => $incomeDetails
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $key => $item) {
            if ($item['id'] == $request->id) {
                unset($cart[$key]);
                break;
            }
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product removed from cart');
    }
}
