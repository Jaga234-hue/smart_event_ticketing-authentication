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

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            // Authentication successful
            $_SESSION['admin_id'] = $row['Admin_ID'];
            $_SESSION['admin_name'] = $row['Name'];

            // Check the status of the user
            $checksql = "SELECT status FROM notifications WHERE user_email = ?"; 
            $stm = $conn->prepare($checksql);
            $stm->bind_param("s", $email);
            $stm->execute();
            $statusResult = $stm->get_result();

            if ($statusResult->num_rows == 1) {
                $statusRow = $statusResult->fetch_assoc();
                $status = $statusRow['status'];

                if ($status == 'approved') {
                    header("Location: memberhome.php");
                } else {
                    header("Location: memberload.php");
                }
                exit();
            } else {
                echo "User status not found.";
            }
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }
    $stmt->close();
    $stm->close();
}
$conn->close();
?>