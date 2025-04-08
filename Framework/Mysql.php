<?php


namespace App\Framework;

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
            $fileContent = fread($file, $fileSize);
            $this->pdo->exec($fileContent);
            fclose($file);
        }
    }
}