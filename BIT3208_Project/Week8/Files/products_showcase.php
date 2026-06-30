<?php
// Includes my existing database connection file
include("db_connect.php"); 

// Fetch the 4 products from your database table
$sql = "SELECT * FROM products LIMIT 4";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Product Showcase - Task 2</title>
    <style>
        /* 🎨 GLOBAL STYLE RESET */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: #f4f5f9;
            color: #1a1926;
            padding: 20px;
        }

        .showcase-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .showcase-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px 0;
        }

        .showcase-header h2 {
            font-size: 2.2rem;
            color: #111111;
            margin-bottom: 8px;
        }

        .showcase-header p {
            color: #71717a;
            font-size: 1rem;
        }

        /* =============================================================
           📱 1. MOBILE-FIRST BASE STYLES (Default Viewport: 0px - 767px)
           ============================================================= */
        
        /* 🌟 MANDATORY REQUIREMENT: CSS Grid Layout Container */
        .product-grid {
            display: grid;
            grid-template-columns: 1fr; /* Expected Output: Mobile view displays exactly one product per row */
            gap: 20px;
        }

        .product-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            border: 1px solid #e4e4e7;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        }

        .image-wrapper {
            width: 100%;
            background-color: #fafafa;
            position: relative;
        }

        /* 🌟 MANDATORY REQUIREMENT: Fully Responsive Image rules */
        .image-wrapper img {
            width: 100%;           /* Scale image fluidly inside card container space */
            max-width: 100%;       /* Prevent accidental pixel stretching or frame blowout */
            height: 250px;         /* Uniform display grid block heights */
            object-fit: cover;     /* Clean centering crops regardless of image aspect ratios */
            display: block;
        }

        .product-details {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            justify-content: space-between;
            gap: 12px;
        }

        .product-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a1926;
        }

        .product-description {
            font-size: 0.9rem;
            color: #71717a;
            line-height: 1.5;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid #f4f4f5;
        }

        .product-price {
            font-size: 1.25rem;
            font-weight: 800;
            color: #bd2bf2; /* Vibrant accent matching Sea of Games profile */
        }

        .buy-btn {
            background-color: #131124;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .buy-btn:hover {
            background-color: #bd2bf2;
        }

        /* =============================================================
           📑 2. BREAKPOINT ONE: TABLET MEDIA QUERY (Widths 768px - 1023px)
           ============================================================= */
        @media (min-width: 768px) {
            body {
                padding: 40px;
            }

            .product-grid {
                /* Expected Output: Tablet view displays fewer products (2 columns) */
                grid-template-columns: repeat(2, 1fr); 
                gap: 25px;
            }

            .image-wrapper img {
                height: 220px; /* Squeeze down heights slightly to account for dual row layouts */
            }
        }

        /* =============================================================
           🖥️ 3. BREAKPOINT TWO: DESKTOP MEDIA QUERY (Widths 1024px and up)
           ============================================================= */
        @media (min-width: 1024px) {
            .product-grid {
                /* Expected Output: Desktop view displays multiple products per row (4 columns) */
                grid-template-columns: repeat(4, 1fr); 
                gap: 30px;
            }

            .image-wrapper img {
                height: 200px; /* Refine height presentation properties for inline rows */
            }
        }
    </style>
</head>
<body>

    <div class="showcase-container">
        
        <header class="showcase-header">
            <h2>Sea of Games Vault</h2>
        </header>

        <div class="product-grid">
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Look into the local images directory or fall back safely if empty
                    $image_src = (!empty($row['image'])) ? "images/" . $row['image'] : 'https://via.placeholder.com/250x200?text=No+Cover+Found';
                    
                    // Generate descriptions dynamically, or apply a fallback description if column is missing
                    $description = (!empty($row['description'])) ? $row['description'] : "Immersive digital interactive entertainment application. High performance desktop and platform optimizations enabled.";
                    ?>
                    
                    <div class="product-card">
                        <div class="image-wrapper">
                            <img src="<?php echo htmlspecialchars($image_src); ?>" alt="<?php echo htmlspecialchars($row['name']); ?> Cover Image">
                        </div>
                        
                        <div class="product-details">
                            <h3 class="product-name"><?php echo htmlspecialchars($row['name']); ?></h3>
                            <p class="product-description"><?php echo htmlspecialchars($description); ?></p>
                            
                            <div class="product-meta">
                                <span class="product-price">$<?php echo number_format($row['price'], 2); ?></span>
                                <button class="buy-btn">Purchase</button>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "<p style='grid-column: 1/-1; text-align: center; color: #71717a; padding: 40px;'>No database items found in your inventory collection.</p>";
            }
            ?>
        </div>

    </div>

</body>
</html>