<?php

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/Router.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Controllers/ProductController.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';
require_once __DIR__ . '/../src/JwtMiddleware.php';

// Initialize the database connection
$database = new Database();
$db = $database->getConnection();

// Initialize the ProductController
$productController = new ProductController($db);
$authController = new AuthController($db);

// Initialize the router
$router = new Router();



// Public routes (no authentication required)
$router->post('/login', function() use ($authController) {
    $authController->login();
});

$router->post('/register', function() use ($authController) {
    $authController->register();
});

// Define routes
$router->post('/products', function() use ($productController) {
    JwtMiddleware::authenticate(); // Check JWT first
    $productController->createProduct();
});

$router->get('/products', function() use ($productController) {
    JwtMiddleware::authenticate(); // Check JWT first
    $productController->getProducts();
});

$router->get('/products/{id}', function($id) use ($productController) {
    JwtMiddleware::authenticate(); // Check JWT first
    $productController->getProduct($id);
});

$router->put('/products/{id}', function($id) use ($productController) {
    JwtMiddleware::authenticate(); // Check JWT first
    $productController->updateProduct($id);
});

$router->delete('/products/{id}', function($id) use ($productController) {
    JwtMiddleware::authenticate(); // Check JWT first
    $productController->deleteProduct($id);
});

// Resolve the current request
$router->resolve();
