<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Direct access not allowed');
    exit();
};
define("SITE_ROOT", "/");
define("USER_DATA", "data/");
define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT'] . SITE_ROOT);
define("DATA_ROOT", $_SERVER['DOCUMENT_ROOT'] . SITE_ROOT . USER_DATA);
define("PASS", 'p@$$word');
define("ADMIN_PASS", 'Sdrm1415');
define("SITE_LANG", "ru");