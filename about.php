<?php
// Include the header
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Book Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .about-hero {
            background: linear-gradient(135deg, #6c63ff, #ff6e7f);
            color: white;
            padding: 50px 0;
            text-align: center;
        }
        .about-hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .about-hero p {
            font-size: 1.2rem;
            margin-top: 10px;
        }
        .about-section {
            padding: 40px 0;
        }
        .about-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #6c63ff;
        }
        .about-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
        }
        .about-section img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<section class="about-hero">
    <h1>About Book Explorer</h1>
    <p>Your gateway to discovering, exploring, and enjoying books like never before!</p>
</section>

<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Our Mission</h2>
                <p>
                    At Book Explorer, our mission is to connect readers with their favorite books and authors. 
                    We aim to create a seamless and enjoyable experience for book enthusiasts by providing a platform 
                    where they can search, explore, and purchase books with ease.
                </p>
                <p>
                    Whether you're a casual reader or a passionate bibliophile, Book Explorer is designed to cater to your needs. 
                    From discovering new authors to revisiting timeless classics, we bring the world of books to your fingertips.
                </p>
            </div>
            <div class="col-md-6">
                <img src="https://ts2.mm.bing.net/th?id=OIP.XHxHkV3iucoWMdUIxacQcwHaFJ&pid=15.1" alt="Books" class="img-fluid">
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <img src="https://ts3.mm.bing.net/th?id=OIP.9j0kj9e2UhR1jB6q-9MviAHaEt&pid=15.1" alt="Reading" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h2>What We Offer</h2>
                <p>
                    Book Explorer is more than just a platform for buying books. Here’s what we offer:
                </p>
                <ul>
                    <li>Search for books by title or author.</li>
                    <li>Add books to your favorites list for easy access.</li>
                    <li>Build your cart and enjoy a seamless checkout process.</li>
                    <li>Choose from multiple payment options for convenience.</li>
                    <li>Get books delivered right to your doorstep.</li>
                </ul>
                <p>
                    Our platform is designed with simplicity and user-friendliness in mind, ensuring that every reader has a delightful experience.
                </p>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <p class="text-center mt-4">&copy; 2025 All Rights Reserved by Keerthika ShakarGanesh.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
