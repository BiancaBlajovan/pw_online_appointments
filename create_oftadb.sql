-- --------------------------------------------------------
-- Server:                       127.0.0.1
-- Versiune server:              10.1.36-MariaDB - mariadb.org binary distribution
-- SO server:                    Win32
-- HeidiSQL Versiune:            9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Descarcă structura bazei de date pentru oftadb
CREATE DATABASE IF NOT EXISTS `oftadb` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `oftadb`;

-- Descarcă structura pentru tabelă oftadb.consultatii
CREATE TABLE IF NOT EXISTS `consultatii` (
  `idcons` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idpac` int(11) unsigned NOT NULL DEFAULT '0',
  `data` date NOT NULL,
  `observatii` varchar(300) DEFAULT NULL,
  `dp` int(3) NOT NULL,
  `diagnostic` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`idcons`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Descarcă datele pentru tabela oftadb.consultatii: ~2 rows (aproximativ)
DELETE FROM `consultatii`;
/*!40000 ALTER TABLE `consultatii` DISABLE KEYS */;
INSERT INTO `consultatii` (`idcons`, `idpac`, `data`, `observatii`, `dp`, `diagnostic`) VALUES
	(1, 1, '2018-10-06', 'ft bine', 60, 'miopie'),
	(2, 2, '2018-10-07', 'nu vede', 10, 'hipermetropie');
/*!40000 ALTER TABLE `consultatii` ENABLE KEYS */;

-- Descarcă structura pentru tabelă oftadb.consultatii_detalii
CREATE TABLE IF NOT EXISTS `consultatii_detalii` (
  `idcons` int(11) unsigned NOT NULL,
  `tip` enum('D','A','L') NOT NULL,
  `ochi` enum('D','S') NOT NULL,
  `sfera` float DEFAULT NULL,
  `cilindru` float DEFAULT NULL,
  `axa` int(10) unsigned DEFAULT NULL,
  `prisma` float unsigned DEFAULT NULL,
  `baza` int(11) unsigned DEFAULT NULL,
  `rc` int(11) DEFAULT NULL,
  `diametru` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`idcons`,`tip`,`ochi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Descarcă datele pentru tabela oftadb.consultatii_detalii: ~8 rows (aproximativ)
DELETE FROM `consultatii_detalii`;
/*!40000 ALTER TABLE `consultatii_detalii` DISABLE KEYS */;
INSERT INTO `consultatii_detalii` (`idcons`, `tip`, `ochi`, `sfera`, `cilindru`, `axa`, `prisma`, `baza`, `rc`, `diametru`) VALUES
	(1, 'D', 'D', -4.25, NULL, NULL, NULL, NULL, NULL, NULL),
	(1, 'D', 'S', -4, -0.5, 10, NULL, NULL, NULL, NULL),
	(1, 'L', 'D', -4, NULL, NULL, NULL, NULL, NULL, NULL),
	(1, 'L', 'S', -4, NULL, NULL, NULL, NULL, NULL, NULL),
	(2, 'A', 'D', -4.25, NULL, NULL, NULL, NULL, NULL, NULL),
	(2, 'A', 'S', -4, -0.5, 10, NULL, NULL, NULL, NULL),
	(2, 'L', 'D', -4, NULL, NULL, NULL, NULL, NULL, NULL),
	(2, 'L', 'S', -4, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `consultatii_detalii` ENABLE KEYS */;

-- Descarcă structura pentru tabelă oftadb.contact
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subiect` varchar(100) DEFAULT NULL,
  `mesaj` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Descarcă datele pentru tabela oftadb.contact: ~0 rows (aproximativ)
DELETE FROM `contact`;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;

-- Descarcă structura pentru tabelă oftadb.pacienti
CREATE TABLE IF NOT EXISTS `pacienti` (
  `idpac` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nume` varchar(50) NOT NULL,
  `prenume` varchar(50) NOT NULL,
  `cnp` varchar(13) NOT NULL,
  `datan` varchar(10) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`idpac`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Descarcă datele pentru tabela oftadb.pacienti: ~6 rows (aproximativ)
DELETE FROM `pacienti`;
/*!40000 ALTER TABLE `pacienti` DISABLE KEYS */;
/*!40000 ALTER TABLE `pacienti` ENABLE KEYS */;

-- Descarcă structura pentru tabelă oftadb.programari
CREATE TABLE IF NOT EXISTS `programari` (
  `idprog` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idpac` int(11) unsigned NOT NULL,
  `data` date NOT NULL,
  `ora` char(5) NOT NULL,
  PRIMARY KEY (`idprog`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- Descarcă datele pentru tabela oftadb.programari: ~0 rows (aproximativ)
DELETE FROM `programari`;
/*!40000 ALTER TABLE `programari` DISABLE KEYS */;
/*!40000 ALTER TABLE `programari` ENABLE KEYS */;

-- Descarcă structura pentru tabelă oftadb.utilizatori
CREATE TABLE IF NOT EXISTS `utilizatori` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `idpac` int(11) unsigned DEFAULT NULL,
  `itsadmin` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- Descarcă datele pentru tabela oftadb.utilizatori: ~0 rows (aproximativ)
DELETE FROM `utilizatori`;
/*!40000 ALTER TABLE `utilizatori` DISABLE KEYS */;
INSERT INTO `utilizatori` (`id`, `username`, `password`, `idpac`, `itsadmin`) VALUES
	(1, 'admin1', '$2y$10$8KMoxrQw2SwaFa2np1ow/eOeFHiVKd5FuAsemMe9BhI1JBL4x3oUi', NULL, 'Y'),
	(2, 'admin2', '$2y$10$m2WeQkYsbGj/j0bLbmXNaucmKzTC3mw06m6iJO0yY/KrEeUMrqUey', NULL, 'Y');
/*!40000 ALTER TABLE `utilizatori` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
