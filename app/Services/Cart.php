<?php

namespace App\Services;

class Cart
{
    public static function add($productData)
    {
        $cart = session()->get('cart', []);

        $exists = false;

        // Verificar si el producto ya está en el carrito
        foreach ($cart as &$item) {
            if ($item['id'] == $productData['id']) {
                if (isset($item['quantity'])) {
                    $item['quantity']++;
                } else {
                    // Si no está definido, inicializamos la cantidad en 1
                    $item['quantity'] = 1;
                }
                $exists = true;
                break;
            }
        }

        // Si el producto no está en el carrito, agregarlo
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
            // Verifica si el elemento tiene la clave 'quantity' antes de sumar
            if (isset($item['quantity'])) {
                $count += $item['quantity'];
            }
        }

        return $count;
    }
}
