<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Handle CORS preflight request
    header("HTTP/1.1 200 OK");
    exit();
}

error_log("Received Request Method: " . $_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Request Method: POST");
    error_log("QR Code Data: " . print_r($_POST, true));

    // Retrieve the QR code data
    $qrCodeData = $_POST['qrCodeData'] ?? '';

    if (!empty($qrCodeData)) {
        echo "QR Code Data Received: " . htmlspecialchars($qrCodeData);
    } else {
        echo "No QR Code Data Received.";
    }
} else {
    error_log("Invalid Request Method: " . $_SERVER['REQUEST_METHOD']);
    echo "Invalid Request Method.";
}
?>
