<?php
session_start();

// Session check
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.html");
    exit;
}

// Safer role check
if($_SESSION['role'] !== "user"){
    echo "Unauthorized access!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Schedule</title>

<!-- Correct CSS path -->
<link rel="stylesheet" href="../assets/css/admin.css">

<style>
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: center;
    font-size: 15px;
}

th {
    background: #023254;
    color: white;
    font-weight: bold;
}

tr:hover {
    background: #f3f8ff;
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" alt="UU Logo" style="width: 55px;">
        <p style="color: #eef5ff; margin-top:5px;">Uttara University</p>
    </div>

    <h2>User Panel</h2>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="schedule.php" class="active">📅 Schedule</a>
    <a href="tracking.php">📡 Tracking</a>
    <a href="feedback.php">💬 Feedback</a>
    <a href="../logout.php">🚪 Logout</a>
</div>

<!-- Content -->
<div class="content">
    <h1>Daily Schedule</h1>
    <p>Below is today’s bus schedule created by admin.</p>

    <table>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Bus No</th>
            <th>Start</th>
            <th>End</th>
            <th>Driver</th>
        </tr>

        <tr>
            <td>2025-01-10</td>
            <td>8:00 AM</td>
            <td>UU-120</td>
            <td>Tongi</td>
            <td>Uttara</td>
            <td>Driver-201</td>
        </tr>
    </table>
</div>

</body>
</html>
