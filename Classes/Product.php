<?php

namespace SimpleStore;

class Product
{
    public $id;
    public $category_id;
    public $name = "new product";
    public $description = "";
    public $price = 50;
    public $qtty = 1;
    public $warehouse = 10;
    public $kind = 'kg';
    public $img = 'img/product.png';
    public $options = "";
    public $kinds = array("kg", "gr", "mg", "l", "ml", "pcs");

    function __construct($product = array())
    {
        global $lng;
        $name = "name_" . $lng;
        $description = 'description_' . $lng;
        $options = "options_" . $lng;
        $product = (object)$product;
        if (!property_exists($product, "id")) {
            $this->category_id = property_exists($product, 'category_id') && $product['category_id'] != '' ? $product['category_id'] : '1';
            $this->id = $this->get_last_id($this->category_id) + 1;

            $this->$name = property_exists($product, $name) && $product[$name] != '' ? $product[$name] : $this->name;
            $this->$description = property_exists($product, $description) && $product[$description] != '' ? $product[$description] : '';
            $this->price = property_exists($product, 'price') && $product['price'] != '' ? $product['price'] : $this->price;
            $this->qtty = property_exists($product, 'qtty') && $product['qtty'] != '' ? $product['qtty'] : $this->qtty;
            $this->warehouse = property_exists($product, 'warehouse') && $product['warehouse'] != '' ? $product['warehouse'] : $this->warehouse;
            $this->kind = property_exists($product, 'kind') && $product['kind'] != '' ? $product['kind'] : $this->kind;
            $this->img = property_exists($product, 'img') && $product['img'] != '' ? $product['img'] : $this->img;
            $this->$options = property_exists($product, $options) && $product[$options] != '' ? $product[$options] : '';
        } else {
            foreach ($product as $key => $value) {
                $this->$key = htmlspecialchars($value, ENT_QUOTES);
            }
        }
    }

    function get_product($category_id, $product_id, $with_key=false)
    {
        $products = $this->get_products($category_id);
        foreach ($products as $key => $product) {
            if ($product->id == $product_id) {
                if($with_key){
                    $product->product_key = $key;
                }
                return $product;
            }
        }
        return null;
    }

    function get_products($category_id)
    {
        if (!file_exists(SP_DATA_ROOT)) {
            mkdir(SP_DATA_ROOT, 0700);
        }
        if (file_exists(SP_DATA_ROOT . "$category_id.json")) {
            $products = json_decode(file_get_contents(SP_DATA_ROOT . "$category_id.json"));
        } else {
            $products = json_decode("{}");
        }
        return $products;
    }

    function edit_product($category_id, $product)
    {
        global $lng;
        $products = json_decode(file_get_contents(SP_DATA_ROOT . "$category_id.json"));
        $product = (object)$product;
        foreach ($products as $key => $curent_product) {
            if ($curent_product->id == $product->id) {
                $old_product = $curent_product;
                $product_key = $key;
            }
        }
        $name = "name_" . $lng;
        $description = 'description_' . $lng;
        $options = "options_" . $lng;
        $old_product->price = $product->price;
        $old_product->$name = htmlspecialchars($product->name, ENT_QUOTES);
        $old_product->$description = htmlspecialchars($product->description, ENT_QUOTES);
        $old_product->kind = htmlspecialchars($product->kind, ENT_QUOTES);
        $old_product->qtty = $product->qtty != "" ? $product->qtty : 1;
        $old_product->warehouse = $product->warehouse != "" ? $product->warehouse : 10;
        $old_product->img = $product->img;
        $old_product->$options = htmlspecialchars($product->options, ENT_QUOTES);
        $products[$product_key] = $old_product;
        file_put_contents(SP_DATA_ROOT . "$category_id.json", json_encode($products, JSON_UNESCAPED_UNICODE));
        return true;
    }

    function edit_product_warehouse($category_id, $product_id, $qtty)
    {
        global $store;
        $product_id = intval(str_replace('_', '', $product_id));
        $product = $store->product->get_product($category_id, $product_id, 1);
        if (isset($product->warehouse)){
            $product->warehouse -= intval($qtty);
            if ($product->warehouse < 0){
                $product->warehouse = 0;
            }
        }else{
            $product->warehouse = 0;
        }
        $products = json_decode(file_get_contents(SP_DATA_ROOT . "$category_id.json"));
        $current_key = $product->product_key;
        unset($product->product_key);
        $products[$current_key] = $product;
        file_put_contents(SP_DATA_ROOT . "$category_id.json", json_encode($products, JSON_UNESCAPED_UNICODE));
        return true;
    }

    function get_last_id($category_id)
    {
        $bigest_id = 0;
        $products =  $this->get_products($category_id);
        if (is_iterable($products)) {
            foreach ($products as $product) {
                $id = str_replace('_', '', $product->id);
                if ($bigest_id < intval($id)) {
                    $bigest_id = $id;
                }
            }
        }
        return $bigest_id;
    }

    function new_product($category_id, $product)
    {
        global $lng;
        $products = $this->get_products($category_id);
        $last_product_id =  $this->get_last_id($category_id);
        $product = (object)$product;

        if ($product->name != "") {
            $new_product = new Product($product);
        } else {
            $new_product = new Product();
        }
        $new_product->id = $last_product_id + 1;
        $new_product->category_id = $category_id;

        $name = "name_" . $lng;
        $description = 'description_' . $lng;
        $options = "options_" . $lng;

        $this->price = $product->price;
        $this->$name = htmlspecialchars($product->name, ENT_QUOTES);
        $this->$description = htmlspecialchars($product->description, ENT_QUOTES);
        $this->kind = htmlspecialchars($product->kind, ENT_QUOTES);
        $this->qtty = $product->qtty != "" ? $product->qtty : 1;
        $this->img = $product->img;
        $this->$options = htmlspecialchars($product->options, ENT_QUOTES);
        $products[] = $new_product;
        file_put_contents(SP_DATA_ROOT . "$category_id.json", json_encode($products, JSON_UNESCAPED_UNICODE));
    }

    function favorite_product($category_id, $product_id)
    {
        $product = $this->get_product($category_id, $product_id);
        $this->new_product("favorites", $product);
    }

    function duplicate_product($category_id, $product_id)
    {
        $product = $this->get_product($category_id, $product_id);
        $this->new_product($category_id, clone ($product));
    }
}
