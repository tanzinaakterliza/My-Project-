<?php
session_start();

// Session check
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.html");
    exit;
}

// Role check — safer method
if($_SESSION['role'] !== "user"){
    echo "Unauthorized access!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Dashboard</title>

<!-- Correct CSS path -->
<link rel="stylesheet" href="../assets/css/admin.css">

<style>
/* Extra card styling */
.cards {
    display: flex;
    gap: 20px;
    margin-top: 25px;
}
.card {
    background: #ffffff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    flex: 1;
    text-align: center;
    text-decoration: none;
    color: #023254;
    transition: 0.3s;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
.card h3 {
    margin-bottom: 8px;
    font-size: 22px;
}
.card p {
    font-size: 14px;
    color: #666;
}
</style>

</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" style="width: 60px;">
        <p style="color: #eef5ff; margin-top:5px;">Uttara University</p>
    </div>

    <h2>User Panel</h2>
    <a href="dashboard.php" class="active">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="schedule.php">📅 View Schedule</a>
    <a href="tracking.php">📡 Live Tracking</a>
    <a href="feedback.php">💬 Feedback</a>
    <a href="../logout.php">🚪 Logout</a>
</div>

<!-- Content -->
<div class="content">
    <h1>Welcome, <?php echo $_SESSION['name']; ?> 👋</h1>
    <p>View bus schedule & live tracking updates easily.</p>

    <div class="cards">
        <a class="card" href="schedule.php">
            <h3>📅 View Schedule</h3>
            <p>Daily bus time & route list</p>
        </a>

        <a class="card" href="tracking.php">
            <h3>📡 Live Tracking</h3>
            <p>Check real-time bus location</p>
        </a>
    </div>
</div>

</body>
</html>
