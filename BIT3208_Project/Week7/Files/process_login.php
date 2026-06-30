<?php
include('db_connect.php');

// 1. We check if the form was actually submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. We capture the username and password the user typed in
    $captured_username = $_POST['username'];
    $captured_password = $_POST['password'];

    // 3. We print a dynamic welcome message using the username
    echo "<h1>Welcome to Sea of Games!</h1>";
    echo "<p>We have successfully received your login request, <strong>" . htmlspecialchars($captured_username) . "</strong>!</p>";
    
} else {
    // If someone tries to just type the URL directly without logging in, we show an error.
    echo "Error: Please use the login form.";
}
?>