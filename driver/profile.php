<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'driver'){
    header("Location: ../login.html");
    exit;
}

require '../db.php';

$driver_id = $_SESSION['user_id'];

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SAFE SQL
$stmt = $conn->prepare("SELECT id, driver_name, phone FROM drivers WHERE id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $driver_id);

$stmt->execute();

// Get the result
$result = $stmt->get_result();


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Driver Profile</title>
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
    <a href="profile.php" class="active">Profile</a>
    <a href="my_schedule.php">My Schedule</a>
    <a href="update_location.php">Update Location</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="content" style="margin-left:260px; padding:30px;">
    <h1>My Profile</h1>

    <form method="POST" action="../php/driver_update_profile.php" class="form-box">
        
        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars(isset($driver['name'])? ($driver['name']): '') ?>" required>

        <label>Driver ID</label>
        <input type="text" value="<?= isset($driver['id'])? ($driver['id']) : '' ?>" disabled>

        <label>Contact Number</label>
        <input type="text" name="phone" value="<?= htmlspecialchars(isset($driver['phone']) ? $driver['phone'] : '') ?>" required>

        <label>Password (Leave blank to keep old password)</label>
        <input type="password" name="password">

        <button type="submit">Update Profile</button>
    </form>
</div>

</body>
</html>
