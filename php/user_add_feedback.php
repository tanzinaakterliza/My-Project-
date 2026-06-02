<?php
session_start();
require 'db.php';  // db.php location user folder theke ek level up

if(!isset($_SESSION['user_id'])) {
    echo "Unauthorized";
    exit;
}

if(isset($_POST['message'])){
    $user_id = $_SESSION['user_id'];
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO feedback (user_id, message) VALUES ($user_id, '$message')";
    if($conn->query($sql)){
        header("Location: user/feedback.php?success=1");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No message provided.";
}
?>
