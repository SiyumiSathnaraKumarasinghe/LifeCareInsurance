<?php
// Enable CORS headers for cross-origin requests
header("Access-Control-Allow-Origin: *"); // Allow all origins; restrict to specific origin if needed
header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allowed HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allowed headers
header("Access-Control-Max-Age: 3600"); // Cache preflight response for 1 hour

// Handle OPTIONS preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include '../config.php'; // Adjust path as needed

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON payload
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $id = $data['id'];

        // Prepare and execute the query to delete the claim
        $stmt = $conn->prepare("DELETE FROM claims WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Claim deleted successfully.']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Failed to delete claim.']);
        }

        $stmt->close();
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Invalid input. Claim ID is required.']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Method not allowed.']);
}

$conn->close();
?>
