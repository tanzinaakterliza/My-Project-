<?php
require '../db.php';
$sql = "SELECT s.id,b.bus_name,d.driver_name,CONCAT(r.start_point,' → ',r.end_point) AS route_name,
        s.departure_time,s.arrival_time
        FROM schedules s
        JOIN buses b ON s.bus_id=b.id
        JOIN drivers d ON s.driver_id=d.id
        JOIN routes r ON s.route_id=r.id";
$result = $conn->query($sql);
$schedules = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($schedules);
?>
