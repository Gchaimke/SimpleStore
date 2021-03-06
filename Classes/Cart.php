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
        if ($product->price > 0) {
            $product->cart_price = $product->price;
            $product->cart_qtty = $product->qtty;
            $option = preg_replace('~[^\p{L}\p{N}]++~u', '', $product->option);
            $product->id = $product->id . "_" . $option;
            $key = $product->category_id . "_" . $product->id;
            if (isset($_SESSION['cart'][$key])) {
                $product = $_SESSION['cart'][$key];
                $product->cart_price += $product->price;
                $product->cart_price = number_format($product->cart_price, 2, '.', '');
                $product->cart_qtty += $product->qtty;
            } else {
                $_SESSION['cart'][$key] = $product;
            }
        }
    }

    function minus_from_cart($key)
    {
        $product = $_SESSION['cart'][$key];
        $product->price = intval($product->price);
        $product->qtty = intval($product->qtty);
        $product->cart_price -= $product->price;
        $product->cart_price = number_format($product->cart_price, 2, '.', '');
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
                $id = $product->category_id . "_" . $product->id;
                $html .= "
                <li data-product_id='$id' class='list-group-item'>
                    <span class='bg-danger remove-from-cart badge badge-primary badge-pill'>X</span>
                    <center>
                        <span class='cart-product mx-2'>{$product->$name} $product->option</span>
                        <span class='cart_qty'>{$product->cart_qtty}</span>
                        <span class='cart_kind me-1'>" . lang($product->kind) . "</span>
                        <span class='cart_price'>{$product->cart_price}</span>$carrency
                    </center>
                    <div class='cart-controls text-nowrap mb-2 text-center' data-product_id='$id' data-product_option='$product->option'>
                        <span class='btn btn-warning ml-2 minus'>-</span><b class='m-2'>1</b><span class='btn btn-success plus'>+</span>
                    </div>
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
