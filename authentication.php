<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["qrCodeData"])) {
        $qrData = $_POST["qrCodeData"];
        echo "QR Code Data Received: " . htmlspecialchars($qrData);

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

            // You can now use these variables for further processing (e.g., database operations)
        } else {
            echo "<br>Error: Unable to parse QR code data.";
        }
    } else {
        echo "Error: No QR code data received.";
    }
} else {
    echo "Invalid request method.";
}
?>