<?php
include 'db_connect.php';

// Fetch total revenue
$result = $conn->query("SELECT SUM(total_amount) AS revenue FROM Orders WHERE order_status = 'Completed'");
if ($result) {
    $row = $result->fetch_assoc();
    $totalRevenue = $row['revenue'];
} else {
    $totalRevenue = 0; // Default value if query fails
}

// Fetch best-selling product
$result = $conn->query("SELECT product_name, COUNT(*) AS total_orders FROM Order_Items JOIN Orders ON Order_Items.order_id = Orders.order_id WHERE Orders.order_status = 'Completed' GROUP BY product_name ORDER BY total_orders DESC LIMIT 1");
if ($result) {
    $bestSellingProduct = $result->fetch_assoc();
} else {
    $bestSellingProduct = ['product_name' => 'N/A']; // Default value if query fails
}

// Fetch total completed orders
$result = $conn->query("SELECT COUNT(*) AS total_orders FROM Orders WHERE order_status = 'Completed'");
if ($result) {
    $totalOrdersRow = $result->fetch_assoc();
    $totalOrders = $totalOrdersRow['total_orders'];
} else {
    $totalOrders = 0; // Default value if query fails
}

// Fetch all orders with customer names and total amounts
$orderResult = $conn->query("SELECT Orders.order_id, Customers.customer_name, Orders.total_amount, Orders.order_status FROM Orders JOIN Customers ON Orders.customer_id = Customers.customer_id");
$orders = [];
if ($orderResult) {
    while ($orderRow = $orderResult->fetch_assoc()) {
        $orders[] = $orderRow;
    }
}

// Fetch existing order IDs for selection
$orderIdsResult = $conn->query("SELECT order_id FROM Orders");
$orderIds = [];
if ($orderIdsResult) {
    while ($idRow = $orderIdsResult->fetch_assoc()) {
        $orderIds[] = $idRow['order_id'];
    }
}

// Function to download CSV for orders
function downloadOrdersCSV($filename, $orders) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $output = fopen('php://output', 'w');
    fputcsv($output, array('Order ID', 'Customer Name', 'Total Amount', 'Order Status'));
    foreach ($orders as $order) {
        fputcsv($output, $order);
    }
    fclose($output);
    exit();
}

// Check if download button for orders is clicked
if (isset($_POST['download_orders'])) {
    downloadOrdersCSV('orders_report.csv', $orders);
}

// Function to download CSV for sales report
function downloadCSV($filename, $totalRevenue, $bestSellingProduct, $totalOrders) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $output = fopen('php://output', 'w');
    fputcsv($output, array('Total Revenue', 'Best Selling Product', 'Total Orders'));
    fputcsv($output, array($totalRevenue, $bestSellingProduct['product_name'], $totalOrders));
    fclose($output);
    exit();
}

// Check if download button for sales report is clicked
if (isset($_POST['download_report'])) {
    downloadCSV('sales_report.csv', $totalRevenue, $bestSellingProduct, $totalOrders);
}

// Retrieve order items for a specific order
$orderItems = [];
if (isset($_POST['retrieve_order_items'])) {
    $orderId = $_POST['order_id'];
    $orderItemsResult = $conn->query("SELECT Order_Items.order_id, Products.product_name, Order_Items.quantity, Order_Items.subtotal FROM Order_Items JOIN Products ON Order_Items.product_id = Products.product_id WHERE Order_Items.order_id = $orderId");
    if ($orderItemsResult) {
        while ($itemRow = $orderItemsResult->fetch_assoc()) {
            $orderItems[] = $itemRow;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" href="css/styles.css">
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

    <div class="container mt-3">
        <h2 class="text-center mb-4">Sales Report</h2>
        <div class="alert alert-info" role="alert">
            Here you can view the sales report and download it as a CSV file.
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Total Revenue</th>
                    <th>Best Selling Product</th>
                    <th>Total Orders</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>RM <?php echo isset($totalRevenue) ? $totalRevenue : 0; ?></td>
                    <td><?php echo isset($bestSellingProduct['product_name']) ? $bestSellingProduct['product_name'] : 'N/A'; ?></td>
                    <td><?php echo isset($totalOrders) ? $totalOrders : 0; ?></td>
                </tr>
            </tbody>
        </table>
        <form method="post" action="">
            <button type="submit" class="btn btn-success" name="download_report">Download Sales Report</button>
        </form>

        <h2 class="text-center mb-4 mt-5">All Orders</h2>
        <div class="alert alert-warning" role="alert">
            Below is the list of all completed orders.
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Order Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['customer_name']; ?></td>
                    <td>RM <?php echo $order['total_amount']; ?></td>
                    <td><?php echo $order['order_status']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form method="post" action="">
            <div class="form-group">
                <label for="order_id">Select Order ID to Retrieve Items:</label>
                <select class="form-control" name="order_id" required style="max-width: 300px;">
                    <?php foreach ($orderIds as $id): ?>
                        <option value="<?php echo $id; ?>"><?php echo $id; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="retrieve_order_items">Retrieve Order Items</button>
        </form>

        <?php if (!empty($orderItems)): ?>
        <h2 class="text-center mb-4 mt-5">Order Items</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td><?php echo $item['order_id']; ?></td>
                    <td><?php echo $item['product_name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>RM <?php echo $item['subtotal']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</body>
</html>
