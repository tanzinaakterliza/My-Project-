<?php
require '../db.php';

$result = $conn->query("SELECT * FROM drivers ORDER BY id DESC");
$drivers = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($drivers);
?>
