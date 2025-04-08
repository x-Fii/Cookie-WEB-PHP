<?php
include 'db_connect.php';
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);
?>
<h2>Available Products</h2>
<table border="1">
<tr><th>Name</th><th>Category</th><th>Price (RM)</th><th>Stock</th></tr>
<?php while($row = $result->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['product_name']; ?></td>
<td><?php echo $row['category']; ?></td>
<td><?php echo $row['price']; ?></td>
<td><?php echo $row['stock_quantity']; ?></td>
</tr>
<?php } ?>
</table>