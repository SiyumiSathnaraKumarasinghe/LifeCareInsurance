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

// Retrieve the client data from the POST request
$data = json_decode(file_get_contents("php://input"));

// Query to update the client data
$query = "UPDATE clients SET 
    name = ?, 
    nic = ?, 
    date_of_birth = ?, 
    contact_number = ?, 
    email = ?, 
    address = ?, 
    policy_type = ?, 
    coverage_amount = ?, 
    payment_frequency = ?, 
    beneficiary_name = ?, 
    beneficiary_relationship = ?, 
    height_cm = ?, 
    weight_kg = ?, 
    smoker_status = ?, 
    alcohol_status = ?, 
    medical_conditions = ?, 
    family_medical_history = ?, 
    occupation = ?, 
    annual_income = ?, 
    payment_mode = ?, 
    bank_account_details = ?, 
    emergency_contact_name = ?, 
    emergency_contact_relationship = ?, 
    emergency_contact_number = ? 
    WHERE id = ?";

// Prepare and execute the statement
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssssssssssssssssssssssssi", 
    $data->name, $data->nic, $data->date_of_birth, $data->contact_number, $data->email, 
    $data->address, $data->policy_type, $data->coverage_amount, $data->payment_frequency, 
    $data->beneficiary_name, $data->beneficiary_relationship, $data->height_cm, 
    $data->weight_kg, $data->smoker_status, $data->alcohol_status, $data->medical_conditions, 
    $data->family_medical_history, $data->occupation, $data->annual_income, $data->payment_mode, 
    $data->bank_account_details, $data->emergency_contact_name, $data->emergency_contact_relationship, 
    $data->emergency_contact_number, $data->id);

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['message' => 'Client updated successfully']);
} else {
    echo json_encode(['message' => 'Failed to update client']);
}

// Close the connection
$stmt->close();
$conn->close();
?>
