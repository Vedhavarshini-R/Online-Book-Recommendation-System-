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

// Fetch the user's favorite books
$user_id = $_SESSION['user_id'];
$query = "SELECT b.* FROM books b JOIN favorites f ON b.book_id = f.book_id WHERE f.user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorites - Book Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-remove {
            color: white;
            background-color: #dc3545;
        }
        .btn-remove:hover {
            background-color: #a71d2a;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">My Favorites</h2>
    <div class="row mt-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($book = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="images/<?= htmlspecialchars($book['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($book['title']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                            <p class="card-text">By <?= htmlspecialchars($book['author']) ?></p>
                            <a href="book_details.php?book_id=<?= htmlspecialchars($book['book_id']) ?>" class="btn btn-primary">View Details</a>
                            <button class="btn btn-remove" onclick="removeFavorite(<?= htmlspecialchars($book['book_id']) ?>)">Remove from Favorites</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No favorites added yet.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function removeFavorite(bookId) {
        fetch(`remove_favorite.php?book_id=${bookId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Refresh the page to reflect the updated list
                } else {
                    console.error("Failed to remove the book from favorites.");
                }
            });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
