<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['role'])) {
        $role = $_POST['role'];

        // Redirect based on selected role
        if ($role === "user") {
            header("Location: user.php");
            exit();
        } elseif ($role === "organiser") {
            header("Location: organiser.php");
            exit();
        } elseif ($role === "member") {
            header("Location: member.php");
            exit();
        }
    } else {
        // Redirect back if no selection is made
        header("Location: index.html"); // Change to your main page
        exit();
    }
}
?>
