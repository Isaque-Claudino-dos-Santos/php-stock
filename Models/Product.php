<?php


namespace App\Models;


use PDO;

class Product
{
    public int $id;
    public string $name;
    public string $description;
    public int $price;
    public int $quantity;
    public string $create_at;
    public string $update_at;

    public function create(): void
    {
        $mysql = mysql();

        $sql = 'INSERT INTO products (name, description, price, quantity) VALUES (:name, :description, :price, :quantity)';
        $statement = $mysql->pdo->prepare($sql);
        $statement->bindValue(':name', $this->name);
        $statement->bindValue(':description', $this->description);
        $statement->bindValue(':price', $this->price);
        $statement->bindValue(':quantity', $this->quantity);
        $statement->execute();
    }

    public function update(): void
    {
        $mysql = mysql();

        $sql = 'UPDATE products SET name = :name, description = :description, price = :price, quantity = :quantity WHERE id = :id';
        $statement = $mysql->pdo->prepare($sql);
        $statement->bindValue(':name', $this->name);
        $statement->bindValue(':description', $this->description);
        $statement->bindValue(':price', $this->price);
        $statement->bindValue(':quantity', $this->quantity);
        $statement->bindValue('id', $this->id);
        $statement->execute();
    }

    public static function findById(int $id): Product|null
    {
        $mysql = mysql();


        $sql = "SELECT * FROM products WHERE id = :id";
        $statement = $mysql->pdo->prepare($sql);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $object = $statement->fetchObject();

        if (!$object) {
            return null;
        }

        $product = new Product();
        $product->id = $object->id;
        $product->name = $object->name;
        $product->description = $object->description;
        $product->price = $object->price;
        $product->quantity = $object->quantity;
        $product->create_at = $object->create_at;
        $product->update_at = $object->update_at;

        return $product;
    }

    public static function deleteById(int $id): void
    {
        $mysql = mysql();

        $sql = "DELETE FROM products WHERE id = :id";
        $statement = $mysql->pdo->prepare($sql);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
}