<?php


namespace App\Framework;

class Mysql
{
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
}