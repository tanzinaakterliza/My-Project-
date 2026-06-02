<?php
session_start();
require '../db.php'; // DB connection

// Admin session check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.html");
    exit;
}

// Fetch all messages
$messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Contact Messages</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<style>
/* Table Styling */
table { width:100%; border-collapse: collapse; margin-top:20px; }
th, td { border:1px solid #ccc; padding:10px; text-align:center; }
th { background:#023254; color:white; }
.btn-delete { background:red; color:white; padding:5px 10px; border:none; border-radius:5px; cursor:pointer; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" alt="UU Logo" style="width:50px;">
        <p style="color:#eef5ff;">Uttara University</p><br>
    </div>
    <h2>Admin Panel</h2>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="manage_buses.php">🚌 Manage Buses</a>
    <a href="manage_drivers.php">👨‍✈️ Manage Drivers</a>
    <a href="manage_routes.php">🗺 Manage Routes</a>
    <a href="create_schedule.php">📅 Create Schedule</a>
    <a href="tracking.php">📡 Tracking</a>
    <a href="contact_messages.php" class="active">💬 Contact Messages</a>
    <a href="../logout.php"> Logout</a>
</div>

<!-- Content -->
<div class="content" style="margin-left:260px; padding:30px;">
    <h1>Contact Messages</h1>

    <table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Message</th>
        <th>Time</th>
    </tr>

    <?php foreach($messages as $m): ?>
    <tr>
        <td><?= $m['id'] ?></td>
        <td><?= htmlspecialchars($m['name']) ?></td>
        <td><?= htmlspecialchars($m['email']) ?></td>
        <td><?= htmlspecialchars($m['phone']) ?></td>
        <td><?= htmlspecialchars($m['message']) ?></td>
        <td><?= $m['created_at'] ?></td>
    </tr>
    <?php endforeach; ?>

    </table>
</div>
</body>
</html>
