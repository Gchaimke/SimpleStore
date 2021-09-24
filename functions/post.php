<?php

if (isset($_POST['delete_product'])) {
    if (!empty($_POST['category'])) {
        delete_product(clean($_POST['category']), clean($_POST['product']));
    }
    exit;
}

if (isset($_POST['duplicate_product'])) {
    if (!empty($_POST['category'])) {
        $store->product->duplicate_product(clean($_POST['category']), clean($_POST['product']));
    }
    exit;
}

if (isset($_POST['favorite_product'])) {
    if (!empty($_POST['category'])) {
        $store->product->favorite_product(clean($_POST['category']), clean($_POST['product']));
    }
    exit;
}

if (isset($_POST['add_category'])) {
    $store->category->add_category($_POST['category_name']);
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

if (isset($_POST['add_to_cart'])) {
    $product = explode("_", $_POST['product']);
    $category_id = $product[0];
    $product_id = $product[1];
    $product = $store->product->get_product($category_id, $product_id);
    $product->option = isset($_POST['option']) ? $_POST['option'] : "";
    $cart->add_to_cart($product);
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
