<?php
// Enable CORS headers for cross-origin requests
header("Access-Control-Allow-Origin: *"); // Allow all origins; restrict to specific origin if needed
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allowed HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allowed headers
header("Access-Control-Max-Age: 3600"); // Cache preflight response for 1 hour

// Handle OPTIONS preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Connect to the database
include '../config.php';

// Query to fetch clients data
$query = "SELECT * FROM clients"; // Adjust the table name if needed
$result = $conn->query($query);

if ($result) {
    $clients = [];
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
    echo json_encode($clients); // Return clients as JSON
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['message' => 'Failed to fetch clients.']);
}

// Close the connection
$conn->close();
?>
