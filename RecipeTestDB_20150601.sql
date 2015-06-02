-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 02, 2015 at 07:40 
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `RecipeTestDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `Difficulties`
--

CREATE TABLE IF NOT EXISTS `Difficulties` (
  `difficultyID` varchar(10) NOT NULL,
  `difficultyName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Difficulties`
--

INSERT INTO `Difficulties` (`difficultyID`, `difficultyName`) VALUES
('c', 'challenging'),
('m', 'medium'),
('s', 'simple');

-- --------------------------------------------------------

--
-- Table structure for table `Ingredient`
--

CREATE TABLE IF NOT EXISTS `Ingredient` (
  `ingredientID` int(11) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createUserID` varchar(50) DEFAULT NULL,
  `updateDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `ingredientName` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Ingredient`
--

INSERT INTO `Ingredient` (`ingredientID`, `createDate`, `createUserID`, `updateDate`, `ingredientName`) VALUES
(1, '2015-05-22 00:29:48', '0', '0000-00-00 00:00:00', 'Tomato'),
(2, '2015-05-22 00:29:48', '0', '0000-00-00 00:00:00', 'Meat'),
(3, '2015-05-22 00:29:48', '0', '0000-00-00 00:00:00', 'Salt'),
(4, '2015-05-22 00:29:48', '0', '0000-00-00 00:00:00', 'Curry');

-- --------------------------------------------------------

--
-- Table structure for table `IngredientsOfRecipe`
--

