<?php
// Database connection
include('includes/db.php');

// Admin username, password (hashed), and email
$username = 'admin';
$password = password_hash('admin123', PASSWORD_BCRYPT); // Use your own password
$email = 'admin@example.com';
$role = 'admin';

// Insert the admin user into the database
$sql = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";

if (mysqli_query($conn, $sql)) {
    echo "Admin user created successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
