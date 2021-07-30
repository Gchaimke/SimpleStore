<?php

namespace SimpleStore;

class Cart
{
    public $total;

    function __construct()
    {
        $this->total = 0;
    }

    function add_to_cart($product)
    {
        $product->price = intval($product->price);
        $product->qtty = intval($product->qtty);
        (int)$product->cart_qtty = isset($product->cart_qtty) ? $product->cart_qtty : $product->qtty;
        $key = $product->id . "_" . $product->category_id;
        $cart = $_SESSION['cart'];
        if (count($cart) > 0) {
            if ($key) {
                $product->price += $cart[$key]->price;
                $product->cart_qtty += $cart[$key]->cart_qtty;
                $cart[$key] = $product;
            } else {
                $cart[$key] = $product;
            }
        } else {
            $cart[$key] = $product;
        }

        $_SESSION['cart'] = $cart;
    }

    function get_total()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        foreach ($_SESSION['cart'] as $product) {
            $this->total += $product->price;
        }
        return $this->total;
    }
}
