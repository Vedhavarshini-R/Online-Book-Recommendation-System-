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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Book Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6c63ff, #ff6e7f);
            color: white;
            margin: 0;
        }
        main{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }
        .checkout-container {
            background: white;
            color: #444;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .checkout-container h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #6c63ff;
        }
        .btn-payment {
            background: linear-gradient(135deg, #6c63ff, #ff6e7f);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 1rem;
            margin-top: 20px;
        }
        .btn-payment:hover {
            background: linear-gradient(135deg, #ff6e7f, #6c63ff);
            color: white;
        }
    </style>
</head>
<body>
    <main>
        <div class="checkout-container">
        <h1>Checkout</h1>
        <form method="POST" action="make_payment.php">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Delivery Address</label>
                <textarea id="address" name="address" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-payment">Make Payment</button>
        </form>
    </div>
    </main>
</body>
</html>
