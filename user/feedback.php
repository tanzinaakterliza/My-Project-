<?php
session_start();

// Session check
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.html");
    exit;
}

// Role check
$currentRole = basename(__DIR__); // folder name: user/admin/driver
if($_SESSION['role'] !== $currentRole){
    echo "Unauthorized access!";
    exit;
}

require '../db.php';

$msg = "";
if(isset($_POST['submit'])){
    $user_id = $_SESSION['user_id'];
    $message = $conn->real_escape_string($_POST['message']);
    $conn->query("INSERT INTO feedback (user_id, message, created_at) VALUES ($user_id, '$message', NOW())");
    $msg = "Feedback submitted successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Feedback</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<style>
/* Sidebar & Card style same as dashboard.php */
.cards { display:flex; gap:20px; margin-top:20px; }
.card {
    background:#fff; padding:20px; border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    flex:1; text-align:center; text-decoration:none; color:#023254;
    transition:0.3s;
}
.card:hover { transform:translateY(-5px); box-shadow:0 8px 18px rgba(0,0,0,0.2); }
.card h3{ margin-bottom:10px; }
.card p{ font-size:14px; color:#555; }

.form-box { background:#fff; padding:20px; border-radius:12px; max-width:500px; margin-top:20px; }
.form-box label { display:block; margin-top:10px; font-weight:bold; }
.form-box textarea { width:100%; padding:10px; margin-top:5px; border-radius:8px; border:1px solid #ccc; }
.form-box button { margin-top:15px; padding:10px 20px; border:none; background:#023254; color:#fff; border-radius:8px; cursor:pointer; }
.msg { margin-top:15px; color:green; font-weight:bold; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="assets/img/uu-logo-transparent.png" alt="UU Logo" style="width:50px;">
        <p style="color:#eef5ff;">Uttara University</p><br>
    </div>
    <h2>User Panel</h2>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="schedule.php">📅 View Schedule</a>
    <a href="tracking.php">📡 Live Tracking</a>
    <a href="feedback.php" class="active">💬 Feedback</a>
    <a href="../logout.php"> Logout</a>
</div>

<!-- Content -->
<div class="content" style="margin-left:260px; padding:30px;">
    <h1>Submit Feedback</h1>
    <p>Your feedback will help us improve the service.</p>

    <form method="POST" class="form-box">
        <label>Message</label>
        <textarea name="message" rows="5" required></textarea>
        <button type="submit" name="submit">Send Feedback</button>
        <?php if($msg) echo "<div class='msg'>$msg</div>"; ?>
    </form>

    <div class="cards">
        <a class="card" href="schedule.php">
            <h3>View Schedule</h3>
            <p>Daily bus time & route list</p>
        </a>

        <a class="card" href="tracking.php">
            <h3>Live Tracking</h3>
            <p>Check real-time bus location</p>
        </a>
    </div>
</div>

</body>
</html>
