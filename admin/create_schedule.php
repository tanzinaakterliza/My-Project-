<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Create Schedule</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" alt="UU Logo" style="width: 50px;">
        <p style="color:#eef5ff;">Uttara University</p><br>
    </div>

    <h2>Admin Panel</h2>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="manage_buses.php">🚌 Buses</a>
    <a href="manage_drivers.php">👨‍✈️ Drivers</a>
    <a href="manage_routes.php">🗺 Routes</a>
    <a class="active" href="create_schedule.php">📅 Schedule</a>
    <a href="tracking.php">📡 Tracking</a>
    <a href="feedback.php" >💬 Feedback</a>
    <a href="contact_messages.php" >💬 Contact Messages</a>
    <a href="../logout.php"> Logout</a>
</div>

<div class="content" style="margin-left:260px; padding:30px;">
    <h1>Create Schedule</h1>

    <div class="card">
        <h2>Add New Schedule</h2>
        <form id="scheduleForm">
            <label>Select Bus</label>
            <select name="bus_id" id="busList" required>
                <option value="" selected disabled>select a bus</option>
            </select>

            <label>Select Driver</label>
            <select name="driver_id" id="driverList" required></select>

            <label>Select Route</label>
            <select name="route_id" id="routeList" required></select>

            <label>Departure Time</label>
            <input type="time" name="departure_time" required>

            <label>Arrival Time</label>
            <input type="time" name="arrival_time" required>

            <button type="submit" class="btn">Add Schedule</button>
        </form>
    </div>

    <div class="card" style="margin-top:20px;">
        <h2>Schedule List</h2>
        <table width="100%" cellpadding="8" style="background:#fff;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bus</th>
                    <th>Driver</th>
                    <th>Route</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="scheduleTable"></tbody>
        </table>
    </div>
</div>

<script>
// Load Buses
    const busList = document.getElementById("busList");
console.log(busList);
fetch('../php/admin_get_buses.php')
.then(res => res.json())
.then(data => {
    let options = "";
    data.forEach(d => {
        const opt = `<option value="${d.id}">${d.bus_name} (${d.bus_number})</option>`;
        busList.innerHTML += opt;
    });
});


// // Load Drivers
fetch('../php/admin_get_drivers.php')
.then(res => res.json())
.then(data => {
    data.forEach(d => {
        const opt = `<option value="${d.id}">${d.driver_name}</option>`;
        document.getElementById("driverList").innerHTML += opt;
    });
});

// // Load Routes
fetch('../php/admin_get_routes.php')
.then(res => res.json())
.then(data => {
    data.forEach(r => {
        const opt = `<option value="${r.id}">${r.start_point} → ${r.end_point}</option>`;
        document.getElementById("routeList").innerHTML += opt;
    });
});

document.getElementById("scheduleForm").addEventListener("submit", function(e){
    e.preventDefault();
    let f = new FormData(this);
    fetch("../php/admin_add_schedule.php", {method:"POST", body:f})
    .then(res=>res.json())
    .then(data=>{
        console.log(data);
        if(data.status==="success"){ alert("Schedule Added!"); this.reset(); loadSchedule(); }
        else alert("Error!");
    });
});

// // Load schedule
function loadSchedule(){
    fetch("../php/admin_get_schedule.php")
    .then(res=>res.json())
    .then(data=>{
        let html="";
        data.forEach(s=>{
            html+=`<tr>
                <td>${s.id}</td>
                <td>${s.bus_name}</td>
                <td>${s.driver_name}</td>
                <td>${s.route_name}</td>
                <td>${s.departure_time}</td>
                <td>${s.arrival_time}</td>
                <td><button onclick="delSchedule(${s.id})" class="btn" style="background:red;">Delete</button></td>
            </tr>`;
        });
        document.getElementById("scheduleTable").innerHTML=html;
    });
}
loadSchedule();

// // Delete schedule
function delSchedule(id){
    if(confirm("Delete Schedule?")){
        fetch("../php/admin_delete_schedule.php?id="+id)
        .then(res=>res.text())
        .then(data=>{
            if(data==="success"){ alert("Deleted!"); loadSchedule(); }
        });
    }
}
</script>

</body>
</html>
