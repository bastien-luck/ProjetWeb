-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 09 nov. 2018 à 08:15
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_web`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `Sequence_Nextval`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sequence_Nextval` (OUT `preturn` BIGINT)  BEGIN
	INSERT INTO Sequences(description) VALUES ("nexval");
	SELECT LAST_INSERT_ID() INTO preturn;
	DELETE FROM Sequences;
END$$

--
-- Fonctions
--
DROP FUNCTION IF EXISTS `AddCommand`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AddCommand` (`pDelivery` INTEGER, `pPayment` INTEGER, `pClient` INTEGER) RETURNS VARCHAR(250) CHARSET utf8 MODIFIES SQL DATA
BEGIN
    DECLARE vAutoIncrement integer;
    DECLARE responseMessage NVARCHAR(250);
    
	DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        SET @responseMessage="ERROR";
        RETURN @responseMessage;
    END;
    
    CALL Sequence_Nextval(@a);
    SELECT @a INTO @vAutoIncrement;
	INSERT INTO Command(id_command, Delivery_addr, Payment_addr, Client) VALUES (CONCAT('c',CAST(@vAutoIncrement AS CHAR(16))) , pDelivery, pPayment, pClient);
	INSERT INTO Product_list(id_list) VALUES (CONCAT('c', CAST(@vAutoIncrement AS CHAR(16))));
	SET @responseMessage="SUCCESS";
	
	RETURN @responseMessage;

END$$

DROP FUNCTION IF EXISTS `AddFavorite`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AddFavorite` (`pClient` INTEGER) RETURNS VARCHAR(250) CHARSET utf8 MODIFIES SQL DATA
BEGIN
    DECLARE vAutoIncrement integer;
    DECLARE responseMessage NVARCHAR(250);
    
	DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        SET @responseMessage="ERROR";
	    RETURN @responseMessage;
    END;
    
    CALL Sequence_Nextval(@a);
    SELECT @a INTO @vAutoIncrement;
	INSERT INTO Favorites(id_fav, Client) VALUES (CONCAT('f',CAST(@vAutoIncrement AS CHAR(16))) , pClient);
	INSERT INTO Product_list(id_list) VALUES (CONCAT('f',CAST(@vAutoIncrement AS CHAR(16))));
	SET @responseMessage="SUCCESS";
	
	RETURN @responseMessage;

END$$

