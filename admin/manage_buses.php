<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.html");
    exit;
}

require '../db.php'; // Database connection

// Fetch all buses
$result = $conn->query("SELECT id, bus_name, bus_number FROM buses ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Buses</title>
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
    <a class="active" href="manage_buses.php">🚌 Buses</a>
    <a href="manage_drivers.php">👨‍✈️ Drivers</a>
    <a href="manage_routes.php">🗺 Routes</a>
    <a href="create_schedule.php">📅 Schedule</a>
    <a href="tracking.php">📡 Tracking</a>
    <a href="feedback.php">💬 Feedback</a>
    <a href="contact_messages.php">💬 Contact Messages</a> 
    <a href="../logout.php"> Logout</a>
</div>

<div class="content" style="margin-left:260px; padding:30px;">
    <h1>Add New Bus</h1>
    <div class="card">
        <form id="busForm">
            <label>Bus Name</label>
            <input type="text" name="bus_name" placeholder="Enter Bus Name" required>

            <label>Bus Number</label>
            <input type="text" name="bus_number" placeholder="Enter Bus Number" required>

            <button type="submit" class="btn">Add Bus</button>
        </form>
    </div>

    <h2 style="margin-top:30px;">Bus List</h2>
    <table width=100% cellpadding="10" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Bus Name</th>
                <th>Bus Number</th>
            </tr>
        </thead>
        <tbody id="busTableBody">
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['bus_name']) ?></td>
                <td><?= htmlspecialchars($row['bus_number']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById("busForm").addEventListener("submit", function(e){
    e.preventDefault();
    let f = new FormData(this);
    fetch("../php/admin_add_bus.php", { method:"POST", body:f })
    .then(res=>res.text())
    .then(data=>{
        if(data==="success"){ 
            alert("Bus Added!"); 
            this.reset(); 
            // Table update
            fetch("../php/get_buses.php")
            .then(res=>res.json())
            .then(list=>{
                let tbody = document.getElementById("busTableBody");
                tbody.innerHTML = "";
                list.forEach(bus=>{
                    let tr = document.createElement("tr");
                    tr.innerHTML = `<td>${bus.id}</td><td>${bus.bus_name}</td><td>${bus.bus_number}</td>`;
                    tbody.appendChild(tr);
                });
            });
        }
        else alert("Error Adding Bus!");
    });
});
</script>

</body>
</html>
