<?php
require_once('config.php');
$company = get_company();
$stats = month_statistic();
$categories = get_categories();
$images = get_images();


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
    global $company;
    if ($pass == $company->pass) {
        $_SESSION["login"] = true;
        redirect(SITE_ROOT);
    } else {
        redirect(SITE_ROOT . '?login_error');
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
    file_put_contents(DOC_ROOT . "data/company.json", json_encode((object)$data), JSON_UNESCAPED_UNICODE);
}

function get_favorites()
{
    return json_decode(file_get_contents(DOC_ROOT . 'data/favorites.json'));
}

function get_categories()
{
    return json_decode(file_get_contents(DOC_ROOT . 'data/categories.json'));
}

function get_category($id)
{
    global $categories;
    foreach ($categories as $category) {
        if ($category->id == $id) {
            if (!property_exists($category, 'last_index')) {
                $category->last_index = 0;
            }
            return $category;
        }
    }
    return null;
}

function get_products($file = 0)
{
    if (file_exists(DOC_ROOT . "data/$file.json")) {
        return json_decode(file_get_contents(DOC_ROOT . "data/$file.json"));
    }
}

function new_product($product_array = array())
{
    $product = new stdClass();
    if ($product_array['id'] == '') {
        $product->name = $product_array['name'] != '' ? $product_array['name'] : 'New Product';
        $product->description = $product_array['description'] != '' ? $product_array['description'] : '';
        $product->price = $product_array['price'] != '' ? $product_array['price'] : 50;
        $product->kind = $product_array['kind'] != '' ? $product_array['kind'] : '1kg';
        $product->img = $product_array['img'] != '' ? $product_array['img'] : 'img/product.jpg';
        $product->id = "";
        return $product;
    }
}

function add_product($category_index, $product)
{
    $category = get_category($category_index);
    $products = get_products($category_index);
    $product = new_product($product);
    $product->id = $category->last_index + 1;
    $products[] = $product;
    save_json($products, $category_index);
    edit_category($category_index, "last_index", $category->last_index + 1);
}

function duplicate_product($category_index, $product_index)
{
    $category = get_category($category_index);
    $products = get_products($category_index);
    $new_product = new stdClass();
    foreach ($products as $curent_product) {
        if ($curent_product->id == $product_index) {
            $new_product = clone ($curent_product);
        }
    }
    $new_product->id = $category->last_index + 1;
    $products[] = $new_product;
    save_json($products, $category_index);
    edit_category($category_index, "last_index", $category->last_index + 1);
}

function edit_product($category_index, $product)
{
    $products = get_products($category_index);
    $product = (object)$product;
    $product->id = intval($product->id);
    foreach ($products as $key => $curent_product) {
        if ($curent_product->id == $product->id) {
            $products[$key] = $product;
        }
    }
    save_json($products, $category_index);
}

function update_products_id($category_index = '')
{
    if ($category_index != '') {
        $category = get_category($category_index);
        if (isset($category)) {
            $products = get_products($category_index);
            foreach ($products as $key => $product) {
                if (!property_exists($product, 'id')) {
                    $product->id = $category->last_index;
                    $products[$key] = $product;
                    $category->last_index++;
                }
            }
            save_json($products, $category_index);
            edit_category($category_index, "last_index", $category->last_index);
            echo 'updated';
            return;
        }
    }
    echo 'no category with id ' . $category_index;
}

function delete_product($category_index, $product_index)
{
    $products = get_products($category_index);
    foreach ($products as $key => $curent_product) {
        if ($curent_product->id ==  $product_index) {
            unset($products[$key]);
        }
    }
    save_json($products, $category_index);
}

function add_category($name = 'New Category')
{
    $categories = get_categories();
    $last_category =  end($categories);
    $category = new stdClass();
    $category->id = isset($last_category->id) ? $last_category->id + 1 : 0;
    $category->name = $name;
    $category->last_index = 0;
    $categories[] = $category;
    $products[] = new_product();
    save_json($categories, 'categories');
    save_json($products, $category->id);
}

function edit_category($id, $key, $value)
{
    $categories = get_categories();
    foreach ($categories as $index => $category) {
        if ($category->id == $id) {
            $categories[$index]->$key = $value;
        }
    }
    save_json($categories, 'categories');
}

function delete_category($id)
{
    $categories = get_categories();
    foreach ($categories as $key => $category) {
        if ($category->id == $id) {
            unset($categories[$key]);
        }
    }
    unlink(DOC_ROOT . "data/$id.json");
    save_json($categories, 'categories');
}

function save_json($array, $file_name = 'test')
{
    usort($array, function ($a, $b) { //Sort the array using a user defined function
        return $a->name > $b->name ? 1 : -1; //Compare the scores
    });
    file_put_contents(DOC_ROOT . "data/$file_name.json", json_encode(array_values($array), JSON_UNESCAPED_UNICODE));
}

function auto_version($file)
{
    if (!file_exists(DOC_ROOT . $file)) return $file;
    $mtime = filemtime(DOC_ROOT . $file);
    return sprintf("%s?v=%d", SITE_ROOT . $file, $mtime);
}

