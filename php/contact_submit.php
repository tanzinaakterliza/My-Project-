<?php
header('Content-Type: application/json');
require 'db.php'; // db connection

$response = ['status' => 'error', 'error' => 'Unknown error'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Sanitize & validate input
    $name = isset($_POST['name']) ? trim($conn->real_escape_string($_POST['name'])) : '';
    $email = isset($_POST['email']) ? trim($conn->real_escape_string($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? trim($conn->real_escape_string($_POST['phone'])) : '';
    $message = isset($_POST['message']) ? trim($conn->real_escape_string($_POST['message'])) : '';

    if(empty($name) || empty($email) || empty($message)){
        $response['error'] = "Name, Email, and Message are required.";
    } else {
        $sql = "INSERT INTO contact_messages (name, email, phone, message, created_at) 
                VALUES ('$name', '$email', '$phone', '$message', NOW())";

        if($conn->query($sql)){
            $response['status'] = 'success';
            unset($response['error']);
        } else {
            $response['error'] = "Database error: " . $conn->error;
        }
    }
} else {
    $response['error'] = "Invalid request method.";
}

echo json_encode($response);
?>
