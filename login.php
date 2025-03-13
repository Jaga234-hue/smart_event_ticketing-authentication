<?php
session_start();
require_once 'db_connect.php';

ini_set('display_errors', 0); // Disable error display in production
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Email and password are required.';
        header("Location: user.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT User_ID, Password FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['User_ID']; // Store user ID in session
        session_regenerate_id(true); // Regenerate session ID for security
        header("Location: userhome.php");
        exit();
    } else {
        $_SESSION['error'] = 'Invalid email or password.';
        header("Location: user.php");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>