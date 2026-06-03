<?php
// 1. Pull in the database connection file
require_once 'db_connect.php';

// 2. Check if the login form was actually submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 3. Collect the inputs from the form $_POST array
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // 4. Construct the SQL query string
    // (This assumes your table is named 'users' and column is 'username')
    $sql = "SELECT * FROM users WHERE username = '$username'";
    
    // 5. Run the query against the database using the $conn variable from db_connect.php
    $result = mysqli_query($conn, $sql);
    
    // 6. Check if the query found at least one matching user record
    if (mysqli_num_rows($result) > 0) {
        
        // Fetch the matching user record as an associative array
        $user = mysqli_fetch_assoc($result);
        
        // 7. Verify if the entered password matches the password in the database
        // (Note: This is a plain-text check typically used in introductory assignments)
        if ($password == $user['password']) {
            echo "<p style='color:green; font-weight:bold;'>Login successful! Welcome, " . htmlspecialchars($username) . ".</p>";
            
            // TODO: In future steps, you will add session handling and redirects here
            
        } else {
            echo "<p style='color:red; font-weight:bold;'>Invalid password. Please try again.</p>";
        }
        
    } else {
        echo "<p style='color:red; font-weight:bold;'>Username does not exist.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sea of Games - Logi</title>
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
    
    <div id="error-message"></div>

   <form id="loginForm" action="process_login.php" method="POST">
    <label>Username:</label>
   <input type="text" name="username" id="usernameField" oninput="updatePreview()" required>
    <p id="usernamePreview"></p>
    <label>Password:</label>
    <input type="password" name="password" id="password" onkeyup="checkStrength()" required>
    <p id="strength-message"></p>
    <button id="menuButton" onclick="toggleMenu()">Open Menu</button>
    <button type="submit">Login</button>
</form>

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
    if (menu.style.display == "none") {
        menu.style.display = "block";
    } 
    else {
        menu.style.display = "none";
    }
    
}
function updatePreview() {
    // 1. Get what was typed in the input field
    let typedText = document.getElementById("usernameField").value;

    // 2. Put that text into the paragraph preview
    document.getElementById("usernamePreview").innerText = typedText;
}
</script>
</body>
</html>