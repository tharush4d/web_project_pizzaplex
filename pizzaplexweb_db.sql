-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 07:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
--
-- Database: `pizzaplexweb_db`
CREATE DATABASE pizzaplexweb_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
--
USE pizzaplexweb_db;
-- --------------------------------------------------------
--
-- Table structure for table `contact_messages`
--
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `received_at` timestamp NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'unread',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- --------------------------------------------------------
--
-- Table structure for table `menu_items`
--
CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Dumping data for table `menu_items`
--
INSERT INTO `menu_items` (`id`, `name`, `description`, `image_path`, `price`, `category`) VALUES
(1, 'Margherita', 'Fresh tomato sauce, creamy mozzarella cheese, and fragrant basil leaves – a classic!', 'images/Margherita_Pizza.jpg', 1500.00, 'pizza'),
(2, 'Pepperoni', 'A timeless favorite – spicy pepperoni slices layered with hot, melted mozzarella.', 'images/Pepperoni_Pizza.jpg', 1850.00, 'pizza'),
(3, 'Chicken BBQ', 'Tender chicken chunks, smoky BBQ sauce, onions, and gooey mozzarella cheese.', 'images/Chicken_BBQ_Pizza.jpg', 1950.00, 'pizza'),
(4, 'Vegetarian', 'A colorful mix of fresh bell peppers, onions, olives, and mushrooms.', 'images/Vegetarian_Pizza.jpg', 1700.00, 'pizza'),
(5, 'Seafood Delight', 'Prawns, cuttlefish, and fish chunks topped with a rich white garlic sauce.', 'images/Seafood_Delight.jpg', 2200.00, 'pizza'),
(6, 'Garlic Bread', 'Freshly baked bread infused with butter and aromatic garlic.', 'images/Garlic_Bread.jpg', 450.00, 'sides'),
(7, 'Cheesy Garlic Bread', 'Golden garlic bread topped with hot, melty mozzarella cheese.', 'images/Cheesy_Garlic_Bread.jpg', 600.00, 'sides'),
(8, 'BBQ Chicken Wings', '6 juicy wings coated in rich, smoky BBQ sauce – full of flavor!', 'images/Chicken_Wings.jpg', 850.00, 'sides'),
(9, 'French Fries', 'Crispy, golden fries lightly salted to perfection.', 'images/French_Fries.jpg', 400.00, 'sides'),
(10, 'Coca-Cola', '330ml can of classic Coca-Cola.', 'images/CocaColaCan.jpg', 200.00, 'drinks'),
(11, 'Sprite', '330ml can of refreshing Sprite.', 'images/Sprite.jpg', 200.00, 'drinks'),
(12, 'Water Bottle', '500ml mineral water.', 'images/water.jpg', 100.00, 'drinks'),
(13, 'Iced Tea (Lemon)', 'Chilled lemon-flavored tea.', 'images/Iced_Tea.jpg', 300.00, 'drinks');
-- --------------------------------------------------------
--
-- Table structure for table `orders`
--
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_address1` varchar(255) NOT NULL,
  `customer_address2` varchar(255) DEFAULT NULL,
  `customer_city` varchar(100) NOT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` varchar(50) DEFAULT 'Pending',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- --------------------------------------------------------
--
-- Table structure for table `order_items`
--
CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_item` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- --------------------------------------------------------
--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
--
-- Indexes for dumped tables
--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);
--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);
--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_user_order` (`user_id`);
--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`);
--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_order` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;


