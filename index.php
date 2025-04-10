<?php

use App\Framework\{Router, Response, Request, Mysql};
use App\Controllers\{ExampleController, ProductController};

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/autoload.php';
require __DIR__ . '/helpers.php';

$router = new Router();

//Mysql::getInstance()->migrate('Database/migrations');

$router->get('/', function () {
    response()->sendHtml('Views/index.html', ['title' => 'Home']);
});


$router->get('/products', [ProductController::class, 'productsPagination']);
$router->get('/products/create', [ProductController::class, 'productCreateForm']);
$router->get('/products/update/{id}', [ProductController::class, 'productUpdateForm']);
$router->post('/products', [ProductController::class, 'productCreate']);
$router->put('/products/{id}', [ProductController::class, 'productUpdate']);
$router->delete('/products/{id}', [ProductController::class, 'productDelete']);

$router->boot();



