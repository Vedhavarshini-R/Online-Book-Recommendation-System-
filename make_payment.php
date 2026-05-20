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
    <title>Payment Options - Book Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #3a6073, #ff6e7f);
            color: white;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
            padding: 20px;
        }
        .payment-container {
            background: white;
            color: #444;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 600px;
            width: 100%;
            animation: fadeIn 1.5s ease-in-out;
        }
        .payment-container h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #3a6073;
            font-weight: bold;
        }
        .form-check-label {
            font-size: 1.2rem;
            font-weight: 500;
            color: #3a6073;
            margin-left: 10px;
        }
        .form-check-input:checked {
            background-color: #3a6073;
            border-color: #3a6073;
        }
        .btn-submit {
            background: linear-gradient(135deg, #3a6073, #ff6e7f);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 15px 25px;
            font-size: 1.2rem;
            margin-top: 20px;
            transition: transform 0.3s, background 0.3s;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #ff6e7f, #3a6073);
            color: white;
            transform: translateY(-3px);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        footer {
            position: fixed;
            bottom: 10px;
            text-align: center;
            width: 100%;
            font-size: 0.9rem;
            color: #ffffff;
        }
    </style>
</head>
<body>
   <main>
        <div class="payment-container">
            <h1>Select Payment Method</h1>
            <form method="POST" action="order_confirmation.php">
                <div class="mb-4">
                    <div class="form-check mb-2 text-start">
                        <input class="form-check-input" type="radio" name="payment_method" id="upi" value="UPI" required>
                        <label class="form-check-label" for="upi">UPI</label>
                    </div>
                    <div class="form-check mb-2 text-start">
                        <input class="form-check-input" type="radio" name="payment_method" id="creditCard" value="Credit Card" required>
                        <label class="form-check-label" for="creditCard">Credit Card</label>
                    </div>
                    <div class="form-check mb-2 text-start">
                        <input class="form-check-input" type="radio" name="payment_method" id="debitCard" value="Debit Card" required>
                        <label class="form-check-label" for="debitCard">Debit Card</label>
                    </div>
                    <div class="form-check mb-2 text-start">
                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="COD" required>
                        <label class="form-check-label" for="cod">Cash on Delivery (COD)</label>
                    </div>
                    <div class="form-check mb-2 text-start">
                        <input class="form-check-input" type="radio" name="payment_method" id="netBanking" value="Net Banking" required>
                        <label class="form-check-label" for="netBanking">Net Banking</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-submit">Proceed</button>
            </form>
        </div>
   </main>
   <footer>
       &copy; 2025 Book Explorer - Designed for your comfort
   </footer>
</body>
</html>
