<?php
// Include the header
include 'header.php';

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'book_explorer');

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start the session if not already started (handled in header.php)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the book ID from the query string
$book_id = $_GET['book_id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null; // Get user ID from the session

// Initialize book details
$book = null;

if ($book_id) {
    // Fetch book details
    $query = "SELECT * FROM books WHERE book_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $book_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $book = mysqli_fetch_assoc($result);
    }
}

// Close the database connection
mysqli_close($conn);

if (!$book) {
    // Redirect to homepage if no book found
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['title']) ?> - Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .book-details { padding: 50px 0; }
        .book-image img { width: 100%; max-height: 300px; object-fit: cover; }
        .details-card { background-color: #f9f9f9; border-radius: 10px; padding: 20px; box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>

<section class="book-details">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 book-image">
                <img src="images/<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="img-fluid">
            </div>
            <div class="col-md-6">
                <div class="details-card">
                    <h2><?= htmlspecialchars($book['title']) ?></h2>
                    <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
                    <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn_number']) ?></p>
                    <p><strong>Rating:</strong>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="text-warning"><?= $i <= $book['rating'] ? '★' : '☆' ?></span>
                        <?php endfor; ?>
                    </p>
                    <p><strong>Cost:</strong> ₹<?= number_format($book['cost'], 2) ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($book['description']) ?></p>
                    <div class="mt-4">
                        <button class="btn btn-outline-danger" onclick="handleFavorite(<?= $book['book_id'] ?>)">❤️ Add to Favorites</button>
                        <button class="btn btn-primary" onclick="handleCart(<?= $book['book_id'] ?>)">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <p class="text-center mt-4">&copy; 2025 All Rights Reserved by Keerthika ShakarGanesh.</p>
</footer>

<script>
    // Handle Add to Favorites
    function handleFavorite(bookId) {
        const userId = <?= $user_id ? 'true' : 'false' ?>;
        if (!userId) {
            if (confirm("You need to login to add to your favorites. Redirect to login page?")) {
                window.location.href = "login.php";
            }
            return;
        }

        fetch(`add_to_favorites.php?book_id=${bookId}`)
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            });
    }

    // Handle Add to Cart
    function handleCart(bookId) {
        const userId = <?= $user_id ? 'true' : 'false' ?>;
        if (!userId) {
            alert("You need to login to add to the cart.");
            window.location.href = "login.php";
            return;
        }

        fetch(`add_to_cart.php?book_id=${bookId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Book added to cart successfully!");
                } else {
                    alert("Failed to add the book to cart. Please try again.");
                }
            });
    }
</script>
</body>
</html>
