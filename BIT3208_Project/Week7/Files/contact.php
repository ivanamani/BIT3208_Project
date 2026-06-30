<?php
// Pull in the database connection
require_once 'db_connect.php';

$message_status = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_message = $_POST['message'];

    // Construct insertion query (assumes a 'messages' table exists)
    $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$user_message')";
    
    // Execute query
    if (mysqli_query($conn, $sql)) {
        $message_status = "<p style='color:green; font-weight:bold;'>Thank you! Your message has been saved.</p>";
    } else {
        $message_status = "<p style='color:red; font-weight:bold;'>Failed to send message: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
</head>
<body>
    <h2>Contact Us</h2>
    
    <?php echo $message_status; ?>

    <form method="POST" action="contact.php">
        <label for="name">Your Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Your Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="message">Message:</label><br>
        <textarea id="message" name="message" rows="5" cols="30" required></textarea><br><br>

        <input type="submit" value="Send Message">
    </form>
</body>
</html>