<?php

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Direct access not allowed');
    exit();
};

/**
 * Config
 */
define("VERSION", "1.5");

require_once(__DIR__ . '/../config.php');
define("ORDERS_PATH", DOC_ROOT . "data/orders/");

/**
 * Classes Loader
 */
require_once(DOC_ROOT . 'Classes/Store.php');

/**
 * Settings
 */

if (isset($_COOKIE['language']) && $_COOKIE['language']) {
    $lng = $_COOKIE['language'];
    require(DOC_ROOT . "lang/$lng.php");
} else {
    $lng = SITE_LANG;
    require(DOC_ROOT . "lang/$lng.php");
}

if (isset($_SESSION['login']) && $_SESSION['login']) {
    $logedin = true;
} else {
    $logedin = false;
}

if (isset($_COOKIE['total']) && $_COOKIE['total']) {
    $previos_total = $_COOKIE['total'];
} else {
    $previos_total = 0;
}

if (isset($_COOKIE['items']) && $_COOKIE['items']) {
    $previos_cart = $_COOKIE['items'];
} else {
    $previos_cart = '';
}



/**
 * Globals
 */
$store = new SimpleStore\Store();
$carrency = $store->carrency;
$company = $store->company;
$categories = $store->categories->get_categories_with_products();
$product_class = new SimpleStore\Product;


$images = get_files();
$favorites = get_data("favorites");
$distrikts = get_data("distrikts");



/**
 * Functions
 */
function set_lang($lng)
{
    $cookie_name = "language";
    $cookie_value = $lng;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), SITE_ROOT); // 86400 = 1 day
}

function lang($key = "chaim")
{
    global $lang;
    $out =  key_exists($key, $lang) ? $lang[$key] : $key;
    return $out;
}

function redirect($url)
{
    echo "<script>window.location.href = '$url';</script>";
}

