<?php
// Week 4 Database Connection String
$conn = mysqli_connect("localhost", "root", "", "sea_of_games_week5");

// Check if the connection works
if($conn){
    echo "<p style='color:green; font-weight:bold;'>Database Connected Successfully to Week 5!</p>";
} else {
    // If it fails, this will stop everything and show the error
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>