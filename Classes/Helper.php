<?php

namespace SimpleStore;

class Helper
{
    public static function log($msg, $kind = 1)
    {
        $kinds = [1 => "INFO", 2 => "ERROR"];
        $log_folder = DOC_ROOT . "data/log/" . date("m");
        if (!file_exists(DOC_ROOT . "data/log/")) {
            mkdir(DOC_ROOT . "data/log/", 0600);
        }
        if (!file_exists($log_folder)) {
            mkdir($log_folder, 0600);
        }
        $file = $log_folder . "/" . date('d');
        $msg = date("Y-m-d H:i:s") . " [" . $kinds[$kind] . "] " . $msg . PHP_EOL;
        file_put_contents($file, $msg, FILE_APPEND);
    }
}