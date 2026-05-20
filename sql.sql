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


INSERT INTO books (title, author, isbn_number, description, image, cost, rating) VALUES
('Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', '9780747532699',
 'A young wizard discovers his magical heritage and attends Hogwarts School of Witchcraft and Wizardry.',
 'harry_potter.jpg', 499.99, 4.9),
('To Kill a Mockingbird', 'Harper Lee', '9780061120084',
 'A gripping tale of racial injustice and the loss of innocence, set in the American South during the 1930s.',
 'mockingbird.jpg', 399.99, 4.8),
('1984', 'George Orwell', '9780451524935',
 'A dystopian novel exploring the dangers of totalitarianism, surveillance, and loss of individual freedom.',
 '1984.jpg', 299.99, 4.7),
('The Great Gatsby', 'F. Scott Fitzgerald', '9780743273565',
 'The story of Jay Gatsby and his unrelenting love for Daisy Buchanan, set in the Jazz Age of the 1920s.',
 'gatsby.jpg', 349.99, 4.6),
('Pride and Prejudice', 'Jane Austen', '9780141040349',
 'A romantic comedy about manners, marriage, and the societal expectations of Regency England.',
 'pride_prejudice.jpg', 249.99, 4.8),
('The Hobbit', 'J.R.R. Tolkien', '9780618968633',
 'The adventurous tale of Bilbo Baggins, who is swept into an epic quest to reclaim the lost Dwarf Kingdom.',
 'hobbit.jpg', 549.99, 4.9),
('Becoming', 'Michelle Obama', '9781524763138',
 'An intimate, powerful, and inspiring memoir by the former First Lady of the United States.',
 'becoming.jpg', 599.99, 4.8),
('The Alchemist', 'Paulo Coelho', '9780061122415',
 'A young shepherd’s journey to the Egyptian pyramids teaches him about following dreams and finding treasure.',
 'alchemist.jpg', 299.99, 4.7),
('The Catcher in the Rye', 'J.D. Salinger', '9780316769488',
 'The story of Holden Caulfield, a teenager navigating the challenges of adulthood and society.',
 'catcher_rye.jpg', 279.99, 4.5),
('Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', '9780099590088',
 'A groundbreaking narrative of humanity’s creation, evolution, and impact on the world.',
 'sapiens.jpg', 649.99, 4.8);
