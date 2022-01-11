<?php
include_once('helper.php');

if (isset($_POST['login'])) {
    if ($_POST['password'] != '') {
        $login = login($_POST['password']);
        if ($login) {
            echo "true";
        }else{
            echo lang("password_error");
        }
    }
}

if (isset($_POST['logout'])) {
    logout();
}

if (isset($_POST['edit_product'])) {
    if (!empty($_POST['category_id'])) {
        if (empty($_POST['id'])) {
            echo $store->product->new_product(clean($_POST['category_id']), $_POST);
        } else {
            echo $store->product->edit_product(clean($_POST['category_id']), $_POST);
        }
    }
    exit;
}

if (isset($_POST['get_stats'])) {
    echo  json_encode(get_stats($_POST['get_stats']));
    exit;
}

if (isset($_POST['prev_stats'])) {
    echo update_stats($_POST['prev_stats']);
    exit;
}

if (isset($_POST['update_stats'])) {
    echo update_stats($_POST['update_stats']);
    exit;
}


if (isset($_POST['get_from_url'])) {
    $name = str_replace([' ', '%', '\\'], '_', $_POST['name']);
    save_image($name, clean($_POST['url']));
    exit;
}

if (isset($_FILES['file']['name'])) {

    $filename = $_FILES['file']['name'];
    $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);
    $save_name = str_replace([' ', '%', '\\'], '_', $_POST['name']);
    $tmp = SP_DATA_ROOT . "products/tmp.$imageFileType";
    $location = SP_DATA_ROOT . "products/$save_name.$imageFileType";
    /* Valid extensions */
    $valid_extensions = array("jpg", "jpeg", "png");

    $response = "Error";
    /* Check file extension */
    if (in_array(strtolower($imageFileType), $valid_extensions)) {
        /* Upload file */
        if (move_uploaded_file($_FILES['file']['tmp_name'], $tmp)) {
            $response = $save_name . "." . $imageFileType;
            compressImage($tmp, $location, 60);
        }
    }

    echo $response;
    exit;
}

if (isset($_POST['delete_gallery_image'])) {
    delete_image(clean($_POST['image']));
    exit;
}

if (isset($_POST['view_cart'])) {
    echo $cart->view_cart();
    exit;
}

if (isset($_POST['view_total'])) {
    echo $cart->get_total();
    exit;
}

if (isset($_POST['search'])) {
    if (strlen($_POST['search']) >= 1) {
        $search = clean_search($_POST['search']);
        $str = "";
        $name = 'name_' . $lng;
        foreach ($categories as $category) {
            $products = get_data($category->id);
            if (is_iterable($products)) {
                foreach ($products as $product) {
                    if (property_exists($product, $name)) {
                        $search_name = clean_search($product->$name);
                    } else {
                        $search_name = clean_search($product->name);
                    }
                    if (stripos($search_name, $search) !== false) {
                        $str .= $category->id . "_" . $product->id . ",";
                    } else if (stripos($search_name, substr($search, 2)) !== false) {
                        $str .= $category->id . "_" . $product->id . ",";
                    }
                }
            }
        }
        echo "FOUND:" . $str;
    } else {
        echo "Min chars 3";
    }
    exit;
}
