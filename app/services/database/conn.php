<?php

namespace App\Services\Database;

use PDO;
use PDOException;

class Conn
{
    private static $instance = null;
    private $conn;
    private $host = '127.0.0.1';
    private $dbName = 'boardify';
    private $username = 'root';
    private $password = '';

    private function __construct()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName}",
                $this->username,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
