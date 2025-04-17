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

if (!function_exists('component')) {
    function component(string $file, array|Closure|string ...$data): void
    {

        if (key_exists(0, $data) && is_callable($data[0]) || key_exists(0, $data) && is_string($data[0])) {
            extract(['element' => $data[0]]);
        }

        if (is_array($data)) {
            extract($data);
        }

        require __ROOT__ . "/views/components/$file" . '_component.php';
    }
}














