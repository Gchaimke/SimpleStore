<?php
define("SITE_ROOT","/");
define("DOC_ROOT",$_SERVER['DOCUMENT_ROOT'].SITE_ROOT);

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
    $company = get_company();
    if ($pass == $company->pass) {
        $_SESSION["login"] = true;
        redirect(SITE_ROOT);
    } else {
        redirect(SITE_ROOT.'?login_error');
    }
}

function logout()
{
    $_SESSION["login"] = '';
    redirect(SITE_ROOT);
}

function get_company()
{
    return json_decode(file_get_contents(DOC_ROOT . 'data/company.json'));
}

function edit_company($data)
{
    file_put_contents(DOC_ROOT . "data/company.json", json_encode((object)$data));
}

function get_categories()
{
    return json_decode(file_get_contents(DOC_ROOT . 'data/categories.json'));
}

function get_products($file = 0)
{
    return json_decode(file_get_contents(DOC_ROOT . "data/$file.json"));
}

function new_product($name = 'New Product', $description = 'description', $price = '50', $kind = 'kg', $img = '')
{
    if ($img == "") {
        $img = 'https://cdn.profile.ru/wp-content/uploads/2019/08/shutterstock_1050939104-782x440.jpg';
    }
    if ($kind == "") {
        $kind = 'кг';
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
}

function edit_category($category_index, $name)
{
    $categories = get_categories();
    $categories[$category_index]->name = $name;
    save_json($categories, 'categories');
}

function delete_category($category_index)
{
    $categories = get_categories();
    unset($categories[$category_index]);
    unlink(DOC_ROOT . "data/$category_index.json");
    save_json($categories, 'categories');
}

function save_json($array, $file_name = 'test')
{
    file_put_contents(DOC_ROOT . "data/$file_name.json", json_encode(array_values($array)));
}

function auto_version($file)
{
    if (strpos($file, '/') !== 0 || !file_exists(DOC_ROOT . $file)) return $file;
    $mtime = filemtime(DOC_ROOT . $file);
    return sprintf("%s?v=%d", $file, $mtime);
}

function clean($str)
{
    return str_replace(' ', '', $str);
}
