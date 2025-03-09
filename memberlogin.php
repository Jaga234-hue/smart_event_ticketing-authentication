<?php
session_start();
include 'db_connect.php'; // Ensure this file correctly connects to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare query to prevent SQL injection
    $sql = "SELECT * FROM admin WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $email; // Store session

            // Redirect based on email
            if ($email === "payment@gmail.com") {
                header("Location: cashcheck.php");
            } else {
                header("Location: memberhome.php");
            }
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid email or password'); window.location.href='login.php';</script>";
        }
    } else {
        // Invalid email
        echo "<script>alert('Invalid email or password'); window.location.href='login.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
