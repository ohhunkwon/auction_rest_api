-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 26, 2021 at 04:08 PM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auction_rest_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `Bids`
--

CREATE TABLE `Bids` (
  `bidID` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(10,0) NOT NULL,
  `userID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Bids`
--

INSERT INTO `Bids` (`bidID`, `createdAt`, `amount`, `userID`, `itemID`) VALUES
(1, '2021-10-22 08:02:18', '770', 3, 11),
(2, '2021-10-22 08:04:45', '68', 1, 12),
(3, '2021-10-22 08:04:45', '800', 3, 13),
(4, '2021-10-22 08:15:49', '1000', 4, 14),
(5, '2021-10-30 17:38:32', '1250', 1, 16),
(6, '2021-10-23 10:00:00', '1000', 1, 11),
(7, '2021-10-22 07:01:07', '1100', 3, 12),
(8, '2021-10-22 07:01:07', '1200', 3, 12),
(9, '2021-10-22 07:01:07', '1300', 3, 12),
(10, '2021-10-22 07:01:07', '1400', 3, 12),
(11, '2021-10-22 07:01:07', '1100', 3, 13),
(12, '2021-10-22 07:01:07', '1200', 3, 13),
(13, '2021-10-22 07:01:07', '1300', 3, 13),
(14, '2021-10-22 07:01:07', '1301', 3, 13),
(15, '2021-10-22 07:01:07', '1302', 3, 13),
(16, '2021-10-22 07:01:07', '1303', 3, 13),
(17, '2021-10-22 07:01:07', '1304', 3, 13),
(18, '2021-10-22 07:01:07', '1305', 3, 13),
(19, '2021-10-22 07:01:07', '1100', 3, 14),
(20, '2021-10-22 07:01:07', '1500', 3, 12),
(21, '2021-10-22 07:01:07', '1501', 3, 12),
(22, '2021-10-22 07:01:07', '1505', 3, 12),
(23, '2021-10-22 07:01:07', '1600', 3, 13);

-- --------------------------------------------------------

--
-- Table structure for table `Items`
--

CREATE TABLE `Items` (
  `itemID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `startingPrice` decimal(10,0) NOT NULL,
  `reservePrice` decimal(10,0) NOT NULL,
  `startDateTime` datetime NOT NULL,
  `endDateTime` datetime NOT NULL,
  `image` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  `bidID` int(11) DEFAULT NULL,
  `highestPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Items`
--

INSERT INTO `Items` (`itemID`, `title`, `description`, `category`, `startingPrice`, `reservePrice`, `startDateTime`, `endDateTime`, `image`, `userID`, `bidID`, `highestPrice`) VALUES
(11, '42 inch TV', 'adasdfewfwe', 'Electronics', '400', '500', '2021-10-22 07:01:07', '2021-10-24 08:01:08', 'image.png', 1, 1, 500),
(12, 'Parka Coat', 'savasd sdf dsa fs s', 'Fashion', '50', '60', '2021-10-22 07:02:29', '2021-10-28 08:02:30', 'image.png', 2, 22, 1505),
(13, 'Macbook Pro 2018', 'adsafvs da sa', 'Electronics', '700', '850', '2021-10-22 07:02:29', '2021-10-29 08:02:30', 'image.jpeg', 4, 23, 1600),
(14, 'Tennis Racket', 'asdfnnja jkva vv', 'Sports', '15', '20', '2021-10-23 10:00:00', '2021-10-29 08:00:30', 'image.jpg', 2, 3, 1100),
(16, 'Rare £1 Coin', 'adsadssda', 'Collectibles', '300', '450', '2021-10-25 10:00:00', '2021-11-10 10:00:00', 'image.jpg', 1, 5, 1000),
(17, 'Nike shoes', 'asdfnsdasdaa adjkva vv', 'Sports', '15', '20', '2021-10-23 10:00:00', '2021-10-29 08:00:30', 'image.jpg', 3, NULL, 20);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT NULL,
  `pwhash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`userID`, `firstName`, `lastName`, `email`, `role`, `createdAt`, `updatedAt`, `pwhash`) VALUES
(1, 'John', 'Doe', 'johndoe@gmail.com', 'Seller', '2021-10-22 07:47:02', '2021-10-22 06:44:34', '1'),
(2, 'Jane', 'Doe', 'janedoe@gmail.com', 'Seller', '2021-10-22 07:47:02', '2021-10-22 06:44:34', '2'),
(3, 'Michael', 'Scott', 'michaelscott@hotmail.com', 'Buyer', '2021-10-22 07:47:02', '2021-10-22 06:44:34', '3'),
(4, 'David', 'Smith', 'DavidSmith1991@gmail.com', 'Buyer', '2021-10-22 07:47:02', '2021-10-22 06:44:34', '4'),
(5, 'Alex', 'Smith', 'alexsmith@gmail.com', 'Buyer', '2021-10-22 07:47:02', '2021-10-22 06:44:34', '5'),
(6, 'Ohhun', 'Kwon', 'ohhunkwon@hotmail', 'Seller', '2021-11-22 07:47:02', '2021-11-22 07:47:02', '$2y$10$pFS1ATZUIyEiq8GVjT2G3ONd8Q/XLo7Kon7yJeuiQsM7/uGbTpoVq'),
(9, 'asdadsa', 'dadsasda', 'janedoe1@gmail.com', 'Seller', '2021-11-22 07:47:02', '2021-11-22 07:47:02', '$2y$10$Rc5D8Y96zL45ljaZauQ8Uex7QkOmDceRqfs9NfBL6MMvIs4akACka'),
(14, 'asdadsa', 'dadsasda', 'janedoe2@gmail.com', 'Seller', '2021-11-22 07:47:02', '2021-11-22 07:47:02', '$2y$10$2HrUtqw0YF34t4jv6uAAP.sus43rw.sLM5dSEdlsT1efU.ydeXvp6');

-- --------------------------------------------------------

--
-- Table structure for table `Watchlist`
--

CREATE TABLE `Watchlist` (
  `userID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Watchlist`
--

INSERT INTO `Watchlist` (`userID`, `itemID`) VALUES
(5, 13),
(4, 16),
(1, 11),
(4, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Bids`
--
ALTER TABLE `Bids`
  ADD PRIMARY KEY (`bidID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `Items`
--
ALTER TABLE `Items`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `bidID` (`bidID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Watchlist`
--
ALTER TABLE `Watchlist`
  ADD KEY `itemID` (`itemID`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Bids`
--
ALTER TABLE `Bids`
  MODIFY `bidID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `Items`
--
ALTER TABLE `Items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Bids`
--
ALTER TABLE `Bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `Users` (`userID`),
  ADD CONSTRAINT `bids_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `Items` (`itemID`);

--
-- Constraints for table `Items`
--
ALTER TABLE `Items`
  ADD CONSTRAINT `bidID` FOREIGN KEY (`bidID`) REFERENCES `Bids` (`bidID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `Users` (`userID`);

--
-- Constraints for table `Watchlist`
--
ALTER TABLE `Watchlist`
  ADD CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `Items` (`itemID`),
  ADD CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `Users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;