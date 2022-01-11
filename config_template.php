<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Direct access not allowed');
    exit();
};
define("SP_SITE_ROOT", "/");
define("SP_USER_DATA", "data/");
define("SP_DOC_ROOT", $_SERVER['DOCUMENT_ROOT'] . SP_SITE_ROOT);
define("SP_DATA_ROOT", $_SERVER['DOCUMENT_ROOT'] . SP_SITE_ROOT . SP_USER_DATA);
define("PASS", '');
define("ADMIN_PASS", '');
define("SITE_LANG", "ru");