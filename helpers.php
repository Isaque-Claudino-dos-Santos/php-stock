<?php


use  \App\Framework\Mysql;

if (!function_exists('dd')) {
    function dd(mixed $value, bool $noExist = false): void
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';

        if (!$noExist) {
            exit;
        }
    }
}


if (!function_exists('mysql')) {
    function mysql(): Mysql
    {
        return Mysql::getInstance();
    }
}