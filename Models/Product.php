<?php


namespace App\Models;


use PDO;

class Product
{
    public static string $table = "products";
    public const array FIELDS = ['id', 'name', 'description', 'price', 'created_at', 'updated_at', 'ecommerce_id'];

    public int $id;

    public string $name;
    public string $description;
    public float $price;
    public ?int $ecommerceId;
    public string $createdAt;
    public string $updatedAt;

    public function ecommerce(): Ecommerce|null
    {
        $table = Ecommerce::$table;
        $fields = implode(', ', Ecommerce::FIELDS);
        $sql = "SELECT $fields FROM $table WHERE id = :id";
        $statement = mysql()->pdo->prepare($sql);
        $statement->bindParam(":id", $this->ecommerceId);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $ecommerce = new Ecommerce();
        $ecommerce->id = $this->id;
        $ecommerce->name = $row['name'];
        $ecommerce->createdAt = $row['created_at'];
        $ecommerce->updatedAt = $row['updated_at'];
        return $ecommerce;
    }

}