<?php
// 1. Always start the session first
session_start();

// 2. Enforce authentication (Kick out users who aren't logged in)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// 3. Connect to your database seamlessly
require_once 'db_connect.php'; 

$message = ""; // Container for success/error alerts

// 4. Handle Deletion Request (FIXED)
if (isset($_GET['delete_id'])) {
    // Securely cast the ID to an integer to prevent SQL injection vulnerabilities
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM products WHERE id = $delete_id";
    
    if (mysqli_query($conn, $delete_query)) {
        $message = "<div class='alert alert-success'>🗑️ Product #$delete_id deleted successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>❌ Error deleting item: " . mysqli_error($conn) . "</div>";
    }
}

// 5. Safely handle form submissions (Adding products)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = intval($_POST['stock']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $insert_query = "INSERT INTO products (name, image, price, stock, description) 
                     VALUES ('$name', '$image', '$price', '$stock', '$description')";
    
    if (mysqli_query($conn, $insert_query)) {
        $message = "<div class='alert alert-success'>🎉 \"$name\" has been added to your catalog successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>❌ Error inserting item: " . mysqli_error($conn) . "</div>";
    }
}

// 6. Fetch all products to display down in the inventory list table
$query = "SELECT * FROM products ORDER BY id DESC";
$products_result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sea of Games - Inventory Management</title>
    <style>
        :root {
            --bg-dark: #0f0e15;
            --card-bg: #161522;
            --text-main: #ffffff;
            --text-muted: #a0aec0;
            --primary-purple: #b646fd;
            --primary-hover: #931bf0;
            --accent-green: #00ff87;
            --danger-red: #ff4a4a;
            --border-color: #242333;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }
        .dashboard-container {
            width: 100%;
            max-width: 1200px;
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }
        .logo-text {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .logo-text span {
            color: var(--primary-purple);
        }
        .user-badge {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .btn-nav-link {
            color: var(--primary-purple);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 16px;
            border: 1px solid var(--primary-purple);
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .btn-nav-link:hover {
            color: #fff;
            background: var(--primary-purple);
        }
        .logout-btn {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .logout-btn:hover {
            color: var(--danger-red);
            border-color: var(--danger-red);
            background: rgba(255, 74, 74, 0.05);
        }
        .alert {
            padding: 14px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 15px;
        }
        .alert-success { background: rgba(0, 255, 135, 0.1); color: var(--accent-green); border: 1px solid rgba(0, 255, 135, 0.2); }
        .alert-danger { background: rgba(255, 74, 74, 0.1); color: var(--danger-red); border: 1px solid rgba(255, 74, 74, 0.2); }

        .form-container {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            margin-bottom: 40px;
        }
        .form-container h3 {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group.full-width {
            grid-column: span 2;
        }
        label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        input, textarea {
            padding: 12px 16px;
            background: #1c1b2a;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s;
        }
        input:focus, textarea:focus {
            border-color: var(--primary-purple);
        }
        .btn-submit {
            grid-column: span 2;
            background: var(--primary-purple);
            color: #fff;
            border: none;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }
        .btn-submit:hover {
            background: var(--primary-hover);
        }

        .inventory-section h3 {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .table-wrapper {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }
        th {
            background-color: #191826;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .game-preview {
            width: 45px;
            height: 55px;
            object-fit: cover;
            border-radius: 6px;
            background-color: #1c1b2a;
            border: 1px solid var(--border-color);
        }
        .game-title {
            font-weight: 600;
            color: var(--text-main);
        }
        .game-desc {
            color: var(--text-muted);
            font-size: 14px;
            max-width: 450px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .price-tag {
            font-weight: 700;
            color: var(--accent-green);
        }
        .stock-badge {
            background: rgba(255, 255, 255, 0.05);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }
        .actions-cell {
            display: flex;
            gap: 12px;
        }
        .btn-action {
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: opacity 0.2s;
        }
        .btn-action:hover {
            opacity: 0.8;
        }
        .action-edit { color: var(--primary-purple); }
        .action-delete { color: var(--danger-red); }
    </style>
</head>
<body>
<div class="dashboard-container">
    <header class="dashboard-header">
        <div class="logo-text"><span>Sea</span>ofGames</div>
        <div class="user-badge">
            <a href="dashboard.php" class="btn-nav-link">👁️ View Public Storefront</a>
            <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>! 👋</span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </header>

    <?php if (!empty($message)) { echo $message; } ?>

    <div class="form-container">
        <h3>Add New Product</h3>
        <form method="POST" action="products.php" class="form-grid">
            <input type="hidden" name="add_product" value="1">
                        
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" placeholder="e.g., Grand Theft Auto V" required>
            </div>

            <div class="form-group">
                <label>Image Filename</label>
                <input type="text" name="image" placeholder="e.g., gta5.png">
            </div>

            <div class="form-group">
                <label>Price ($)</label>
                <input type="number" step="0.01" name="price" placeholder="59.99" required>
            </div>

            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" placeholder="100" required>
            </div>

            <div class="form-group full-width">
                <label>Description</label>
                <textarea name="description" rows="3" placeholder="Enter game overview, features, or details..." required></textarea>
            </div>

            <button type="submit" class="btn-submit">Save Product</button>
        </form>
    </div>

    <div class="inventory-section">
        <h3>Current Inventory List</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cover</th>
                        <th>Name & Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($products_result && mysqli_num_rows($products_result) > 0) {
                        while($row = mysqli_fetch_assoc($products_result)) { 
                    ?>
                    <tr>
                        <td><span style="color: var(--text-muted); font-size: 14px;">#<?php echo $row['id']; ?></span></td>
                        <td>
                            <img src="images/<?php echo !empty($row['image']) ? htmlspecialchars($row['image']) : 'default.png'; ?>" 
                                 class="game-preview" 
                                 alt="Cover">
                        </td>
                        <td>
                            <div class="game-title"><?php echo htmlspecialchars($row['name']); ?></div>
                            <div class="game-desc" title="<?php echo htmlspecialchars($row['description']); ?>">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </div>
                        </td>
                        <td><span class="price-tag">$<?php echo number_format($row['price'], 2); ?></span></td>
                        <td><span class="stock-badge"><?php echo $row['stock']; ?> pcs</span></td>
                        <td>
                            <div class="actions-cell">
                                <a class="btn-action action-edit" href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a class="btn-action action-delete" href="products.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        $error_suffix = (!$products_result) ? " Error: " . mysqli_error($conn) : "";
                        echo "<tr><td colspan='6' style='text-align:center; padding: 30px; color: var(--text-muted);'>No games found in your inventory database.$error_suffix</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>