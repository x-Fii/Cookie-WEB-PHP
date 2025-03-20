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
            <li>
                <a class="nav-link" href="homepage.php" style="text-decoration: none; color: white; font-weight: 500; font-size: 18px;">Home</a>
            </li>
            <li>
                <a class="nav-link" href="menu.php" style="text-decoration: none; color: white; font-weight: 500; font-size: 18px;">Menu</a>
            </li>
            <li>
                <a class="nav-link" href="order.php" style="text-decoration: none; color: white; font-weight: 500; font-size: 18px;">Order</a>
            </li>
            <li>
                <a class="nav-link" href="contact.php" style="text-decoration: none; color: white; font-weight: 500; font-size: 18px;">Contact Us</a>
            </li>
            <li>
                <a class="nav-link" href="login.php" style="text-decoration: none; color: white; font-weight: 500; font-size: 18px;">User</a>
            </li>
        </ul>
    </div>
</nav>

<div>
        <h2 style="text-align: center; color: #333;">Available Products</h2>


    <div>
        <label for="search" style="font-weight: bold;">Search:</label>
        <input type="text" id="search" placeholder="Search for products..." onkeyup="filterProducts()" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
        <label for="filter" style="font-weight: bold;">Filter by:</label>
        <select id="filter" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">

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

        $sql = "SELECT * FROM products WHERE 1=1";

        if ($selectedCategory !== 'all') {
            $sql .= " AND category = '$selectedCategory'";
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

<script>
    function filterProducts() {
        const searchInput = document.getElementById('search').value.toLowerCase();
        const productCards = document.querySelectorAll('#product-list .product-box');

        productCards.forEach(card => {
            const productName = card.querySelector('h5').textContent.toLowerCase();
            if (productName.includes(searchInput)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
</body>
<footer>
<div>
    <div>
        <address>
            <strong>Cookie MOnstarz, Inc.</strong><br>
            Petra Jaya<br>
            Kuching, 93050, Sarawak<br>
            (011) 11-028700
        </address>
        <address>
            <strong>MUHAMMAD NUR ZULFIQAR</strong><br>
            <a href="mailto:#">KL2311015179@STUDENT.UPTM.MY</a>
        </address>
    </div>
</div>

    <div>
        <p>Copyright © Cookie MOnstarz. All rights reserved.</p>
    </div>
</footer>
</html>
