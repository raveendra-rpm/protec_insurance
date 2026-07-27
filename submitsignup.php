<?php
// Set headers to allow CORS and return JSON
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

// Ensure newsletter_subscribers table exists
$table_sql = "CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$conn->query($table_sql);

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Please enter a valid email address."]);
        exit;
    }

    // Prepare SQL Statement to insert into dedicated newsletter_subscribers table
    $sql = "INSERT INTO newsletter_subscribers (email) VALUES ('$email')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Thank you! You have successfully signed up for updates."]);
    } else {
        // Check for duplicate entry error (error code 1062)
        if ($conn->errno === 1062) {
            echo json_encode(["status" => "success", "message" => "You are already signed up with this email address. Thank you!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method."]);
}

$conn->close();
?>
