<?php
require '../db.php';

header('Content-Type: application/json');
ob_clean();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $bus_id    = $_POST['bus_id'] ?? null;
    $driver_id = $_POST['driver_id'] ?? null;
    $route_id  = $_POST['route_id'] ?? null;
    $dep       = $_POST['departure_time'] ?? null;
    $arr       = $_POST['arrival_time'] ?? null;

    if (!$bus_id || !$driver_id || !$route_id || !$dep || !$arr) {
        echo json_encode(["status" => "error", "msg" => "Missing required fields"]);
        exit;
    }

    $sql = "INSERT INTO schedules (bus_id, driver_id, route_id, departure_time, arrival_time) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["status" => "error", "msg" => $conn->error]);
        exit;
    }

    $stmt->bind_param("iiiss", $bus_id, $driver_id, $route_id, $dep, $arr);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "msg" => $stmt->error]);
    }
}
