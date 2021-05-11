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

if (isset($_GET['email'])) {
    send_email(512002);
}


