<?php

if (isset($_GET['add_category']) && $_GET['add_category'] != '') {
    if ($logedin) {
        $new = add_category($categories, $_GET['add_category']);
        save_json($new, 'categories');
        echo 'save_category ok';
    } else {
        echo 'please login';
    }
}

if (isset($_GET['remove_category']) && $_GET['remove_category'] != '') {
    if ($logedin) {
        $new = add_category($categories, $_GET['remove_category'], '1');
        save_json($new, 'categories');
        echo 'save_category ok';
    } else {
        echo 'please login';
    }
}

if (isset($_GET['login'])) {
    include_once('elements/login.php');
    login($_GET['login']);
}

if (isset($_GET['logout'])) {
    logout();
}