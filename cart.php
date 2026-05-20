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

// Fetch the books in the user's cart
$user_id = $_SESSION['user_id'];
$query = "SELECT c.book_id, b.title, b.author, b.image, b.cost, c.quantity
          FROM cart c
          JOIN books b ON c.book_id = b.book_id
          WHERE c.user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$total_cost = 0;

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart - Book Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-remove {
            color: white;
            background-color: #dc3545;
        }
        .btn-remove:hover {
            background-color: #a71d2a;
        }
        .btn-checkout {
            background: linear-gradient(135deg, #6c63ff, #ff6e7f);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            margin-top: 20px;
        }
        .btn-checkout:hover {
            background: linear-gradient(135deg, #ff6e7f, #6c63ff);
            color: white;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">My Cart</h2>
    <div class="row mt-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Author</th>
                        <th>Quantity</th>
                        <th>Cost</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cart_item = mysqli_fetch_assoc($result)): 
                        $total_cost += $cart_item['cost'] * $cart_item['quantity'];
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($cart_item['title']) ?></td>
                            <td><?= htmlspecialchars($cart_item['author']) ?></td>
                            <td><?= htmlspecialchars($cart_item['quantity']) ?></td>
                            <td>₹<?= number_format($cart_item['cost'], 2) ?></td>
                            <td>₹<?= number_format($cart_item['cost'] * $cart_item['quantity'], 2) ?></td>
                            <td>
                                <button class="btn btn-remove" onclick="removeFromCart(<?= htmlspecialchars($cart_item['book_id']) ?>)">Remove</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total Cost:</th>
                        <th>₹<?= number_format($total_cost, 2) ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end">
                <a href="checkout.php" class="btn btn-checkout">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <p class="text-center">Your cart is empty.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function removeFromCart(bookId) {
        fetch(`remove_from_cart.php?book_id=${bookId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Refresh the cart
                } else {
                    console.error("Failed to remove the book from cart.");
                }
            });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
