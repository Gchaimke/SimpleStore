<?php
require_once('functions/helper.php');
if (isset($_POST['edit_product']) && $logedin) {
    if (!empty($_POST['category'])) {
        echo "edit from category:" . $_POST['category'] . " product:" . $_POST['product'];
    }
    exit;
}

if (isset($_POST['delete_product'])) {
    if (!empty($_POST['category'])) {
        delete_product(clean($_POST['category']), clean($_POST['product']));
        echo "delete from category:" . $_POST['category'] . " product:" . $_POST['product'];
    }
    exit;
}

if (isset($_POST['add_product'])) {
    if (!empty($_POST['category'])) {
        echo "add to category:" . $_POST['category'];
    }
    exit;
}
