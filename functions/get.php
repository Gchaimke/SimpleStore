<?php

if (isset($_GET['login'])) {
    if ($_GET['login'] != '') {
        $login = login($_GET['login']);
    }
}

if (isset($_GET['login_error'])) {
    $message['kind'] = 3;
    $message['text'] = lang("password_error");
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
        $msg = lang("order_send_success");
        $message['kind'] = 1;
        $message['text'] = "$msg <i class=\"far fa-smile-wink\"></i>";
    }
}
