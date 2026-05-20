<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6c63ff, #ff6e7f);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
            margin: 0;
        }
        .success-container {
            background: white;
            color: #444;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .success-container h1 {
            font-size: 2.5rem;
            color: #6c63ff;
            margin-bottom: 20px;
        }
        .success-container p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .btn-login {
            background: linear-gradient(135deg, #6c63ff, #ff6e7f);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 1rem;
            text-decoration: none;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #ff6e7f, #6c63ff);
            color: white;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <h1>Signup Successful!</h1>
        <p>Thank you for signing up. We're excited to have you on board!</p>
        <p>Click below to log in and continue your journey:</p>
        <a href="login.php" class="btn btn-login">Login Here</a>
    </div>
</body>
</html>
