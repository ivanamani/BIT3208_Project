<?php
// 1. Always start the session and database once at the absolute top
session_start();
require_once 'db_connect.php';

// Turn on error reporting for safe development debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Access Control
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$product_id = "";

// 2. Handle the update submission FIRST if the form was posted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = intval($_POST['stock']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);

    $update_sql = "UPDATE products SET 
                    name = '$name', 
                    description = '$description', 
                    price = '$price', 
                    stock = '$stock', 
                    image = '$image' 
                  WHERE id = '$product_id'";

    if (mysqli_query($conn, $update_sql)) {
        // Redirect back to main dashboard on success
        header("Location: products.php");
        exit();
    } else {
        // Retain the error message if something goes wrong
        $message = "<div class='alert alert-danger'>❌ Update Failed: " . mysqli_error($conn) . "</div>";
    }
}

// 3. Identify the target product ID safely from either GET or POST
if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);
} elseif (isset($_POST['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['id']);
} else {
    // No valid ID found anywhere? Boot them back to the catalog safely
    header("Location: products.php");
    exit();
}

// 4. Fetch the fresh product details to populate/re-populate the form fields
$select_sql = "SELECT * FROM products WHERE id = '$product_id'";
$result = mysqli_query($conn, $select_sql);

if ($result && mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
} else {
    die("Error: Product not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Product #<?php echo htmlspecialchars($product_id); ?></title>
    <style>
        :root {
            --bg-dark: #161522;
            --page-bg: #0f0e15;
            --text-main: #ffffff;
            --text-muted: #a0aec0;
            --accent-green: #00ff87;
            --accent-hover: #00dd73;
            --border-color: #242333;
            --input-bg: #1c1b2a;
        }
        body {
            background-color: var(--page-bg);
            color: var(--text-main);
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .modify-container {
            background: var(--bg-dark);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 30px;
            width: 100%;
            max-width: 500px;
        }
        h2 {
            color: var(--accent-green);
            font-size: 22px;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }
        label {
            font-size: 14px;
            color: var(--text-main);
            margin-bottom: 8px;
            font-weight: 500;
        }
        input, textarea {
            padding: 12px 16px;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s;
        }
        input:focus, textarea:focus {
            border-color: var(--accent-green);
        }
        .btn-group {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
        }
        .btn-update {
            background: var(--accent-green);
            color: #000;
            border: none;
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-update:hover {
            background: var(--accent-hover);
        }
        .btn-cancel {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .btn-cancel:hover {
            color: #fff;
        }
        .alert-danger {
            background: rgba(255, 74, 74, 0.1);
            color: #ff4a4a;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid rgba(255, 74, 74, 0.2);
        }
    </style>
</head>
<body>

<div class="modify-container">
    <h2>Modify Product #<?php echo htmlspecialchars($product_id); ?></h2>
    
    <?php if (!empty($message)) { echo $message; } ?>

    <form method="POST" action="edit_product.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
        <input type="hidden" name="update_product" value="1">

        <div class="form-group">
            <label>Product Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" rows="5" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Image Filename:</label>
            <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>" placeholder="e.g., nfs.png">
        </div>

        <div class="form-group">
            <label>Price ($):</label>
            <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>

        <div class="form-group">
            <label>Stock Quantity:</label>
            <input type="number" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn-update">Update Product</button>
            <a href="products.php" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>