<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cookies</title>
    <link rel="stylesheet" href="css/custom-styles-updated.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(to right, rgb(182, 20, 109), #ffba5a);
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
        .form-container {
            padding: 20px;
            max-width: 600px;
            margin: auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group select,
        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            background-color: #502801;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #ffba5a;
        }
    </style>
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

<div class="form-container">
    <h2 style="text-align: center;">Cookie Order Form</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="customer_id">Select Customer:</label>
            <select name="customer_id" required>
                <?php
                include 'db_connect.php'; // Ensure the database connection is included
                $sql = "SELECT customer_id, customer_name FROM Customers"; // Query to get customer IDs and names
                $result = $conn->query($sql);
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $customer_id = $row['customer_id'];
                        $customer_name = $row['customer_name'];
                        echo "<option value='$customer_id'>$customer_name</option>"; // Display customer name
                    }
                } else {
                    echo "<option value=''>No customers available</option>"; // Handle case where no customers are found
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="cookie_type">Select Cookie Type:</label>
            <select name="cookie_type" required>
                <?php
                $sql = "SELECT * FROM Products WHERE stock_quantity > 0"; // Only show products in stock
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $cookie_name = $row['product_name'];
                    $stock_quantity = $row['stock_quantity'];
                    echo "<option value='$cookie_name'>$cookie_name (Stock: $stock_quantity)</option>"; // Display stock quantity
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required>
        </div>
        <button type="submit" name="place_order" class="btn">Place Order</button>
        <div id="order_total" class="mt-3"></div>
    </form>

    <div class="form-group">
        <button type="button" id="registerCustomerBtn" class="btn">Register New Customer</button>
    </div>

    <div id="registrationForm" style="display: none;">
        <h3>Register New Customer</h3>
        <form method="post" action="">
            <div class="form-group">
                <label for="new_customer_name">Customer Name:</label>
                <input type="text" name="new_customer_name" required>
            </div>
            <div class="form-group">
                <label for="new_customer_email">Email:</label>
                <input type="email" name="new_customer_email" required>
            </div>
            <button type="submit" name="register_customer" class="btn">Register</button>
        </form>
    </div>

    <script>
        const quantityInput = document.querySelector('input[name="quantity"]');
        const cookieTypeSelect = document.querySelector('select[name="cookie_type"]');
        const orderTotalDiv = document.getElementById('order_total');

        cookieTypeSelect.addEventListener('change', updateTotal);
        quantityInput.addEventListener('input', updateTotal);

        function updateTotal() {
            const cookieType = cookieTypeSelect.value;
            const quantity = quantityInput.value;

            if (cookieType && quantity) {
                fetch(`get_price.php?cookie_type=${cookieType}`)
                    .then(response => response.json())
                    .then(data => {
                        const total = data.price * quantity;
                        orderTotalDiv.innerHTML = `Total: RM ${total.toFixed(2)}`;
                    });
            } else {
                orderTotalDiv.innerHTML = '';
            }
        }

        document.getElementById('registerCustomerBtn').addEventListener('click', function() {
            const registrationForm = document.getElementById('registrationForm');
            registrationForm.style.display = registrationForm.style.display === 'none' ? 'block' : 'none';
        });
    </script>

    <?php
    if (isset($_POST["place_order"])) {
        $cookieType = $_POST["cookie_type"];
        $quantity = $_POST["quantity"];
        $customer_id = $_POST["customer_id"]; // Get customer ID
        
        // Fetch price
        $sql = "SELECT price FROM Products WHERE product_name = '$cookieType'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $subtotal = $row['price'] * $quantity;

        // Insert order
        $conn->query("INSERT INTO Orders (customer_id, total_amount) VALUES ($customer_id, $subtotal)");
        $order_id = $conn->insert_id;

        // Insert order item
        $conn->query("INSERT INTO Order_Items (order_id, product_id, quantity, subtotal) VALUES ($order_id, (SELECT product_id FROM Products WHERE product_name = '$cookieType'), $quantity, $subtotal)");

        // Update stock quantity
        $conn->query("UPDATE Products SET stock_quantity = stock_quantity - $quantity WHERE product_name = '$cookieType'");

        echo "Order placed successfully!";
        // Redirect to receipt page after processing
        echo "<script>window.location.href='receipt.php';</script>";
    }

    if (isset($_POST["register_customer"])) {
        $newCustomerName = $_POST["new_customer_name"];
        $newCustomerEmail = $_POST["new_customer_email"];

        // Insert new customer into the database
        $conn->query("INSERT INTO Customers (customer_name, email) VALUES ('$newCustomerName', '$newCustomerEmail')");
        echo "Customer registered successfully!";
    }
    ?>
<br>
    <form method="post" action="">
        <div class="form-group">
            <label for="order_id">Select Order ID to Update:</label>
            <select name="order_id" required>
                <?php
                $sql = "SELECT order_id FROM Orders"; // Query to get order IDs
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $order_id = $row['order_id'];
                    echo "<option value='$order_id'>Order ID: $order_id</option>"; // Display order ID
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Select New Order Status:</label>
            <select name="status" required>
                <option value="Pending">Pending</option>
                <option value="Processing">Processing</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>
        <button type="submit" name="update_order" class="btn">Update Order</button>
    </form>
<br>
    <?php
    // Update order status
    if (isset($_POST["update_order"])) {
        $order_id = $_POST["order_id"];
        $status = $_POST["status"];
        $conn->query("UPDATE Orders SET order_status='$status' WHERE order_id=$order_id");
        echo "Order status updated!";
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
