<?php

// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Database configuration
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_PORT', $_ENV['DB_PORT']);
define('DB_DATABASE', $_ENV['DB_DATABASE']);
define('DB_USERNAME', $_ENV['DB_USERNAME']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

// JWT configuration
define('JWT_SECRET', $_ENV['JWT_SECRET']);

// Application settings
define('APP_ENV', $_ENV['APP_ENV']);
define('APP_DEBUG', $_ENV['APP_DEBUG']);
define('APP_URL', $_ENV['APP_URL']);
