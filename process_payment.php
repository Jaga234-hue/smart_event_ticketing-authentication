<?php
session_start();
include 'phpqrcode.php'; // Include the php qrcode library
include 'db_connect.php'; // Include the database connection file

// Validate and get user ID from cookie
if (!isset($_COOKIE['user_id'])) {
    die("User ID not found. Please log in.");
}
$user_id = $_COOKIE['user_id'];

// Validate and get event name from the form
if (!isset($_POST['eventName']) || empty($_POST['eventName'])) {
    die("Event name is missing. Please ensure the form is submitted correctly.");
}
$event_name = $_POST['eventName'];

// Fetch Event ID from the database based on the event name
$stmt = $conn->prepare("SELECT Event_ID FROM event WHERE Name = ?");
$stmt->bind_param("s", $event_name);
$stmt->execute();
$stmt->bind_result($event_id);
$stmt->fetch();
$stmt->close();

if (!$event_id) {
    die("Event not found in the database.");
}

// Handle payment method
$payment_method = $_POST['payment-method'] ?? null;
$transaction_id = null;
$transaction_date =  null;
$status = '0'; // Default status for online payment

if ($payment_method == 'online') {
    if (!isset($_POST['transaction-id']) || empty($_POST['transaction-id'])) {
        die("Transaction ID is missing for online payment.");
    }
    if (!isset($_POST['transaction-date']) || empty($_POST['transaction-date'])) {
        die("Transaction date is missing for online payment.");
    }

    $transaction_id = $_POST['transaction-id']; 
    $transaction_date = $_POST['transaction-date']; 
    $status = '0'; 
} else {
    $transaction_id = "CASH"; 
    $transaction_date = date('Y-m-d H:i:s'); 
    $status = '1'; 
}

// Generate a unique ticket ID
function generateTicketID($conn) {
    $ticket_id = rand(100000, 999999);
    $stmt = $conn->prepare("SELECT Ticket_ID FROM payment WHERE Ticket_ID = ?");
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        return generateTicketID($conn);
    }
    $stmt->close();
    return $ticket_id;
}

$ticket_id = generateTicketID($conn);

// Generate QR code
$qrData = "UserID: $user_id, EventID: $event_id, TicketID: $ticket_id , Status: $status";
$qrFilePath = "qr/$ticket_id.png";
QRcode::png($qrData, $qrFilePath, QR_ECLEVEL_H, 10, 2);
$status = '1';
// Insert payment details into the database
$stmt = $conn->prepare("INSERT INTO payment (Ticket_ID, Event_ID, User_id, Qr_code, status, Transaction_Date) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiisss", $ticket_id, $event_id, $user_id, $qrFilePath, $status, $transaction_date);
 $stmt->execute(); //
/* if ($stmt->execute()) {
    // Change this based on your condition

   echo "Payment processed successfully. Ticket ID: $ticket_id<br>";
   echo "QR code generated: <img src='$qrFilePath' alt='QR Code'>"; 
} else {
   echo "Error processing payment: " . $stmt->error;
} */
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #121212;
            overflow: hidden;
        }

        /* LOADING SCREEN */
        .loading {
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100vw;
            height: 100vh;
            background: #000;
            color: white;
            font-size: 2rem;
            animation: fadeOut 1s 1s forwards;
        }

        @keyframes fadeOut {
            100% {
                opacity: 0;
                visibility: hidden;
            }
        }

        /* SUCCESS BOX */
        .success-box {
            position: relative;
            display: none;
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #00ff99, #0077ff);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 20px rgba(0, 255, 153, 0.5);
            animation: popUp 0.5s ease-out;
        }

        @keyframes popUp {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* CHECKMARK */
        .checkmark {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 5px 10px rgba(255, 255, 255, 0.2);
            animation: bounce 0.6s ease-out;
        }

        .checkmark::after {
            content: "✔";
            font-size: 3rem;
            color: #00ff99;
        }

        @keyframes bounce {
            0% {
                transform: scale(0);
            }
            70% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        /* SUCCESS MESSAGE */
        .message {
            margin-top: 20px;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* SKIP BUTTON */
        .skip-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.3);
            border: none;
            color: white;
            font-size: 1rem;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .skip-btn:hover {
            background: rgba(255, 255, 255, 0.6);
        }

    </style>
</head>
<body>

    <!-- LOADING SCREEN -->
    <div class="loading">Processing...</div>

    <!-- SUCCESS BOX -->
    <div class="success-box" id="successBox">
        <button class="skip-btn" onclick="skipAnimation()">Skip</button>
        <div class="checkmark"></div>
        <div class="message">Payment Successful</div>
    </div>

    <script>
        setTimeout(() => {
            document.getElementById("successBox").style.display = "flex";
            window.location.href = "userhome.php";
        }, 3000);

        function skipAnimation() {
            document.getElementById("successBox").style.display = "none";
            window.location.href = "userhome.php";
        }
    </script>

</body>
</html>
