<?php

use App\Framework\{Router, Request};
use App\Controllers\{ProductController, EcommerceController};

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/autoload.php';
require __DIR__ . '/helpers.php';

$router = new Router();

// ## Route to return styles system ##
$router->get('/styles/{file}', function (Request $request) {
    $file = $request->params['file'];
    response()->sendCSS("/views/assets/styles/$file");
});

// ## Route to return scripts system ##
$router->get('/scripts/{file}', function (Request $request) {
    $file = $request->params['file'];
    response()->sendJS("/views/assets/scripts/$file");
});


$router->get('/', function () {
    response()->sendHtml('views/index.php', ['title' => 'Home']);
});


$router->get('/products', [ProductController::class, 'productsPagination']);
$router->get('/products/create', [ProductController::class, 'productCreateForm']);
$router->get('/products/update/{id}', [ProductController::class, 'productUpdateForm']);
$router->post('/products', [ProductController::class, 'productCreate']);
$router->put('/products/{id}', [ProductController::class, 'productUpdate']);
$router->delete('/products/{id}', [ProductController::class, 'productDelete']);


$router->get('/ecommerces', [EcommerceController::class, 'ecommercePagination']);
$router->get('/ecommerces/create', [EcommerceController::class, 'ecommerceCreateForm']);
$router->get('/ecommerces/update/{id}', [EcommerceController::class, 'ecommerceUpdateForm']);
$router->post('/ecommerces', [EcommerceController::class, 'ecommerceCreate']);
$router->put('/ecommerces/{id}', [EcommerceController::class, 'ecommerceUpdate']);
$router->delete('/ecommerces/{id}', [EcommerceController::class, 'ecommerceDelete']);

$router->boot();




