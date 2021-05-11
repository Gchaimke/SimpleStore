<?php

if (isset($_GET['login'])) {
    if ($_GET['login'] != '') {
        $login = login($_GET['login']);
    }
    include_once('elements/login.php');
}

if (isset($_GET['login_error'])) {
    echo "<script>alert('Password Error');</script>";
    include_once('elements/login.php');
}

if (isset($_GET['logout'])) {
    logout();
}

if (isset($_GET['email_order'])) {
    send_email($_GET['email_order']);
}

if (isset($_GET['order'])) {
    $order = get_order($_GET['order']);
    print_r($order);
}

if (isset($_GET['client'])) {
    $client = get_order_client($_GET['client']);
    print_r($client);
}