DROP FUNCTION IF EXISTS `AddUser`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AddUser` (`pName` NVARCHAR(128), `pFirst_name` NVARCHAR(128), `pMail` NVARCHAR(128), `pPsswd` NCHAR(128), `pTelephone` NVARCHAR(12), `pUser_permission` INTEGER, `pUser_sex` NCHAR(1), `pUser_Bday` DATE) RETURNS VARCHAR(250) CHARSET utf8 MODIFIES SQL DATA
BEGIN

    DECLARE vSalt NCHAR(32);
    DECLARE responseMessage NVARCHAR(250);
    
	DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        SET @responseMessage="ERROR";
        RETURN @responseMessage;
    END;
    
    SET @vSalt = CAST(UUID() AS NCHAR(32));

	INSERT INTO Users(Name, First_name, Mail, Psswd, Telephone, User_permission, User_sex, User_Bday, Salt) 
	VALUES(pName, pFirst_name, pMail, SHA1(CONCAT(pPsswd , @vSalt)), pTelephone, pUser_permission, pUser_sex, pUser_Bday, @vSalt);
	
	
	SET @responseMessage="SUCCESS";

    RETURN @responseMessage;
	
END$$

DROP FUNCTION IF EXISTS `Login`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `Login` (`pMail` NVARCHAR(128), `pPsswd` NVARCHAR(128)) RETURNS VARCHAR(250) CHARSET utf8 READS SQL DATA
    DETERMINISTIC
BEGIN
        DECLARE responseMessage NVARCHAR(250);
    	DECLARE userID integer;
    	
    	IF EXISTS (SELECT id_usr FROM Users WHERE Mail=pMail)
    	THEN
    	    SELECT id_usr INTO @userID FROM Users WHERE Mail=pMail AND Psswd=SHA1(CONCAT(pPsswd, CAST(Salt AS CHAR(32))));
    	    IF (@userID = NULL) THEN
           	    SET @responseMessage='ERROR';
       	    ELSE
           	    SET @responseMessage=@userID;
            END IF;
    	ELSE
       		SET @responseMessage='ERROR';
       	END IF;
       	
       	RETURN @responseMessage; 
       	
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id_addr` int(11) NOT NULL AUTO_INCREMENT,
  `Street` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `Additional` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `Postcode` int(11) DEFAULT NULL,
  `City` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `Country` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id_addr`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `addresses`
--

INSERT INTO `addresses` (`id_addr`, `Street`, `Additional`, `Postcode`, `City`, `Country`) VALUES
(1, '1 Rue de la ville', 'Local 3', 56000, 'Vannes', 'France'),
(2, 'a', 'a', 1, 'non', 'a'),
(3, '1 Rue de la ville', 'Local 3', 56000, 'Vannes', 'France');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `Description` varchar(512) CHARACTER SET utf8 DEFAULT NULL,
  `parent_category` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_cat`),
  KEY `FK_cat` (`parent_category`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_cat`, `Name`, `Description`, `parent_category`) VALUES
(1, 'parpaing', 'parpaing', 1);

-- --------------------------------------------------------

--
-- Structure de la table `client_addr`
--

DROP TABLE IF EXISTS `client_addr`;
CREATE TABLE IF NOT EXISTS `client_addr` (
  `Client` int(11) NOT NULL,
  `Address` int(11) NOT NULL,
  `Name` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`Client`,`Address`),
  KEY `FK_client_addr_a` (`Address`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client_addr`
--

INSERT INTO `client_addr` (`Client`, `Address`, `Name`) VALUES
(1, 1, 'Maison'),
(2, 3, 'Maison');

-- --------------------------------------------------------

--
-- Structure de la table `command`
--

DROP TABLE IF EXISTS `command`;
CREATE TABLE IF NOT EXISTS `command` (
  `id_command` varchar(16) CHARACTER SET utf8 NOT NULL,
  `Delivery_addr` int(11) DEFAULT NULL,
  `Payment_addr` int(11) DEFAULT NULL,
  `Client` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_command`),
  KEY `FK_command_delivery` (`Delivery_addr`),
  KEY `FK_command_payment` (`Payment_addr`),
  KEY `FK_command_client` (`Client`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `id_fav` varchar(16) CHARACTER SET utf8 NOT NULL,
  `Client` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_fav`),
  KEY `FK_fav` (`Client`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id_prod` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `Description` varchar(512) CHARACTER SET utf8 DEFAULT NULL,
  `Price` double DEFAULT NULL,
  `Stock` int(11) DEFAULT NULL,
  `Sales` double DEFAULT NULL,
  `Picture` varchar(512) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id_prod`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id_prod`, `Name`, `Description`, `Price`, `Stock`, `Sales`, `Picture`) VALUES
(1, 'Parpaing creux bÃ©ton', 'B40 15 x 20 x 50cm', 1000, NULL, NULL, 'parpaing1.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE IF NOT EXISTS `product_category` (
  `Product` int(11) NOT NULL,
  `Category` int(11) NOT NULL,
  PRIMARY KEY (`Product`,`Category`),
  KEY `FK_prod_cat_c` (`Category`),
  KEY `I_products` (`Product`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `product_category`
--

INSERT INTO `product_category` (`Product`, `Category`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `product_list`
--

DROP TABLE IF EXISTS `product_list`;
CREATE TABLE IF NOT EXISTS `product_list` (
  `id_list` varchar(16) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id_list`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `product_quantity`
--

DROP TABLE IF EXISTS `product_quantity`;
CREATE TABLE IF NOT EXISTS `product_quantity` (
  `list` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`list`,`product`),
  KEY `FK_prod_qty_prod` (`product`),
  KEY `I_passwords` (`list`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `sequences`
--

DROP TABLE IF EXISTS `sequences`;
CREATE TABLE IF NOT EXISTS `sequences` (
  `sequence_number` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(8) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`sequence_number`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_usr` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `First_name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `Mail` varchar(128) CHARACTER SET utf8 NOT NULL,
  `Psswd` char(128) CHARACTER SET utf8 NOT NULL,
  `Telephone` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `User_permission` int(11) NOT NULL,
  `User_sex` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `User_Bday` date DEFAULT NULL,
  `Salt` char(32) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id_usr`),
  UNIQUE KEY `Mail` (`Mail`),
  UNIQUE KEY `I_passwords` (`Mail`,`Psswd`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_usr`, `Name`, `First_name`, `Mail`, `Psswd`, `Telephone`, `User_permission`, `User_sex`, `User_Bday`, `Salt`) VALUES
(1, 'Le Falher', 'Antoine', 'admin@admin.fr', 'ce9875a1f889b3586402c86a8c10eff7a336b11b', '0123456789', 2, '2', '2018-11-06', 'cc7a21cc-e2ca-11e8-86bc-448a5ba2'),
(2, 'ClientN', 'ClientPr', 'client@client.fr', 'ff0fded2a70519bbf5da073c9c7c4e6225304870', '', 1, '1', '2018-11-07', '6a4f6943-e32d-11e8-9be1-448a5ba2');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
