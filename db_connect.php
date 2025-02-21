<?php
// Database configuration
$host = 'localhost';
$dbname = 'smart_event';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database Connection Error: " . $e->getMessage()); // Log error
    exit(json_encode(['status' => 'error', 'message' => 'Database connection failed.']));
}

// Uncomment this if you want to confirm successful connection
echo json_encode(['status' => 'success', 'message' => 'Database connected successfully.']);

?>
