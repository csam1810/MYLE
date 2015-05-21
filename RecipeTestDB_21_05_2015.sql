-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 21, 2015 at 01:14 
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
  `ingredientName` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Ingredient`
--

INSERT INTO `Ingredient` (`ingredientID`, `ingredientName`) VALUES
(1, 'Tomato'),
(2, 'Meat'),
(3, 'Salt'),
(4, 'Curry');

-- --------------------------------------------------------

--
-- Table structure for table `IngredientsOfRecipe`
--

CREATE TABLE IF NOT EXISTS `IngredientsOfRecipe` (
  `ingredientsOfRecipeID` int(11) NOT NULL,
  `amount` float NOT NULL,
  `weightUnitID` varchar(10) NOT NULL,
  `ingredientID` int(11) NOT NULL,
  `recipeID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `IngredientsOfRecipe`
--

INSERT INTO `IngredientsOfRecipe` (`ingredientsOfRecipeID`, `amount`, `weightUnitID`, `ingredientID`, `recipeID`) VALUES
(1, 4, 'pc', 1, 1),
(2, 300, 'g', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Recipe`
--

CREATE TABLE IF NOT EXISTS `Recipe` (
  `recipeID` int(11) NOT NULL,
  `recipeName` varchar(255) NOT NULL,
  `instructions` varchar(5000) NOT NULL,
  `duration` int(11) NOT NULL,
  `difficultyID` varchar(10) NOT NULL COMMENT 'Id of the difficulty as stored in the Difficulties table'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Recipe`
--

INSERT INTO `Recipe` (`recipeID`, `recipeName`, `instructions`, `duration`, `difficultyID`) VALUES
(1, 'Lasagna', 'Preheat oven to 375 degrees F. Lightly oil the bottom of a 13 by 9 by 2-inch baking dish.\r\n\r\nIn a large saute pan, over medium-high heat, add 1 tablespoon oil and saute meat, onion, and garlic until meat is browned, breaking up meat with a wooden spoon. Drain pan of fat and add stewed tomatoes, tomato sauce, and tomato paste. Cover and simmer for 15 minutes, stirring occasionally.\r\n\r\nIn a large bowl, whisk together eggs, then mix in cottage cheese, 1/2 cup Parmesan, parsley, salt, pepper, and seasoning salt.\r\n\r\nSpread a little of the meat sauce in the bottom of the prepared pan. Lay half the noodles in the bottom of the baking dish, overlapping by 1/2-inch. Spread half the egg and cottage cheese mixture evenly on top. Sprinkle half the mozzarella and Cheddar evenly over the cottage cheese mixture. Pour half the meat sauce on top. Repeat layering in same order. Sprinkle remaining 1/4 cup Parmesan on top. Bake in center of oven 30 to 35 minutes until sauce is bubbling around the edges. Let stand 10 minutes before serving.', 120, 'm'),
(2, 'Curry', 'Peel the garlic and deseed the chillies, then roughly chop and place into a pestle and mortar. Bash to a rough paste with a good pinch of salt and pepper. Peel, finely chop and add the ginger, then bash to break it down.\r\n\r\nPeel and finely chop the onions. Heat a lug of oil in a large non-stick pan over a medium heat. Add the cinnamon, bay and cardamom, stir for a minute, then add the onions. Reduce the heat slightly and fry for 15 minutes, or until softened but not coloured.\r\n\r\nChop the chicken into 2.5cm chunks and add to the pan. Turn the heat up to medium, fry for a few minutes, then stir in the chilli paste. Cook for 2 minutes, add the remaining spices and mix well. Halve and roughly chop the tomatoes, then stir them into the pan.\r\n\r\nBring to the boil, reduce the heat to medium and simmer for around 15 minutes, or until the tomatoes have softened and broken down. Add the yoghurt and cook for a further 10 to 15 minutes, or until the chicken is tender and the sauce has thickened and reduced.\r\n\r\nPick, finely chop and stir in most of the coriander leaves, season to taste, then serve with a homemade naan, brown rice, a dollop of yoghurt and the remaining coriander leaves scattered on top.', 75, 'c');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `ID` text NOT NULL,
  `DisplayName` text NOT NULL,
  `PhoneNo` text NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`ID`, `DisplayName`, `PhoneNo`, `Password`) VALUES
('dalychea@ymail.com', 'Daly', '0987654321', '123'),
('hello@ymail.com', 'Hello', '098765567890', '111'),
('dalychea@ymail.com', 'Daly', '098765432', '123');

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
('g', 'gramm'),
('kg', 'kilogramm'),
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
  ADD PRIMARY KEY (`ingredientID`);

--
-- Indexes for table `IngredientsOfRecipe`
--
ALTER TABLE `IngredientsOfRecipe`
  ADD PRIMARY KEY (`ingredientsOfRecipeID`);

--
-- Indexes for table `Recipe`
--
ALTER TABLE `Recipe`
  ADD PRIMARY KEY (`recipeID`);

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
-- AUTO_INCREMENT for table `IngredientsOfRecipe`
--
ALTER TABLE `IngredientsOfRecipe`
  MODIFY `ingredientsOfRecipeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Recipe`
--
ALTER TABLE `Recipe`
  MODIFY `recipeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
