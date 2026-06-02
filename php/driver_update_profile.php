<?php
session_start();
include 'db.php'; // Database connection file

// Check if driver is logged in
if (!isset($_SESSION['driver_id'])) {
    header("Location: login.php");
    exit();
}

$driver_id = $_SESSION['driver_id'];
$message = "";

// Fetch current driver data
$sql = "SELECT * FROM drivers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
$driver = $result->fetch_assoc();

if (!$driver) {
    die("Driver not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (!$name || !$email || !$phone) {
        $message = "Name, email, and phone are required.";
    } else {
        if ($password) {
            // Update with new password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE drivers SET name=?, email=?, phone=?, password=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $name, $email, $phone, $hashed_password, $driver_id);
        } else {
            // Update without changing password
            $sql = "UPDATE drivers SET name=?, email=?, phone=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $name, $email, $phone, $driver_id);
        }

        if ($stmt->execute()) {
            $message = "Profile updated successfully!";
            // Refresh driver data
            $driver['name'] = $name;
            $driver['email'] = $email;
            $driver['phone'] = $phone;
        } else {
            $message = "Failed to update profile. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Profile</title>
</head>
<body>
<h2>Update Profile</h2>
<?php if ($message) echo "<p>$message</p>"; ?>
<form method="POST" action="">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($driver['name']) ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($driver['email']) ?>" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($driver['phone']) ?>" required><br><br>

    <label>New Password (leave blank to keep current):</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Update Profile</button>
</form>
</body>
</html>
