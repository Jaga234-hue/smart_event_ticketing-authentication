<?php
// Check if the form data was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve event details from POST data
    $eventName = isset($_POST['eventName']) ? htmlspecialchars($_POST['eventName']) : "No Event Selected";
    $eventDate = isset($_POST['eventDate']) ? htmlspecialchars($_POST['eventDate']) : "N/A";
    $eventLocation = isset($_POST['eventLocation']) ? htmlspecialchars($_POST['eventLocation']) : "N/A";
} else {
    // Handle case where form was not submitted
    $eventName = "No Event Selected";
    $eventDate = "N/A";
    $eventLocation = "N/A";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            color: #333;
        }

        p {
            font-size: 18px;
            color: #555;
        }

        .payment-box {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        label,
        select,
        input,
        button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 8px;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background: #0056b3;
        }

        #online-payment-form {
            display: none;
        }

        #upi-button:hover {
            color: white;
            font-weight: bold;
            background: linear-gradient(135deg, rgb(120, 124, 129), #00c6ff);
            transform: scale(2.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <div id="payment-top">
        <h1>Payment Page</h1>
        <p><strong>Event Name:</strong> <?php echo $eventName; ?></p>
        <p><strong>Event Date:</strong> <?php echo $eventDate; ?></p>
        <p><strong>Event Location:</strong> <?php echo $eventLocation; ?></p>
        </div>
        <!-- Payment Form (Example) -->
        <div class="payment-box" id="payment-box">
            <h2>Payment</h2>
            <form id="payment-form" id="proceed-button" action="process_payment.php" method="POST">
                <label for="payment-method">Payment Method</label>
                <select name="payment-method" id="payment-method">
                    <option value="cash">Cash</option>
                    <option value="online">Online</option>
                </select>
                <input type="hidden" name="eventName" value="<?php echo htmlspecialchars($eventName); ?>">
                <input type="hidden" name="eventDate" value="<?php echo htmlspecialchars($eventDate); ?>">
                <input type="hidden" name="eventLocation" value="<?php echo htmlspecialchars($eventLocation); ?>">
                <button type="submit" id="proceed-button">Proceed</button>
            </form>
            
            <form id="online-payment-form" id="submit-payment" action="process_payment.php" method="POST">
                <label for="online-payment">Online Payment</label>
                <p> Name: <strong>Jagabandhu Prusty</strong></p>
                <p>UPI ID: <strong>9861828508@ybl</strong></p>
                <p>UPI Number: <strong>9861828508</strong></p>
                <a href="upi://pay?pa=9861828508@axl&pn=Jagabandhu%20Prusty&tn=Ticket&am=20&cu=INR" target="_blank">
                    <button type="button" id="upi-button">Pay ₹2000 via UPI</button>
                </a>
                <input type="file" id="upi-screenshot" accept="image/*">
                <input type="hidden" name="eventName" value="<?php echo htmlspecialchars($eventName); ?>">
                <input type="hidden" name="eventDate" value="<?php echo htmlspecialchars($eventDate); ?>">
                <input type="hidden" name="eventLocation" value="<?php echo htmlspecialchars($eventLocation); ?>">
                <input type="hidden" name="payment-method" value="online">
                <input type="text" name="transaction-id" id="transaction-id" placeholder="Enter Transaction ID" required >
                <input type="date" name="transaction-date" id="transaction-date" required>
                <button type="submit">Submit</button>
                </div>
            </form>
            <button id="cancel-button">Cancel</button>
        </div>
    </div>
    <script>
        const paymenttop = document.getElementById('payment-top');
        document.getElementById('payment-method').addEventListener('change', function() {
            let onlineForm = document.getElementById('online-payment-form');
            const proceedButton = document.getElementById('proceed-button');
            if (this.value === 'online') {
                onlineForm.style.display = 'block';
                proceedButton.style.display = 'none';
                paymenttop.style.display = 'none';
            } else {
                onlineForm.style.display = 'none';
                proceedButton.style.display = 'block';
                paymenttop.style.display = 'block';
            }
        });
        const cancelButton = document.getElementById('cancel-button');
        cancelButton.addEventListener('click', function() {
            window.location.href = 'userhome.php';
        });
    </script>
</body>

</html>