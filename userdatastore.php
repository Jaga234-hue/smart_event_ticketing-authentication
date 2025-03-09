<?php
require_once 'db_connect.php';

// Function to generate a unique 6-digit user ID
function generateUniqueUserId($conn) {
    do {
        $user_id = mt_rand(100000, 999999); // Generate a 6-digit random number
        $check_sql = "SELECT User_ID FROM user WHERE User_ID = ?";
        $stmt = mysqli_prepare($conn, $check_sql);
        
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $is_unique = mysqli_stmt_num_rows($stmt) == 0;
        mysqli_stmt_close($stmt);

    } while (!$is_unique); // Repeat if the ID is not unique

    return $user_id;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs
    $name = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["mobile-number"]);
    $password = trim($_POST["password"]);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $check_sql = "SELECT Email FROM user WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $check_sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "<script>alert('Email already exists!');</script>";
        mysqli_stmt_close($stmt);
        exit();
    }

    mysqli_stmt_close($stmt); // Close the check statement

    // Generate unique 6-digit user ID
    $user_id = generateUniqueUserId($conn);

    // Insert new user into database
    $sql = "INSERT INTO user (User_ID, Name, Email, Phone, Password) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "issss", $user_id, $name, $email, $phone, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        setcookie("user_id", $user_id, time() + (86400 * 30), "/");
        setcookie("username", $name, time() + (86400 * 30), "/");
        setcookie("email", $email, time() + (86400 * 30), "/");
        setcookie("phone", $phone, time() + (86400 * 30), "/");
        echo "<script>alert('Registration successful!'); </script>";
        echo "<script>window.location.href = 'userhome.php';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.history.back();</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>


