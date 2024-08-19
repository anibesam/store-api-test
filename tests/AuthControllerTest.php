<?php

use PHPUnit\Framework\TestCase;
use \Firebase\JWT\JWT;

class ProductControllerTest extends TestCase
{
    private $productController;
    private $db;

    protected function setUp(): void
    {
        require_once __DIR__ . '/../src/Database.php';
        require_once __DIR__ . '/../src/Controllers/ProductController.php';

        $database = new Database();
        $this->db = $database->getConnection();
        $this->productController = new ProductController($this->db);

        $this->db->exec("DELETE FROM products");
    }

    public function testCreateProduct()
    {
        
        $_POST['name'] = 'Test Product';
        $_POST['description'] = 'A product for testing';
        $_POST['price'] = '99.99';
        $_POST['quantity'] = 10;

      
        $this->productController->createProduct();

        
        $stmt = $this->db->prepare("SELECT * FROM products WHERE name = ?");
        $stmt->execute(['Test Product']);
        $product = $stmt->fetch();

        $this->assertNotEmpty($product);
        $this->assertEquals('Test Product', $product['name']);
    }

    public function testGetProducts()
    {
        
        $stmt = $this->db->prepare("INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Test Product', 'A product for testing', '99.99', 10]);

        
        ob_start(); 
        $this->productController->getProducts();
        $output = ob_get_clean(); // Get the output and clean the buffer

        $this->assertStringContainsString('Test Product', $output);
    }

    public function testGetProduct()
    {
        
        $stmt = $this->db->prepare("INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Test Product', 'A product for testing', '99.99', 10]);

        
        ob_start(); 
        $this->productController->getProduct(1);
        $output = ob_get_clean(); 

        $this->assertStringContainsString('Test Product', $output);
    }

    public function testUpdateProduct()
    {
        
        $stmt = $this->db->prepare("INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Test Product', 'A product for testing', '99.99', 10]);

      
        $_POST['name'] = 'Updated Product';
        $_POST['description'] = 'Updated description';
        $_POST['price'] = '129.99';
        $_POST['quantity'] = 20;

        
        $this->productController->updateProduct(1);

        
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([1]);
        $product = $stmt->fetch();

        $this->assertEquals('Updated Product', $product['name']);
        $this->assertEquals('Updated description', $product['description']);
        $this->assertEquals('129.99', $product['price']);
        $this->assertEquals(20, $product['quantity']);
    }

    public function testDeleteProduct()
    {
        
        $stmt = $this->db->prepare("INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Test Product', 'A product for testing', '99.99', 10]);

      
        $this->productController->deleteProduct(1);

        
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([1]);
        $product = $stmt->fetch();

        $this->assertEmpty($product);
    }
}
