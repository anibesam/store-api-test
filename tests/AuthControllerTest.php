<?php

use PHPUnit\Framework\TestCase;

class AuthControllerTest extends TestCase
{
    private $authController;
    private $db;

    protected function setUp(): void
    {
        require_once __DIR__ . '/../src/Database.php';
        require_once __DIR__ . '/../src/Controllers/AuthController.php';

        $database = new Database();
        $this->db = $database->getConnection();
        $this->authController = new AuthController($this->db);
    }

    public function testLogin()
    {
        // Mock request data
        $_POST['username'] = 'testuser';
        $_POST['password'] = 'testpassword';

        // Call the method
        $this->authController->login();

        // Verify the response (you may need to adjust this based on your method implementation)
        // For example, you could capture the output and verify the JWT token
        // Make sure to handle the response appropriately
    }

    // Add more tests for register method
}
