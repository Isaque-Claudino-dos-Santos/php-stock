<?php

use App\Framework\{Router, Response, Request};

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/helpers.php';
require_once __DIR__ . '/autoload.php';

$router = new Router();

$router->get("/users/{id}", function (Request $request) {
    $id = $request->params['id'];
    $response = new Response(200, "<h1>Hello Users <code>id #$id</code></h1>");

    $response->send();
});

$router->boot();



