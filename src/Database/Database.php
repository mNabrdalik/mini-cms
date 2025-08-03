<?php

namespace MiniCMS\Database;

use PDO;
use PDOException;

class Database {
    //stores a single instance variable - this is typical for Singleton
    private static ?self $instance = null;

    private PDO $connection;

    private function __construct(
        private string $servername,
        private string $dbname,
        private string $username,
        private string $password
    ) {
        $this->connect();
    }

    public static function getInstance(string $servername, string $dbname, string $username, string $password): self {
        //check if instance is created for the first time 
        if (self::$instance === null) {
            self::$instance = new self($servername, $dbname, $username, $password);
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }

    private function connect(): void {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->servername};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }
}