<?php
// Database connection

// Localhost setup (for testing)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "uuswifttransit";
$port = 3306;

// // InfinityFree / live hosting setup
// $host = "sql211.infinityfree.com";  // Replace with your InfinityFree host
// $user = "if0_40642184";     // Replace with your DB username
// $pass = "786201210";     // Replace with your DB password
// $db   = "if0_40642184_bus_tracking";     // Replace with your DB name

// Create connection
$conn = new mysqli($host, $user, $pass, $db, $port);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Optional: set charset
$conn->set_charset("utf8");
?>
