<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .contact-info {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .social-media {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }
        .social-media a {
            text-decoration: none;
        }
        .social-media img {
            width: 30px;
            height: 30px;
            transition: transform 0.2s;
        }
        .social-media img:hover {
            transform: scale(1.1);
        }
        button {
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
        button:hover {
            background-color: rgb(240, 85, 170);
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
    <h2>Get in Touch</h2>
    <div class="contact-info">
        <div class="social-media" style="justify-content: center;">

            <span style="font-weight: bold;">FOLLOW</span>
            <a href="https://www.facebook.com" target="_blank">
                <img src="https://cdn-icons-png.flaticon.com/512/124/124010.png" alt="Facebook">
            </a>
            <a href="https://www.instagram.com" target="_blank">
                <img src="https://cdn-icons-png.flaticon.com/512/1409/1409946.png" alt="Instagram">
            </a>
            <a href="https://www.youtube.com" target="_blank">
                <img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" alt="YouTube">
            </a>
            <a href="https://my.linkedin.com" target="_blank">
                <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" alt="LinkedIn">
            </a>
        </div>
        <div>
            <address>
                <strong>Cookie MOnstarz, Inc.</strong><br>
                Petra Jaya<br>
                Kuching, 93050, Sarawak<br>
            </address>
            <address>
                <strong>MUHAMMAD NUR ZULFIQAR</strong><br>
                <a href="mailto:KL2311015179@STUDENT.UPTM.MY">KL2311015179@STUDENT.UPTM.MY</a>
            </address>
            <p>Email: <a href="mailto:info@cookiemonstarz.com">info@cookiemonstarz.com</a></p>

        </div>

        <p>Email: <a href="mailto:info@cookiemonstarz.com">info@cookiemonstarz.com</a></p>
        <button onclick="window.location.href='login.php'">Login</button>
    </div>
</div>

</body>
<br>
<<footer>
    <div>
        <p>Copyright © Cookie MOnstarz. All rights reserved.</p>
    </div>
</footer>


</body>
</html>
