<?php


namespace App\Framework;

use App\Framework\SQL\SqlBuilder;

class Mysql
{
    private static Mysql $instance;
    public readonly \PDO $pdo;
    private const string USER = 'test';
    private const string PASS = 'Test@123';
    private const int PORT = 3306;
    private const string DB_NAME = "php-stock";
    private const string HOST = "localhost";

    public function __construct()
    {
        $this->pdo = new \PDO($this->getDNS(), self::USER, self::PASS);
        $this->createDatabase();
    }

    public static function getInstance(): Mysql
    {
        if (!isset(self::$instance)) {
            self::$instance = new Mysql();
        }

        return self::$instance;
    }

    private function getDNS(): string
    {
        $host = self::HOST;
        $port = self::PORT;
        $database = self::DB_NAME;
        return "mysql:host=$host;port=$port;dbname=$database";
    }

    private function createDatabase(): void
    {
        $database = "`" . self::DB_NAME . "`";
        $this->pdo->exec("CREATE DATABASE IF NOT EXISTS $database");
    }

    public function migrate(string $migrationsDir): void
    {
        $migrationsDir = __ROOT__ . "/" . $migrationsDir;

        foreach (scandir($migrationsDir) as $fileName) {
            if ($fileName === '.' || $fileName === '..') continue;
            $fileDir = $migrationsDir . "/" . $fileName;
            $file = fopen($fileDir, "r");
            $fileSize = filesize($fileDir);

            if ($fileSize <= 0) {
                fclose($file);
                continue;
            }

            $fileContent = fread($file, $fileSize);
            $this->pdo->exec($fileContent);
            fclose($file);
        }
    }

    public function fetch(string $sql): array|null
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($data)) {
            return null;
        }

        return $data;
    }

    public function query(string $table): array
    {
        $sql = new SqlBuilder()->table($table)->query();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function total(string $model): int
    {
        $primaryKey = property_exists($model, 'PRIMARY_KEY') ? $model::PRIMARY_KEY : 'id';
        $table = $model::$table;
        $sql = "SELECT COUNT($primaryKey) FROM $table";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function paginate(string $model, int $limit, int $page, string $orderBy, string $orderColumn): array
    {

        $orderColumn = camelCaseToSnakeCase($orderColumn);

        if (!in_array($orderColumn, $model::FIELDS)) {
            throw new \PDOException("Invalid Column: {$orderColumn}");
        }

        if (!in_array(strtoupper($orderBy), ['ASC', 'DESC'])) {
            throw new \PDOException("Invalid Direction Order: {$orderBy}");
        }

        $table = $model::$table;
        $fields = implode(', ', $model::FIELDS);

        $sql = "SELECT {$fields} FROM {$table} ORDER BY $orderColumn $orderBy LIMIT :limit OFFSET :offset";
        $offset = $limit * ($page - 1);
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $statement->execute();


        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $items = [];

        foreach ($rows as $row) {
            $objClass = new $model();

            foreach ($model::FIELDS as $field) {
                $objClassField = $field;

                if (!property_exists($objClass, $field)) {
                    $objClassField = snakeCaseToCamelCase($field);
                }

                $objClass->$objClassField = $row[$field];
            }

            $items[] = $objClass;
        }

        $totalItems = count($items);
        $totalPages = intval(ceil($this->total($model) / $limit));
        $hasNextPage = $page < $totalPages;
        $hasPreviousPage = $page > 1;

        return [
            'items' => $items,
            'limit' => $limit,
            'page' => $page,
            'total_items' => $totalItems,
            'total_pages' => $totalPages,
            'has_next_page' => $hasNextPage,
            'has_previous_page' => $hasPreviousPage,
        ];
    }

    /**
     * @template  T
     * @param T $model
     * @param string $id
     * @return T
     */
    public function findById(string $model, string $id): mixed
    {
        $table = $model::$table;
        $primaryKey = property_exists($model, 'PRIMARY_KEY') ? $model::PRIMARY_KEY : 'id';
        $fields = implode(', ', $model::FIELDS);

        $sql = "SELECT {$fields} FROM {$table} WHERE {$primaryKey} = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(":id", $id, \PDO::PARAM_INT);
        $statement->execute();
        $object = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!$object) {
            return null;
        }

        $objClass = new $model();

        foreach ($model::FIELDS as $field) {

            $objClassField = $field;

            if (!property_exists($objClass, $field)) {
                $objClassField = snakeCaseToCamelCase($field);
            }

            $objClass->$objClassField = $object[$field];
        }


        return $objClass;
    }

    public function create(string $model, array $data): void
    {
        $table = $model::$table;
        $keys = implode(', ', array_keys($data));
        $values = implode(', :', array_keys($data));

        $sql = "INSERT INTO $table ($keys) VALUES (:$values)";
        $statement = mysql()->pdo->prepare($sql);

        foreach (array_keys($data) as $key) {
            $statement->bindParam(":$key", $data[$key]);
        }

        $statement->execute();
    }

    public function update(string $model, int|string $id, array $data): void
    {
        $table = $model::$table;
        $primaryKey = property_exists($model, 'PRIMARY_KEY') ? $model::PRIMARY_KEY : 'id';

        $keys = array_map(fn($key) => "$key = :$key", array_keys($data));
        $keys = implode(', ', $keys);

        $sql = "UPDATE $table SET $keys WHERE $primaryKey = :id";
        $statement = $this->pdo->prepare($sql);

        $statement->bindParam(":id", $id);

        foreach (array_keys($data) as $key) {
            $statement->bindParam(":$key", $data[$key]);
        }

        $statement->execute();
    }

    public function deleteById(string $model, int $id): void
    {
        $table = $model::$table;
        $primaryKey = property_exists($model, 'PRIMARY_KEY') ? $model::PRIMARY_KEY : 'id';

        $sql = "DELETE FROM $table WHERE $primaryKey = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();
    }
}