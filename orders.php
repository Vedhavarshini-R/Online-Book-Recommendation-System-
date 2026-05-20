<?php
// Include the header
include 'header.php';

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'book_explorer');

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve all orders for the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Initialize orders data
$orders = [];
while ($order = mysqli_fetch_assoc($result)) {
    $orders[] = $order;
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Book Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .order-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .order-container h5 {
            font-weight: bold;
        }
        .btn-view-items {
            background: #6c63ff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
        }
        .btn-view-items:hover {
            background: #5846d0;
            color: white;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">My Orders</h2>
    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-container">
                <h5>Order ID: <?= htmlspecialchars($order['order_id']) ?></h5>
                <p><strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
                <p><strong>Total Cost:</strong> ₹<?= number_format($order['total_cost'], 2) ?></p>
                <button class="btn btn-view-items" onclick="viewOrderItems(<?= htmlspecialchars($order['order_id']) ?>)">View Items</button>
                <div id="order-items-<?= htmlspecialchars($order['order_id']) ?>" class="mt-3" style="display: none;">
                    <ul class="list-group">
                        <?php
                        // Retrieve items for the order
                        $order_id = $order['order_id'];
                        $conn = mysqli_connect('localhost', 'root', '', 'book_explorer');
                        $item_query = "SELECT oi.book_id, oi.quantity, oi.cost, b.title, b.author
                                       FROM order_items oi
                                       JOIN books b ON oi.book_id = b.book_id
                                       WHERE oi.order_id = ?";
                        $item_stmt = mysqli_prepare($conn, $item_query);
                        mysqli_stmt_bind_param($item_stmt, 'i', $order_id);
                        mysqli_stmt_execute($item_stmt);
                        $item_result = mysqli_stmt_get_result($item_stmt);

                        // Display the items
                        while ($item = mysqli_fetch_assoc($item_result)):
                        ?>
                            <li class="list-group-item">
                                <strong><?= htmlspecialchars($item['title']) ?></strong> by <?= htmlspecialchars($item['author']) ?> (Qty: <?= htmlspecialchars($item['quantity']) ?>, Cost: ₹<?= number_format($item['cost'], 2) ?>)
                            </li>
                        <?php endwhile; ?>
                        <?php mysqli_close($conn); ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">You have not placed any orders yet.</p>
    <?php endif; ?>
</div>

<script>
    function viewOrderItems(orderId) {
        const itemsDiv = document.getElementById(`order-items-${orderId}`);
        itemsDiv.style.display = itemsDiv.style.display === 'none' ? 'block' : 'none';
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
