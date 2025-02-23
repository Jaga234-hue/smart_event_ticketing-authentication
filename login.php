<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Email and password are required.']);
        exit;
    }

    // Prepare the SQL query using MySQLi
    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email); // "s" means string type
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        echo json_encode(['status' => 'success', 'message' => 'Login successful.']);
        header("Location: userhome.php"); // Redirect to userhome.php
    exit(); // Ensure script stops executing after redirect
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>
