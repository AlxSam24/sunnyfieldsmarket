-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 31, 2024 at 12:14 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sunnyfielddata`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `email` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `password_hash` varchar(500) DEFAULT NULL,
  `fullname` varchar(30) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`email`, `birthdate`, `password_hash`, `fullname`, `user_id`) VALUES
('alexanderdsamuel@gmail.com', '2006-06-24', '$2y$10$dhoMdlC/1ODkf6QCszlPHu9eDQrI0AReFU.E4Veo9DwMoQsXjznf2', 'Alex Samuel', 1),
('30133473@gmail.com', '1994-06-14', '$2y$10$nfoLEYwcamCAp/qbDFUDkOj5ETMGrB8GwN8MGB4XY5xO29oeEB1Jm', 'James Phillips ', 3),
('30133473@outlook.com', '1994-06-14', '$2y$10$2/6sfWDY4tjG1ZiPTRmjNuFpHSBys7PHRJZWbx3obVRsNpUb.IjYO', 'James Jones', 5);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackEntryID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `Contents` text,
  `FeedbackDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FeedbackEntryID`, `CustomerID`, `Contents`, `FeedbackDate`) VALUES
(1, 1, 'How do you collect order from store?', '2024-02-07'),
(2, 1, 'vxcvxcvxvxcvvbnvjxnmvbxncbv bnxcv', '2024-02-07'),
(3, 1, 'This is another test', '2024-02-18'),
(4, 2, 'What is your store opening times ?', '2024-02-27');

-- --------------------------------------------------------

--
-- Table structure for table `groceries`
--

CREATE TABLE `groceries` (
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `grocery_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groceries`
--

INSERT INTO `groceries` (`name`, `price`, `quantity`, `image_path`, `grocery_id`) VALUES
('Carrots', '1.50', 0, 'carrots.jpg', 1),
('Broccoli', '0.70', 2, 'broccoli.jpg', 2),
('Tomato', '2.00', 0, 'tomato.jfif', 3),
('Cauliflower', '1.10', 8, 'cauliflower.jpg', 4),
('Eggs', '1.20', 0, 'eggs.jpg', 5),
('Bananas', '1.00', 3, 'bananas.jpg', 6),
('Apples', '1.99', 20, 'apples.jpg', 7),
('Oranges', '2.49', 12, 'oranges.jpg', 8),
('Grapes (Red)', '3.99', 5, 'grapes.jpg', 9),
('Strawberries', '4.99', 4, 'strawberries.jpg', 10),
('Blueberries', '5.99', 10, 'blueberries.jpg', 11),
('Avocados', '1.49', 10, 'avocados.jpg', 12),
('Cucumbers', '0.99', 10, 'cucumbers.jpg', 13),
('Lettuce', '2.29', 10, 'lettuce.jpg', 14),
('Spinach', '2.99', 8, 'spinach.jpg', 15),
('Bell peppers', '1.69', 11, 'bell_peppers.jpg', 16),
('Onions', '0.89', 12, 'onions.jpg', 17),
('Potatoes', '1.19', 10, 'potatoes.jpg', 18),
('Sweet potatoes', '1.49', 19, 'sweet_potatoes.jpg', 19),
('Garlic', '0.69', 12, 'garlic.jpg', 20),
('Ginger', '1.29', 7, 'ginger.jpg', 21),
('Lemons', '0.99', 10, 'lemons.jpg', 22),
('Limes', '0.79', 8, 'limes.jpg', 23),
('Watermelon', '4.99', 20, 'watermelon.jpg', 24),
('Cantaloupe', '3.49', 8, 'cantaloupe.jpg', 25),
('Pineapple', '2.99', 9, 'pineapple.jpg', 26),
('Mangoes', '1.79', 9, 'mangoes.jpg', 27),
('Peaches', '2.29', 8, 'peaches.jpg', 28),
('Plums', '1.99', 9, 'plums.jpg', 29),
('Nectarines', '2.49', 20, 'nectarines.jpg', 30),
('Cherries', '3.99', 5, 'cherries.jpg', 31),
('Kiwi', '0.99', 12, 'kiwi.jpg', 32),
('Papaya', '3.29', 8, 'papaya.jpg', 33),
('Pears', '1.79', 10, 'pears.jpg', 34),
('Peppers (assorted)', '2.99', 15, 'peppers_assorted.jpg', 35),
('Zucchini', '1.29', 12, 'zucchini.jpg', 36),
('Eggplant', '1.49', 10, 'eggplant.jpg', 37),
('Radishes', '0.89', 14, 'radishes.jpg', 38),
('Celery', '1.29', 12, 'celery.jpg', 39),
('Asparagus', '2.99', 8, 'asparagus.jpg', 40),
('Green beans', '1.79', 12, 'green_beans.jpg', 41),
('Brussels sprouts', '2.49', 10, 'brussels_sprouts.jpg', 42),
('Artichokes', '3.99', 4, 'artichokes.jpg', 43),
('Mushrooms', '2.29', 10, 'mushrooms.jpg', 44),
('Squash (varieties)', '1.99', 12, 'squash_varieties.jpg', 45),
('Beets', '1.49', 15, 'beets.jpg', 46),
('Sweet corn', '0.79', 16, 'sweet_corn.jpg', 47),
('Red cabbage', '1.29', 10, 'red_cabbage.jpg', 48),
('Iceberg lettuce', '1.49', 10, 'iceberg_lettuce.jpg', 49),
('Romaine lettuce', '1.79', 7, 'romaine_lettuce.jpg', 50),
('Arugula', '2.29', 8, 'arugula.jpg', 51),
('Baby spinach', '2.99', 10, 'baby_spinach.jpg', 52),
('Kale', '2.49', 10, 'kale.jpg', 53),
('Swiss chard', '2.79', 8, 'swiss_chard.jpg', 54),
('Red onions', '0.89', 14, 'red_onions.jpg', 55),
('Shallots', '1.49', 10, 'shallots.jpg', 56),
('Scallions', '0.99', 12, 'scallions.jpg', 57),
('Leeks', '1.29', 9, 'leeks.jpg', 58),
('Cilantro', '0.69', 15, 'cilantro.jpg', 59),
('Parsley', '0.69', 15, 'parsley.jpg', 60),
('Basil', '0.79', 12, 'basil.jpg', 61),
('Mint', '0.79', 12, 'mint.jpg', 62),
('Thyme', '0.89', 10, 'thyme.jpg', 63),
('Rosemary', '0.89', 10, 'rosemary.jpg', 64),
('Dill', '0.79', 8, 'dill.jpg', 65),
('Chives', '0.69', 15, 'chives.jpg', 66),
('Oregano', '0.79', 12, 'oregano.jpg', 67),
('Sage', '0.89', 10, 'sage.jpg', 68),
('Bay leaves', '0.79', 12, 'bay_leaves.jpg', 69),
('Coriander', '0.50', 12, 'coriander.jpg', 70),
('Ground cinnamon', '1.99', 10, 'ground_cinnamon.jpg', 71),
('Vanilla extract', '4.99', 5, 'vanilla_extract.jpg', 72),
('Nutmeg', '2.49', 10, 'nutmeg.jpg', 73),
('Cloves', '2.99', 8, 'cloves.jpg', 74),
('Milk (Whole)', '2.50', 16, 'whole_milk.jpg', 75),
('Milk (Semi-skimmed)', '2.00', 10, 'semiskimmed_milk.jpg', 76),
('Milk (skimmed)', '2.00', 4, 'skimmed_milk.jpg', 77),
('Steak', '15.00', 8, 'steak.jpg', 78),
('Whole Chicken ', '12.00', 7, 'chicken.jpg', 79),
('Pork ', '12.00', 9, 'pork.jpg', 80),
('Beef', '14.99', 13, 'beef.jpg', 81),
('Bread', '1.50', 4, 'bread.jpg', 82),
('Dragon Fruit ', '3.50', 11, 'dragonfruit.jpg', 83),
('Honeycomb ', '5.00', 19, 'honeycomb.jfif', 84),
('Bacon', '5.00', 10, 'bacon.jpg', 85);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_date` date DEFAULT NULL,
  `order_total` decimal(10,2) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `expiry_month` varchar(10) DEFAULT NULL,
  `expiry_year` varchar(10) DEFAULT NULL,
  `cvv` varchar(10) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `orderID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_date`, `order_total`, `customer_id`, `address`, `card_number`, `expiry_month`, `expiry_year`, `cvv`, `postcode`, `orderID`) VALUES
('2024-03-24', '9.43', 3, '4 llangorse road', '9f61dca66c06855381bb8b5af61654675b4c853a8d881f4bb0f46d2a901ab4a4', 'January ', '2022', '223', 'CF23 6PE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `grocery_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`grocery_id`, `quantity`, `order_id`) VALUES
(3, 1, 1),
(14, 1, 1),
(13, 2, 1),
(23, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Staff_Password` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Postcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `Name`, `Address`, `DateOfBirth`, `Staff_Password`, `Email`, `Postcode`) VALUES
(1, 'Brian Foster', '123 George Street', '1994-05-17', '$2y$10$teEQAWl2t.CNhabQQG22veNEcx.32eayxEijFh6kOrgCRyByMCx1m', 'brianfoster@sunnyfieldsmarket.co.uk', 'NP14 6JQ'),
--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackEntryID`);

--
-- Indexes for table `groceries`
--
ALTER TABLE `groceries`
  ADD PRIMARY KEY (`grocery_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedbackEntryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `groceries`
--
ALTER TABLE `groceries`
  MODIFY `grocery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
