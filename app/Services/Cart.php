<?php

namespace App\Services;

class Cart
{
    public static function add($product)
    {
        $cart = session()->get('cart', []);

        $cartItem = [
            'id' => $product->id,
            'title' => $product->title,
            'price' => $product->sale_price,
            'quantity' => 1, // Puedes ajustar la lógica para cantidades
        ];

        $exists = false;

        // Verificar si el producto ya está en el carrito
        foreach ($cart as &$item) {
            if ($item['id'] == $product->id) {
                $item['quantity']++;
                $exists = true;
                break;
            }
        }

        // Si el producto no está en el carrito, agregarlo
        if (!$exists) {
            $cart[] = $cartItem;
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
            $count += $item['quantity'];
        }

        return $count;
    }
}
