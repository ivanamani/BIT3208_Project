<?php
session_start(); // Access the current session
session_unset(); // Clear all session variables
session_destroy(); // Completely destroy the session on the server

// Kick the user back to the login page
header("Location: login.php");
exit();