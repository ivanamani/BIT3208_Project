<?php
session_start();
include("db_connect.php"); // Makes sure $conn is available

// 1. Authorization Guard
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// 2. Count the total games found
$count_sql = "SELECT COUNT(*) as total FROM products"; 
$count_result = mysqli_query($conn, $count_sql);

if ($count_result) {
    $count_data = mysqli_fetch_assoc($count_result);
    $total_games = $count_data['total']; 
} else {
    $total_games = 0; 
}

// 3. Fetch the actual games
$games_sql = "SELECT * FROM products";
$result = mysqli_query($conn, $games_sql);
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

        /* 📱 1. MOBILE-FIRST BASE LAYOUT (Default: Screens under 768px wide) */
        body { 
            display: flex;
            flex-direction: column; /* Stack sidebar on top of main content for mobile layouts */
            background-color: #f4f5f7; 
            min-height: 100vh;
            overflow-y: auto; /* Allow full page scrolling on tiny phones */
        }

        /* --- SIDEBAR PANEL (Becomes a top bar or toggleable pane on Mobile) --- */
        .sidebar {
            width: 100%; /* Spans full horizontal screen space on mobile phones */
            background-color: #131124; 
            color: #ffffff;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }
        .profile-section {
            margin-bottom: 15px;
            text-align: center;
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
            flex-direction: row; /* Horizontal tabs menu configuration on phone viewports */
            flex-wrap: wrap; /* Let menus wrap cleanly if device screen is narrow */
            gap: 5px;
            justify-content: center;
        }
        .nav-links a {
            display: inline-flex;
            align-items: center;
            color: #b3b3b3;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.85em;
            transition: all 0.2s ease;
        }
        .nav-links a:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }
        .nav-links a.active {
            background-color: #ffffff;
            color: #bd2bf2; 
            font-weight: bold;
        }
        .sidebar-footer {
            display: none; /* Hide setting footers from top bars on compact viewports */
        }

        /* --- MAIN DASHBOARD CONTENT (Below top navigation bar on mobile) --- */
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .header-title {
            color: #111111;
            font-size: 1.7em;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .results-counter {
            color: #bd2bf2;
            font-weight: 700;
            font-size: 0.9em;
            margin-bottom: 20px;
        }

        /* --- WEEK 8 MANDATORY REQUIREMENT: CSS GRID SYSTEM --- */
        .game-grid {
            display: grid;
            grid-template-columns: 1fr; /* Default: exactly one single column per row on smartphone displays */
            gap: 20px;
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
        
        /* Responsive scaling image adjustments */
        .game-card img { 
            width: 100%; 
            height: auto; /* Allow height to adjust safely according to mobile widths */
            max-height: 250px;
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


        /* 📑 2. TABLET MEDIA QUERY BREAKPOINT (Screens 768px wide and up) */
        @media (min-width: 768px) {
            .header-title {
                font-size: 2.2em;
            }
            .game-grid {
                grid-template-columns: repeat(2, 1fr); /* 2 products across per row space on tablet viewport targets */
                gap: 25px;
            }
            .nav-links a {
                font-size: 0.95em;
                padding: 10px 14px;
            }
        }


        /* 🖥️ 3. DESKTOP MEDIA QUERY BREAKPOINT (Screens 1024px wide and up) */
        @media (min-width: 1024px) {
            body { 
                flex-direction: row; /* Switch back to side-by-side standard orientation */
                height: 100vh; 
                overflow: hidden;
            }
            .sidebar {
                width: 260px; /* Lock left container parameters fixed */
                height: 100%;
                justify-content: space-between;
                padding: 25px;
                text-align: left;
            }
            .profile-section {
                margin-bottom: 30px;
                text-align: left;
            }
            .nav-links {
                flex-direction: column; /* Column orientation formatting */
                justify-content: flex-start;
            }
            .nav-links a {
                display: flex;
                width: 100%;
            }
            .sidebar-footer {
                display: flex; /* Bring setting and logouts option interface panel views back */
                flex-direction: column;
                gap: 5px;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                padding-top: 15px;
            }
            .main-content {
                padding: 40px;
                overflow-y: auto; /* Scroll inside main container block area only */
            }
            .game-grid {
                /* Dynamically adjusts column arrangements across maximum screens space cleanly */
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); 
            }
            .game-card img {
                height: 220px;
            }
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
            if ($total_games > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
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
                echo "<p style='grid-column: 1/-1; color: #888888; text-align: center; padding: 40px;'>No database items found in your inventory collection.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>