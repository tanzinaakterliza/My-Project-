<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Profile</title>
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
    <a href="profile.php" class="active">👤 Profile</a>
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
    <h1>Admin Profile</h1>

    <form class="form-box">
        <label>Name</label>
        <input type="text" value="<?php echo $_SESSION['name']; ?>">

        <label>Email</label>
        <input type="email">

        <label>Password</label>
        <input type="password">

        <button>Update Profile</button>
    </form>
</div>

</body>
</html>
