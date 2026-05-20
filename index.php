<?php
// Include the header
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .index-hero {
            background: linear-gradient(135deg, #6c63ff, #ff6e7f);
            color: white;
            padding: 50px 0;
            text-align: center;
        }
        .index-hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .index-hero p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .search-container {
            padding: 30px 0;
        }
        .search-form {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .autocomplete-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
        }
        .autocomplete-suggestion {
            padding: 10px;
            cursor: pointer;
        }
        .autocomplete-suggestion:hover {
            background: #f0f0f0;
        }
        .btn-search {
            background: linear-gradient(135deg, #6c63ff, #ff6e7f);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
        }
        .btn-search:hover {
            background: linear-gradient(135deg, #ff6e7f, #6c63ff);
        }
    </style>
</head>
<body>

<section class="index-hero">
    <h1>Welcome to Book Explorer</h1>
    <p>Your gateway to finding and enjoying your favorite books</p>
</section>

<section class="search-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="search-form">
                    <form method="GET" action="book_list.php">
                        <div class="mb-3">
                            <label class="form-label"><strong>Search By:</strong></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="search_by" id="searchAuthor" value="author" required>
                                <label class="form-check-label" for="searchAuthor">Author Name</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="search_by" id="searchBook" value="book">
                                <label class="form-check-label" for="searchBook">Book Name</label>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="search" class="form-label">Enter Your Search</label>
                            <input type="text" id="search" name="search" class="form-control" placeholder="Type here..." onkeyup="fetchSuggestions()" required>
                            <div id="suggestions" class="autocomplete-suggestions"></div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-search">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <p class="text-center mt-4">&copy; 2025 All Rights Reserved by Keerthika ShakarGanesh.</p>
</footer>

<script>
    function fetchSuggestions() {
        const searchInput = document.getElementById("search").value;
        const searchBy = document.querySelector('input[name="search_by"]:checked')?.value;
        const suggestionsContainer = document.getElementById("suggestions");

        if (searchInput.length > 0 && searchBy) {
            fetch(`autocomplete.php?query=${searchInput}&search_by=${searchBy}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsContainer.innerHTML = ""; // Clear previous suggestions
                    data.forEach(item => {
                        const div = document.createElement("div");
                        div.className = "autocomplete-suggestion";
                        div.textContent = searchBy === "author" ? item.author : item.title;
                        div.onclick = () => {
                            document.getElementById("search").value = searchBy === "author" ? item.author : item.title; // Set selected value
                            suggestionsContainer.innerHTML = ""; // Clear suggestions
                        };
                        suggestionsContainer.appendChild(div);
                    });
                });
        } else {
            suggestionsContainer.innerHTML = ""; // Clear suggestions if no input
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
