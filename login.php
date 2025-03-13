<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Email and password are required.';
        header("Location: user.php");
        exit();
    }

    // Use correct column name for email (e.g., 'Email')
    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Use correct column name for password (e.g., 'Password')
    if ($user && $password === $user['Password']) { // Replace with your logic
        header("Location: userhome.php");
        exit();
    } else {
        $_SESSION['error'] = 'Invalid email or password.';
        header("Location: loginpage.php"); // Fixed redirect
        exit();
    }

    $stmt->close();
}

$conn->close();
?>