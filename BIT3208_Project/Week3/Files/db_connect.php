<?php
// Week 3 Database Connection String
$conn = mysqli_connect("localhost", "root", "", "sea_of_games_week3");

// Check if the connection works
if($conn){
  // echo "<p style='color:green; font-weight:bold;'>Database Connected Successfully to Week 3!</p>";
} else {
    // If it fails, this will stop everything and show the error
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>