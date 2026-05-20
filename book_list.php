<?php
// Include the header
include 'header.php';

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'book_explorer');

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$search_by = $_GET['search_by'] ?? ''; // 'author' or 'book'
$search = $_GET['search'] ?? ''; // User's search term
$books = [];

// Fetch books based on search criteria
if (!empty($search_by) && !empty($search)) {
    $query = "";
    if ($search_by === 'author') {
        $query = "SELECT * FROM books WHERE author LIKE '%$search%'";
    } elseif ($search_by === 'book') {
        $query = "SELECT * FROM books WHERE title LIKE '%$search%'";
    }
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $books[] = $row;
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List - Book Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .book-list-hero {
            background: linear-gradient(135deg, #6c63ff, #ff6e7f);
            color: white;
            padding: 50px 0;
            text-align: center;
        }
        .book-list-hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .book-card img {
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .book-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

<section class="book-list-hero">
    <h1>Search Results</h1>
    <p>Displaying books based on your search: <strong><?= htmlspecialchars($search) ?></strong></p>
</section>

<section class="book-list-section py-4">
    <div class="container">
        <div class="row">
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card book-card">
                            <img src="images/<?= htmlspecialchars($book['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($book['title']) ?>">
                            <div class="card-body">
                                <h5 class="card-title text-center"><?= htmlspecialchars($book['title']) ?></h5>
                                <p class="text-muted text-center"><?= htmlspecialchars($book['author']) ?></p>
                                <div class="text-center">
                                    <a href="book_details.php?book_id=<?= htmlspecialchars($book['book_id']) ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        No books found for the search term: <strong><?= htmlspecialchars($search) ?></strong>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<footer class="footer">
    <p class="text-center mt-4">&copy; 2025 All Rights Reserved by Keerthika ShakarGanesh.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
