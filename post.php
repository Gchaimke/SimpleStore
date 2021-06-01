<?php
require_once('functions/helper.php');

if (isset($_POST['edit_product'])) {
    if (!empty($_POST['category'])) {
        $product = array(
            'id' => clean($_POST['product_id']),
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'qtty' => $_POST['qtty'],
            'kind' => $_POST['kind'],
            'img' => $_POST['img'],
        );
        if (!empty($_POST['product_id'])) {
            $product_class->edit_product(clean($_POST['category']), $product);
        } else {
            $store->products->add_product(clean($_POST['category']), $product);
        }
    }
    exit;
}

if (isset($_POST['delete_product'])) {
    if (!empty($_POST['category'])) {
        delete_product(clean($_POST['category']), clean($_POST['product']));
    }
    exit;
}

if (isset($_POST['duplicate_product'])) {
    if (!empty($_POST['category'])) {
        $store->products->duplicate_product(clean($_POST['category']), clean($_POST['product']));
    }
    exit;
}

if (isset($_POST['favorite_product'])) {
    if (!empty($_POST['category'])) {
        $store->products->favorite_product(clean($_POST['category']), clean($_POST['product']));
    }
    exit;
}

if (isset($_POST['add_category'])) {
    $store->categories->add_category($_POST['category_name']);
    exit;
}

if (isset($_POST['edit_category'])) {
    edit_category($_POST['category_index'], "name", $_POST['category_name']);
    exit;
}

if (isset($_POST['delete_category'])) {
    delete_category(clean($_POST['category']));
    exit;
}

if (isset($_POST['edit_company'])) {
    unset($_POST['edit_company']);
    $company->update($_POST);
    echo 'Saved';
    exit;
}

if (isset($_POST['save_cart'])) {
    echo save_order($_POST['cart'], $_POST['total'], $_POST['client']);
    exit;
}

if (isset($_POST['set_cookie'])) {
    $cookie_name = $_POST['name'];
    $cookie_value = $_POST['data'];
    setcookie($cookie_name, json_encode($cookie_value, JSON_UNESCAPED_UNICODE), time() + (86400 * 30), SITE_ROOT); // 86400 = 1 day
    print_r($_COOKIE);
    exit;
}

if (isset($_POST['remove_cookie'])) {
    $cookie_name = $_POST['name'];
    unset($_COOKIE[$cookie_name]);
    if (isset($_COOKIE[$cookie_name])) {
        foreach ($_COOKIE as $cookieKey => $cookieValue) {
            if (strpos($cookieKey, $cookie_name) === 0) {
                // remove the cookie
                setcookie($cookieKey, null, -1);
                unset($_COOKIE[$cookieKey]);
            }
        }
    }
    setcookie($cookie_name, null, -1, SITE_ROOT);
    exit;
}

if (isset($_POST['remove_all_cookie'])) {
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

if (isset($_POST['get_form_url'])) {
    $name = str_replace(' ', '_', $_POST['name']);
    save_image($name, clean($_POST['url']));
    exit;
}

if (isset($_POST['delete_gallery_image'])) {
    delete_image(clean($_POST['image']));
    exit;
}

if (isset($_FILES['file']['name'])) {

    $filename = $_FILES['file']['name'];
    $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);
    $save_name = str_replace(' ', '_', $_POST['name']);
    $location = DOC_ROOT . "img/products/$save_name.$imageFileType";
    /* Valid extensions */
    $valid_extensions = array("jpg", "jpeg", "png");

    $response = "Error";
    /* Check file extension */
    if (in_array(strtolower($imageFileType), $valid_extensions)) {
        /* Upload file */
        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
            $response = $save_name . "." . $imageFileType;
        }
    }

    echo $response;
    exit;
}

if (isset($_POST['get_stats'])) {
    echo get_stats();
    exit;
}

if (isset($_POST['set_lang'])) {
    set_lang($_POST['language']);
    exit;
}


if (isset($_POST['update_stats'])) {
    update_stats();
    echo 'ok';
    exit;
}

if (isset($_POST['search'])) {
    if (strlen($_POST['search']) >= 3) {
        $search = $_POST['search'];
        $str = "";
        foreach ($categories as $category) {
            $products = get_data($category->id);
            if (is_iterable($products)) {
                foreach ($products as $product) {
                    $search_name = str_replace(' ', '', $product->name);
                    if (stripos($search_name, $search) !== false) {
                        $str .= $category->id . "_" . $product->id . ",";
                    }
                }
            }
        }
        echo $str;
    } else {
        echo "Min chars 3";
    }
    exit;
}


echo "Error";
