<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'driver'){
    header("Location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Location</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


<style>
.map-box {
        width: 100%;
        height: 500px;
        margin-bottom: 30px; 
    }
</style>

</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" alt="UU Logo" style="width:50px;">
        <p style="color:#eef5ff;">Uttara University</p>
    </div>
    <h2>Driver Panel</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="profile.php">Profile</a>
    <a href="my_schedule.php">My Schedule</a>
    <a href="update_location.php" class="active">Update Location</a>
    <a href="../logout.php">Logout</a>
</div>

<!-- Content -->
<div class="content" style="margin-left:260px; padding:30px;">
    <h1>Update Bus Location</h1>

    <div id="map" class="map-box">
    </div>

    <h2>Send Current Location</h2>

    <form id="locationForm" class="form-box">
        <input type="text" id="lat" placeholder="Latitude" readonly>
        <input type="text" id="lng" placeholder="Longitude" readonly>
        <button type="button" onclick="sendLocation()">Update Location</button>
    </form>
</div>

<script>
// Auto detect location every 5 seconds
function updateLocation(){
    navigator.geolocation.getCurrentPosition(pos => {
        document.getElementById('lat').value = pos.coords.latitude;
        document.getElementById('lng').value = pos.coords.longitude;
    });
}
setInterval(updateLocation, 5000);

// Send location to backend
function sendLocation(){
    let lat = document.getElementById('lat').value;
    let lng = document.getElementById('lng').value;

    fetch("../php/driver_update_location.php", {
        method: "POST",
        body: new URLSearchParams({
            driver_id: <?= $_SESSION['user_id'] ?>,
            lat: lat,
            lng: lng
        })
    })
    .then(res => res.text())
    .then(data => {
        alert("Location Updated");
    });
}





 // Initialize map
    const map = L.map('map').setView([23.883839, 90.360851], 19);  

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add marker (optional)
    const marker = L.marker([23.883839, 90.360851]).addTo(map);
    marker.bindPopup("<b>Hello!</b><br>Your bus is Here").openPopup();
</script>

</body>
</html>
