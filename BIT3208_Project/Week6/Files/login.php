<?php
// 1. ABSOLUTE TOP - Starts session and grabs your universal DB configuration
session_start();
require_once 'db_connect.php'; 

$error = "";

// 2. Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $conn comes directly out of your db_connect.php file cleanly!
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 3. Query the database for the user
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        
        // 🚀 Redirects straight to your main inventory list dashboard
        header("Location: products.php"); 
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SeaofGames</title>
    <style>
        /* Modern Design Tokens mirroring your Dashboard Layout */
        :root {
            --bg-color: #f4f5f9;
            --card-bg: #ffffff;
            --text-main: #1a1926;
            --text-muted: #71717a;
            --primary-purple: #b646fd; /* Signature SeaofGames purple */
            --primary-hover: #931bf0;
            --error-bg: #fee2e2;
            --error-text: #ef4444;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }

        .login-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 40px 36px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            text-align: center;
        }

        .logo-container {
            margin-bottom: 12px;
        }

        .logo-text {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .logo-text span {
            color: var(--primary-purple);
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 32px;
        }

        .error-banner {
            background-color: var(--error-bg);
            color: var(--error-text);
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 24px;
            text-align: left;
            border-left: 4px solid var(--error-text);
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 22px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 13px 16px;
            border: 1px solid #e4e4e7;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.2s ease;
            outline: none;
            background-color: #fafafa;
        }

        .form-group input:focus {
            border-color: var(--primary-purple);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(182, 70, 253, 0.12);
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-purple);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 8px;
        }

        .login-btn:hover {
            background-color: var(--primary-hover);
        }

        .footer-link {
            margin-top: 28px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .footer-link a {
            color: var(--primary-purple);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card">
        
        <div class="logo-container">
            <div class="logo-text"><span>Sea</span>ofGames</div>
        </div>
        <p class="subtitle">Sign in to manage your video game vault</p>

        <?php 
        if (isset($error) && !empty($error)): 
        ?>
            <div class="error-banner">
                ℹ️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="login-btn">Log In</button>
        </form>

        <div class="footer-link">
            Need an account? <a href="register.php">Create one here</a>
        </div>

    </div>
</div>

</body>
</html>