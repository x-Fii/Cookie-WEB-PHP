<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie MOnstarz - Freshly Baked Cookies</title>
    <link href="css/custom-styles-updated.css" rel="stylesheet">
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
            background-color: rgb(240, 85, 170);
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

<div class="w3-content w3-display-container">
    <img class="mySlides" src="images/Carousel 1.jpg" style="width:100%; height: 400px; object-fit: cover;" alt="Delicious Cookies">
    <img class="mySlides" src="images/Carousel 2.jpg" style="width:100%; height: 400px; object-fit: cover;" alt="Freshly Baked Cookies">
    <img class="mySlides" src="images/Carousel 3.jpg" style="width:100%; height: 400px; object-fit: cover;" alt="Tasty Treats">
</div>

<script>
var slideIndex = 1;
showDivs(slideIndex);

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}

    var autoSlide = setInterval(function() {
      showDivs(slideIndex += 1);

}, 1500); // Change slide every 1 second
</script>

<hr>
<div style="display: flex; justify-content: space-around;">
    <div>
        <img class="rounded-circle" alt="Free Shipping" src="images/delivery-truck.png" style="width: 40px; height: 40px;">
        <h4 style="text-align: center;">Free Shipping</h4>
    </div>
    <div>
        <img class="rounded-circle" alt="Freshly Baked" src="images/baking.png" style="width: 40px; height: 40px;">
        <h4 style="text-align: center;">Freshly Baked</h4>
    </div>
    <div>
        <img class="rounded-circle" alt="Low Prices" src="images/discount.png" style="width: 40px; height: 40px;">
        <h4 style="text-align: center;">Low Prices</h4>
    </div>
</div>

<hr>
<h2 style="text-align: center;">FEATURED PRODUCTS</h2>

<div id="product-list" style="display: flex; flex-wrap: wrap; justify-content: space-around;">
    <?php
    include 'db_connect.php'; // Include database connection
    $sql = "SELECT * FROM Products"; // Query to get all products
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="product-box">
            <img src="images/' . $row['product_image'] . '" alt="' . $row['product_name'] . '" style="width: 200px; height: 200px; object-fit: cover;">
            <h5>' . $row['product_name'] . '</h5>
            <p>Price: RM' . $row['price'] . '</p>
            <p>Stock: ' . $row['stock_quantity'] . '</p>
            <a href="order.php?cookie_type=' . $row['product_name'] . '" class="btn">Add to Cart</a>
        </div>';
    }
    ?>
</div>

<hr>

<footer>
    <div>
        <p>Copyright © Cookie MOnstarz. All rights reserved.</p>
    </div>
</footer>


</body>
</html>
