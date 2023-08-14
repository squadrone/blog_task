<?php

namespace Project\Services;

use PDO;
use PDOException;

class Database
{
    private static object $instance;
    private PDO $connection;

    private function __construct()
    {
    }

    public static function getInstance(): Database {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect($dsn): PDO|null {
        try {
            $this->connection = new PDO($dsn);
            return $this->connection;
        } catch(PDOException $e) {
            return null;
        }
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}