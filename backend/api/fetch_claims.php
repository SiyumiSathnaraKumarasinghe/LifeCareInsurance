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

// Query to fetch claims data
$query = "SELECT * FROM claims";
$result = $conn->query($query);

if ($result) {
    $claims = [];
    while ($row = $result->fetch_assoc()) {
        $claims[] = $row;
    }
    echo json_encode($claims); // Return claims as JSON
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['message' => 'Failed to fetch claims.']);
}

// Close the connection
$conn->close();
?>
