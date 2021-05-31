<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Direct access not allowed');
    exit();
};

require_once(__DIR__ . '/../config.php');
define("ORDERS_PATH", DOC_ROOT . "data/orders/");
$carrency = "₪";
$company = get_data("company");
$categories = get_data("categories");
$images = get_files();
$favorites = get_data("favorites");
$distrikts = get_data("distrikts");


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

if (isset($_COOKIE['language']) && $_COOKIE['language']) {
    $lng = $_COOKIE['language'];
    require(DOC_ROOT . "lang/$lng.php");
} else {
    $lng = 'ru';
    require(DOC_ROOT . "lang/$lng.php");
}

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
    if ($pass == PASS) {
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

function get_data($file)
{
    $path = DOC_ROOT . "data/$file.json";
    if (file_exists($path)) {
        return json_decode(file_get_contents($path));
    } else {
        return json_decode("{}");
    }
}

function get_files($dir = DOC_ROOT . "img/products/", $kind = ["jpeg", "png", "jpg"])
{
    $result = array();
    $cdir = scandir($dir);
    foreach ($cdir as $value) {
        $extension = explode('.', $value);
        $extension = end($extension);
        if (in_array($extension, $kind)) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }
    return $result;
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

function edit_company($data)
{
    file_put_contents(DOC_ROOT . "data/company.json", json_encode((object)$data, JSON_UNESCAPED_UNICODE));
}

function get_category($id)
{
    global $categories;
    foreach ($categories as $category) {
        if ($category->id == $id) {
            if (!property_exists($category, 'last_index')) {
                $category->last_index = 1;
            }
            return $category;
        }
    }
    return null;
}

function new_product($product_array = array())
{
    global $lng;
    $name = lang("new_product");
    $product = new stdClass();
    if (key_exists('id', $product_array) && $product_array['id'] == '') {
        $product->name = $product_array['name'] != '' ? $product_array['name'] : $name;
        $product->description = $product_array['description'] != '' ? $product_array['description'] : '';
        $product->price = $product_array['price'] != '' ? $product_array['price'] : 50;
        $product->kind = $product_array['kind'] != '' ? $product_array['kind'] : '1kg';
        $product->img = $product_array['img'] != '' ? $product_array['img'] : 'img/product.jpg';
        $product->id = "";
    } else {
        $product->name = $name;
        $product->description = '';
        $product->price = 50;
        $product->kind = '1kg';
        $product->img = 'img/product.jpg';
        $product->id = "";
    }
    return $product;
}

function add_product($category_index, $product)
{
    $category = get_category($category_index);
    $products = get_data($category_index);
    $product = new_product($product);
    $product->id = $category->last_index + 1;
    $products[] = $product;
    save_json($products, $category_index);
    edit_category($category_index, "last_index", $category->last_index + 1);
}

function duplicate_product($category_index, $product_index)
{
    $category = get_category($category_index);
    $products = get_data($category_index);
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

function favorite_product($category_index, $product_index)
{
    $products = get_data($category_index);
    $favorites = get_data("favorites");
    $new_product = new stdClass();
    foreach ($products as $curent_product) {
        if ($curent_product->id == $product_index) {
            $new_product = clone ($curent_product);
        }
    }
    $new_product->id = $category_index . "_" . $product_index;
    $favorites[] = $new_product;
    save_json($favorites, "favorites");
}

function edit_product($category_index, $product)
{
    $products = get_data($category_index);
    $product = (object)$product;
    $product->id = intval($product->id);
    foreach ($products as $key => $curent_product) {
        if ($curent_product->id == $product->id) {
            $products[$key] = $product;
        }
    }
    save_json($products, $category_index);
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

function add_category($name = 'New Category')
{
    $categories = get_data("categories");
    $last_category =  end($categories);
    $category = new stdClass();
    $category->id = isset($last_category->id) ? $last_category->id + 1 : 1;
    $category->name = $name;
    $category->last_index = 1;
    $categories[] = $category;
    $product = new_product();
    $product->id = 1;
    $products[] = $product;
    save_json($categories, 'categories');
    save_json($products, $category->id);
}

function edit_category($id, $key, $value)
{
    $categories = get_data("categories");
    foreach ($categories as $index => $category) {
        if ($category->id == $id) {
            $categories[$index]->$key = $value;
        }
    }
    save_json($categories, 'categories');
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

function save_image($image_name, $url)
{
    global $lng;
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

function save_cart($cart, $total, $client)
{
    $orders_path = ORDERS_PATH . date('my');
    if (!file_exists($orders_path)) {
        mkdir($orders_path, 0700);
    }
    $orders = get_files($orders_path, ["json"]);
    $order_count = add_zero(count($orders) + 1);
    $order_name = date('my_') . $order_count;
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
        $orders['orders'] = get_files($orders_path, ["json"]);
        $orders['month'] = $month;
        return $orders;
    }
    return null;
}

function get_order($order_num = 0)
{
    global $lng;
    $order_month = explode("_", $order_num);
    if (count($order_month) != 2) {
        $order_month = "0521";
        $order_num = $order_month . "_" . substr($order_num, -3);
    } else {
        $order_month = $order_month[0];
    }
    $order_path = ORDERS_PATH . $order_month . '/' . $order_num . ".json";
    if (file_exists($order_path)) {
        return json_decode(file_get_contents($order_path));
    }
    $msg = lang("order_not_found");
    return "<h3>#$order_num $msg</h3>";
}

function order_client_to_html($order_num = 0)
{
    global $lng;
    $order = get_order($order_num);
    if (is_object($order)) {
        $msg = lang("shipment_address");
        $html = "<br><h3>$msg</h3>";
        $html .= "<ul>";
        foreach ($order->client as $key => $value) {
            $html .= "<li>$key: $value</li>";
        }
        $html .= '</ul>';
        return $html;
    }
    $msg = lang("client_not_found");
    return "<br>$msg";
}

function order_to_html($order_num = 0)
{
    global $carrency;
    global $lng;
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
            foreach ($value as $td) {
                $html .= "<td style='$style'>$td</td>";
            }
            $html .= '</tr>';
        }
        $html .= "<tr><td style='$style'>$total (<span style='color:red;'>$approximately</span>) ~</td><td colspan='2' style='text-align: center;$style'>$order->total$carrency</td></tr>";
        return "<h3 style='text-align: center;background: #bb80a1;color: white;padding: 30px;'>$order->date <br> $order_lbl: #$order->id</h3>
        <table style='width:100%;$style'>$html</table><br>";
    }
    return $order;
}

function send_email($order_num = 0)
{
    global $company;
    global $lng;
    $msg = lang("email_not_useble");
    if ($order_num != 0) {
        $to = $company->email;
        $subject = "Order #" . $order_num;
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . SITE_ROOT . "?order=" . $order_num;
        $message =  order_to_html($order_num) . order_client_to_html($order_num) .
            "<b style='color:red;'> $msg <a href='https://wa.me/972$company->phone'>Вотсап</a> </b><br><br>" .
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

function str_contains($haystack, $needle, $ignoreCase = true)
{
    if ($ignoreCase) {
        $haystack = strtolower($haystack);
        $needle   = strtolower($needle);
    }
    $needlePos = strpos($haystack, $needle);
    return ($needlePos === false ? false : ($needlePos + 1));
}


/**
 * TO DO: Delete After Use
 */
function update_products_id($category_index = '')
{
    global $lng;
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
    $orders = json_decode(file_get_contents(ORDERS_PATH . "05_21.json"));
    $tmp = [];
    foreach ($orders as $order) {
        $order_path = ORDERS_PATH . date("my/") . date("my_") . substr($order->id, -3) . ".json";
        file_put_contents($order_path, json_encode($order, JSON_UNESCAPED_UNICODE));
    }
    return $tmp;
}
