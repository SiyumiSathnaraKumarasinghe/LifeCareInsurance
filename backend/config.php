<?php
// Database configuration settings
$host = "localhost"; // Default XAMPP host
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "LifeCare"; // Replace with your database name

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a database connection using mysqli
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection and handle errors
if ($conn->connect_error) {
    // Log error details to a file for debugging
    error_log("Database connection failed: " . $conn->connect_error, 3, __DIR__ . '/error.log');
    die("Connection failed: Please try again later."); // Hide sensitive details from the user
}

// Ensure character set is set to UTF-8 for proper encoding
if (!$conn->set_charset("utf8mb4")) {
    // Log error details to a file for debugging
    error_log("Error loading character set utf8mb4: " . $conn->error, 3, __DIR__ . '/error.log');
    die("Internal error. Please contact the administrator.");
}

// Connection established successfully
?>
