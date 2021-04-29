<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/helper.php');
if (isset($_POST['edit_product']) && $logedin) {
    echo 'test';
    if (!empty($_POST['category'])) {
        echo "edit from category:" . $_POST['category'] . " product:" . $_POST['product'];
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
