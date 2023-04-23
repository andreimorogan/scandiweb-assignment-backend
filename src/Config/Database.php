<?php

namespace Scandiweb\Config;

use PDO;
use PDOException;

class Database
{
    private $dsn;
    private $conn;
    private $env;

    public function __construct()
    {
        $this->env = parse_ini_file(__DIR__ . '/../Config/.env');
        $dbType = 'mysql';
        $dbName = $this->env['DB_NAME'];
        $charset = 'utf8mb4';
        $host = $this->env['DB_HOST'];
        $user = $this->env['DB_USER'];
        $password = $this->env['DB_PASS'];
        $this->dsn = "$dbType:charset=$charset;dbname=$dbName;host=$host;$user;$password";
    }

    public function connect()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->env['DB_USER'], $this->env['DB_PASS']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function query($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function prepare($query)
    {
        try {
            return $this->conn->prepare($query);
        } catch (PDOException $e) {
            echo "Query prepare failed: " . $e->getMessage();
        }
    }

    public function execute($statement, $params = [])
    {
        try {
            return $statement->execute($params);
        } catch (PDOException $e) {
            echo "Query execute failed: " . $e->getMessage();
        }
    }
}
