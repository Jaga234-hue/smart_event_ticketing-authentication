<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        /* Centering the container */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Glassmorphism effect */
        .container {
            width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            position: relative; /* Fix for pseudo-element */
        }

        /* Input Fields */
        .form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            outline: none;
            font-size: 16px;
        }

        /* Placeholder Styling */
        .form input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Button with animation */
        .form button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            border: none;
            color: white;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.3s;
        }

        .form button:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(255, 75, 43, 0.7);
        }

        /* Floating animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Removed container::before to prevent interference */
        
    </style>
</head>

<body>
<div class="container">
    <div id="loginForm" class="form active">
        <form id="loginform" method="POST">
            <label for="unique-number" style="color: white; font-size: 18px;">Unique-number</label>
            <input type="password" id="password" name="unique-number" placeholder="Enter your unique number" required>
            <div id="loginError" style="color: red; display: none;"></div>
            <button type="submit">Login</button>
        </form>
    </div>
</div>
    <script>
        var uniqid = 2457;
        document.getElementById('loginform').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the traditional way

        var password = document.getElementById('password').value;
        var errorDiv = document.getElementById('loginError');
        
        if (password == uniqid) {
            // Redirect to organiserhome.php if the password is correct
            window.location.href = 'organiserhome.php';
        } else {
            // Show error message if the password is incorrect
            errorDiv.style.display = 'block';
            errorDiv.textContent = 'Incorrect unique number. Please try again.';
        }
    });
    </script>
</body>

</html>
