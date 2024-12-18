<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Enable CORS headers for cross-origin requests
header("Access-Control-Allow-Origin: *"); // Allow all origins; for security, restrict to specific origin if needed
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allowed HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allowed headers
header("Access-Control-Max-Age: 3600"); // Cache preflight response for 1 hour

// Handle OPTIONS preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include '../config.php'; // Adjust path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON payload
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    if (!isset($data['name'], $data['nic'], $data['telephone'], $data['email'], $data['age'], $data['package'])) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Invalid input. All fields are required.']);
        exit;
    }

    // Assign variables
    $name = $data['name'];
    $nic = $data['nic'];
    $telephone = $data['telephone'];
    $email = $data['email'];
    $age = (int)$data['age'];
    $package = $data['package'];
    $non_communicable_diseases = $data['non_communicable_diseases'] ?? '';
    $additional_info = $data['additional_info'] ?? '';

    // Prepare and execute the query
    $stmt = $conn->prepare("INSERT INTO claims (name, nic, telephone, email, age, package, non_communicable_diseases, additional_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Debugging - check if $stmt is valid
    if (!$stmt) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Failed to prepare the statement.', 'error' => $conn->error]);
        exit;
    }

    $stmt->bind_param("ssssisss", $name, $nic, $telephone, $email, $age, $package, $non_communicable_diseases, $additional_info);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Claim submitted successfully!']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Failed to save claim.', 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Method not allowed.']);
}
?>
