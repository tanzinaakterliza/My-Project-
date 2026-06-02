<?php
require '../db.php';

header("Content-Type: application/json");
ob_clean(); // Removes accidental whitespace or warnings

// Ensure POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "msg" => "Invalid request method"]);
    exit;
}

// Read POST safely
$start = $_POST['start_point'] ?? null;
$via   = $_POST['via_point'] ?? null;
$end   = $_POST['end_point'] ?? null;

// Validate required fields
if (!$start || !$via || !$end) {
    echo json_encode(["status" => "error", "msg" => "Missing fields"]);
    exit;
}

$sql = "INSERT INTO routes (start_point, via_point, end_point) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["status" => "error", "msg" => $conn->error]);
    exit;
}

$stmt->bind_param("sss", $start, $via, $end);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "msg" => $stmt->error]);
}
?>
