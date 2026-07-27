<?php
// Set headers to allow CORS (useful if testing from VS Code Live Server) and return JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

// Database credentials from config
require_once 'config.php';

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database Connection Failed: " . $conn->connect_error]));
}

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $full_name = isset($_POST['fullName']) ? $conn->real_escape_string(trim($_POST['fullName'])) : '';
    $mobile = isset($_POST['mobile']) ? $conn->real_escape_string(trim($_POST['mobile'])) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : '';
    $insurance_type = isset($_POST['insuranceType']) ? $conn->real_escape_string(trim($_POST['insuranceType'])) : '';
    $message = isset($_POST['message']) ? $conn->real_escape_string(trim($_POST['message'])) : '';
    
    // Checkboxes send 'on' if checked, else they might not be set
    $whatsapp_consent = isset($_POST['whatsappConsent']) ? 1 : 0;
    $promo_consent = isset($_POST['promoConsent']) ? 1 : 0;

    // Basic validation
    if (empty($full_name) || empty($mobile) || empty($email)) {
        echo json_encode(["status" => "error", "message" => "Please fill in all required fields."]);
        exit;
    }

    // Prepare SQL Statement
    $sql = "INSERT INTO contact_leads (full_name, mobile, email, insurance_type, message, whatsapp_consent, promo_consent) 
            VALUES ('$full_name', '$mobile', '$email', '$insurance_type', '$message', '$whatsapp_consent', '$promo_consent')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Thank you! Your interest has been captured successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method."]);
}

$conn->close();
?>

