<?php
$servername = "localhost:8080";

$username = "root";
$password = "";
$dbname = "hari_raya_store";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
?>
