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
    $check_query = "SELECT * FROM favorites WHERE user_id = ? AND book_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $book_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['success' => false, 'message' => 'This book is already added to favorites.']);
    } else {
        $insert_query = "INSERT INTO favorites (user_id, book_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, 'ii', $user_id, $book_id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Book added to favorites!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add to favorites.']);
        }
    }
}

mysqli_close($conn);
