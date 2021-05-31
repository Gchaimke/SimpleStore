<?php
class Product
{
    public $id, $name, $description, $price, $kind, $img;

    function __construct($product = array())
    {
        global $lng;
        $name = "name_" . $lng;
        $description = 'description_' . $lng;
        $kind = 'kind_' . $lng;
        $this->$name = key_exists('name', $product) && $product['name'] != '' ? $product['name'] : "new product";
        $this->$description = key_exists('description', $product) && $product['description'] != '' ? $product['description'] : '';
        $this->price = key_exists('price', $product) && $product['price'] != '' ? $product['price'] : 50;
        $this->qtty = key_exists('qtty', $product) && $product['qtty'] != '' ? $product['qtty'] : '1';
        $this->$kind = key_exists('kind', $product) && $product['kind'] != '' ? $product['kind'] : 'kg';
        $this->img = key_exists('img', $product) && $product['img'] != '' ? $product['img'] : 'img/product.jpg';
    }

    function update($category_index, $product)
    {
        global $lng;
        $products = json_decode(file_get_contents(DOC_ROOT . "data/$category_index.json"));
        $product = (object)$product;
        $product->id = intval($product->id);
        foreach ($products as $key => $curent_product) {
            if ($curent_product->id == $product->id) {
                $old_product = $curent_product;
                $product_key = $key;
            }
        }
        $name = "name_" . $lng;
        $description = 'description_' . $lng;
        $kind = 'kind_' . $lng;
        $old_product->$name = $product->name;
        $old_product->$description = $product->description;
        $old_product->$kind = $product->kind;
        $old_product->qtty = $product->qtty;
        $old_product->img = $product->img;
        $products[$product_key] = $old_product;
        file_put_contents(DOC_ROOT . "data/$category_index.json", json_encode($products, JSON_UNESCAPED_UNICODE));
    }
}
