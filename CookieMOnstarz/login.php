<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #f1f1f1;
            border-top: 1px solid #ddd;
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

<div>
    <h2 class="text-center">Customer Information</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="customer_name">Customer Name:</label>
            <input type="text" class="form-control" name="customer_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" name="address" required></textarea>
        </div>
        <button type="submit" class="btn">Add Customer</button>
    </form>

    <h2 class="text-center mt-5">Admin Login</h2>
    <form method="post" action="admin.php">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn">Sign In</button>
    </form>
</div>

<footer>
    <div>
        <p>Copyright © Cookie MOnstarz. All rights reserved.</p>
    </div>
</footer>



<?php
include 'db_connect.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["customer_name"])) {
    $customerName = $_POST["customer_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    // Query to insert customer information
    $sql = "INSERT INTO customers (customer_name, email, phone, address) VALUES ('$customerName', '$email', '$phone', '$address')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Customer added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>
</body>
</html>
