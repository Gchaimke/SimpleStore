<?php
include_once('helper.php');

if (isset($_POST['get_stats'])) {
    echo  json_encode(get_stats($_POST['get_stats']));
    exit;
}

if (isset($_POST['update_stats'])) {
    echo update_stats($_POST['update_stats']);
    exit;
}