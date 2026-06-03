<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// Handle Form Submission Updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $update_sql = "UPDATE products SET name='$name', description='$description', price='$price', stock='$stock' WHERE id='$id'";
    if (mysqli_query($conn, $update_sql)) {
        header("Location: products.php");
        exit();
    }
}

// Fetch Current Data to populate inputs
$fetch_sql = "SELECT * FROM products WHERE id = '$id'";
$result = mysqli_query($conn, $fetch_sql);
$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body { font-family: Arial, sans-serif; background: #1e1e24; color: #fff; padding: 20px; display: flex; justify-content: center; }
        .edit-container { background: #2a2a35; padding: 30px; border-radius: 8px; width: 400px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0 15px; background: #1e1e24; color: #fff; border: 1px solid #444; box-sizing: border-box; }
        .btn { background: #00ff87; color: #121214; border: none; padding: 10px 15px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>

<div class="edit-container">
    <h3>Modify Product #<?php echo $product['id']; ?></h3>
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
        <a href="products.php" style="color:#aaa; margin-left:15px; text-decoration:none;">Cancel</a>
    </form>
</div>

</body>
</html>