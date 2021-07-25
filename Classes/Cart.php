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
        $_SESSION['cart'][] = $product;
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
