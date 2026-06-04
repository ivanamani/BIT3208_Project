<?php
// Start the session to access login data
session_start();

// Check if the user is NOT logged in
if (!isset($_SESSION['username'])) {
    // Redirect them to the login page immediately
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! </h1>
    <p>You have successfully logged into your dynamic dashboard.</p>
    
    <br>
    <a href="logout.php">Logout Securely</a>
</body>
</html>