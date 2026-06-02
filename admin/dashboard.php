<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" alt="UU Logo" style="width: 50px;">
        <p style="color: #eef5ff;">Uttara University</p><br>
    </div>
    <h2>Admin Panel</h2>
    <a href="dashboard.php" class="active">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="manage_buses.php">🚌 Manage Buses</a>
    <a href="manage_drivers.php">👨‍✈️ Manage Drivers</a>
    <a href="manage_routes.php">🗺 Manage Routes</a>
    <a href="create_schedule.php">📅 Create Schedule</a>
    <a href="tracking.php">📡 Tracking</a>
    <a href="feedback.php" >💬 Feedback</a>
    <a href="contact_messages.php" >💬 Contact Messages</a>
    <a href="../logout.php"> Logout</a>
</div>

<div class="content" style="margin-left:260px; padding:30px;">
    <h1>Welcome Admin</h1>
    <p>Manage bus, routes, drivers & schedules</p>

    <div class="cards">
        <a class="card" href="manage_buses.php">
            <h3>Manage Buses</h3>
            <p>Total buses: 12</p>
        </a>
        <a class="card" href="manage_drivers.php">
            <h3>Manage Drivers</h3>
            <p>Total drivers: 8</p>
        </a>
        <a class="card" href="manage_routes.php">
            <h3>Manage Routes</h3>
            <p>Total routes: 5</p>
        </a>
        <a class="card" href="create_schedule.php">
            <h3>Create Schedules</h3>
            <p>Update daily schedules</p>
        </a>
        <a class="card" href="tracking.php">
            <h3>Tracking</h3>
            <p>Check bus location</p>
        </a>
    </div>
</div>

</body>
</html>
