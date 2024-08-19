<?php

class Database
{
    private $host = "db"; // Use the service name defined in docker-compose
    private $db_name = "storeapp";
    private $username = "root";
    private $password = "wjzpbvrk";
    private $conn;

    // Get the database connection
    public function getConnection()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
