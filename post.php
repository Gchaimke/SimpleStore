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

if (isset($_POST['add_product'])) {
    if (!empty($_POST['category'])) {
        //new_product($name = 'New Product', $description = '', $price = 50, $kind = 'kg', $img = '')
        $product = new_product($_POST['name'], $_POST['description'], $_POST['price'], $_POST['kind'], $_POST['picture']);
        add_product(clean($_POST['category']), $product);
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
