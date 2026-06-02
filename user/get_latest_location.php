<?php
// get_latest_location.php
// GET parameter: bus_id (optional). If not provided, return all latest per bus (simple version: latest single overall)

header('Content-Type: application/json');

// DB config
$dbHost = 'localhost';
$dbUser = 'db_user';
$dbPass = 'db_pass';
$dbName = 'db_name';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if($mysqli->connect_errno){
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'DB connection failed']);
    exit;
}

$bus_id = isset($_GET['bus_id']) ? $_GET['bus_id'] : null;

if($bus_id){
    $stmt = $mysqli->prepare("SELECT bus_id, driver_id, latitude, longitude, speed, created_at FROM bus_location_updates WHERE bus_id = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->bind_param("s", $bus_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if($row){
        echo json_encode(['status'=>'ok','data'=>$row]);
    } else {
        echo json_encode(['status'=>'empty','data'=>null]);
    }
} else {
    // Return latest of each bus (simple approach)
    $query = "SELECT t1.bus_id, t1.driver_id, t1.latitude, t1.longitude, t1.speed, t1.created_at
              FROM bus_location_updates t1
              INNER JOIN (
                SELECT bus_id, MAX(created_at) AS max_created
                FROM bus_location_updates
                GROUP BY bus_id
              ) t2 ON t1.bus_id = t2.bus_id AND t1.created_at = t2.max_created
              ORDER BY t1.bus_id";
    $res = $mysqli->query($query);
    $rows = [];
    while($r = $res->fetch_assoc()){
        $rows[] = $r;
    }
    echo json_encode(['status'=>'ok','data'=>$rows]);
}

$mysqli->close();
