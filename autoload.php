<?php

spl_autoload_register(function ($class) {

    $class = str_replace("\\", "/", $class);
    $class = str_replace("App", "", $class);
    $class = $class . ".php";

    $class = __DIR__ . $class;

    if (!file_exists($class)) {
        return;
    }

    require_once $class;

});