<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color: rgba(0, 0, 0, 0.6);
        }
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            background-color:rgb(76, 131, 76);
        }
        .loader {
            border: 30px solid #f3f3f3;
            border-top: 30px solid #007BFF;
            border-radius: 50%;
            width: 200px;
            height: 200px;            
            animation: spin 1s linear infinite;
        }
        .wait-text {
            color: white;
            font-size: 18px;
            margin-top: 10px;
            font-weight: bold;
            color: black;
            text-align: center;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="loader-container" id="loader">
        <div>
            <div class="loader"></div>
            <div class="wait-text">Waiting for <br> organizer's approval...</div>
        </div>
</div>

<script>
    window.addEventListener('load', function() {
        document.getElementById('loader').style.display = 'flex';
    });
</script>
</body>
</html>