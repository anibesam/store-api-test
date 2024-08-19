<?php

class Product
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    // Create a new product
    public function create($name, $description, $price, $quantity)
    {
        $sql = "INSERT INTO products (name, description, price, quantity) VALUES (:name, :description, :price, :quantity)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);

        return $stmt->execute();
    }

    // Get all products
    public function getAll()
    {
        $sql = "SELECT * FROM products";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single product by ID
    public function getById($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update an existing product
    public function update($id, $name, $description, $price, $quantity)
    {
        $sql = "UPDATE products SET name = :name, description = :description, price = :price, quantity = :quantity WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Delete a product by ID
    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}

