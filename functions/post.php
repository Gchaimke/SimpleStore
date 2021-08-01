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

if (isset($_POST['set_lang'])) {
    set_lang($_POST['language']);
    exit;
}

if (isset($_POST['add_to_cart'])) {
    $product = explode("_", $_POST['product']);
    $category_id = $product[0];
    $product_id = $product[1];
    $product = $products_class->get_product($category_id, $product_id);
    $product->option = isset($_POST['option'])?$_POST['option']:"";
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

