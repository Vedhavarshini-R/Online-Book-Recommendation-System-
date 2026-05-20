<?php
// Include the header
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Book Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .contact-hero {
            background: linear-gradient(135deg, #6c63ff, #ff6e7f);
            color: white;
            padding: 50px 0;
            text-align: center;
        }
        .contact-hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .contact-details {
            padding: 40px 0;
        }
        .contact-details h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #6c63ff;
        }
        .contact-details p {
            font-size: 1.1rem;
            color: #444;
        }
    </style>
</head>
<body>

<section class="contact-hero">
    <h1>Contact Us</h1>
    <p>We’re here to help and answer any questions!</p>
</section>

<section class="contact-details">
    <div class="container">
        <h2 class="text-center">Our Contact Information</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                <p><strong>Company Name:</strong> Book Explorer Pvt Ltd</p>
                <p><strong>Phone Number:</strong> +91 1234-567-890</p>
                <p><strong>Email:</strong> support@bookexplorer.com</p>
                <p><strong>Address:</strong> 123 Book Street, Chennai, Tamil Nadu, India</p>
                <p><strong>Website:</strong> <a href="https://www.bookexplorer.com" target="_blank">www.bookexplorer.com</a></p>
            </div>
            <div class="col-md-6">
                <!-- Embedded Google Map -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.482334514128!2d79.14087051534463!3d12.972442490860747!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5367d3519adfd9%3A0x664b6cf51ed9f5ef!2sChennai%2C%20Tamil%20Nadu%2C%20India!5e0!3m2!1sen!2sin!4v1678902012345!5m2!1sen!2sin"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
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
