<?php
session_start();

// Session check
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.html");
    exit;
}

// Role check
$currentRole = basename(__DIR__);
if($_SESSION['role'] !== $currentRole){
    echo "Unauthorized access!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Profile</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <div style="text-align:center; margin-bottom:15px;">
        <img src="../assets/img/uu-logo-transparent.png" alt="UU Logo" style="width: 50px;">
        <p style="color: #eef5ff;">Uttara University</p><br>
    </div>
    <h2>User Panel</h2>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php" class="active">👤 Profile</a>
    <a href="schedule.php">📅 Schedule</a>
    <a href="tracking.php">📡 Tracking</a>
    <a href="feedback.php" >💬 Feedback</a>
    <a href="../logout.php"> Logout</a>
</div>

<!-- Content -->
<div class="content" style="margin-left:260px; padding:30px;">
    <h1>My Profile</h1>

    <form class="form-box">
        <label>Name</label>
        <input type="text" value="<?php echo $_SESSION['name']; ?>">

        <label>Student ID</label>
        <input type="text" value="STU-101" disabled>

        <label>Email</label>
        <input type="text" value="student@uu.edu">

        <label>Password</label>
        <input type="password">

        <button>Update Profile</button>
    </form>
</div>

</body>
</html>
