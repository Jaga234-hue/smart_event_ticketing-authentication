<?php
require_once 'db_connect.php';

// Check if POST request and email is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    $update_sql = "UPDATE notifications SET status = 'rejected' WHERE user_email = ?";
    $stmt = mysqli_prepare($conn, $update_sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        if (mysqli_stmt_execute($stmt)) {
            echo "rejected"; // Success response
        } else {
            echo "SQL Error: " . mysqli_error($conn); // Debugging SQL error
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Statement Error: " . mysqli_error($conn); // Debugging statement error
    }
} else {
    echo "Invalid Request"; // If POST request fails
}

mysqli_close($conn);
?>
