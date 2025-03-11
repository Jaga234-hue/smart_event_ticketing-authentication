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

            // Check the current status of the ticket
            $query = "SELECT status FROM payment WHERE Ticket_ID = ?";
            $stmt1 = mysqli_prepare($conn, $query);

            if ($stmt1) {
                // Bind the $ticketID parameter to the query
                mysqli_stmt_bind_param($stmt1, "s", $ticketID);

                // Execute the query
                mysqli_stmt_execute($stmt1);

                // Bind the result to a variable
                mysqli_stmt_bind_result($stmt1, $statu);

                // Fetch the result
                if (mysqli_stmt_fetch($stmt1)) {
                    // $statu now contains the value of the 'status' column for the given Ticket_ID
                    echo "Status for Ticket ID $ticketID: " . $statu;
                } else {
                    echo "No record found for Ticket ID: " . $ticketID;
                }

                // Close the statement
                mysqli_stmt_close($stmt1);
            } else {
                echo "Error preparing statement: " . mysqli_error($conn);
            }

            // Update the ticket status in the database
            $sql = "UPDATE payment SET status = '0' WHERE Ticket_ID = ?";
            $stmt2 = mysqli_prepare($conn, $sql);

            if ($stmt2) {
                mysqli_stmt_bind_param($stmt2, "s", $ticketID);
                if (mysqli_stmt_execute($stmt2)) {
                    echo "<script>var updateSuccess = true;</script>";
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
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Animation with Tick Mark</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .tick-mark {
            font-size: 60px;
            color: green;
            display: none;
            position: absolute;
        }
    </style>
</head>
<body>
    <div class="loader" id="loader"></div>
    <div class="tick-mark" id="tickMark">&#10004;</div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if the update was successful
            if (typeof updateSuccess !== 'undefined' && updateSuccess) {
                setTimeout(function() {
                    // Hide the loader
                    document.getElementById('loader').style.display = 'none';

                    // Show the tick mark
                    document.getElementById('tickMark').style.display = 'block';
                }, 2000); // 2 seconds
            } else {
                // Hide the loader if the update failed
                document.getElementById('loader').style.display = 'none';
            }
        });
    </script>
</body>
</html>