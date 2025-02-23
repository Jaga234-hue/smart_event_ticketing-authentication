<?php
// Database configuration
$host = 'localhost';
$dbname = 'smart_event';
$username = 'root';
$password = '';

// Create connection using MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Database Connection Error: " . $conn->connect_error); // Log error
    exit(json_encode(['status' => 'error', 'message' => 'Database connection failed.']));
}

// Uncomment this if you want to confirm successful connection
/* echo json_encode(['status' => 'success', 'message' => 'Database connected successfully.']); */

?>
