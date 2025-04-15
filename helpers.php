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

if (!function_exists('response')) {
    function response(int $status = 200, mixed $content = null): \App\Framework\Response
    {
        return new \App\Framework\Response($status, $content);
    }
}

if (!function_exists('template')) {
    function template(string $file): void
    {
        require(__ROOT__ . "/views/templates/$file" . "_template.html");
    }
}

if (!function_exists('style')) {
    function style(string $file): string
    {
        $host = $_SERVER['HTTP_HOST'];
        $protocol = 'http';

        $href = "$protocol://$host/styles/$file";

        return $href;
    }
}

if (!function_exists('script')) {
    function script(string $file): string
    {
        $host = $_SERVER['HTTP_HOST'];
        $protocol = 'http';

        $href = "$protocol://$host/scripts/$file";

        return $href;
    }
}



















