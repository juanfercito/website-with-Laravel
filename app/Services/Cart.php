<?php

namespace App\Services;

class Cart
{
    public static function add($productData)
    {
        $cart = session()->get('cart', []);

        $exists = false;

        foreach ($cart as &$item) {
            if ($item['id'] == $productData['id']) {
                if (isset($item['quantity'])) {
                    $item['quantity']++;
                } else {
                    $item['quantity'] = 1;
                }
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $cart[] = [
                'id' => $productData['id'],
                'title' => $productData['title'],
                'price' => $productData['sale_price'],
                'quantity' => $productData['cant'],
            ];
        }

        session()->put('cart', $cart);
    }

    public static function getCart()
    {
        return session()->get('cart', []);
    }

    public static function count()
    {
        $cart = session()->get('cart', []);
        $count = 0;

        foreach ($cart as $item) {
            if (isset($item['quantity'])) {
                $count += $item['quantity'];
            }
        }

        return $count;
    }

    public static function remove($productId)
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $key => $item) {
            if ($item['id'] == $productId) {
                unset($cart[$key]);
                break;
            }
        }

        // Reindexar el array para mantener el orden correcto
        $cart = array_values($cart);

        session()->put('cart', $cart);
    }

    public static function clearCart()
    {
        session()->forget('cart');
    }
}
