<?php
require '../db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $bus_name = isset($_POST['bus_name']) ? $_POST['bus_name'] : null;
    $bus_number = isset($_POST['bus_number']) ? $_POST['bus_number'] : null;

    if($bus_name && $bus_number){
        $sql = "INSERT INTO buses (bus_name, bus_number) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $bus_name, $bus_number);

        if($stmt->execute()){
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "missing_fields";
    }

    exit;
}

echo "invalid_request";
?>
