<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'book_explorer');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = $_GET['book_id'] ?? null;

if ($book_id) {
    // Insert the book into the user's cart
    $query = "INSERT INTO cart (user_id, book_id, quantity) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE quantity = quantity + 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $book_id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Book added to cart successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add the book to cart.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid book ID']);
}

mysqli_close($conn);
