<?php

require_once __DIR__ . '/../Models/Product.php';

class ProductController
{
    private $product;

    public function __construct($db)
    {
        $this->product = new Product($db);
    }

    // Handle the request to create a new product
    public function createProduct()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->name, $data->description, $data->price, $data->quantity)) {
            $name = $data->name;
            $description = $data->description;
            $price = $data->price;
            $quantity = $data->quantity;

            if ($this->product->create($name, $description, $price, $quantity)) {
                http_response_code(201);
                echo json_encode(['message' => 'Product created successfully.']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to create product.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Incomplete product data.']);
        }
    }

    // Handle the request to get all products
    public function getProducts()
    {
        $products = $this->product->getAll();
        http_response_code(200);
        echo json_encode($products);
    }

    // Handle the request to get a single product by ID
    public function getProduct($id)
    {
        $product = $this->product->getById($id);

        if ($product) {
            http_response_code(200);
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found.']);
        }
    }

    // Handle the request to update a product
    public function updateProduct($id)
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->name, $data->description, $data->price, $data->quantity)) {
            $name = $data->name;
            $description = $data->description;
            $price = $data->price;
            $quantity = $data->quantity;

            if ($this->product->update($id, $name, $description, $price, $quantity)) {
                http_response_code(200);
                echo json_encode(['message' => 'Product updated successfully.']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to update product.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Incomplete product data.']);
        }
    }

    // Handle the request to delete a product
    public function deleteProduct($id)
    {
        if ($this->product->delete($id)) {
            http_response_code(200);
            echo json_encode(['message' => 'Product deleted successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete product.']);
        }
    }
}

