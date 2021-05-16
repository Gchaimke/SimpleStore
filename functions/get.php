<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Direct access not allowed');
    exit();
};

if (isset($_GET['login'])) {
    if ($_GET['login'] != '') {
        $login = login($_GET['login']);
    }
}

if (isset($_GET['login_error'])) {
    $message['kind'] = 3;
    $message['text'] = 'Password Error';
}

if (isset($_GET['logout'])) {
    logout();
}

if (isset($_GET['email_order'])) {
    send_email($_GET['email_order']);
}

if (isset($_GET['order'])) {
    $order = order_to_html($_GET['order']);
    if ($logedin) {
        $order .= order_client_to_html($_GET['order']);
    }
    print($order);
    if (isset($_GET['sent'])) {
        $message['kind'] = 1;
        $message['text'] = "Заказ отправлен успешно, будем на связи! <i class=\"far fa-smile-wink\"></i>";
    }
}

if (isset($_GET['update_data'])) {
    update_products_id($_GET['update_data']);
}
