-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 27, 2025 at 05:26 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_explorer`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `book_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn_number` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `rating` float DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  UNIQUE KEY `isbn_number` (`isbn_number`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `isbn_number`, `description`, `image`, `cost`, `rating`) VALUES
(1, 'Book Title 1', 'Author Name 1', 'ISBN1234567891', 'A short description of Book 1...', 'book1.jpg', 500.00, 4.5),
(2, 'Book Title 2', 'Author Name 2', 'ISBN1234567892', 'A short description of Book 2...', 'book2.jpg', 300.00, 4),
(3, 'Book Title 3', 'Author Name 3', 'ISBN1234567893', 'A short description of Book 3...', 'book3.jpg', 700.00, 4.8),
(4, 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', '9780747532699', 'A young wizard discovers his magical heritage and attends Hogwarts School of Witchcraft and Wizardry.', 'harry_potter.jpg', 499.99, 4.9),
(5, 'To Kill a Mockingbird', 'Harper Lee', '9780061120084', 'A gripping tale of racial injustice and the loss of innocence, set in the American South during the 1930s.', 'mockingbird.jpg', 399.99, 4.8),
(6, '1984', 'George Orwell', '9780451524935', 'A dystopian novel exploring the dangers of totalitarianism, surveillance, and loss of individual freedom.', '1984.jpg', 299.99, 4.7),
(7, 'The Great Gatsby', 'F. Scott Fitzgerald', '9780743273565', 'The story of Jay Gatsby and his unrelenting love for Daisy Buchanan, set in the Jazz Age of the 1920s.', 'gatsby.jpg', 349.99, 4.6),
(8, 'Pride and Prejudice', 'Jane Austen', '9780141040349', 'A romantic comedy about manners, marriage, and the societal expectations of Regency England.', 'pride_prejudice.jpg', 249.99, 4.8),
(9, 'The Hobbit', 'J.R.R. Tolkien', '9780618968633', 'The adventurous tale of Bilbo Baggins, who is swept into an epic quest to reclaim the lost Dwarf Kingdom.', 'hobbit.jpg', 549.99, 4.9),
(10, 'Becoming', 'Michelle Obama', '9781524763138', 'An intimate, powerful, and inspiring memoir by the former First Lady of the United States.', 'becoming.jpg', 599.99, 4.8),
(11, 'The Alchemist', 'Paulo Coelho', '9780061122415', 'A young shepherd?s journey to the Egyptian pyramids teaches him about following dreams and finding treasure.', 'alchemist.jpg', 299.99, 4.7),
(12, 'The Catcher in the Rye', 'J.D. Salinger', '9780316769488', 'The story of Holden Caulfield, a teenager navigating the challenges of adulthood and society.', 'catcher_rye.jpg', 279.99, 4.5),
(13, 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', '9780099590088', 'A groundbreaking narrative of humanity?s creation, evolution, and impact on the world.', 'sapiens.jpg', 649.99, 4.8);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `book_id`, `quantity`) VALUES
(6, 3, 1, 1),
(7, 3, 7, 1),
(16, 1, 1, 1),
(15, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `book_id`) VALUES
(11, 1, 1),
(12, 1, 2),
(10, 3, 5),
(9, 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `payment_method` enum('UPI','Credit Card','Debit Card','BHIM','COD') DEFAULT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `name`, `mobile`, `email`, `address`, `payment_method`, `total_cost`) VALUES
(1, 1, '2025-03-26 15:47:07', 'yy', '7', 'ee@gmail.com', 'yfei', '', 1400.00),
(2, 1, '2025-03-26 16:01:12', 'tt', '55', 'tt@gmail.com', '5tyfh\\r\\n', '', 500.00),
(3, 1, '2025-03-26 22:01:19', 'tt', '6', 'dd@gmail.com', 'hjfdk\\r\\n', NULL, 300.00),
(4, 1, '2025-03-27 22:38:13', 'desh', '123', 'aa@gmail.com', 'chennai\\r\\n', NULL, 800.00),
(5, 1, '2025-03-27 22:44:37', 'Venkatesh R', '123', 'ee@gmail.com', 'Lal Bahadur Shastri Street\\r\\nSathya moorthy block', NULL, 800.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `book_id` int NOT NULL,
  `quantity` int NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `book_id`, `quantity`, `cost`) VALUES
(1, 2, 1, 1, 500.00),
(2, 2, 2, 1, 300.00),
(3, 1, 2, 1, 300.00),
(4, 1, 2, 1, 300.00),
(5, 1, 2, 1, 300.00),
(6, 1, 1, 1, 500.00),
(7, 2, 1, 1, 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `languages` enum('English','Hindi','Tamil','Others') DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `mobile` (`mobile`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `mobile`, `email`, `password`, `address`, `nationality`, `languages`) VALUES
(1, 'magnaa', '1', 'aa@gmail.com', '123', 'hjkh', 'kkjhjk', 'English'),
(2, 'maxx6660', '1234', 'qq@gmail.com', '1234', 'aaad', 'sds', 'English'),
(3, 'vedha', '1234567', 'vedha@gmail.com', '1234', 'chennai', 'indian', 'English');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
