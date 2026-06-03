<?php
session_start();
require_once 'db_connect.php';

// Access Control: Only logged-in users can edit products
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if an ID was passed in the URL
if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$id = $_GET['id'];
$message = "";

// --- UPDATE OPERATION ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Update the specific record matching the ID
    $update_sql = "UPDATE products SET name='$name', description='$description', price='$price', stock='$stock' WHERE id='$id'";
    
    if (mysqli_query($conn, $update_sql)) {
        header("Location: products.php"); // Redirect back to main list on success
        exit();
    } else {
        $message = "<p style='color:red;'>Error updating product: " . mysqli_error($conn) . "</p>";
    }
}

// --- FETCH CURRENT DATA (To pre-populate the form inputs) ---
$fetch_sql = "SELECT * FROM products WHERE id = '$id'";
$result = mysqli_query($conn, $fetch_sql);
$product = mysqli_fetch_assoc($result);

// If the product doesn't exist, redirect back
if (!$product) {
    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body { font-family: Arial, sans-serif; background: #1e1e24; color: #fff; padding: 20px; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .edit-container { background: #2a2a35; padding: 30px; border-radius: 8px; width: 400px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); }
        h3 { color: #00ff87; margin-top: 0; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0 15px; background: #1e1e24; color: #fff; border: 1px solid #444; box-sizing: border-box; border-radius: 4px; }
        .btn { background: #00ff87; color: #121214; border: none; padding: 10px 15px; font-weight: bold; cursor: pointer; border-radius: 4px; }
        .btn:hover { background: #00e574; }
        .cancel-link { color: #aaa; margin-left: 15px; text-decoration: none; font-size: 14px; }
        .cancel-link:hover { color: #fff; }
    </style>
</head>
<body>

<div class="edit-container">
    <h3>Modify Product #<?php echo $product['id']; ?></h3>
    
    <?php echo $message; ?>

    <form method="POST">
        <label>Product Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

        <label>Description:</label>
        <textarea name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label>Price ($):</label>
        <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>

        <label>Stock Quantity:</label>
        <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>

        <button type="submit" class="btn">Update Product</button>
        <a href="products.php" class="cancel-link">Cancel</a>
    </form>
</div>

</body>
</html>