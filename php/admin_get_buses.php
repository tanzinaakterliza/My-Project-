<?php
require '../db.php';
header('Content-Type: application/json; charset=utf-8');

$result = $conn->query("SELECT * FROM buses ORDER BY id DESC");
$buses = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($buses);
?>
