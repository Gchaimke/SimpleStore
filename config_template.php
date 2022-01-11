<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Direct access not allowed');
    exit();
};
define("SP_SITE_ROOT", "/");
define("SP_USER_DATA", "data/");
define("SP_DOC_ROOT", $_SERVER['DOCUMENT_ROOT'] . SP_SITE_ROOT);
define("SP_DATA_ROOT", SP_DOC_ROOT . SP_USER_DATA);
function config()
{
    return array(
        "PASS" => '',
        "ADMIN_PASS" => '',
        "SMTP_EMAIL" => 'sp@mc88.co.il',
        "SMTP_PASS" => '',
        "SMTP_ENCRYPTION" => true,
        "SMTP_ENCRYPTION_TYPE" => "SSL",
        "SMTP_PORT" => '465',
        "SMTP_HOST" => 'smtp.timeweb.ru',
        "SMTP_DEBUG" => false,
        "SMTP_DEBUG_EMAIL" => '',
        "SMTP_BCC_EMAIL" => '',
        "SITE_LANG" => "ru"
    );
}
