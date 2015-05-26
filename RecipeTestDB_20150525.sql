-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 25, 2015 at 09:06 
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
(2, 4, '2015-05-22 16:19:26', '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `List`
--

CREATE TABLE IF NOT EXISTS `List` (
  `listID` int(11) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createUserID` varchar(50) DEFAULT NULL,
  `updateDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `listName` varchar(50) NOT NULL,
  `listDescription` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Recipe`
--

INSERT INTO `Recipe` (`recipeID`, `createDate`, `createUserID`, `updateDate`, `recipeName`, `difficultyID`, `duration`, `description`, `instructions`, `picture`) VALUES
(1, '2015-05-22 16:17:22', 'user1', '0000-00-00 00:00:00', 'recipe 1', 'c', 10, 'description of recipe 1', 'instructions of recipe 1', NULL),
(2, '2015-05-22 16:17:22', NULL, '0000-00-00 00:00:00', 'recipe 2', NULL, NULL, NULL, NULL, NULL);

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
('user1', '2015-05-22 16:15:41', '0000-00-00 00:00:00', NULL, NULL, NULL);

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
-- Indexes for table `List`
--
ALTER TABLE `List`
  ADD PRIMARY KEY (`listID`),
  ADD KEY `createUser` (`createUserID`);

--
-- Indexes for table `ListDetail`
--
ALTER TABLE `ListDetail`
  ADD PRIMARY KEY (`listID`,`recipeID`),
  ADD KEY `fk_listDetail_recipeID` (`recipeID`);

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
-- AUTO_INCREMENT for table `List`
--
ALTER TABLE `List`
  MODIFY `listID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Recipe`
--
ALTER TABLE `Recipe`
  MODIFY `recipeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
-- Constraints for table `List`
--
ALTER TABLE `List`
  ADD CONSTRAINT `fk_list_user` FOREIGN KEY (`createUserID`) REFERENCES `User` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ListDetail`
--
ALTER TABLE `ListDetail`
  ADD CONSTRAINT `fk_listDetail_list` FOREIGN KEY (`listID`) REFERENCES `List` (`listID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_listDetail_recipeID` FOREIGN KEY (`recipeID`) REFERENCES `Recipe` (`recipeID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `Recipe`
--
ALTER TABLE `Recipe`
  ADD CONSTRAINT `fk_recipe_difficulty` FOREIGN KEY (`difficultyID`) REFERENCES `Difficulties` (`difficultyID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_recipe_user` FOREIGN KEY (`createUserID`) REFERENCES `User` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
