<?php
require '../db.php';

$result = $conn->query("SELECT * FROM routes ORDER BY id DESC");
$routes = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($routes);
?>
