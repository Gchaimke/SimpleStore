<?php

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Direct access not allowed');
    exit();
};
session_start();

/**
 * Config
 */
define("VERSION", "2.2");

require_once(__DIR__ . '/../config.php');
define("ORDERS_PATH", DATA_ROOT . "orders/");

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
$price_format = $store->price_format;
$company = $store->company;
$cart = $store->cart;
$categories = $store->category->get_categories_with_products();
$products_images = get_files();
$site_images = get_files(DOC_ROOT . "img/");
$images = array_merge($site_images, $products_images);
$favorites = get_data("favorites");
$distrikts = get_data("distrikts");

/**
 * Functions
 */

function lang($key = "chaim")
{
    global $lang;
    $key = strtolower($key);
    $out =  key_exists($key, $lang) ? $lang[$key] : $key;
    return $out;
}

function redirect($url)
{
    echo "<script>window.location.href = '$url';</script>";
}

function reload()
{
    echo "<script>location.reload();</script>";
}

function login($pass)
{
    if (urldecode($pass)  == PASS || urldecode($pass)  == ADMIN_PASS) {
        $_SESSION["login"] = true;
        return true;
    } else {
        return false;
    }
}

function logout()
{
    $_SESSION["login"] = '';
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
    $store->category->edit_category($id, $key, $value);
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
    unlink(DATA_ROOT . "$id.json");
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
    $orders = get_files($orders_path, false, ["json"]);
    if (count($orders) > 0) {
        $order_count = add_zero(count($orders) + 1);
    } else {
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
    global $logedin;
    if (!$logedin) redirect(SITE_ROOT);

    $orders_path = ORDERS_PATH . $month;
    if (file_exists($orders_path)) {
        $orders['orders'] = get_files($orders_path, false, ["json"], 1);
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
    global $price_format, $carrency, $lng;
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

        $html = "<tr><th style='$style $th_style'>$product</th>
        <th style='$style $th_style'>$qtty</th>
        <th style='$style $th_style'>$price</th></tr>";
        foreach ($order->items as $item) {
            if (property_exists($item, "qtty")) {
                $name = property_exists($item, "name_" . $lng) ? "name_" . $lng : "name";
                $item_name = $item->$name != "" ? $item->$name : $item->name;
                $description = property_exists($item, "description_" . $lng) ? "description_" . $lng : "description";
                $item_description = $item->$description != "" ? "<i>({$item->$description})</i>" : "";
                $option = property_exists($item, "option") && $item->option != "" ? "($item->option)" : "";
                $cart_price = number_format($item->cart_price, $price_format)  . $carrency;
                $html .= "<tr>";
                $html .= "<td style='$style'>$item_name $item_description $option $item->qtty" . lang($item->kind) . "</td>";
                $html .= "<td style='$style'>$item->cart_qtty" . lang($item->kind) . "</td>";
                $html .= "<td style='$style'>$cart_price</td>";
                $html .= '</tr>';
            } else {
                //TODO: old order compatibility, please remove if you dont have old orders
                $item = explode(",", $item);
                $html .= "<tr>";
                $html .= "<td style='$style'>$item[0] $item[1]</td>";
                $html .= "<td style='$style'>$item[1]</td>";
                $html .= "<td style='$style'>$item[2] $carrency</td>";
                $html .= '</tr>';
            }
        }
        $html .= "<tr><td style='$style'>$total - <span style='color:red;'>$approximately ~ </span>
        </td><td colspan='2' style='text-align: center;$style'>$order->total$carrency</td></tr>";

        return "<div style='direction:$direction'><h3 style='text-align: center;background: #bb80a1;color: white;padding: 30px;'>
        $order->date <br> $order_lbl: <span style='direction:$direction'>$order->id </span></h3><table style='width:100%;$style'>$html</table><br>";
    }
    return $order;
}

//** Helper */

function get_data($file)
{
    $path = DATA_ROOT . "$file.json";
    if (file_exists($path)) {
        return json_decode(file_get_contents($path));
    } else {
        return json_decode("[{}]");
    }
}

function get_files($dir = DOC_ROOT . "data/products/", $keys = true, $kind = ["jpeg", "png", "jpg"], $ASC = 0)
{
    $files = array();
    if (!file_exists($dir)) {
        mkdir($dir, 0700);
    }
    $path = str_replace(DOC_ROOT, "", $dir);
    $cdir = scandir($dir, $ASC);
    foreach ($cdir as $file) {
        $extension = explode('.', $file);
        $extension = end($extension);
        if (in_array($extension, $kind)) {
            if (!is_dir($dir . $file)) {
                if ($keys) {
                    $files[$path . $file] =  $file;
                } else {
                    $files[] =  $file;
                }
            }
        }
    }
    return $files;
}

function save_image($image_name, $url)
{
    $valid_ext = array('png', 'jpeg', 'jpg');
    $image_ext = pathinfo($url, PATHINFO_EXTENSION);
    $image_ext = strtolower($image_ext);

    $tmp = DATA_ROOT . 'tmp.' . $image_ext;
    $location = DATA_ROOT . 'products/' . $image_name . '.' . $image_ext;

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
    if (strpos($image, "/img/") === false) {
        if (unlink(DOC_ROOT . $image)) {
            echo 'success';
        } else {
            echo 'fail';
        }
    } else {
        echo 'img/ folder protected';
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
    file_put_contents(DATA_ROOT . "$file_name.json", json_encode(array_values($array), JSON_UNESCAPED_UNICODE));
}

function update_stats($month = 0)
{
    if ($month == 0) {
        $month = date('my');
    }
    if (file_exists(DATA_ROOT . "stats.json")) {
        $statistic = json_decode(file_get_contents(DATA_ROOT . "stats.json"));
    } else {
        $statistic = json_decode('[{"month":"0","total":0,"count":0}]');
    }
    $current_key = "";
    $orders = get_orders($month);
    $month_stats = new stdClass();
    $month_stats->month = $month;
    $month_stats->total = 0;
    $month_stats->count = 0;
    if (is_array($orders)) {
        foreach ($statistic as $key => $value) {
            if ($value->month == $month) {
                $current_key = $key;
            }
        }
        foreach ($orders["orders"] as $order) {
            $order = json_decode(file_get_contents(ORDERS_PATH . $orders["month"] . '/' . $order));
            if (property_exists($order, "client")) {
                if (isset($order->total) && $order->client->name != 'test') {
                    if (is_numeric($order->total)) {
                        $month_stats->total += $order->total;
                    }
                    $month_stats->count++;
                }
            }
        }
        $month_stats->total = number_format($month_stats->total, 0);
        if ($current_key == "") {
            $statistic[] = $month_stats;
        } else {
            $statistic[$current_key] = $month_stats;
        }
    }
    file_put_contents(DATA_ROOT . "stats.json", json_encode($statistic));
    return $month;
}

function get_stats($month = 0)
{
    if ($month == 0) {
        $month = date('my');
    }
    $path = DATA_ROOT . 'stats.json';
    if (file_exists($path)) {
        $data =  json_decode(file_get_contents($path));
    } else {
        update_stats();
        $data =  json_decode(file_get_contents($path));
    }
    foreach ($data as $stats) {
        if ($stats->month == $month) {
            return $stats;
        }
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
        $phone = str_replace("-", "", $company->phone);
        $subject = "New Order " . $order_num;
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . SITE_ROOT . "?order=" . $order_num;
        $message =  order_to_html($order_num) . order_client_to_html($order_num);
        $message .= $phone != "" ? "<b style='color:red;'> $msg <a href='https://wa.me/972$phone'>whatsapp</a> </b><br><br>" : "";
        $message .=   "<br> Sent from <a target='_blank' href='$actual_link'> $actual_link</a><br><br><br><br>";
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
    $fp = fopen(DATA_ROOT . "" . $file_name, 'w');
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

function debug($data)
{
    if (is_array($data) || is_object($data)) {
        foreach ($data as $key => $value) {
            echo "<br>$key<br>";
            if (is_array($value) || is_object($value)) {
                foreach ($value as $key_1 => $value_1) {
                    if (is_array($value_1) || is_object($value_1)) {
                        foreach ($value_1 as $key_2 => $value_2) {
                            echo "$key_2 => $value_2<br><br>";
                        }
                    } else {
                        echo "$key_1 => $value_1<br>";
                    }
                }
            } else {
                echo "$key => $value<br>";
            }
        }
    } else {
        echo $data . "<br>";
    }
}

function paginate($vars)
{
    extract($vars);
    ob_start();
    include(__DIR__ . '/../elements/layout/pagination.php');
    $output = ob_get_clean();
    print $output;
}
/**
 * TO DO: Use one time
 */
function update_products_data()
{
    global $categories;
    $favorites = new stdClass();
    $favorites->id = "favorites";
    $favorites->name = "favorites";
    $categories[] = $favorites;
    $updated = "";
    foreach ($categories as $category) {
        $category_index = $category->id;
        $category_name = $category->name;
        $products = get_data($category_index);
        foreach ($products as $key => $product) {
            //add property
            if (!property_exists($product, 'category_id')) {
                $product->category_id = $category_index;
                $products[$key] = $product;
            }
            if (!property_exists($product, 'options')) {
                $product->options = "";
                $products[$key] = $product;
            }
            //remove property
            if (property_exists($product, 'kind_ru')) {
                unset($product->kind_ru);
            }
            if (property_exists($product, 'kind_he')) {
                unset($product->kind_he);
            }
        }
        $updated .= $category_name . ", ";
        save_json($products, $category_index);
        //edit_category($category_index, "last_index", $category->last_index);
    }
    echo lang("updated:" . $updated);
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
