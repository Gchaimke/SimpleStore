<?php

namespace SimpleStore;

class Cart
{
    public $total, $cart;

    function __construct()
    {
        $this->total = 0;
    }

    function add_to_cart($product)
    {
        $product->cart_price = $product->price;
        $product->cart_qtty = $product->qtty;
        $key = $product->category_id . "_" . $product->id;
        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]->cart_price += $product->price;
            $_SESSION['cart'][$key]->cart_qtty += $product->cart_qtty;
        } else {
            $_SESSION['cart'][$key] = $product;
        }
    }

    function minus_from_cart($key)
    {
        $product = $_SESSION['cart'][$key];
        $product->price = intval($product->price);
        $product->qtty = intval($product->qtty);
        $product->cart_price -= $product->price;
        $product->cart_qtty -= $product->qtty;
        $_SESSION['cart'][$key] = $product;
        if($product->cart_price == 0 || $product->cart_qtty == 0){
            $this->remove_from_cart($key);
        }
    }

    function remove_from_cart($key)
    {
        unset($_SESSION['cart'][$key]);
        Helper::log($key);
    }


    function get_total()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        foreach ($_SESSION['cart'] as $product) {
            $this->total += $product->cart_price;
        }
        return $this->total;
    }
}
