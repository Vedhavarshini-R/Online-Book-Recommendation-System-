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

// Retrieve the selected payment method
$payment_method = $_POST['payment_method'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Book Explorer</title>
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
        .confirmation-container {
            background: white;
            color: #444;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .confirmation-container h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #6c63ff;
        }
        .btn-home {
            background: linear-gradient(135deg, #6c63ff, #ff6e7f);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 1rem;
            margin-top: 20px;
        }
        .btn-home:hover {
            background: linear-gradient(135deg, #ff6e7f, #6c63ff);
            color: white;
        }
    </style>
</head>
<body>
   <main>
        <div class="confirmation-container">
        <h1>Order Placed Successfully!</h1>
        <p>Thank you for ordering. We cherish your business with us.</p>
        <p>Your selected payment method: <strong><?= htmlspecialchars($payment_method) ?></strong></p>
        <p>We hope to serve you again in the future!</p>
        <a href="index.php" class="btn btn-home">Go to Homepage</a>
    </div>
   </main>
</body>
</html>
