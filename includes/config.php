<?php
// Check if constants are already defined to avoid redefinition warnings
if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}
if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', 'admin');
}
if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', 'NewStrongPassword123!');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'crazynaters');
}

// Create the database connection
$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
