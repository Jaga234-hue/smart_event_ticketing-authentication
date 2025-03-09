<?php
session_start();
include 'phpqrcode.php'; // Include the php qrcode library
include 'db_connect.php'; // Include the database connection file

// Debugging: Print the POST data
echo "<pre>";
print_r($_POST);
echo "</pre>";

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
$status = 0; // Default status for online payment

if ($payment_method == 'online') {
    // Validate online payment fields
    if (!isset($_POST['transaction-id']) || empty($_POST['transaction-id'])) {
        die("Transaction ID is missing for online payment.");
    }
    if (!isset($_POST['transaction-date']) || empty($_POST['transaction-date'])) {
        die("Transaction date is missing for online payment.");
    }

    // Online payment
    $transaction_id = $_POST['transaction-id']; // Use the provided transaction ID
    $transaction_date = $_POST['transaction-date']; // Use the provided transaction date
    $status = 0; // Status remains 0 for online payment
} else {
    // Cash payment
    $transaction_id = "CASH"; // Default value for cash payments
    $transaction_date = date('Y-m-d H:i:s'); // Current date and time for cash payment
    $status = 1; // Status is 1 for cash payment
}

// Generate a unique ticket ID
function generateTicketID($conn) {
    $ticket_id = rand(100000, 999999);
    // Check if the ticket ID already exists in the database
    $stmt = $conn->prepare("SELECT Ticket_ID FROM payment WHERE Ticket_ID = ?");
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        // If the ticket ID already exists, generate a new one recursively
        return generateTicketID($conn);
    }
    $stmt->close();
    return $ticket_id;
}

$ticket_id = generateTicketID($conn);

// Generate QR code
$qrData = "UserID: $user_id, EventID: $event_id, TicketID: $ticket_id";
$qrFilePath = "qr/$ticket_id.png";
QRcode::png($qrData, $qrFilePath, QR_ECLEVEL_H, 10, 2);

// Insert payment details into the database
$stmt = $conn->prepare("INSERT INTO payment (Ticket_ID, Event_ID, User_id, Qr_code, status,  Transaction_Date) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiisss", $ticket_id, $event_id, $user_id, $qrFilePath, $status,  $transaction_date);

if ($stmt->execute()) {
    echo "Payment processed successfully. Ticket ID: $ticket_id<br>";
    echo "QR code generated: <img src='$qrFilePath' alt='QR Code'>";
} else {
    echo "Error processing payment: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>