function login($pass)
{
    if (urldecode($pass)  == PASS) {
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

function clean_search($str)
{
    return preg_replace('~[^\p{L}\p{N}]++~u', '', $str);
}


function delete_product($category_index, $product_index)
{
    $products = get_data($category_index);
    foreach ($products as $key => $curent_product) {
        if ($curent_product->id ==  $product_index) {
            unset($products[$key]);
        }
    }
    save_json($products, $category_index);
}

function edit_category($id, $key, $value)
{
    global $lng, $store;
    $key = $key == "name" ? "name_" . $lng : $key;
    $store->categories->edit_category($id, $key, $value);
    return true;
}

function delete_category($id)
{
    $categories = get_data("categories");
    foreach ($categories as $key => $category) {
        if ($category->id == $id) {
            unset($categories[$key]);
        }
    }
    unlink(DOC_ROOT . "data/$id.json");
    save_json($categories, 'categories');
}

/**
 * Order
 * TODO: reformat to class
 */
function save_order($cart, $total, $client)
{
    $orders_path = ORDERS_PATH . date('my');
    if (!file_exists($orders_path)) {
        mkdir($orders_path, 0700);
    }
    $orders = get_files($orders_path, ["json"]);
    if(is_countable($orders)){
        $order_count = add_zero(count($orders) + 1);
    }else{
        $order_count = add_zero(1);
    }
    $order_name = date('my-') . $order_count;
    $order_path = $orders_path . "/$order_name.json";

    $order = new stdClass();
    $log_date = date('d/m/y H:i:s');
    $order->id = $order_name;
    $order->date = $log_date;
    $order->items = $cart;
    $order->total = $total;
    $order->client = $client;

    file_put_contents($order_path, json_encode($order, JSON_UNESCAPED_UNICODE));
    send_email($order_name);
    return $order_name;
}

function add_zero($orders)
{
    if ($orders >= 0 && $orders < 10) {
        return '00' . $orders;
    }
    if ($orders >= 10 && $orders < 100) {
        return '0' . $orders;
    }
    if ($orders >= 100) {
        return $orders;
    }
}

function get_orders($month)
{
    $orders_path = ORDERS_PATH . $month;
    if (file_exists($orders_path)) {
        $orders['orders'] = get_files($orders_path, ["json"], 1);
        $orders['month'] = $month;
        return $orders;
    }
    return null;
}

function get_order($order_num = 0)
{
    $order_month = explode("-", $order_num);
    if (count($order_month) != 2) {
        $order_month = date("my");
        $order_num = $order_month . "-" . substr($order_num, -3);
    } else {
        $order_month = $order_month[0];
    }
    $order_path = ORDERS_PATH . $order_month . '/' . $order_num . ".json";
    if (file_exists($order_path)) {
        return json_decode(file_get_contents($order_path));
    } else {
        $order_num = $order_month . "-" . substr($order_num, -3);
        $order_path = ORDERS_PATH . $order_month . '/' . $order_num . ".json";
        if (file_exists($order_path)) {
            return json_decode(file_get_contents($order_path));
        }
    }
    $msg = lang("order_not_found");
    return "<h3>$order_num $msg</h3>";
}

function order_client_to_html($order_num = 0)
{
    $order = get_order($order_num);
    $note = isset($order->client->note) ? $order->client->note : "";
    if (is_object($order)) {
        $html = "<br><h3>" . lang("shipment_address") . "</h3>";
        $html .= "<ul>";
        $html .= "<li>" . lang("name") . ": " . $order->client->name . "</li>";
        $html .= "<li>" . lang("phone") . ": " . $order->client->phone . "</li>";
        $html .= "<li>" . lang("email") . ": " . $order->client->email . "</li>";
        $html .= "<li>" . lang("address") . ": " . $order->client->address . "</li>";
        $html .= "<li>" . lang("note") . ": " . $note . "</li>";
        $html .= '</ul>';
        return $html;
    }
    $msg = lang("client_not_found");
    return "<br>$msg";
}

function order_to_html($order_num = 0)
{
    global $carrency, $lng;
    $direction = $lng != "he" ? "ltr" : "rtl";
    $order = get_order($order_num);
    if (is_object($order)) {
        $style = 'border: 1px solid black;border-collapse: collapse;padding: 5px;font-weight: 700;';
        $th_style = 'text-align: center;background-color: #bce0ff;font-size: larger;';
        $product = lang("product");
        $qtty = lang("qtty");
        $price = lang("price");
        $total = lang("total");
        $approximately = lang("approximately");
        $order_lbl = lang("order");
        $html = "<tr><th style='$style $th_style'>$product</th><th style='$style $th_style'>$qtty</th><th style='$style $th_style'>$price</th></tr>";
        foreach ($order->items as $value) {
            $html .= "<tr>";
            $value = explode(',', $value);
            if ($value[2] != 0) {
                foreach ($value as $td) {

                    $html .= "<td style='$style'>$td</td>";
                }
            }
            $html .= '</tr>';
        }
        $html .= "<tr><td style='$style'>$total - <span style='color:red;'>$approximately ~ </span>
        </td><td colspan='2' style='text-align: center;$style'>$order->total$carrency</td></tr>";

        return "<div style='direction:$direction'><h3 style='text-align: center;background: #bb80a1;color: white;padding: 30px;'>
        $order->date <br> $order_lbl: <span style='direction:rtl'>$order->id </span></h3><table style='width:100%;$style'>$html</table><br>";
    }
    return $order;
}

function clear_cookie()
{
    $ignore = ["PHPSESSID", "language"];
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach ($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        if (!in_array($name, $ignore)) {
            setcookie($name, '', 1);
            setcookie($name, '', 1, SITE_ROOT);
        }
    }
}

//** Helper */

function get_data($file)
{
    $path = DOC_ROOT . "data/$file.json";
    if (file_exists($path)) {
        return json_decode(file_get_contents($path));
    } else {
        return json_decode("[{}]");
    }
}

function get_files($dir = DOC_ROOT . "img/products/", $kind = ["jpeg", "png", "jpg"], $ASC = 0)
{
    $files = array();
    $cdir = scandir($dir, $ASC);
    foreach ($cdir as $file) {
        $extension = explode('.', $file);
        $extension = end($extension);
        if (in_array($extension, $kind)) {
            if (!is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                $files[] =  $file;
            }
        }
    }
    return ($files) ? $files : false;
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
        $msg = lang("image_not_valid");
        echo $msg . ' ' . $image_ext;
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
    $max_h = 800;
    $max_w = 1000;

    list($orig_width, $orig_height) = getimagesize($source);
    $width = $orig_width;
    $height = $orig_height;

    # taller
    if ($height > $max_h) {
        $width = ($max_h / $height) * $width;
        $height = $max_h;
    }

    # wider
    if ($width > $max_w) {
        $height = ($max_w / $width) * $height;
        $width = $max_w;
    }

    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    }

    $resized = imagecreatetruecolor($width, $height);
    imagealphablending($resized, false);
    imagesavealpha($resized, true);

    imagecopyresampled($resized, $image, 0, 0,  0, 0, $width, $height, $orig_width, $orig_height);
    if ($info['mime'] == 'image/jpeg') {
        imagejpeg($resized, $destination, $quality);
    } elseif ($info['mime'] == 'image/gif') {
        imagegif($resized, $destination);
    } elseif ($info['mime'] == 'image/png') {
        imagepng($resized, $destination, 7);
    }
    unlink($source);
}

function save_json($array, $file_name = 'test')
{
    usort($array, function ($a, $b) { //Sort the array using a user defined function
        return $a->name > $b->name ? 1 : -1; //Compare the scores
    });
    file_put_contents(DOC_ROOT . "data/$file_name.json", json_encode(array_values($array), JSON_UNESCAPED_UNICODE));
}

function update_stats()
{
    $stats['total'] = 0;
    $stats['count'] = 0;
    $orders = get_orders(date('my'));
    if (is_array($orders)) {
        foreach ($orders["orders"] as $order) {
            $order = json_decode(file_get_contents(ORDERS_PATH . $orders["month"] . '/' . $order));
            if (property_exists($order, "client")) {
                if ($order->client->name != 'test') {
                    $stats['total'] += $order->total;
                    $stats['count']++;
                }
            }
        }
    }
    file_put_contents(DOC_ROOT . "data/stats.json", json_encode($stats));
}

function get_stats()
{
    $path = DOC_ROOT . 'data/stats.json';
    if (file_exists($path)) {
        return file_get_contents($path);
    } else {
        update_stats();
        return file_get_contents($path);
    }
}

function str_contains($haystack, $needle, $ignoreCase = true)
{
    if ($ignoreCase) {
        $haystack = strtolower($haystack);
        $needle   = strtolower($needle);
    }
    $needlePos = strpos($haystack, $needle);
    return ($needlePos === false ? false : ($needlePos + 1));
}

function send_email($order_num = 0)
{
    global $company;
    $msg = lang("email_not_useble");
    if ($order_num != 0) {
        $to = $company->email;
        $subject = "New Order " . $order_num;
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . SITE_ROOT . "?order=" . $order_num;
        $message =  order_to_html($order_num) . order_client_to_html($order_num) .
            "<b style='color:red;'> $msg <a href='https://wa.me/972$company->phone'>whatsapp</a> </b><br><br>" .
            "<br> Sent from <a target='_blank' href='$actual_link'> $actual_link</a><br><br><br><br>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: admin@mc88.co.il" . "\r\n";
        $headers .= "CC: " . get_order($order_num)->client->email . "\r\n";
        $headers .= "Bcc: gchaimke@gmail.com" . "\r\n";

        mail($to, $subject, $message, $headers);
        return $message;
    }
}


function export_csv()
{
    global $store;
    global $lng;
    $company_name = str_replace(" ", "_", $store->company->name);
    $file_name =  $company_name . ".csv";
    $categories = $store->categories->get_categories_with_products();

    //$fp = fopen('php://output', 'w');
    $fp = fopen(DOC_ROOT . "data/" . $file_name, 'w');
    fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
    fputcsv($fp, array("Category", "Name", "Price"));

    foreach ($categories as $category) {
        $name = 'name_' . $lng;
        foreach ($category->products as $product) {
            if (property_exists($product, $name)) {
                fputcsv($fp, array($category->$name, $product->$name, $product->price));
            } else {
                fputcsv($fp, array($category->$name, $product->name, $product->price));
            }
        }
    }
    fclose($fp);
}
/**
 * TO DO: Use one time
 */
function update_products_id($category_index = '')
{
    if ($category_index != '') {
        $category = get_category($category_index);
        if (isset($category)) {
            $products = get_data($category_index);
            foreach ($products as $key => $product) {
                if (!property_exists($product, 'id')) {
                    $product->id = $category->last_index;
                    $products[$key] = $product;
                    $category->last_index++;
                }
            }
            save_json($products, $category_index);
            edit_category($category_index, "last_index", $category->last_index);
            echo lang("updated");
            return;
        }
    }
    echo 'no category with id ' . $category_index;
}

function old_to_new()
{
    if (file_exists(ORDERS_PATH . "05_21.json")) {
        $orders = json_decode(file_get_contents(ORDERS_PATH . "05_21.json"));
    } else {
        $orders = array();
    }
    $tmp = [];
    foreach ($orders as $order) {
        $order_path = ORDERS_PATH . date("my/") . date("my_") . substr($order->id, -3) . ".json";
        file_put_contents($order_path, json_encode($order, JSON_UNESCAPED_UNICODE));
    }
    return $tmp;
}
