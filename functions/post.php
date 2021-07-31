<?php
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
            'options' => $_POST['options'],
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
    $company->update($_POST);
    exit;
}

if (isset($_POST['delete_gallery_image'])) {
    delete_image(clean($_POST['image']));
    exit;
}

if (isset($_POST['get_form_url'])) {
    $name = str_replace([' ', '%', '\\'], '_', $_POST['name']);
    save_image($name, clean($_POST['url']));
    exit;
}

if (isset($_FILES['file']['name'])) {

    $filename = $_FILES['file']['name'];
    $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);
    $save_name = str_replace([' ', '%', '\\'], '_', $_POST['name']);
    $tmp = DOC_ROOT . "img/products/tmp.$imageFileType";
    $location = DOC_ROOT . "img/products/$save_name.$imageFileType";
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

if (isset($_POST['set_lang'])) {
    set_lang($_POST['language']);
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

if (isset($_POST['add_to_cart'])) {
    $product = explode("_", $_POST['product']);
    $category_id = $product[0];
    $product_id = $product[1];
    $cart->add_to_cart($products_class->get_product($category_id, $product_id));
    exit;
}

if (isset($_POST['remove_product'])) {
    $cart->remove_from_cart($_POST['remove_product']);
    exit;
}

if (isset($_POST['minus_product'])) {
    $cart->minus_from_cart($_POST['minus_product']);
    exit;
}
