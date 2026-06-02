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
<title>Manage Routes</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" alt="UU Logo" style="width: 50px;">
        <p style="color: #eef5ff;">Uttara University</p><br>
    </div>

    <h2>Admin Panel</h2>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="manage_buses.php">🚌 Buses</a>
    <a href="manage_drivers.php">👨‍✈️ Drivers</a>
    <a class="active" href="manage_routes.php">🗺 Routes</a>
    <a href="create_schedule.php">📅 Schedule</a>
    <a href="tracking.php">📡 Tracking</a>
    <a href="feedback.php" >💬 Feedback</a>
    <a href="contact_messages.php" >💬 Contact Messages</a>
    <a href="../logout.php"> Logout</a>
</div>

<div class="content" style="margin-left:260px; padding:30px;">
    <h1>Manage Routes</h1>

    <div class="card">
        <h2>Add New Route</h2>
        <form id="routeForm">
            <label>Start Location</label>
            <input type="text" name="start_point" required>

            <label>Middle Stops</label>
            <input type="text" name="via_point" placeholder="Comma separated (Example: Mirpur, Pallabi)">

            <label>End Location</label>
            <input type="text" name="end_point" required>

            <button type="submit" class="btn">Add Route</button>
        </form>
    </div>

    <div class="card" style="margin-top:20px;">
        <h2>Route List</h2>
        <table  width="100%" cellpadding="8" style="background:#fff;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Start</th>
                    <th>Middle</th>
                    <th>End</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="routeTable"></tbody>
        </table>
    </div>
</div>

<script>
// Add Route
document.getElementById("routeForm").addEventListener("submit", function(e){
    e.preventDefault();
    let f = new FormData(this);
    fetch("../php/admin_add_route.php", { method:"POST", body:f })
    .then(res=>res.json())
    .then(data=>{
        if(data.status==="success"){ alert("Route Added!"); this.reset(); loadRoutes(); }
        else alert("Error Adding Route!");
    });
});

// Load Route List
function loadRoutes(){
    fetch("../php/admin_get_routes.php")
    .then(res=>res.json())
    .then(data=>{
        let html="";
        data.forEach(r=>{
            html+=`<tr>
                <td>${r.id}</td>
                <td>${r.start_point}</td>
                <td>${r.via_point}</td>
                <td>${r.end_point}</td>
                <td><button onclick="delRoute(${r.id})" class="btn" style="background:red;">Delete</button></td>
            </tr>`;
        });
        document.getElementById("routeTable").innerHTML=html;
    });
}

loadRoutes();

// Delete Route
function delRoute(id){
    if(confirm("Delete this route?")){
        fetch("../php/admin_delete_route.php?id="+id)
        .then(res=>res.text())
        .then(data=>{
            if(data==="success"){ alert("Route Deleted!"); loadRoutes(); }
        });
    }
}
</script>

</body>
</html>
