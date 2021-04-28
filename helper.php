<?php
function login($pass)
{
    if ($pass == '12345') {
        $_SESSION["login"] = true;
        echo "<script>window.location.href = '/';</script>";
    }
}

function logout()
{
    $_SESSION["login"] = '';
    echo "<script>window.location.href = '/';</script>";
}

function get_categories()
{
    return json_decode(file_get_contents('data/categories.json'));
}

function get_products($file = 0)
{
    return json_decode(file_get_contents("data/$file.json"));
}

function new_product($name = 'New Product', $description = '', $price = 50, $kind = 'kg', $img = 'https://cdn.pixabay.com/photo/2016/02/19/11/33/trees-1209774__340.jpg')
{
    $product = new stdClass();
    $product->name = $name;
    $product->description = $description;
    $product->price = $price;
    $product->kind = $kind;
    $product->img = $img;
    return $product;
}

function add_product($products, $product)
{
    $products[] = $product;
    return $products;
}

function add_category($categories, $name = 'New Category')
{
    $object = new stdClass();
    $object->name = $name;
    $categories[] = $object;
    $products[] = new_product();
    save_json($products, count($categories) - 1);
    return $categories;
}

function save_json($categories, $file_name = 'test')
{
    file_put_contents("data/$file_name.json", json_encode($categories));
}
