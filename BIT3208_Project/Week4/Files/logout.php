<?php
// Start the session to find the active data
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session entirely
session_destroy();

// Redirect back to the login page
header("Location: login.php");
exit();
?>