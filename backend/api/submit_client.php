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
    $required_fields = [
        'name', 'nic', 'date_of_birth', 'contact_number', 'email', 'address', 'policy_type', 
        'coverage_amount', 'payment_frequency', 'beneficiary_name', 'beneficiary_relationship', 
        'height_cm', 'weight_kg', 'smoker_status', 'alcohol_status', 'medical_conditions', 
        'family_medical_history', 'occupation', 'annual_income', 'payment_mode', 
        'bank_account_details', 'emergency_contact_name', 'emergency_contact_relationship', 'emergency_contact_number'
    ];
    
    foreach ($required_fields as $field) {
        if (!isset($data[$field])) {
            http_response_code(400); // Bad Request
            echo json_encode(['message' => "Missing field: $field"]);
            exit;
        }
    }

    // Sanitize input to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $data['name']);
    $nic = mysqli_real_escape_string($conn, $data['nic']);
    $date_of_birth = mysqli_real_escape_string($conn, $data['date_of_birth']);
    $contact_number = mysqli_real_escape_string($conn, $data['contact_number']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $address = mysqli_real_escape_string($conn, $data['address']);
    $policy_type = mysqli_real_escape_string($conn, $data['policy_type']);
    $coverage_amount = mysqli_real_escape_string($conn, $data['coverage_amount']);
    $payment_frequency = mysqli_real_escape_string($conn, $data['payment_frequency']);
    $beneficiary_name = mysqli_real_escape_string($conn, $data['beneficiary_name']);
    $beneficiary_relationship = mysqli_real_escape_string($conn, $data['beneficiary_relationship']);
    $height_cm = mysqli_real_escape_string($conn, $data['height_cm']);
    $weight_kg = mysqli_real_escape_string($conn, $data['weight_kg']);
    $smoker_status = mysqli_real_escape_string($conn, $data['smoker_status']);
    $alcohol_status = mysqli_real_escape_string($conn, $data['alcohol_status']);
    $medical_conditions = mysqli_real_escape_string($conn, $data['medical_conditions']);
    $family_medical_history = mysqli_real_escape_string($conn, $data['family_medical_history']);
    $occupation = mysqli_real_escape_string($conn, $data['occupation']);
    $annual_income = mysqli_real_escape_string($conn, $data['annual_income']);
    $payment_mode = mysqli_real_escape_string($conn, $data['payment_mode']);
    $bank_account_details = mysqli_real_escape_string($conn, $data['bank_account_details']);
    $emergency_contact_name = mysqli_real_escape_string($conn, $data['emergency_contact_name']);
    $emergency_contact_relationship = mysqli_real_escape_string($conn, $data['emergency_contact_relationship']);
    $emergency_contact_number = mysqli_real_escape_string($conn, $data['emergency_contact_number']);

    // Prepare the SQL query
    $sql = "INSERT INTO clients (
                name, nic, date_of_birth, contact_number, email, address, policy_type, 
                coverage_amount, payment_frequency, beneficiary_name, beneficiary_relationship, 
                height_cm, weight_kg, smoker_status, alcohol_status, medical_conditions, 
                family_medical_history, occupation, annual_income, payment_mode, 
                bank_account_details, emergency_contact_name, emergency_contact_relationship, emergency_contact_number
            ) VALUES (
                '$name', '$nic', '$date_of_birth', '$contact_number', '$email', '$address', '$policy_type',
                '$coverage_amount', '$payment_frequency', '$beneficiary_name', '$beneficiary_relationship',
                '$height_cm', '$weight_kg', '$smoker_status', '$alcohol_status', '$medical_conditions',
                '$family_medical_history', '$occupation', '$annual_income', '$payment_mode',
                '$bank_account_details', '$emergency_contact_name', '$emergency_contact_relationship', '$emergency_contact_number'
            )";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Client data submitted successfully.']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
    }

} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

mysqli_close($conn);
?>
