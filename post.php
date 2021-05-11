<?php
require_once('functions/helper.php');

if (isset($_POST['edit_product'])) {
    if (!empty($_POST['category'])) {
        $product = new_product($_POST['name'], $_POST['description'], $_POST['price'], $_POST['kind'], $_POST['picture']);
        edit_product(clean($_POST['category']),  clean($_POST['product']), $product);
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
        duplicate_product(clean($_POST['category']), clean($_POST['product']));
    }
    exit;
}

if (isset($_POST['add_category'])) {
    add_category($_POST['category_name']);
    exit;
}

if (isset($_POST['edit_category'])) {
    edit_category($_POST['category_index'], $_POST['category_name']);
    exit;
}

if (isset($_POST['delete_category'])) {
    delete_category(clean($_POST['category']));
    exit;
}

if (isset($_POST['edit_company'])) {
    unset($_POST['edit_company']);
    edit_company($_POST);
    echo 'Saved';
    exit;
}

if (isset($_POST['get_form_url'])) {
    save_image(clean($_POST['name']), clean($_POST['url']));
    exit;
}

if (isset($_POST['delete_gallery_image'])) {
    delete_image(clean($_POST['image']));
    exit;
}

if (isset($_POST['cart_log'])) {
    echo cart_log($_POST['cart'],$_POST['total']);
    exit;
}

if (isset($_FILES['file']['name'])) {

    $filename = $_FILES['file']['name'];
    $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);

    $location = DOC_ROOT . "img/products/" . clean($_POST['name']) . "." . $imageFileType;
    /* Valid extensions */
    $valid_extensions = array("jpg", "jpeg", "png");

    $response = "Error";
    /* Check file extension */
    if (in_array(strtolower($imageFileType), $valid_extensions)) {
        /* Upload file */
        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
            $response = clean($_POST['name']) . "." . $imageFileType;
        }
    }

    echo $response;
    exit;
}

echo "Error";
