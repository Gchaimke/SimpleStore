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
    $order = order_to_html($_GET['order']);
    if($logedin){
        $order .= order_client_to_html($_GET['order']);
    }
    print($order."<h2 style='color:green;text-align: center;'>Order sent success,<br> thank you!</h2>");
}
