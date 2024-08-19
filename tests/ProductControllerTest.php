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
    }

    public function testCreateProduct()
    {
        // Mock request data
        $_POST['name'] = 'Test Product';
        $_POST['description'] = 'A product for testing';
        $_POST['price'] = '99.99';
        $_POST['quantity'] = 10;

        // Call the method
        $this->productController->createProduct();

        // Verify the product was added
        // Note: You'll need to adjust this part based on your actual method implementation
        // For example, you could query the database directly to ensure the product exists
        $stmt = $this->db->prepare("SELECT * FROM products WHERE name = ?");
        $stmt->execute(['Test Product']);
        $product = $stmt->fetch();

        $this->assertNotEmpty($product);
        $this->assertEquals('Test Product', $product['name']);
    }

    // Add more tests for other methods (getProducts, getProduct, updateProduct, deleteProduct)
}
