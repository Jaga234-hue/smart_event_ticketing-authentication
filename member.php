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
            <form id="signupform">
                <h2>Sign Up</h2>
                <input type="text" id="username" name="username" placeholder="Full Name" required>
                <input type="email" id="signup-email" name="email" placeholder="Email" required>
                <input type="password" id="signup-password" name="password" placeholder="Password" required>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                <input type="text" id="mobile-number" name="mobile-number" placeholder="Mobile Number" required>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required>
                <button type="submit">Sign Up</button>
            </form>
        </div>
    </div>
    <div class="loader-container" id="loader">
        <div>
            <div class="loader"></div>
            <div class="wait-text">Waiting for <br> organizer's approval...</div>
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
        document.getElementById("signupform").addEventListener("submit", function (e) {
            e.preventDefault();
            document.getElementById("loader").style.display = "flex";
            let formData = new FormData(this);
            fetch("db_store_API.php", { method: "POST", body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.setItem("user_email", formData.get("email"));
                    checkVerification();
                }
            });
        });
        function checkVerification() {
            let userEmail = localStorage.getItem("user_email");
            if (!userEmail) return;
            let interval = setInterval(() => {
                fetch("check_verification.php?email=" + userEmail)
                .then(response => response.json())
                .then(data => {
                    if (data.verified) {
                        clearInterval(interval);
                        document.getElementById("loader").style.display = "none";
                    }
                });
            }, 5000);
        }
    </script>
</body>
</html>
