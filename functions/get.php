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

if (isset($_GET['csv'])) {
    export_csv();
}

if (isset($_GET['order'])) {
    $order = order_to_html($_GET['order']);
    if ($logedin) {
        $order .= order_client_to_html($_GET['order']);
        $order_num = explode("-", $_GET['order']);
        $next = $order_num[0] . "-" . add_zero(intval($order_num[1]) + 1);
        $prev = $order_num[0] . "-" . add_zero(intval($order_num[1]) - 1);
        $order .= "<div id='order_controls'><a href='?order=$prev'>Previos</a><a href='?order=$next'>Next</a></div>";
    }
    print($order);
    if (isset($_GET['sent'])) {
        $msg = lang("order_send_success");
        $message['kind'] = 1;
        $message['text'] = "$msg <i class=\"far fa-smile-wink\"></i>";
    }
}
