<?php
// Database Configuration Setup
$servername = "localhost";
$username = "root";       
$password = "";             
$dbname = "sea_of_games_week7";

// 1. Create the connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// 2. Check if the connection failed
if (!$conn) {
    die("<div style='color:red; font-family:sans-serif; padding:20px;'>
            <strong> Database Connection Failed:</strong> " . mysqli_connect_error() . "
         </div>");
}
?>