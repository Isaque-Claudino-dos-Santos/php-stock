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

    public static function paginate(int $limit, int $page, string $orderBy, string $orderColumn): array
    {

        $allowedColumns = ['id', 'name', 'price', 'quantity', 'description', 'created_at'];
        $allowedOrder = ['ASC', 'DESC'];

        if (!in_array($orderColumn, $allowedColumns)) {
            throw new \PDOException("Invalid Column: {$orderColumn}");
        }

        if (!in_array(strtoupper($orderBy), $allowedOrder)) {
            throw new \PDOException("Invalid Direction Order: {$orderBy}");
        }

        $mysql = mysql();
        $sql = "SELECT * FROM products ORDER BY $orderColumn $orderBy LIMIT :limit OFFSET :offset";
        $offset = $limit * ($page - 1);
        $statement = $mysql->pdo->prepare($sql);
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();


        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        $totalItems = count($products);
        $totalPages = intval(ceil(Product::totalInDatabase() / $limit));
        $hasNextPage = $page < $totalPages;
        $hasPreviousPage = $page > 1;

        return [
            'items' => $products,
            'limit' => $limit,
            'page' => $page,
            'total_items' => $totalItems,
            'total_pages' => $totalPages,
            'has_next_page' => $hasNextPage,
            'has_previous_page' => $hasPreviousPage,
        ];
    }

    public static function totalInDatabase(): int
    {
        $mysql = mysql();
        $sql = 'SELECT COUNT(*) FROM products';
        $statement = $mysql->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

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