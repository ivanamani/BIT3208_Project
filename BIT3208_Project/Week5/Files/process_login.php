<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to find the user in the database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // If the database returns 1 matching row, login is successful
    if (mysqli_num_rows($result) == 1) {
        echo "<h1>Login Successful!</h1>";
        echo "<p>Welcome back, " . htmlspecialchars($username) . "!</p>";
    } else {
        echo "<h1>Login Failed</h1>";
        echo "<p>Invalid username or password. Please try again.</p>";
    }
}
?>