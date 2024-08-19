<?php

class User
{
    private $conn;
    private $table = 'users';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($username, $password)
    {
        $query = "INSERT INTO " . $this->table . " (username, password) VALUES (:username, :password)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function findByUsername($username)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
