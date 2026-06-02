<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.html");
    exit;
}

if($_SESSION['role'] !== "user"){
    echo "Unauthorized access!";
    exit;
}

// --- Database connection ---
$host = "localhost";
$user = "root";   // adjust if needed
$pass = "";       // adjust if needed
$db   = "bus_tracking"; // your DB name

$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
    die("DB Connection failed: " . $conn->connect_error);
}

// --- Handle AJAX request for latest locations ---
if(isset($_GET['action']) && $_GET['action'] === 'get_latest'){
    header('Content-Type: application/json');
    $bus_id_filter = isset($_GET['bus_id']) ? $_GET['bus_id'] : '';

    $sql = "SELECT l.driver_id, l.bus_id, l.latitude, l.longitude, l.speed, l.created_at
            FROM bus_locations l
            JOIN buses b ON b.id = l.bus_id
            JOIN drivers d ON d.id = l.driver_id ";

    if($bus_id_filter !== ''){
        $bus_id_filter = $conn->real_escape_string($bus_id_filter);
        $sql .= "WHERE l.bus_id = '$bus_id_filter' ";
    }

    $sql .= "ORDER BY l.created_at DESC";

    $result = $conn->query($sql);
    $locations = [];

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $locations[] = $row;
        }
        echo json_encode(['status'=>'ok','data'=>$locations]);
    } else {
        echo json_encode(['status'=>'empty']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Live Tracking</title>
<link rel="stylesheet" href="../assets/css/admin.css">

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<style>
.map-container {
    width: 100%;
    height: 70vh;
    border-radius: 8px;
    overflow: hidden;
    margin-top: 20px;
}
.controls {
    margin-top: 12px;
    display:flex;
    gap:10px;
    align-items:center;
}
.badge {
    background:#023254;
    color:white;
    padding:6px 10px;
    border-radius:6px;
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

    <h2>User Panel</h2>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="schedule.php">📅 Schedule</a>
    <a href="tracking.php" class="active">📡 Tracking</a>
    <a href="feedback.php">💬 Feedback</a>
    <a href="../logout.php">🚪 Logout</a>
</div>

<!-- Content -->
<div class="content">
    <h1>Live Bus Tracking</h1>
    <p>Map updates every 5 seconds (configurable). Click a bus marker to see details.</p>

    <div class="controls">
        <div class="badge">Status: <span id="status-text">Connecting...</span></div>
        <label>
            Refresh (sec):
            <select id="refresh-interval">
                <option value="3000">3</option>
                <option value="5000" selected>5</option>
                <option value="10000">10</option>
            </select>
        </label>
        <label>
            Bus id:
            <input type="text" id="bus-filter" placeholder="leave empty for all">
        </label>
        <button id="apply-filter">Apply</button>
    </div>

    <div id="map" class="map-container"></div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
let map;
let markers = {};
let refreshTimer = null;

// Initialize map
function initMap() {
    map = L.map('map').setView([23.883839, 90.360851], 14);  

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    fetchAndUpdate();
    setAutoRefresh();
}

// Auto-refresh setup
function setAutoRefresh(){
    const sel = document.getElementById('refresh-interval');
    sel.addEventListener('change', () => startAutoRefresh(parseInt(sel.value)));
    document.getElementById('apply-filter').addEventListener('click', fetchAndUpdate);
    startAutoRefresh(parseInt(sel.value));
}

function startAutoRefresh(interval){
    if(refreshTimer) clearInterval(refreshTimer);
    refreshTimer = setInterval(fetchAndUpdate, interval);
}

// Fetch latest bus locations
async function fetchAndUpdate(){
    const statusText = document.getElementById('status-text');
    statusText.textContent = 'Fetching...';

    const busFilter = document.getElementById('bus-filter').value.trim();
    const url = '?action=get_latest' + (busFilter ? ('&bus_id=' + encodeURIComponent(busFilter)) : '');

    try {
        const res = await fetch(url);
        const data = await res.json();
        if(data.status === 'ok'){
            statusText.textContent = 'Updated at ' + new Date().toLocaleTimeString();
            updateMarkers(data.data);
        } else if(data.status === 'empty'){
            statusText.textContent = 'No data';
        } else {
            statusText.textContent = 'Error';
            console.error(data);
        }
    } catch(err){
        statusText.textContent = 'Fetch error';
        console.error(err);
    }
}

// Update or create markers
function updateMarkers(payload){
    if(!payload) return;
    let rows = Array.isArray(payload) ? payload : [payload];
    const returnedIds = new Set();

    rows.forEach(row => {
        const id = row.bus_id;
        returnedIds.add(id);
        const lat = parseFloat(row.latitude);
        const lng = parseFloat(row.longitude);

        if(markers[id]){
            markers[id].setLatLng([lat, lng]);
            markers[id].getPopup().setContent(infoContent(row));
        } else {
            markers[id] = L.marker([lat, lng]).addTo(map)
                .bindPopup(infoContent(row));
        }
    });

    // Optionally remove markers not in returnedIds
    // Object.keys(markers).forEach(id => { if(!returnedIds.has(id)) { map.removeLayer(markers[id]); delete markers[id]; } });

    // Auto-center if single bus
    if(rows.length === 1){
        map.setView([parseFloat(rows[0].latitude), parseFloat(rows[0].longitude)], 15);
    }
}

function infoContent(row){
    const time = row.created_at || new Date().toISOString();
    const speed = row.speed ? row.speed + ' km/h' : 'N/A';
    return `<div style="min-width:180px">
        <b>Bus:</b> ${row.bus_id}<br>
        <b>Driver:</b> ${row.driver_id || 'N/A'}<br>
        <b>Lat,Lng:</b> ${row.latitude}, ${row.longitude}<br>
        <b>Speed:</b> ${speed}<br>
        <b>At:</b> ${time}
    </div>`;
}

// Initialize map after page load
window.onload = initMap;
</script>

</body>
</html>
