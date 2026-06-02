<?php
include 'db.php';
header('Content-Type: application/json');

$name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = mysqli_real_escape_string($conn, $_POST['role'] ?? 'user');

if (!$name || !$email || !$password || !$role) {
    echo json_encode(['status'=>'error','message'=>'Missing fields']); 
    exit;
}

// check exists
$check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
if (mysqli_num_rows($check) > 0) {
    echo json_encode(['status'=>'error','message'=>'Email already exists']);
    exit;
}


$q = "INSERT INTO users (name,email,password,role) 
      VALUES ('$name','$email','$password','$role')";

if (mysqli_query($conn, $q)) {
    echo json_encode(['status'=>'success']);
} else {
    echo json_encode([
        'status'=>'error',
        'message'=>mysqli_error($conn)
    ]);
}
?>
