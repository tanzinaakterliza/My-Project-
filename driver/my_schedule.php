<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'driver'){
    header("Location: ../login.html");
    exit;
}

require '../db.php'; // DB connection

$driver_id = $_SESSION['user_id'];

$schedules = $conn->query("SELECT s.id, s.departure_time, s.arrival_time, b.bus_number, r.start_point, r.end_point
FROM schedules s
JOIN buses b ON s.bus_id=b.id
JOIN routes r ON s.route_id=r.id
WHERE s.driver_id=$driver_id
ORDER BY s.departure_time ASC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Schedule</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>
<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" alt="UU Logo" style="width: 50px;">
        <p style="color: #eef5ff;">Uttara University</p><br>
    </div>
    <h2>Driver Panel</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="profile.php">Profile</a>
    <a href="my_schedule.php" class="active">My Schedule</a>
    <a href="update_location.php">Update Location</a>
    <a href="logout.php">Logout</a>
</div>

<div class="content" style="margin-left:260px; padding:30px;">
    <h1>Today's Schedule</h1>

    <table cellpadding="8" width="100%" style="background:#fff;">
        <tr>
            <th>Date</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Bus No</th>
            <th>Start</th>
            <th>End</th>
        </tr>
        <?php foreach($schedules as $sch): ?>
        <tr>
            <td><?= date('Y-m-d') ?></td>
            <td><?= $sch['departure_time'] ?></td>
            <td><?= $sch['arrival_time'] ?></td>
            <td><?= $sch['bus_number'] ?></td>
            <td><?= $sch['start_point'] ?></td>
            <td><?= $sch['end_point'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
