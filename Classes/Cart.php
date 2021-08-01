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
        if ($product->cart_price == 0 || $product->cart_qtty == 0) {
            $this->remove_from_cart($key);
        }
    }

    function remove_from_cart($key)
    {
        unset($_SESSION['cart'][$key]);
    }

    function view_cart()
    {
        global $carrency, $lng;
        $html = "";
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $product) {
                $name = property_exists($product, "name_" . $lng) ? "name_" . $lng : "name";
                $kind = property_exists($product, "kind_" . $lng) ? "kind_" . $lng : "kind";
                $id = $product->category_id . "_" . $product->id;
                $html .= "
                <li data-product_id='$id'>
                    <span class='bg-danger remove-from-cart'>X</span>
                    <span class='cart-product mx-2'>{$product->$name} $product->option</span>
                    <span class='cart_qty'>{$product->cart_qtty}</span>
                    <span class='cart_kind me-1'>{$product->$kind}</span>
                    <span class='cart_price'>{$product->cart_price}</span>$carrency
                    <div class='cart-controls text-nowrap mb-2 text-center' data-product_id='$id'>
                        <span class='btn btn-warning ml-2 minus'>-</span><b class='m-2'>1</b><span class='btn btn-success plus'>+</span>
                    </div>
                    <hr>
                </li>";
            }
            return $html;
        }
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
