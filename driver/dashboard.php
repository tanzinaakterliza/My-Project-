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
<title>Driver Dashboard</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" alt="UU Logo" style="width: 50px;">
        <p style="color: #eef5ff;">Uttara University</p><br>
    </div> 
    <h2>Driver Panel</h2>
    <a href="dashboard.php" class="active">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="my_schedule.php">📅 My Schedule</a>
    <a href="update_location.php">📡 Update Location</a>
    <a href="../logout.php"> Logout</a>
</div>

<div class="content" style="margin-left:260px; padding:30px;">
    <h1>Welcome Driver</h1>
    <p>Your assigned schedule and tasks will appear here.</p>

    <div class="cards">
        <a class="card" href="my_schedule.php">
            <h3>Today's Schedule</h3>
            <p>View your assigned route & bus</p>
        </a>

        <a class="card" href="update_location.php">
            <h3>Update Live Location</h3>
            <p>Share your real-time bus position</p>
        </a>
    </div>
</div>
</body>
</html>
