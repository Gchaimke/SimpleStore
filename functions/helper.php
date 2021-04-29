<?php
if (isset($_SESSION['login']) && $_SESSION['login']) {
    $logedin = true;
} else {
    $logedin = false;
}

function redirect($url)
{
    echo "<script>window.location.href = '$url';</script>";
}

function login($pass)
{
    if ($pass == '12345') {
        $_SESSION["login"] = true;
        redirect('/');
    }
}

function logout()
{
    $_SESSION["login"] = '';
    redirect('/');
}

function get_company()
{
    return json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/company.json'));
}

function get_categories()
{
    return json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/categories.json'));
}

function get_products($file = 0)
{
    return json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/$file.json"));
}

function new_product($name = 'New Product', $description = 'description', $price = '50', $kind = 'kg', $img = '')
{
    if ($img == "") {
        $img = 'https://cdn.pixabay.com/photo/2016/02/19/11/33/trees-1209774__340.jpg';
    }
    $product = new stdClass();
    $product->name = $name;
    $product->description = $description;
    $product->price = $price;
    $product->kind = $kind;
    $product->img = $img;
    return $product;
}

function add_product($category_index, $product)
{
    $products = get_products($category_index);
    $products[] = $product;
    save_json($products, $category_index);
}

function edit_product($category_index, $product_index, $product)
{
    $products = get_products($category_index);
    $products[$product_index] = $product;
    save_json($products, $category_index);
}

function delete_product($category_index, $product_index)
{
    $products = get_products($category_index);
    unset($products[$product_index]);
    save_json($products, $category_index);
}

function add_category($name = 'New Category')
{
    $categories = get_categories();
    $object = new stdClass();
    $object->name = $name;
    $categories[] = $object;
    $products[] = new_product();
    save_json($categories, 'categories');
    save_json($products, count($categories) - 1);
    return $categories;
}

function save_json($array, $file_name = 'test')
{
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/$file_name.json", json_encode(array_values($array)));
}

function auto_version($file)
{
    if (strpos($file, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $file)) return $file;
    $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
    return sprintf("%s?v=%d", $file, $mtime);
}

function clean($str)
{
    return str_replace(' ', '', $str);
}
