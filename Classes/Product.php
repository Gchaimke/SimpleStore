<?php

namespace SimpleStore;

class Product
{
    public $id, $name, $description, $price, $kind, $img, $options;

    function __construct($product = array())
    {
        global $lng;
        $name = "name_" . $lng;
        $description = 'description_' . $lng;
        $kind = 'kind_' . $lng;
        $options = "options_" . $lng;
        if (!key_exists("id", $product)) {
            $this->$name = key_exists('name', $product) && $product['name'] != '' ? $product['name'] : "new product";
            $this->$description = key_exists('description', $product) && $product['description'] != '' ? $product['description'] : '';
            $this->price = key_exists('price', $product) && $product['price'] != '' ? $product['price'] : 50;
            $this->qtty = key_exists('qtty', $product) && $product['qtty'] != '' ? $product['qtty'] : '1';
            $this->category_id = key_exists('category_id', $product) && $product['category_id'] != '' ? $product['category_id'] : '1';
            $this->$kind = key_exists('kind', $product) && $product['kind'] != '' ? $product['kind'] : 'kg';
            $this->img = key_exists('img', $product) && $product['img'] != '' ? $product['img'] : 'img/product.jpg';
            $this->$options = key_exists('options', $product) && $product['options'] != '' ? $product['options'] : '';
        } else {
            foreach ($product as $key => $value) {
                $this->$key = htmlspecialchars($value, ENT_QUOTES);
            }
        }
    }

    function edit_product($category_index, $product)
    {
        global $lng;
        $products = json_decode(file_get_contents(DATA_ROOT . "$category_index.json"));
        $product = (object)$product;
        foreach ($products as $key => $curent_product) {
            if ($curent_product->id == $product->id) {
                $old_product = $curent_product;
                $product_key = $key;
            }
        }
        $name = "name_" . $lng;
        $description = 'description_' . $lng;
        $kind = 'kind_' . $lng;
        $options = "options_" . $lng;
        $old_product->price = $product->price;
        $old_product->$name = htmlspecialchars($product->name, ENT_QUOTES);
        $old_product->$description = htmlspecialchars($product->description, ENT_QUOTES);
        $old_product->$kind = htmlspecialchars($product->kind, ENT_QUOTES);
        $old_product->qtty = $product->qtty != "" ? $product->qtty : 1;
        $old_product->img = $product->img;
        $old_product->$options = htmlspecialchars($product->options, ENT_QUOTES);
        $products[$product_key] = $old_product;
        file_put_contents(DATA_ROOT . "$category_index.json", json_encode($products, JSON_UNESCAPED_UNICODE));
    }
}
