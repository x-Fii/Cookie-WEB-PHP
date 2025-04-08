<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<nav style="display: flex; align-items: center; justify-content: space-between; background: linear-gradient(to right,rgb(182, 20, 109),#ffba5a); padding: 20px 50px; border-bottom: 1px solid #ddd; height: 80px;">
    <a class="navbar-brand" href="homepage.php" style="font-weight: bold; color: white; font-size: 22px; font-family: 'FancyFont', cursive;">Cookie MOnstarz</a>
    <div>
    <ul style="list-style: none; display: flex; gap: 40px; margin: 0; padding: 0; align-items: center;">
        <li><a class="nav-link" href="homepage.php">Home</a></li>
        <li><a class="nav-link" href="menu.php">Menu</a></li>
        <li><a class="nav-link" href="booking.php">Booking</a></li>
        <li><a class="nav-link" href="receipt.php">Receipt</a></li>
        <li><a class="nav-link" href="contact.php">Contact Us</a></li>
        <li><a class="nav-link" href="admin.php">Admin</a></li>
    </ul>
    </div>
</nav>

<div class="container mt-3">
    <h2 class="text-center mb-4" style="text-align: center;">Your Order Has Been Placed Successfully!</h2>

        <div class="alert alert-info" role="alert" style="text-align: center;">

        Thank you for your order! A receipt will be downloaded shortly.
    </div>

    <div class="card mt-3">
        <div class="card-body">
                <p class="card-text" style="text-align: center;">Your receipt is being prepared. Please check your downloads.</p>

        </div>
    </div>

    <script>
        // Simulate receipt download
        setTimeout(function() {
            alert("Receipt downloaded!");
            window.location.href = '#'; // Redirect to home after download
        }, 3000);
    </script>
</div>

</body>
</html>