CREATE TABLE IF NOT EXISTS `IngredientsOfRecipe` (
  `recipeID` int(11) NOT NULL,
  `ingredientID` int(11) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `amount` float DEFAULT NULL,
  `weightUnitID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `IngredientsOfRecipe`
--

INSERT INTO `IngredientsOfRecipe` (`recipeID`, `ingredientID`, `createDate`, `updateDate`, `amount`, `weightUnitID`) VALUES
(1, 1, '2015-05-22 16:19:26', '0000-00-00 00:00:00', 5, 'g'),
(3, 1, '2015-05-25 22:44:33', '0000-00-00 00:00:00', 5, 'g'),
(4, 1, '2015-06-01 13:15:33', '0000-00-00 00:00:00', 5, 'g'),
(3, 2, '2015-05-25 22:44:33', '0000-00-00 00:00:00', 6, 'g'),
(4, 3, '2015-06-01 13:15:33', '0000-00-00 00:00:00', 10, 'g'),
(2, 4, '2015-05-22 16:19:26', '0000-00-00 00:00:00', NULL, NULL),
(3, 4, '2015-05-25 22:44:33', '0000-00-00 00:00:00', 1, 'g');

-- --------------------------------------------------------

--
-- Table structure for table `ListDetail`
--

CREATE TABLE IF NOT EXISTS `ListDetail` (
  `listID` int(11) NOT NULL,
  `recipeID` int(11) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ListDetail`
--

INSERT INTO `ListDetail` (`listID`, `recipeID`, `createDate`, `updateDate`) VALUES
(1, 1, '2015-06-02 04:21:23', '0000-00-00 00:00:00'),
(1, 3, '2015-06-02 04:19:42', '0000-00-00 00:00:00'),
(2, 1, '2015-06-02 03:48:53', '0000-00-00 00:00:00'),
(2, 4, '2015-06-02 04:01:02', '0000-00-00 00:00:00'),
(2, 5, '2015-06-02 04:01:07', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Lists`
--

CREATE TABLE IF NOT EXISTS `Lists` (
  `listID` int(11) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createUserID` varchar(50) DEFAULT NULL,
  `updateDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `listName` varchar(50) NOT NULL,
  `listDescription` varchar(250) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Lists`
--

INSERT INTO `Lists` (`listID`, `createDate`, `createUserID`, `updateDate`, `listName`, `listDescription`) VALUES
(1, '2015-06-02 02:54:43', 'user1@domain.at', '0000-00-00 00:00:00', 'list A', 'description of list A'),
(2, '2015-06-02 02:58:29', 'user3@uibk.ac.at', '0000-00-00 00:00:00', 'list3', 'description of list3 '),
(3, '2015-06-02 02:58:53', 'user2@MYLE.com', '0000-00-00 00:00:00', 'list2', 'description of list2');

-- --------------------------------------------------------

--
-- Table structure for table `Recipe`
--

CREATE TABLE IF NOT EXISTS `Recipe` (
  `recipeID` int(11) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createUserID` varchar(50) DEFAULT NULL,
  `updateDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `recipeName` varchar(255) NOT NULL,
  `difficultyID` varchar(10) DEFAULT NULL COMMENT 'Id of the difficulty as stored in the Difficulties table',
  `duration` int(11) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `instructions` varchar(5000) DEFAULT NULL,
  `picture` mediumblob
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Recipe`
--

INSERT INTO `Recipe` (`recipeID`, `createDate`, `createUserID`, `updateDate`, `recipeName`, `difficultyID`, `duration`, `description`, `instructions`, `picture`) VALUES
(1, '2015-05-22 16:17:22', 'user1@domain.at', '2015-06-02 02:55:19', 'recipe 1', 'c', 8, 'description of recipe 1 (not necessary)', 'instructions of recipe 1', NULL),
(2, '2015-05-22 16:17:22', 'user1@domain.at', '2015-05-27 06:53:14', 'recipe 2', 'm', 5, NULL, 'instructions for recipe 2', NULL),
(3, '2015-05-25 22:44:32', 'user2@MYLE.com', '2015-06-02 02:56:59', 'recipe 3', 'm', 5, NULL, 'instructions for recipe 3', NULL),
(4, '2015-06-01 13:15:33', 'user1@domain.at', '2015-06-02 03:59:22', 'recipe 4', 'c', 10, NULL, 'instructions for recipe 4', NULL),
(5, '2015-06-02 04:00:01', 'user3@uibk.ac.at', '0000-00-00 00:00:00', 'recipe 5', 'c', 5, 'description 5', 'instructions 5', NULL),
(6, '2015-06-02 04:15:32', 'user3@uibk.ac.at', '0000-00-00 00:00:00', 'recipe 5', 'c', 5, 'description 5', 'instructions 5', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `userID` varchar(50) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `displayName` varchar(25) DEFAULT NULL,
  `phoneNo` varchar(25) DEFAULT NULL,
  `password` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userID`, `createDate`, `updateDate`, `displayName`, `phoneNo`, `password`) VALUES
('user1@domain.at', '2015-05-27 02:54:59', '0000-00-00 00:00:00', 'displayNameUser1', '012345', 'user1'),
('user2@MYLE.com', '2015-06-02 02:56:43', '0000-00-00 00:00:00', NULL, NULL, 'user2'),
('user3@uibk.ac.at', '2015-05-22 16:15:41', '2015-06-02 02:57:47', NULL, NULL, 'user3');

-- --------------------------------------------------------

--
-- Table structure for table `WeightUnits`
--

CREATE TABLE IF NOT EXISTS `WeightUnits` (
  `unitID` varchar(10) NOT NULL,
  `unitName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `WeightUnits`
--

INSERT INTO `WeightUnits` (`unitID`, `unitName`) VALUES
('g', 'gram'),
('kg', 'kilogram'),
('l', 'liter'),
('ml', 'milliliter'),
('pc', 'piece');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Difficulties`
--
ALTER TABLE `Difficulties`
  ADD PRIMARY KEY (`difficultyID`);

--
-- Indexes for table `Ingredient`
--
ALTER TABLE `Ingredient`
  ADD PRIMARY KEY (`ingredientID`),
  ADD KEY `createUser` (`createUserID`);

--
-- Indexes for table `IngredientsOfRecipe`
--
ALTER TABLE `IngredientsOfRecipe`
  ADD PRIMARY KEY (`ingredientID`,`recipeID`),
  ADD KEY `fk_ingridentsOfRecipe_recipe` (`recipeID`),
  ADD KEY `weightUnitID` (`weightUnitID`);

--
-- Indexes for table `ListDetail`
--
ALTER TABLE `ListDetail`
  ADD PRIMARY KEY (`listID`,`recipeID`),
  ADD KEY `fk_listDetail_recipeID` (`recipeID`);

--
-- Indexes for table `Lists`
--
ALTER TABLE `Lists`
  ADD PRIMARY KEY (`listID`),
  ADD KEY `createUser` (`createUserID`);

--
-- Indexes for table `Recipe`
--
ALTER TABLE `Recipe`
  ADD PRIMARY KEY (`recipeID`),
  ADD UNIQUE KEY `recipeID` (`recipeID`),
  ADD KEY `difficultyID` (`difficultyID`),
  ADD KEY `createUser` (`createUserID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `WeightUnits`
--
ALTER TABLE `WeightUnits`
  ADD PRIMARY KEY (`unitID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Ingredient`
--
ALTER TABLE `Ingredient`
  MODIFY `ingredientID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Lists`
--
ALTER TABLE `Lists`
  MODIFY `listID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Recipe`
--
ALTER TABLE `Recipe`
  MODIFY `recipeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `IngredientsOfRecipe`
--
ALTER TABLE `IngredientsOfRecipe`
  ADD CONSTRAINT `fk_ingridentsOfRecipe_ingredient` FOREIGN KEY (`ingredientID`) REFERENCES `Ingredient` (`ingredientID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingridentsOfRecipe_recipe` FOREIGN KEY (`recipeID`) REFERENCES `Recipe` (`recipeID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingridentsOfRecipe_weightUnit` FOREIGN KEY (`weightUnitID`) REFERENCES `WeightUnits` (`unitID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ListDetail`
--
ALTER TABLE `ListDetail`
  ADD CONSTRAINT `fk_listDetail_list` FOREIGN KEY (`listID`) REFERENCES `Lists` (`listID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_listDetail_recipeID` FOREIGN KEY (`recipeID`) REFERENCES `Recipe` (`recipeID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `Lists`
--
ALTER TABLE `Lists`
  ADD CONSTRAINT `fk_list_user` FOREIGN KEY (`createUserID`) REFERENCES `User` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Recipe`
--
ALTER TABLE `Recipe`
  ADD CONSTRAINT `fk_recipe_difficulty` FOREIGN KEY (`difficultyID`) REFERENCES `Difficulties` (`difficultyID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_recipe_user` FOREIGN KEY (`createUserID`) REFERENCES `User` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
