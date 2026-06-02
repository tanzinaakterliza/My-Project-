<?php
session_start();
require '../db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.html");
    exit;
}

// Delete feedback
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM feedback WHERE id=$id");
    header("Location: feedback.php");
    exit;
}

// Mark as read
if(isset($_GET['read'])){
    $id = intval($_GET['read']);
    $conn->query("UPDATE feedback SET is_read=1 WHERE id=$id");
    header("Location: feedback.php");
    exit;
}

// Fetch all feedback
$feedbacks = $conn->query("
    SELECT f.id, f.message, f.created_at, f.is_read, u.name AS user_name
    FROM feedback f
    JOIN users u ON f.user_id = u.id
    ORDER BY f.created_at DESC
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Feedback</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<style>
table { width:100%; border-collapse: collapse; margin-top:20px; }
th, td { border:1px solid #ccc; padding:10px; text-align:center; }
th { background:#023254; color:white; }
.read { background:#e0e0e0; }
.btn { padding:5px 10px; border:none; cursor:pointer; border-radius:5px; }
.btn-delete { background:red; color:white; }
.btn-read { background:green; color:white; }
</style>
</head>
<body>

<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" alt="UU Logo" style="width:50px;">
        <p style="color:#eef5ff;">Uttara University</p><br>
    </div>
    <h2>Admin Panel</h2>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="manage_buses.php">🚌 Buses</a>
    <a href="manage_drivers.php">👨‍✈️ Drivers</a>
    <a href="manage_routes.php">🗺 Routes</a>
    <a href="create_schedule.php">📅 Schedule</a>
    <a href="tracking.php">📡 Tracking</a>
    <a href="feedback.php" class="active">💬 Feedback</a>
    <a href="contact_messages.php" >💬 Contact Messages</a>
    <a href="logout.php">⬅ Logout</a>
</div>

<div class="content" style="margin-left:260px; padding:30px;">
<h1>User Feedback</h1>

<table>
<tr>
    <th>ID</th>
    <th>User</th>
    <th>Message</th>
    <th>Time</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php foreach($feedbacks as $f): ?>
<tr class="<?= $f['is_read'] ? 'read' : '' ?>">
    <td><?= $f['id'] ?></td>
    <td><?= $f['user_name'] ?></td>
    <td><?= $f['message'] ?></td>
    <td><?= $f['created_at'] ?></td>
    <td><?= $f['is_read'] ? 'Read' : 'Unread' ?></td>
    <td>
        <?php if(!$f['is_read']): ?>
            <a href="?read=<?= $f['id'] ?>" class="btn btn-read">Mark Read</a>
        <?php endif; ?>
        <a href="?delete=<?= $f['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete feedback?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>

</table>
</div>
</body>
</html>
