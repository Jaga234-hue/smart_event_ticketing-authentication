<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('img/img_for_web.webp');
        }
        .container {
            width: 350px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .tab {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .tab button {
            flex: 1;
            padding: 10px;
            background: #ddd;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .tab button.active {
            background: #007BFF;
            color: white;
            font-weight: bold;
        }
        .form {
            display: none;
        }
        .form.active {
            display: block;
        }
        .form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .form button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tab">
            <button id="loginTab" class="active" onclick="showForm('login')">Login</button>
            <button id="signupTab" onclick="showForm('signup')">Sign Up</button>
        </div>
        <div id="loginForm" class="form active">
            <form id="loginform" action="login.php" method="POST">
                <h2>Login</h2>
                <label for="login-email">Email</label>
                <input type="email" id="login-email" name="email" placeholder="Email" required>
                <label for="login-password">Password</label>
                <input type="password" id="login-password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
        <div id="signupForm" class="form">
            <form id="signupform" action="memberload.php" method="POST">
                <h2>Sign Up</h2>
                <input type="text" id="username" name="username" placeholder="Full Name" required>
                <input type="email" id="signup-email" name="email" placeholder="Email" required>
                <input type="password" id="signup-password" name="password" placeholder="Password" required>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Sign Up</button>
            </form>
        </div>
    </div>
    <script>
        function showForm(formType) {
            document.getElementById('loginTab').classList.remove('active');
            document.getElementById('signupTab').classList.remove('active');
            document.getElementById('loginForm').classList.remove('active');
            document.getElementById('signupForm').classList.remove('active');
            document.getElementById(formType + 'Tab').classList.add('active');
            document.getElementById(formType + 'Form').classList.add('active');
        }
        
    </script>
</body>
</html>
