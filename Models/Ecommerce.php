<?php


namespace App\Models;

class Ecommerce
{
    public const string TABLE = "ecommerces";
    public const array FIELDS = ['id', 'name', 'created_at', 'updated_at'];
    public int $id;
    public string $name;
    public string $createdAt;
    public string $updatedAt;
}