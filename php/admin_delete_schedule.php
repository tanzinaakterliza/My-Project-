<?php
require '../db.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM schedules WHERE id='$id'";
    echo $conn->query($sql) ? "success" : "error";
}
?>
