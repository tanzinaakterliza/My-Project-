<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.html");
    exit;
}

// --- Database connection ---
$host = "localhost";
$user = "root";   // change if needed
$pass = "";       // change if needed
$db   = "bus_tracking"; // your DB name

$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
    die("DB Connection failed: " . $conn->connect_error);
}

// --- Handle AJAX request for bus locations ---
if(isset($_GET['action']) && $_GET['action'] === 'get_locations'){
    header('Content-Type: application/json');
    $sql = "SELECT d.id as driver_id, d.name as driver_name, b.name as bus_name, l.lat, l.lng
            FROM drivers d
            JOIN buses b ON b.driver_id = d.id
            JOIN bus_locations l ON l.driver_id = d.id
            ORDER BY l.updated_at DESC";
    $result = $conn->query($sql);
    $locations = [];
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $locations[] = $row;
        }
    }
    echo json_encode($locations);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Live Tracking</title>
<link rel="stylesheet" href="../assets/css/admin.css">

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<style>
.map-box {
    width: 100%;
    height: 500px;
    border-radius: 12px;
    margin-top: 20px;
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" alt="UU Logo" style="width: 60px;">
        <p style="color: #eef5ff; margin-top:5px;">Uttara University</p>
    </div>

    <h2>Admin Panel</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="profile.php">Profile</a>
    <a href="manage_buses.php">Buses</a>
    <a href="manage_drivers.php">Drivers</a>
    <a href="manage_routes.php">Routes</a>
    <a href="create_schedule.php">Schedule</a>
    <a href="tracking.php" class="active">Tracking</a>
    <a href="feedback.php">💬 Feedback</a>
    <a href="contact_messages.php">💬 Contact Messages</a>
    <a href="../logout.php">Logout</a>
</div>

<!-- Content -->
<div class="content" style="margin-left:260px; padding:30px;">
    <h1>Live Bus Tracking</h1>
    <p>All buses’ live locations will appear on the map below.</p>

    <div id="map" class="map-box"></div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
// Initialize map
const map = L.map('map').setView([23.883839, 90.360851], 19);  

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

let busMarkers = {};

// Fetch locations from this same file
function fetchBusLocations() {
    fetch('?action=get_locations')
    .then(res => res.json())
    .then(data => {
        data.forEach(bus => {
            const id = bus.driver_id;
            const lat = parseFloat(bus.lat);
            const lng = parseFloat(bus.lng);
            const popupText = `<b>${bus.bus_name}</b><br>Driver: ${bus.driver_name}`;

            if(busMarkers[id]){
                busMarkers[id].setLatLng([lat, lng]);
            } else {
                busMarkers[id] = L.marker([lat, lng]).addTo(map).bindPopup(popupText);
            }
        });
    })
    .catch(err => console.error(err));
}

// Update every 5 seconds
setInterval(fetchBusLocations, 5000);
fetchBusLocations();
</script>

</body>
</html>
