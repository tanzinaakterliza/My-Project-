<?php
error_reporting(0);
header('Content-Type: application/json');
session_start();
include 'db.php';
header('Content-Type: application/json');

$email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = mysqli_real_escape_string($conn, $_POST['role'] ?? 'user');

if(!$email || !$password || !$role){
    echo json_encode(['status'=>'error','message'=>'Missing credentials']);
    exit;
}

$res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND role='$role' LIMIT 1");

if(mysqli_num_rows($res)!=1){
    echo json_encode(['status'=>'error','message'=>'User not found']);
    exit;
}

$user = mysqli_fetch_assoc($res);

// Verify password
if($password==$user['password']){
    // Set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['name'] = $user['name'];

    $userRole = strtolower($user['role']);
echo json_encode([
    'status'=>'success',
    'role'=>$userRole,
    'name'=>$user['name']
]);

} else {
    echo json_encode(['status'=>'error','message'=>'Invalid credentials']);
}
?>
