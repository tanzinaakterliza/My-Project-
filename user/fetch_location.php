<?php
include "../db.php";

$sql = "SELECT latitude, longitude FROM drivers WHERE id=1"; // bus driver id
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo json_encode($row);
?>
