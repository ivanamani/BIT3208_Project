<?php
session_start();
require_once 'db_connect.php';
// Pull in the database connection
require_once 'db_connect.php';

$message = ""; // Variable to hold success or error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Stored as plain text to match your login script

    // Check if username already exists
    $check_sql = "SELECT * FROM users WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $message = "<p style='color:red; font-weight:bold;'>Username already taken.</p>";
    } else {
        // Construct insertion query
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        
        // Execute query
        if (mysqli_query($conn, $sql)) {
            $message = "<p style='color:green; font-weight:bold;'>Registration successful! <a href='login.php'>Login here</a>.</p>";
        } else {
            $message = "<p style='color:red; font-weight:bold;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Create an Account</h2>
    
    <?php echo $message; ?>

    <form method="POST" action="register.php">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email Address:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>