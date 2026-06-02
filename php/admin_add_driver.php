<?php
require '../db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $driver_name = $_POST['driver_name'] ?? null;
    $phone       = $_POST['phone'] ?? null;
    $license_no  = $_POST['license_no'] ?? null;

    if ($driver_name && $phone && $license_no) {
        $sql = "INSERT INTO drivers (driver_name, phone, license_no) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $driver_name, $phone, $license_no);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
            exit;
        }
    }
}

echo json_encode(["status" => "error"]);
