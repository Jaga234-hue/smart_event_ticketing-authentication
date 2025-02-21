<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .notification {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(52, 152, 219, 0.8);
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            transition: 0.3s;
        }
        .notification:hover {
            background: rgba(41, 128, 185, 1);
        }
        .buttons {
            display: flex;
            gap: 5px;
        }
        .btn {
            border: none;
            padding: 5px 10px;
            color: white;
            border-radius: 3px;
            cursor: pointer;
            transition: 0.3s;
        }
        .approve {
            background: #2ecc71;
        }
        .approve:hover {
            background: #27ae60;
        }
        .reject {
            background: #e74c3c;
        }
        .reject:hover {
            background: #c0392b;
        }
        .info-box {
            background: white;
            color: black;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pending Notifications</h2>
        <div id="notifications"></div>
        <div class="info-box">Additional Information Here</div>
    </div>

    <script>
        let pendingNotifications = 3; // Change this number to update notifications

        function updateNotifications() {
            const notificationsContainer = document.getElementById("notifications");
            notificationsContainer.innerHTML = "";
            for (let i = 0; i < pendingNotifications; i++) {
                let notification = document.createElement("div");
                notification.className = "notification";
                notification.innerHTML = `
                    <span>Notification ${i + 1}</span>
                    <div class="buttons">
                        <button class="btn approve">✔</button>
                        <button class="btn reject">✖</button>
                    </div>
                `;
                notificationsContainer.appendChild(notification);
            }
        }
        updateNotifications();
    </script>
</body>
</html>
