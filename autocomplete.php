<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'book_explorer');

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the search query and search type
$query = $_GET['query'] ?? '';
$search_by = $_GET['search_by'] ?? '';

if (!empty($query) && !empty($search_by)) {
    $sql = "";

    if ($search_by === 'author') {
        $sql = "SELECT DISTINCT author FROM books WHERE author LIKE ? LIMIT 10";
    } elseif ($search_by === 'book') {
        $sql = "SELECT DISTINCT title FROM books WHERE title LIKE ? LIMIT 10";
    }

    if (!empty($sql)) {
        $stmt = mysqli_prepare($conn, $sql);
        $searchTerm = "%$query%";
        mysqli_stmt_bind_param($stmt, 's', $searchTerm);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Fetch results
        $suggestions = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $suggestions[] = $row;
        }

        // Return results as JSON
        header('Content-Type: application/json');
        echo json_encode($suggestions);
    }
}

// Close the database connection
mysqli_close($conn);
?>
