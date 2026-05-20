-- Create the database
CREATE DATABASE IF NOT EXISTS book_explorer;

-- Use the database
USE book_explorer;

-- Table: users
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    mobile VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    nationality VARCHAR(50),
    languages ENUM('English', 'Hindi', 'Tamil', 'Others')
);

-- Table: books
CREATE TABLE IF NOT EXISTS books (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    isbn_number VARCHAR(20) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    cost DECIMAL(10, 2) NOT NULL,
    rating FLOAT
);

-- Table: favorites
CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (book_id) REFERENCES books(book_id)
);

-- Table: cart
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (book_id) REFERENCES books(book_id)
);

-- Table: orders
CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    name VARCHAR(100) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    payment_method ENUM('UPI', 'Credit Card', 'Debit Card', 'BHIM', 'COD'),
    total_cost DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Insert Sample Data (Books)
INSERT INTO books (title, author, isbn_number, description, image, cost, rating) VALUES
('Book Title 1', 'Author Name 1', 'ISBN1234567891', 'A short description of Book 1...', 'book1.jpg', 500.00, 4.5),
('Book Title 2', 'Author Name 2', 'ISBN1234567892', 'A short description of Book 2...', 'book2.jpg', 300.00, 4.0),
('Book Title 3', 'Author Name 3', 'ISBN1234567893', 'A short description of Book 3...', 'book3.jpg', 700.00, 4.8);
