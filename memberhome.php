<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #2c3e50, #4ca1af);
            font-family: Arial, sans-serif;
        }
        .container {
            width: 500px;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }
        .scanner-box {
            padding: 20px;
            border-radius: 10px;
        }
        .scanner-title {
            background: black;
            color: white;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 5px;
        }
        .scanner-button {
            background: #1e3a5f;
            color: white;
            padding: 12px 25px;
            margin: 15px 0;
            border: none;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            border: 2px solid red;
            transition: all 0.3s ease;
        }
        .scanner-button:hover {
            background: red;
            border-color: white;
        }
        .scan-count {
            margin-top: 20px;
            padding: 12px;
            border: 1px solid white;
            font-size: 16px;
            color: white;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            cursor: pointer;
        }

        /* Scanner Modal */
        #scannerModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        #scannerModal.active {
            opacity: 1;
            visibility: visible;
        }
        .scanner-window {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        video {
            width: 100%;
            border-radius: 5px;
            border: 2px solid #1e3a5f;
        }
        .close-btn {
            background: red;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 15px;
            border-radius: 5px;
            font-size: 16px;
            transition: background 0.3s ease;
        }
        .close-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="scanner-box">
            <div class="scanner-title">Scanner</div>
            <button class="scanner-button" onclick="openScanner()">Open</button>
        </div>
        <div class="scan-count">Total successful scans</div>
    </div>

    <div id="scannerModal">
        <div class="scanner-window">
            <video id="cameraFeed" autoplay></video>
            <button class="close-btn" onclick="closeScanner()">Close</button>
        </div>
    </div>

    <script>
        let videoStream;

        function openScanner() {
            let modal = document.getElementById('scannerModal');
            modal.classList.add("active");

            navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                .then(stream => {
                    videoStream = stream;
                    document.getElementById('cameraFeed').srcObject = stream;
                })
                .catch(err => {
                    alert("Camera access denied or not available.");
                    console.error(err);
                });
        }

        function closeScanner() {
            let modal = document.getElementById('scannerModal');
            modal.classList.remove("active");

            if (videoStream) {
                let tracks = videoStream.getTracks();
                tracks.forEach(track => track.stop());
            }
        }
    </script>

</body>
</html>
