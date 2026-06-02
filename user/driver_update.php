<?php
// driver_update.php
// Driver app posts: bus_id, driver_id, lat, lng, (optional) speed, token
// Use POST requests (application/x-www-form-urlencoded or JSON)

session_start();
// Optionally check a session or token for authentication here
// For simple security, expect a shared token in POST
$EXPECTED_TOKEN = 'SOME_SHARED_SECRET_TOKEN'; // change this

// Accept JSON body or form data
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if(!$data){
    $data = $_POST;
}

if(!isset($data['token']) || $data['token'] !== $EXPECTED_TOKEN){
    http_response_code(401);
    echo json_encode(['status'=>'error','message'=>'Unauthorized']);
    exit;
}

$bus_id = isset($data['bus_id']) ? trim($data['bus_id']) : '';
$driver_id = isset($data['driver_id']) ? trim($data['driver_id']) : null;
$lat = isset($data['lat']) ? (float)$data['lat'] : null;
$lng = isset($data['lng']) ? (float)$data['lng'] : null;
$speed = isset($data['speed']) ? (float)$data['speed'] : null;

if(!$bus_id || !$lat || !$lng){
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'Missing parameters']);
    exit;
}

// DB config — change to your DB credentials
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

$stmt = $mysqli->prepare("INSERT INTO bus_location_updates (bus_id, driver_id, latitude, longitude, speed) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssddd", $bus_id, $driver_id, $lat, $lng, $speed);
$ok = $stmt->execute();
$stmt->close();
$mysqli->close();

if($ok){
    echo json_encode(['status'=>'ok','message'=>'Location saved']);
}else{
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'DB insert failed']);
}
