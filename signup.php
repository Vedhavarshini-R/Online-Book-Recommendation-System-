<?php
// Include the header
include 'header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connect to database
    $conn = mysqli_connect('localhost', 'root', '', 'book_explorer');

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $languages = mysqli_real_escape_string($conn, $_POST['languages']);

    // Insert user into database
    $query = "INSERT INTO users (username, mobile, email, password, address, nationality, languages) VALUES ('$username', '$mobile', '$email', '$password', '$address', '$nationality', '$languages')";
    if (mysqli_query($conn, $query)) {
        header("Location: signup_success.php");
        exit();
    } else {
        $error_message = "Error during signup! Please try again.";
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // JavaScript for real-time restrictions
        function restrictInput() {
            // Restrict the name field to alphabets and spaces only
            const nameField = document.getElementById('username');
            nameField.addEventListener('input', () => {
                nameField.value = nameField.value.replace(/[^a-zA-Z\s]/g, '');
            });

            // Restrict the mobile field to numbers only and set a max length of 10 digits
            const mobileField = document.getElementById('mobile');
            mobileField.addEventListener('input', () => {
                mobileField.value = mobileField.value.replace(/[^0-9]/g, '');
                if (mobileField.value.length > 10) {
                    mobileField.value = mobileField.value.slice(0, 10);
                }
            });
        }

        // Form submission validation
        function validateForm() {
            const nameField = document.getElementById('username');
            const mobileField = document.getElementById('mobile');

            // Ensure the name field is not empty
            if (!nameField.value.trim()) {
                alert('Name field cannot be empty.');
                nameField.focus();
                return false;
            }

            // Ensure the mobile field has exactly 10 digits
            if (mobileField.value.length < 10) {
                alert('Mobile number must be exactly 10 digits.');
                mobileField.focus();
                return false;
            }

            return true; // If all validations pass
        }

        // Initialize restrictions on page load
        window.onload = restrictInput;
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Sign Up</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        <form method="POST" onsubmit="return validateForm();" class="mt-4">
            <div class="mb-3">
                <label for="username" class="form-label">Full Name</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" id="mobile" name="mobile" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="nationality" class="form-label">Nationality</label>
                <input type="text" id="nationality" name="nationality" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="languages" class="form-label">Languages</label>
                <select id="languages" name="languages" class="form-select" required>
                    <option value="English">English</option>
                    <option value="Hindi">Hindi</option>
                    <option value="Tamil">Tamil</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
            <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
