<?php
require 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM buses WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if($stmt->execute()){
    echo "success";
}else{
    echo "error";
}
?>
