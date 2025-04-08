<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/custom-styles-updated.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(to right,rgb(182, 20, 109),#ffba5a);
            padding: 20px 50px;
            border-bottom: 1px solid #ddd;
            height: 80px;
        }
        .navbar-brand {
            font-weight: bold;
            color: white;
            font-size: 22px;
            font-family: 'FancyFont', cursive;
        }
        .nav-link {
            text-decoration: none;
            color: white;
            font-weight: 500;
            font-size: 18px;
            margin: 0 15px;
        }
        .nav-link:hover {
            text-decoration: underline;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: rgb(90, 189, 255);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: rgb(240, 85, 170);
        }
        .alert {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .button-group {
            display: flex;
            gap: 10px; /* Space between buttons */
            margin-top: 10px;
        }
    </style>
    <?php
    // Ensure data directory exists
    if (!file_exists('data')) {
        mkdir('data', 0777, true);
    }
    ?>
</head>
<body>
<nav>
    <a class="navbar-brand" href="homepage.php">Cookie MOnstarz</a>
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
    <h2 class="text-center mb-4">Manage Products</h2>
    
    <div>
        <div class="col-md-6">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="product_name">Product Name:</label>
                    <input type="text" class="form-control" name="product_name" required>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select class="form-control" name="category" required>
                        <?php
                        include 'db_connect.php'; // Include database connection
                        $sql = "SELECT DISTINCT category FROM Products"; // Query to get distinct categories
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            $category = $row['category'];
                            echo "<option value='$category'>$category</option>"; // Display category
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" name="price" required>
                </div>
                <div class="form-group">
                    <label for="stock_quantity">Stock Quantity:</label>
                    <input type="number" class="form-control" name="stock_quantity" required>
                </div>
                <div class="form-group">
                    <label for="cookie_image">Upload Image:</label>
                    <input type="file" class="form-control-file" name="cookie_image">
                </div>
                <button type="submit" class="btn" name="add_product">Add Product</button>
            </form>
        </div>

        <div class="col-md-6">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="product_id">Select Product to Update:</label>
                    <select class="form-control" name="product_id" required>
                        <?php
                        include 'db_connect.php'; // Include database connection
                        $sql = "SELECT product_id, product_name FROM Products"; // Query to get products
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            $product_id = $row['product_id'];
                            $product_name = $row['product_name'];
                            echo "<option value='$product_id'>$product_name</option>"; // Display product name
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="new_name">New Product Name:</label>
                    <input type="text" class="form-control" name="new_name">
                </div>
                <div class="form-group">
                    <label for="new_stock">New Stock Quantity:</label>
                    <input type="number" class="form-control" name="new_stock">
                </div>
                <div class="form-group">
                    <label for="new_image">Update Product Image:</label>
                    <input type="file" class="form-control-file" name="new_image">
                </div>
                <div class="button-group">
                    <button type="submit" class="btn" name="update_product">Update Product</button>
                    <button type="submit" class="btn btn-danger" name="delete_product">Delete Product</button>
                    <button type="submit" class="btn btn-secondary" name="view_product">View Product</button>
                </div>
            </form>
        </div>
    </div>
<br>
    <div class="mt-4">
        <a href="sales_report.php" class="btn btn-secondary">View Sales Report</a>
    </div>

    <?php
    include 'db_connect.php'; // Include database connection

    if (isset($_POST["add_product"])) {
        $productName = $_POST["product_name"];
        $category = $_POST["category"];
        $price = $_POST["price"];
        $stock_quantity = $_POST["stock_quantity"];
        $productImage = $_FILES["cookie_image"]["name"];

        // Move uploaded file to images directory
        move_uploaded_file($_FILES["cookie_image"]["tmp_name"], "images/$productImage");
        
        // Insert new product into the database
        $conn->query("INSERT INTO Products (product_name, category, price, stock_quantity, product_image) VALUES ('$productName', '$category', $price, $stock_quantity, '$productImage')");

        echo '<div class="alert alert-success">Product Added: ' . $productName . '</div>';
    }

    if (isset($_POST["update_product"])) {
        $productId = $_POST["product_id"];
        $newName = $_POST["new_name"];
        $newStock = $_POST["new_stock"];
        $newImage = $_FILES["new_image"]["name"];

        // Prepare the SQL query
        $updateQuery = "UPDATE Products SET";
        $updates = [];

        if (!empty($newName)) {
            $updates[] = " product_name = '$newName'";
        }
        if (!empty($newStock)) {
            $updates[] = " stock_quantity = $newStock";
        }
        if (!empty($newImage)) {
            // Move uploaded file to images directory
            move_uploaded_file($_FILES["new_image"]["tmp_name"], "images/$newImage");
            $updates[] = " product_image = '$newImage'";
        }

        if (!empty($updates)) {
            $updateQuery .= implode(',', $updates) . " WHERE product_id = $productId";
            // Execute the update query
            $conn->query($updateQuery);
        }

        echo '<div class="alert alert-success">Product Updated: ID ' . $productId . '</div>';
    }

    if (isset($_POST["delete_product"])) {
        $productId = $_POST["product_id"];
        // Execute the delete query
        $conn->query("DELETE FROM Products WHERE product_id = $productId");
        echo '<div class="alert alert-success">Product Deleted: ID ' . $productId . '</div>';
    }
    ?>
</div>
<footer>
    <div>
        <p>Copyright © Cookie MOnstarz. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
