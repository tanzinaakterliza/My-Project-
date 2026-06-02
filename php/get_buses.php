<?php
require 'db.php';
$result = $conn->query("SELECT id,bus_name,bus_number FROM buses");
$buses = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($buses);
?>
