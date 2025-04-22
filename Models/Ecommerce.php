<?php


namespace App\Models;

use App\Framework\Model;

class Ecommerce extends Model
{
    public int $id;
    public string $name;
    public string $createdAt;
    public string $updatedAt;


    public function table(): string
    {
        return 'ecommerces';
    }
}