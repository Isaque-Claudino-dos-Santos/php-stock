<?php


namespace App\Models;


use App\Framework\Model;

class Product extends Model
{
    public int $id;

    public string $name;
    public string $description;
    public float $price;
    public ?int $ecommerceId;
    public string $createdAt;
    public string $updatedAt;

    public function table(): string
    {
        return "products";
    }

    public function ecommerce(): Ecommerce|null
    {
        return self::statement()->belongToOne(Ecommerce::class, $this->ecommerceId);
    }

}