<?php

namespace SimpleStore;

class Products
{
    public $products;
    public $data_path = DATA_ROOT;

    function get_products($category_id)
    {
        if (file_exists($this->data_path)) {
            $this->products = json_decode(file_get_contents($this->data_path . "$category_id.json"));
        } else {
            $this->products = json_decode("{}");
        }
        return $this->products;
    }

    function get_last_id()
    {
        $bigest_id = 0;
        foreach ($this->products as $product) {
            $id = str_replace('_', '', $product->id);
            if ($bigest_id < intval($id)) {
                $bigest_id = $id;
            }
        }
        return $bigest_id;
    }

    function add_product($category_id, $product)
    {
        $products = $this->get_products($category_id);
        $last_product_id =  $this->get_last_id();
        $new_product = new Product((array)$product);
        $new_product->id = $last_product_id + 1;
        $new_product->category_id = $category_id;
        $products[] = $new_product;
        file_put_contents($this->data_path . "$category_id.json", json_encode($products, JSON_UNESCAPED_UNICODE));
    }

    function favorite_product($category_id, $product_id)
    {
        $product = $this->get_product($category_id, $product_id);
        $this->add_product("favorites", $product);
    }

    function get_product($category_id, $product_id)
    {
        $products = $this->get_products($category_id);
        foreach ($products as $product) {
            if ($product->id == $product_id) {
                return $product;
            }
        }
        return null;
    }

    function duplicate_product($category_id, $product_id)
    {
        $product = $this->get_product($category_id, $product_id);
        $this->add_product($category_id, clone ($product));
    }
}
