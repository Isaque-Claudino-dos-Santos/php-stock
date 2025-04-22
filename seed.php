<?php

use App\Models\Product;
use App\Models\Ecommerce;

require __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/autoload.php';
require __DIR__ . '/helpers.php';

mysql()->migrate('Database/migrations');

mysql()->create(Ecommerce::class, [
    'name' => 'Lojinha das roupas'
]);

mysql()->create(Product::class, [
    'name' => 'camisa',
    'price' => 5.92,
    'description' => 'Camisa GG',
    'ecommerce_id' => 1,
]);

