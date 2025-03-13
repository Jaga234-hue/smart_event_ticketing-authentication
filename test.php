<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Example</title>
    <style>
        #loader {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <button onclick="startProcess()">Start Process</button>
    <div id="loader"></div>
    <p id="result"></p>

    <script>
        function startProcess() {
            document.getElementById("loader").style.display = "block";

            // Sending request to backend
            fetch("process.php")
                .then(response => response.text())
                .then(data => {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("result").innerText = data;
                })
                .catch(error => {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("result").innerText = "Error: " + error;
                });
        }
    </script>

</body>
</html>
