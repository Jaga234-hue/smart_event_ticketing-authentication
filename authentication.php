<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["qrCodeData"])) {
        $qrData = $_POST["qrCodeData"];
        echo "QR Code Data Received: " . htmlspecialchars($qrData);
        // Process your QR data here (e.g., database check)
    } else {
        echo "Error: No QR code data received.";
    }
} else {
    echo "Invalid request method.";
}
?>