function clean($str)
{
    return str_replace(' ', '', $str);
}

function get_images($dir = DOC_ROOT . "img/products/")
{
    $result = array();
    $cdir = scandir($dir);
    foreach ($cdir as $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }
    return $result;
}

function save_image($image_name, $url)
{
    $valid_ext = array('png', 'jpeg', 'jpg');
    $image_ext = pathinfo($url, PATHINFO_EXTENSION);
    $image_ext = strtolower($image_ext);

    $tmp = DOC_ROOT . 'img/tmp.' . $image_ext;
    $location = DOC_ROOT . 'img/products/' . $image_name . '.' . $image_ext;

    if (in_array($image_ext, $valid_ext)) {
        file_put_contents($tmp, file_get_contents($url));
        compressImage($tmp, $location, 60);
        echo $image_name . '.' . $image_ext;
    } else {
        echo 'image not valid ' . $image_ext;
    }
}

function delete_image($image)
{
    if (unlink(DOC_ROOT . $image)) {
        echo 'success';
    } else {
        echo 'fail';
    }
}
// Compress image
function compressImage($source, $destination, $quality)
{
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);
    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);
    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);
    imagejpeg($image, $destination, $quality);
    unlink($source);
}

function cart_log($cart, $total, $client)
{
    $log_name = date('m_y');
    $log_path = DOC_ROOT . "data/orders/$log_name.json";
    if (file_exists($log_path)) {
        $log = json_decode(file_get_contents($log_path));
    }

    $cart_items = new stdClass();
    $log_date = date('d/m/y H:i:s');
    $last_item =  end($log);
    $next = isset($last_item->id) ? $last_item->id + 1 : intval(date('md')) . '000';
    $cart_items->id = $next;
    $cart_items->date = $log_date;
    $cart_items->items = $cart;
    $cart_items->total = $total;
    $cart_items->client = $client;

    $log->$next = $cart_items;
    file_put_contents($log_path, json_encode($log, JSON_UNESCAPED_UNICODE));
    send_email($next);
    return $next;
}

function month_statistic($file_name = '')
{
    if ($file_name == '') {
        $file_name = date('m_y');
        $file_name = DOC_ROOT . "data/orders/$file_name.json";
    } else {
        $file_name = DOC_ROOT . "data/orders/$file_name.json";
    }
    if (file_exists($file_name)) {
        return json_decode(file_get_contents($file_name));
    } else {
        return array();
    }
}

function get_order($order_num = 0)
{
    if ($order_num != 0) {
        $order =  isset(month_statistic()->$order_num) ? month_statistic()->$order_num : false;
        if ($order) {
            return $order;
        }

        $prev_month_order = date('m_y', strtotime("-1 month"));
        $order =  isset(month_statistic($prev_month_order)->$order_num) ? month_statistic($prev_month_order)->$order_num : false;
        if ($order) {
            return $order;
        }

        return "<h3>Order #$order_num not found!</h3>";
    }
}

function order_client_to_html($order_num = 0)
{
    $order = get_order($order_num);
    $html = "<br><h3>Shipment Address</h3>";
    $html .= "<ul>";
    foreach ($order->client as $key => $value) {
        $html .= "<li>$key: $value</li>";
    }
    $html .= '</ul>';
    return $html;
}

function order_to_html($order_num = 0)
{
    $order = get_order($order_num);
    if (is_object($order)) {
        $style = 'border: 1px solid black;border-collapse: collapse;padding: 5px;font-weight: 700;';
        $th_style = 'text-align: center;background-color: #bce0ff;font-size: larger;';
        $html = "<tr><th style='$style $th_style'>Продукт</th><th style='$style $th_style'>Количество</th><th style='$style $th_style'>Цена</th></tr>";
        foreach ($order->items as $value) {
            $html .= "<tr>";
            $value = explode(',', $value);
            foreach ($value as $td) {
                $html .= "<td style='$style'>$td</td>";
            }
            $html .= '</tr>';
        }
        $html .= "<tr><td style='$style'>Сумма (<span style='color:red;'>приблизительно</span>) ~</td><td colspan='2' style='text-align: center;$style'>$order->total ש\"ח</td></tr>";
        return "<h3 style='text-align: center;background: #bb80a1;color: white;padding: 30px;'>$order->date <br> Order: #$order->id</h3>
        <table style='width:100%;$style'>$html</table><br>";
    }
    return $order;
}

function send_email($order_num = 0)
{
    global $company;
    if ($order_num != 0) {
        $to = $company->email;
        $subject = "Order #" . $order_num;
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . SITE_ROOT . "?order=" . $order_num;
        $message =  order_to_html($order_num) . order_client_to_html($order_num) . "<br> Sent from <a target='_blank' href='$actual_link'> $actual_link</a><br><br><br><br>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: admin@mc88.co.il" . "\r\n";
        $headers .= "CC: " . get_order($order_num)->client->email . "\r\n";
        $headers .= "Bcc: gchaimke@gmail.com" . "\r\n";

        mail($to, $subject, $message, $headers);
        return $message;
    }
}
