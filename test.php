<?php
$showAnimation = true; // Change this based on your condition
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bombastic Benchmark Animation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #0e0e0e;
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
            background: #111;
            z-index: 100;
            font-size: 2rem;
            color: white;
            font-family: Arial, sans-serif;
            animation: fadeOut 1s 1s forwards;
        }

        @keyframes fadeOut {
            100% {
                opacity: 0;
                visibility: hidden;
            }
        }

        /* ANIMATION CONTAINER */
        .benchmark {
            width: 200px;
            height: 200px;
            position: relative;
            display: none;
        }

        /* MODERN BOMBASTIC ANIMATION */
        .benchmark div {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 4px solid transparent;
            border-radius: 50%;
            animation: rotate 2s linear infinite, pulse 2s ease-in-out infinite alternate;
        }

        .benchmark div:nth-child(1) {
            border-color: #ff004c;
            animation-delay: 0s;
        }

        .benchmark div:nth-child(2) {
            border-color: #ff8200;
            animation-delay: 0.2s;
        }

        .benchmark div:nth-child(3) {
            border-color: #00ffcc;
            animation-delay: 0.4s;
        }

        .benchmark div:nth-child(4) {
            border-color: #007bff;
            animation-delay: 0.6s;
        }

        @keyframes rotate {
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {
            100% {
                transform: scale(1.2);
            }
        }

    </style>
</head>
<body>

<?php if ($showAnimation): ?>
    <!-- LOADING SCREEN -->
    <div class="loading">Loading...</div>

    <!-- BOMBASTIC BENCHMARK ANIMATION -->
    <div class="benchmark" id="benchmark">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <script>
        setTimeout(() => {
            document.getElementById("benchmark").style.display = "block";
        }, 1000);
    </script>
<?php else: ?>
    <h2 style="color: white;">Animation is disabled</h2>
<?php endif; ?>

</body>
</html>
