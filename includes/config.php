<?php

// Load environment (safe even if already loaded)
require_once __DIR__ . '/../bootstrap.php';

// Create DB connection using .env
$conn = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD'],
    $_ENV['DB_NAME']
);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>