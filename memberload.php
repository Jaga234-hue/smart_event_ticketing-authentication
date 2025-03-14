<?php
require_once 'db_connect.php';
session_start(); // Start session

// Function to generate a unique Admin_ID
function generateUniqueAdminId($conn) {
    do {
        $admin_id = mt_rand(100000, 999999);
        $check_sql = "SELECT Admin_ID FROM admin WHERE Admin_ID = ?";
        $stmt = mysqli_prepare($conn, $check_sql);
        
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $admin_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $is_unique = mysqli_stmt_num_rows($stmt) == 0;
        mysqli_stmt_close($stmt);

    } while (!$is_unique);

    return $admin_id;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<script>alert('Invalid email format!');</script>");
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email exists
    $check_sql = "SELECT Email FROM admin WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $check_sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "<script>location.href = 'member.php';</script>";
        mysqli_stmt_close($stmt);
        exit();
    }

    mysqli_stmt_close($stmt);

    // Generate unique Admin_ID
    $admin_id = generateUniqueAdminId($conn);

    // Insert new admin
    $sql = "INSERT INTO admin (Admin_ID, Name, Email, Password) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "isss", $admin_id, $name, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['email'] = $email; // Store email in session
        $notif_sql = "INSERT INTO notifications (user_email, status) VALUES (?, 'pending')";
        $notif_stmt = mysqli_prepare($conn, $notif_sql);
        mysqli_stmt_bind_param($notif_stmt, "s", $email);
         mysqli_stmt_execute($notif_stmt); 
        mysqli_stmt_close($notif_stmt);
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.history.back();</script>";
    }
}
?>
<?php
session_start();
echo "Current User Email: " . ($_SESSION['email'] ?? "Not Set");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <style>
        body {
            display: flex;
            background-color: rgba(0, 0, 0, 0.6);
            font-family: Arial, sans-serif;
            align-items: center;
            justify-content: center;
            align-items: center;
            overflow: hidden;

        }
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            background-color: rgb(135, 154, 135);
        }
        .loader {
            border: 15px solid #f3f3f3;
            border-top: 15px solid #3498db;
            border-radius: 50%;
            width: 100px;
            height: 100px;            
            animation: spin 1s linear infinite;
            margin-left: 120px;
        }
        .wait-text {
            color: black;
            font-size: 18px;
            margin-top: 10px;
            font-weight: bold;
            text-align: center;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .form-container {
            margin-top: 50px;
        }
        input, button {
            padding: 10px;
            margin: 10px;
            width: 250px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Admin Registration</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter Name" required><br>
        <input type="email" name="email" placeholder="Enter Email" required><br>
        <input type="password" name="password" placeholder="Enter Password" required><br>
        <button type="submit">Register</button>
    </form>
</div>

<div class="loader-container" id="loader">
    <div>
        <div class="loader"></div>
        <div class="wait-text"><h1>Please Wait</h1>for <br> <h1>organizer's approval...</h1> <br>it may takes some time</div>
    </div>
</div>

   <script>
    const userEmail = "<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>";

function checkApproval() {
    if (!userEmail) return; // Stop checking if no email is available

    fetch('check_approval.php?t=' + new Date().getTime()) // Fetch approval status from the database
        .then(response => response.text())
        .then(status => {
            status = status.trim(); // Remove unwanted spaces

            console.log("Approval Status:", status);

            if (status === 'approved') {
                window.location.href = "memberhome.php"; // Redirect to member home
            } else if (status === 'rejected') {
                window.location.href = "member.php"; // Redirect to organiser home
                document.getElementById('loader').style.display = 'none'; // Hide loader
            } else {
                setTimeout(checkApproval, 5000); // Retry every 5 seconds
            }
        })
        .catch(error => console.error("Error fetching approval status:", error));
}

window.addEventListener('load', function() {
    if (userEmail) {
        document.getElementById('loader').style.display = 'flex';
        checkApproval(); // Start checking approval status
    }
});

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

</script>
</body>
</html>
