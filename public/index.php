<?php

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/Router.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Controllers/ProductController.php';

// Initialize the database connection
$database = new Database();
$db = $database->getConnection();


// Initialize the ProductController
$productController = new ProductController($db);

// Initialize the router
$router = new Router();

// Define routes
$router->post('/products', function() use ($productController) {
    $productController->createProduct();
});

$router->get('/products', function() use ($productController) {
    $productController->getProducts();
});

$router->get('/products/{id}', function($id) use ($productController) {
    $productController->getProduct($id);
});

$router->put('/products/{id}', function($id) use ($productController) {
    $productController->updateProduct($id);
});

$router->delete('/products/{id}', function($id) use ($productController) {
    $productController->deleteProduct($id);
});

// Resolve the current request
$router->resolve();
