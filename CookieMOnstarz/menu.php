<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Menu</title>
    <link rel="stylesheet" href="css/custom-styles-updated.css">
    <style>
        .product-box {
            width: 220px;
            margin: 15px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }
        .product-box:hover {
            transform: scale(1.05);
        }

        .btn {
            background: linear-gradient(to right, rgb(90, 189, 255), rgb(240, 85, 170));
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color:rgb(240, 85, 170);
        }
    </style>
</head>
<body>
<nav style="display: flex; align-items: center; justify-content: space-between; background: linear-gradient(to right,rgb(182, 20, 109),#ffba5a); padding: 20px 50px; border-bottom: 1px solid #ddd; height: 80px;">
    <a class="navbar-brand" href="homepage.php" style="font-weight: bold; color: white; font-size: 22px; font-family: 'FancyFont', cursive;">Cookie MOnstarz</a>
    <div>
    <ul style="list-style: none; display: flex; gap: 40px; margin: 0; padding: 0; align-items: center;">
            <li><a class="nav-link" href="homepage.php">Home</a></li>
            <li><a class="nav-link" href="menu.php">Menu</a></li>
            <li><a class="nav-link" href="order.php">Order</a></li>
            <li><a class="nav-link" href="contact.php">Contact Us</a></li>
            <li><a class="nav-link" href="login.php">User</a></li>
            <li><a class="nav-link" href="about.php">About Us</a></li>
        </ul>
    </div>
</nav>

<div>
    <h2 style="text-align: center; color: #333;">Available Products</h2>

    <div>
        <label for="search" style="font-weight: bold;">Search:</label>
        <input type="text" id="search" name="search" placeholder="Search for products..." style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">

        <label for="filter" style="font-weight: bold;">Filter by:</label>
        <select id="filter" name="filter" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
            <option value="all">All Products</option>

            <option value="all">All Products</option>
            <?php
            include 'db_connect.php';
            $categoryQuery = "SELECT DISTINCT category FROM products";
            $categoryResult = $conn->query($categoryQuery);
            while ($row = $categoryResult->fetch_assoc()) {
                echo '<option value="' . $row['category'] . '">' . $row['category'] . '</option>';
            }
            ?>
        </select>
    </div>

    <div id="product-list" style="display: flex; flex-wrap: wrap; justify-content: space-around;">
        <?php
        include 'db_connect.php';
        $selectedCategory = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $searchTerm = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
        $sql = "SELECT * FROM products";


        $sql = "SELECT * FROM products";

        if ($selectedCategory !== 'all') {
            $sql .= " WHERE category = '$selectedCategory'";
        }

        if (!empty($searchTerm)) {
            $sql .= " AND product_name LIKE '%$searchTerm%'";
        }

        $result = $conn->query($sql);
        $products = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        foreach ($products as $product) {
            echo '
            <div class="product-box">
                <img src="images/' . ($product['product_image'] ? $product['product_image'] : 'default.jpg') . '" alt="' . $product['product_name'] . '" style="width: 200px; height: 200px; object-fit: cover;">
                <h5>' . $product['product_name'] . '</h5>
                <p>Category: ' . $product['category'] . '</p>
                <p>Price: RM ' . $product['price'] . '</p>
                <p>Stock: ' . $product['stock_quantity'] . '</p>
                <a href="order.php?cookie_type=' . $product['product_name'] . '" class="btn">Add to Cart</a>
            </div>';
        }
        ?>
    </div>
</div>

</body>
<footer>
    <div>
        <p>Copyright © Cookie MOnstarz. All rights reserved.</p>
    </div>
</footer>

</html>
