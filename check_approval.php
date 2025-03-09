<?php
require_once 'db_connect.php';
session_start();

if (!isset($_SESSION['email'])) {
    echo "not_logged_in"; 
    exit();
}

$email = $_SESSION['email'];

// Query the database for approval status
$sql = "SELECT status FROM notifications WHERE user_email = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $status);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

echo $status ? $status : "pending"; // Return status ('approved', 'rejected', or 'pending')
?>
