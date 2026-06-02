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
<title>Manage Drivers</title>
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
    <a class="active" href="manage_drivers.php">👨‍✈️ Drivers</a>
    <a href="manage_routes.php">🗺 Routes</a>
    <a href="create_schedule.php">📅 Schedule</a>
    <a href="tracking.php">📡 Tracking</a>
    <a href="feedback.php" >💬 Feedback</a>
    <a href="contact_messages.php" >💬 Contact Messages</a>
    <a href="../logout.php"> Logout</a>
</div>

<div class="content" style="margin-left:260px; padding:30px;">
    <h1>Manage Drivers</h1>

    <div class="card">
        <h2>Add New Driver</h2>
        <form id="driverForm">
            <label>Driver Name</label>
            <input type="text" name="driver_name" required>

            <label>Phone Number</label>
            <input type="text" name="phone" required>

            <label>License Number</label>
            <input type="text" name="license_no" required>

            <button type="submit" class="btn">Add Driver</button>
        </form>
    </div>

    <div class="card" style="margin-top:20px;">
        <h2>Driver List</h2>
        <table width="100%" cellpadding="8" style="background:#fff;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>License</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="driverTable"></tbody>
        </table>
    </div>
</div>

<script>
// Add Driver
document.getElementById("driverForm").addEventListener("submit", function(e){
    e.preventDefault();
    let f = new FormData(this);
    console.log(f);
    fetch("../php/admin_add_driver.php", { method:"POST", body:f })
    .then(res => res.json())
    .then(data=>{
        if(data.status === "success"){ alert("Driver Added!"); this.reset(); loadDrivers(); }
        else alert("Error!");
    });
});

// Load Driver List
function loadDrivers(){
    fetch("../php/admin_get_drivers.php")
    .then(res=>res.json())
    .then(data=>{
        let html="";
        data.forEach(d=>{
            html+=`<tr>
                <td>${d.id}</td>
                <td>${d.driver_name}</td>
                <td>${d.phone}</td>
                <td>${d.license_no}</td>
                <td><button onclick="delDriver(${d.id})" class="btn" style="background:red;">Delete</button></td>
            </tr>`;
        });
        document.getElementById("driverTable").innerHTML=html;
    });
}

loadDrivers();

// // Delete Driver
function delDriver(id){
    if(confirm("Delete Driver?")){
        fetch("../php/admin_delete_driver.php?id="+id)
        .then(res=>res.text())
        .then(data=>{
            if(data==="success"){ alert("Deleted!"); loadDrivers(); }
            else alert("Error!");
        });
    }
}
</script>

</body>
</html>
