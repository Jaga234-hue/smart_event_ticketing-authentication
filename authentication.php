<?php
require_once 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["qrCodeData"])) {
        $qrData = $_POST["qrCodeData"];
        /* echo "QR Code Data Received: " . htmlspecialchars($qrData); */

        // Extract UserID, EventID, TicketID, and Status from the QR code data
        preg_match('/UserID: (\d+), EventID: (\d+), TicketID: (\d+) , Status: (\d+)/', $qrData, $matches);
        if (count($matches) == 5) {
            $userID = $matches[1];
            $eventID = $matches[2];
            $ticketID = $matches[3];
            $status = $matches[4];

            // Now you have the values in separate variables
            echo "<br>UserID: " . $userID;
            echo "<br>EventID: " . $eventID;
            echo "<br>TicketID: " . $ticketID;
            echo "<br>Status: " . $status;
            if ($status == '1') {
                echo "<script>
                window.onload = function() {
                let popup = document.createElement('div');
                popup.innerText = 'Not Paid';
                popup.style.position = 'fixed';
                popup.style.top = '20px'; /* Keep it near the top */
                popup.style.left = '50%'; /* Move it to the center */
                popup.style.transform = 'translateX(-50%)'; /* Adjust centering */
                popup.style.background = 'red';
                popup.style.color = 'white';
                popup.style.padding = '10px 20px';
                popup.style.borderRadius = '5px';
                popup.style.boxShadow = '0px 0px 10px rgba(0,0,0,0.3)';
                popup.style.zIndex = '1000';
            
                document.body.appendChild(popup);

                setTimeout(() => {
                popup.remove();
                },50000 ); // Remove after 3 seconds
                }; 
                </script>";
            }



            // Check the current status of the ticket
            $query = "SELECT status FROM payment WHERE Ticket_ID = ?";
            $stmt1 = mysqli_prepare($conn, $query);
            $status_authentication = 'successful';
            if ($stmt1) {
                // Bind the $ticketID parameter to the query
                mysqli_stmt_bind_param($stmt1, "i", $ticketID);

                // Execute the query
                mysqli_stmt_execute($stmt1);

                // Bind the result to a variable
                mysqli_stmt_bind_result($stmt1, $statu);

                // Fetch the result
                if (mysqli_stmt_fetch($stmt1)) {
                    // $statu now contains the value of the 'status' column for the given Ticket_ID
                    echo "Status for Ticket ID $ticketID: " . $statu;
                    if ($statu == '1') {
                        $status_authentication = 'successful';
                    } else {
                        $status_authentication = 'already_verified';
                    }
                } else {
                    echo "No record found for Ticket ID: " . $ticketID;
                }

                // Close the statement
                mysqli_stmt_close($stmt1);
            } else {
                echo "Error preparing statement: " . mysqli_error($conn);
            }


            function generateUniqueAuthID($conn)
            {
                do {
                    $authentication_id = rand(100000, 999999);
                    $query2 = "SELECT authentication_id FROM authentication WHERE authentication_id = ?";
                    $stmt2 = $conn->prepare($query2);
                    $stmt2->bind_param("i", $authentication_id);
                    $stmt2->execute();
                    $stmt2->store_result();
                } while ($stmt2->num_rows > 0); // Keep generating if ID exists
                $stmt2->close();

                return $authentication_id;
            }

            // Generate a unique authentication_id
            $authentication_id = generateUniqueAuthID($conn);

            // Status value (you can change this when inserting)
            $status = $status_authentication; // Leave blank or provide a value

            // Prepare the SQL statement
            $query2 = "INSERT INTO authentication (Ticket_ID,Name,authentication_id, datetime, status) VALUES (?,?,?, NOW(), ?)";
            $stmt2 = $conn->prepare($query2);

            // access cookie value
            
            if (isset($_COOKIE["user_id"]) && isset($_COOKIE["username"]) && isset($_COOKIE["email"]) && isset($_COOKIE["phone"])) {
                $user_id = $_COOKIE["user_id"];
                $username = $_COOKIE["username"];
                $email = $_COOKIE["email"];
                $phone = $_COOKIE["phone"];
            } else {
                echo "No user information found in cookies.";
            }
            if ($stmt2) {
                // Bind parameters
                $stmt2->bind_param("isis",$ticketID, $username,$authentication_id, $status);

                // Execute the query
                if ($stmt2->execute()) {
                    echo "Record inserted successfully. Authentication ID: " . $authentication_id;
                } else {
                    echo "Error inserting record: " . $stmt2->error;
                }

                // Close statement
                $stmt2->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }



            // Update the ticket status in the database
            $sql = "UPDATE payment SET status = '0' WHERE Ticket_ID = ?";

            $stmt2 = mysqli_prepare($conn, $sql);

            if ($stmt2) {
                mysqli_stmt_bind_param($stmt2, "s", $ticketID);
                if (mysqli_stmt_execute($stmt2)) {
                    echo "<script>var updateSuccess = true;</script>";
                    echo "<script>var ticketStatus = " . $statu . ";</script>"; // Pass $statu to JavaScript
                } else {
                    echo "Error updating ticket status: " . mysqli_error($conn);
                    echo "<script>var updateSuccess = false;</script>";
                }

                // Close the statement
                mysqli_stmt_close($stmt2);
            } else {
                echo "Error preparing update statement: " . mysqli_error($conn);
            }
        } else {
            echo "Error: QR code data format is incorrect.";
        }
    } else {
        echo "Error: No QR code data received.";
    }
} else {
    echo "Invalid request method.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Animation with Tick or Cross Mark</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: rgb(105, 98, 98);
            font-family: Arial, sans-serif;
            flex-direction: column;
        }

        .loader-container {
            display: flex;
            position: relative;
            height: 300px;
            width: 300px;
            background-color: rgb(79, 51, 51);
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid rgb(24, 50, 68);
            box-shadow: rgb(6, 142, 233);
        }

        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .tick-mark,
        .cross-mark {
            height: 200px;
            width: 200px;
            font-weight: bold;
            font-family: Arial, sans-serif;
            text-align: center;
            line-height: 200px;
            font-size: 100px;
            display: none;
            position: absolute;
            background-color: rgb(155, 141, 141);
        }

        .tick-mark {
            color: green;
        }

        .cross-mark {
            color: red;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="loader-container">
        <div class="loader" id="loader"></div>
        <div class="tick-mark" id="tickMark">&#10004;</div>
        <div class="cross-mark" id="crossMark">&#10008;</div>
    </div>
    <button onclick="window.location.href='memberhome.php'">Next</button>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if the update was successful
            if (typeof updateSuccess !== 'undefined' && updateSuccess) {
                setTimeout(function() {
                    // Hide the loader
                    document.getElementById('loader').style.display = 'none';

                    // Show the tick mark or cross mark based on ticketStatus
                    if (typeof ticketStatus !== 'undefined' && ticketStatus == 0) {
                        document.getElementById('crossMark').style.display = 'block';
                    } else {
                        document.getElementById('tickMark').style.display = 'block';
                    }
                }, 2000); // 2 seconds
            } else {
                // Hide the loader if the update failed
                document.getElementById('loader').style.display = 'none';
            }
        });
    </script>
</body>

</html>