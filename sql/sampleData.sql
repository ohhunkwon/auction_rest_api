USE Auction;

INSERT INTO `Items` (`itemID`, `title`, `description`, `category`, `startingPrice`, `reservePrice`, `startDateTime`, `endDateTime`, `image`, `userID`, `bidID`) VALUES
(11, '42 inch TV', 'adasdfewfwe', 'Electronics', '400', '500', '2021-10-22 07:01:07', '2021-10-24 08:01:08', 'image.png', 1, NULL),
(12, 'Parka Coat', 'savasd sdf dsa fs s', 'Fashion', '50', '60', '2021-10-22 07:02:29', '2021-10-28 08:02:30', 'image.png', 2, NULL),
(13, 'Macbook Pro 2018', 'adsafvs da sa', 'Electronics', '700', '850', '2021-10-22 07:02:29', '2021-10-29 08:02:30', 'image.jpeg', 4, NULL),
(14, 'Tennis Racket', 'asdfnnja jkva vv', 'Sports', '15', '20', '2021-10-23 10:00:00', '2021-10-29 08:00:30', 'image.jpg', 2, NULL),
(16, 'Rare £1 Coin', 'adsadssda', 'Collectibles', '300', '450', '2021-10-25 10:00:00', '2021-11-10 10:00:00', 'image.jpg', 1, NULL);

INSERT INTO `Users` (`userID`, `firstName`, `lastName`, `email`, `role`, `createdAt`, `updatedAt`) VALUES
(1, 'John', 'Doe', 'johndoe@gmail.com', 'Seller', '2021-10-22 07:47:02', '2021-10-22 06:44:34'),
(2, 'Jane', 'Doe', 'janedoe@gmail.com', 'Seller', '2021-10-22 07:47:02', '2021-10-22 06:44:34'),
(3, 'Michael', 'Scott', 'michaelscott@hotmail.com', 'Buyer', '2021-10-22 07:47:02', '2021-10-22 06:44:34'),
(4, 'David', 'Smith', 'DavidSmith1991@gmail.com', 'Buyer', '2021-10-22 07:47:02', '2021-10-22 06:44:34'),
(5, 'Alex', 'Smith', 'alexsmith@gmail.com', 'Buyer', '2021-10-22 07:47:02', '2021-10-22 06:44:34');