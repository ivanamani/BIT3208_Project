<?php
session_start();
require_once 'db_connect.php';

// Access Control: Only logged-in users can view this page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";

// --- 1. CREATE OPERATION (Add New Product) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Insert data into the products table
    $insert_sql = "INSERT INTO products (name, description, price, stock) VALUES ('$name', '$description', '$price', '$stock')";
    if (mysqli_query($conn, $insert_sql)) {
        $message = "<p style='color:green;'>Product added successfully!</p>";
    } else {
        $message = "<p style='color:red;'>Error adding product: " . mysqli_error($conn) . "</p>";
    }
}

// --- 2. DELETE OPERATION (Remove Product) ---
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM products WHERE id = '$delete_id'";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: products.php"); // Refresh page to show updated list
        exit();
    } else {
        $message = "<p style='color:red;'>Error deleting product: " . mysqli_error($conn) . "</p>";
    }
}

// --- 3. READ OPERATION (Fetch All Records) ---
$query_sql = "SELECT * FROM products ORDER BY id DESC";
$products_result = mysqli_query($conn, $query_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sea of Games - Inventory Management</title>
    <style>
        body { font-family: Arial, sans-serif; background: #1e1e24; color: #fff; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #2a2a35; }
        th, td { padding: 12px; border: 1px solid #444; text-align: left; }
        th { background-color: #00ff87; color: #121214; }
        .form-container { background: #2a2a35; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0 15px; background: #1e1e24; color: #fff; border: 1px solid #444; box-sizing: border-box; }
        .btn { background: #00ff87; color: #121214; border: none; padding: 10px 15px; cursor: pointer; font-weight: bold; border-radius: 4px; }
        .btn:hover { background: #00e574; }
        .btn-delete { color: #ff4a4a; text-decoration: none; font-weight: bold; }
        .btn-edit { color: #00ff87; text-decoration: none; font-weight: bold; margin-right: 10px; }
    </style>
</head>
<body>

    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! 👋</h2>
    <p><a href="logout.php" style="color: #00ff87; text-decoration: none;">➡️ Logout</a></p>

    <?php echo $message; ?>

    <div class="form-container">
        <h3>Add New Product</h3>
        <form method="POST" action="products.php">
            <input type="hidden" name="add_product" value="1">
            
            <label>Product Name:</label>
            <input type="text" name="name" required>

            <label>Description:</label>
            <textarea name="description" rows="3" required></textarea>

            <label>Price ($):</label>
            <input type="number" step="0.01" name="price" required>

            <label>Stock Quantity:</label>
            <input type="number" name="stock" required>

            <button type="submit" class="btn">Save Product</button>
        </form>
    </div>

    <h3>Current Inventory List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // The while loop pulls data row-by-row until the query results are empty
            while($row = mysqli_fetch_assoc($products_result)) { 
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td>$<?php echo number_format($row['price'], 2); ?></td>
                <td><?php echo $row['stock']; ?></td>
                <td>
                    <a class="btn-edit" href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a class="btn-delete" href="products.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                </td>
            </tr>
            <?php 
            } 
            ?>
        </tbody>
    </table>

</body>
</html>