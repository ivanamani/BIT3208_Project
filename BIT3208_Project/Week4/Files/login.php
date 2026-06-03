<?php
session_start();
require_once 'db_connect.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if ($password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header("Location: welcome.php");
            exit(); 
        } else {
            $error_message = "Password mismatch! You typed: '$password'. DB has: '" . $user['password'] . "'";
        }
    } else {
        $error_message = "Username '$username' not found in the database table.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sea of Games - Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #1e1e24; color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #2a2a35; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); width: 300px; }
        h2 { text-align: center; color: #00ff87; margin-bottom: 20px; }
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 5px; font-size: 14px; }
        .input-group input { width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #444; background: #1e1e24; color: #fff; box-sizing: border-box; }
        .btn { width: 100%; padding: 10px; background: #00ff87; border: none; color: #121214; font-weight: bold; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .btn:hover { background: #00e574; }
        #error-message { color: #ff4a4a; font-size: 14px; margin-bottom: 15px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Sea of Games Login</h2>
    
    <div id="error-message"><?php echo $error_message; ?></div>

    <form id="loginForm" action="login.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username" id="usernameField" oninput="updatePreview()" required>
        <p id="usernamePreview"></p>
        
        <label>Password:</label>
        <input type="password" name="password" id="password" onkeyup="checkStrength()" required>
        <p id="strength-message"></p>
        
        <button type="button" id="menuButton" onclick="toggleMenu()">Open Menu</button>
        <button type="submit" class="btn">Login</button>
    </form>
</div>

<script>
    function checkStrength() {
        let password = document.getElementById('password').value;
        let message = document.getElementById('strength-message');
        
        if (password.length == 0) {
            message.innerText = "";
        } else if (password.length < 5) {
            message.innerText = "Weak";
            message.style.color = "red";
        } else if (password.length < 10) {
            message.innerText = "Medium";
            message.style.color = "orange";
        } else {
            message.innerText = "Strong";
            message.style.color = "green";
        }
    }

    function toggleMenu() {
        let menu = document.getElementById("myMenu");
        if (menu) {
            if (menu.style.display == "none" || menu.style.display == "") {
                menu.style.display = "block";
            } else {
                menu.style.display = "none";
            }
        }
    }

    function updatePreview() {
        let typedText = document.getElementById("usernameField").value;
        document.getElementById("usernamePreview").innerText = typedText;
    }
</script>
</body>
</html>