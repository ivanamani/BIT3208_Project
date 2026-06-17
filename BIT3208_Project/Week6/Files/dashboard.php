<?php
// 1. Enable error reporting for smooth debugging during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Start the session to check if the user is logged in
session_start();

// 3. Security Guard Check: Boot users out if they try to access this page directly
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// 4. Establish database connection
include("db_connect.php");

// 5. Fetch all records from the products table
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// 6. Dynamically count how many records exist in your database
$total_games = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sea of Games</title>
    <style>
        /* Base Styling & Visual Layout Reset */
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }
        body { 
            display: flex; 
            height: 100vh; 
            background-color: #f4f5f7; 
            overflow: hidden;
        }

        /* --- SIDEBAR PANEL (Left Side) --- */
        .sidebar {
            width: 260px;
            background-color: #131124; /* Dark sleek purple/navy profile match */
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 25px;
        }
        .profile-section {
            margin-bottom: 30px;
        }
        .profile-name {
            font-size: 1.1em;
            font-weight: 600;
        }
        .profile-role {
            color: #635e80;
            font-size: 0.85em;
        }
        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .nav-links a {
            display: flex;
            align-items: center;
            color: #b3b3b3;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 0.95em;
            transition: all 0.2s ease;
        }
        .nav-links a:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }
        .nav-links a.active {
            background-color: #ffffff;
            color: #bd2bf2; /* High contrast vibrant purple accent color */
            font-weight: bold;
        }
        .sidebar-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 15px;
        }

        /* --- MAIN DASHBOARD CONTENT (Right Side) --- */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }
        .header-title {
            color: #111111;
            font-size: 2em;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .results-counter {
            color: #bd2bf2;
            font-weight: 700;
            font-size: 0.95em;
            margin-bottom: 25px;
        }

        /* --- RESPONSIVE CARDS GRID --- */
        .game-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
        }
        .game-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
        .game-card img { 
            width: 100%; 
            height: 220px; 
            object-fit: cover; 
            border-radius: 12px; 
            margin-bottom: 15px;
            background-color: #f0f0f0;
        }
        .price { 
            color: #bd2bf2; 
            font-weight: 700; 
            font-size: 1.15em; 
            margin-bottom: 4px; 
        }
        .game-title { 
            color: #2e2c38; 
            font-size: 1em; 
            font-weight: 600;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div>
            <div class="profile-section">
                <p class="profile-name"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <p class="profile-role">@gamevaultshop</p>
            </div>
            
            <nav class="nav-links">
                <a href="dashboard.php" class="active">🎮 Game Storefront</a>
                <a href="products.php">⚙️ Manage Inventory</a>
                <a href="#">📊 Store Statistics</a>
                <a href="#">🔥 Trending Titles</a>
                <a href="#">🏷️ Deals & Offers</a>
            </nav>
        </div>
        
        <div class="nav-links sidebar-footer">
            <a href="#">⚙️ Settings</a>
            <a href="logout.php" style="color: #ff4d4d;">🚪 Log Out</a>
        </div>
    </div>

    <div class="main-content">
        <h2 class="header-title">Game Sales</h2>
        <p class="results-counter"><?php echo $total_games; ?> Games Found</p>

        <div class="game-grid">
            <?php
            // Check if there are any products returned from the query
            if ($total_games > 0) {
                // The Fetch Loop executes repeatedly for every separate data row
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    // Logic to look into the images folder or fall back if empty/unset
                    if (!empty($row['image'])) {
                        $image_src = "images/" . $row['image'];
                    } else {
                        $image_src = 'https://via.placeholder.com/220x220?text=No+Cover+Found';
                    }
                    ?>
                    
                    <div class="game-card">
                        <img src="<?php echo htmlspecialchars($image_src); ?>" alt="Game Cover Image">
                        <div>
                            <p class="price">$<?php echo number_format($row['price'], 2); ?></p>
                            <h4 class="game-title"><?php echo htmlspecialchars($row['name']); ?></h4>
                        </div>
                    </div>

                    <?php
                }
            } else {
                // Error message displays clean layout if table data happens to be empty
                echo "<p style='grid-column: 1/-1; color: #888888; text-align: center; padding: 40px;'>No database items found in your inventory collection.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>