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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
                <!-- Email -->
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
        
                <!-- Password -->
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <div id="loginError" style="color: red; display: none;"></div>
                <!-- Submit Button -->
                <button type="submit">Login</button>
            </form>
        </div>
        

        <div id="signupForm" class="form">
            <form id="signupform" action="db_store_API.php" method="POST" enctype="multipart/form-data">
                <h2>Sign Up</h2>
            
                <!-- Full Name -->
                <label for="username">Full Name</label>
                <input type="text" id="username" name="username" placeholder="Full Name" required>
                
                <!-- Email -->
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
            
                <!-- Password -->
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            
                <!-- Confirm Password -->
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                <!-- location -->
                 <label for="user-location">location</label>
                <input type="text" id="user-location" name="user-location" placeholder="location" required>
                <!-- Profile Picture -->
                <label for="profile_picture">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required>
                <div id="signupError" style="color: red; display: none;"></div>
                <!-- Submit Button -->
                <button type="submit">Sign Up</button>
            </form>
            
        </div>
    </div>

    <script>
        function showForm(formType) {
            // Remove active class from both tabs
            document.getElementById('loginTab').classList.remove('active');
            document.getElementById('signupTab').classList.remove('active');

            // Hide both forms
            document.getElementById('loginForm').classList.remove('active');
            document.getElementById('signupForm').classList.remove('active');

            // Show the selected form and activate its tab
            if (formType === 'login') {
                document.getElementById('loginTab').classList.add('active');
                document.getElementById('loginForm').classList.add('active');
            } else {
                document.getElementById('signupTab').classList.add('active');
                document.getElementById('signupForm').classList.add('active');
            }
        }
    </script>