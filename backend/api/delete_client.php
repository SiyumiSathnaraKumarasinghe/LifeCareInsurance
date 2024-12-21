<?php
// Enable CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Include the database connection
include '../config.php';

// Retrieve the client ID from the POST request
$data = json_decode(file_get_contents("php://input"));
$client_id = $data->id;

// Query to delete the client
$query = "DELETE FROM clients WHERE id = ?";

// Prepare the statement
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $client_id);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Client deleted successfully']);
} else {
    echo json_encode(['message' => 'Failed to delete client']);
}

// Close the connection
$stmt->close();
$conn->close();
?>
