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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- Descarcă datele pentru tabela oftadb.contact: ~3 rows (aproximativ)
DELETE FROM `contact`;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` (`id`, `nume`, `email`, `subiect`, `mesaj`) VALUES
	(11, 'Militaru Adrian', 'militaru.adrian@yahoo.com', 'Intrebare', 'Lucrati si in weekend?'),
	(13, 'Rominescu', 'Raluca', 'Multumesc', 'Vad foarte bine de la ultimul tratament!'),
	(46, 'spam', '', '', 'spaaaaaaaam'),
	(47, 'mesajjjjj', '', '', 'mesaj');
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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- Descarcă datele pentru tabela oftadb.pacienti: ~7 rows (aproximativ)
DELETE FROM `pacienti`;
/*!40000 ALTER TABLE `pacienti` DISABLE KEYS */;
INSERT INTO `pacienti` (`idpac`, `nume`, `prenume`, `cnp`, `datan`, `tel`, `email`) VALUES
	(20, 'Popescu', 'George', '1111111', '11-11-1966', '071111111', 'popescu.george@gmail.com'),
	(21, 'Mihaica', 'Andreea', '2222222', '22-10-1997', '0722222', 'mihaica.andreea@gmail.com'),
	(23, '  Blajovan', 'Bianca', '333333', '30-10-1997', '0723310171', 'bianca.blajovan@yahoo.com'),
	(34, 'Blajovan', 'Ana-Maria', '4444444', '06-03-2003', '0744444', 'ana.blajovan@yahoo.com'),
	(35, 'Seserman', 'Andra', '55555', '10-10-2010', '0755555', 'andra.seserman@gmail.com'),
	(36, 'Rominescu', 'Raluca', '666666', '12-03-1997', '07555555', 'raluca.rominescu@yahoo.com'),
	(42, 'Blajovan', 'Eugen', '7777777', '10-07-1966', '0766666', 'eugen.blajovan@gmail.com'),
	(49, 'hello', 'hello', '', '', '', 'hello@gmail.com'),
	(51, 'Antal', 'Alexandra', '', '', '', '');
/*!40000 ALTER TABLE `pacienti` ENABLE KEYS */;

-- Descarcă structura pentru tabelă oftadb.programari
CREATE TABLE IF NOT EXISTS `programari` (
  `idprog` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idpac` int(11) unsigned NOT NULL,
  `data` date NOT NULL,
  `ora` char(5) NOT NULL,
  PRIMARY KEY (`idprog`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;

-- Descarcă datele pentru tabela oftadb.programari: ~10 rows (aproximativ)
DELETE FROM `programari`;
/*!40000 ALTER TABLE `programari` DISABLE KEYS */;
INSERT INTO `programari` (`idprog`, `idpac`, `data`, `ora`) VALUES
	(93, 20, '2018-11-25', '13:00'),
	(94, 35, '2018-11-29', '13:30'),
	(97, 20, '2019-02-21', '13:30'),
	(99, 34, '2018-11-16', '13:30'),
	(100, 36, '2018-11-16', '09:00'),
	(101, 23, '2018-11-29', '13:00'),
	(106, 23, '2018-11-17', '11:30'),
	(107, 35, '2018-11-18', '14:30'),
	(109, 23, '2018-11-19', '13:30'),
	(110, 23, '2018-11-16', '15:00'),
	(111, 23, '2018-11-30', '13:30'),
	(112, 23, '2018-11-18', '15:00'),
	(113, 35, '2018-12-18', '13:00'),
	(115, 23, '2018-11-17', '13:30'),
	(116, 51, '2018-11-16', '14:00');
/*!40000 ALTER TABLE `programari` ENABLE KEYS */;

-- Descarcă structura pentru tabelă oftadb.utilizatori
CREATE TABLE IF NOT EXISTS `utilizatori` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `idpac` int(11) unsigned DEFAULT NULL,
  `itsadmin` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

-- Descarcă datele pentru tabela oftadb.utilizatori: ~9 rows (aproximativ)
DELETE FROM `utilizatori`;
/*!40000 ALTER TABLE `utilizatori` DISABLE KEYS */;
INSERT INTO `utilizatori` (`id`, `username`, `password`, `idpac`, `itsadmin`) VALUES
	(1, 'admin1', '$2y$10$8KMoxrQw2SwaFa2np1ow/eOeFHiVKd5FuAsemMe9BhI1JBL4x3oUi', NULL, 'Y'),
	(2, 'admin2', '$2y$10$m2WeQkYsbGj/j0bLbmXNaucmKzTC3mw06m6iJO0yY/KrEeUMrqUey', NULL, 'Y'),
	(32, 'george', '$2y$10$H8TwIq0ogvilG3owc/BWk.Ln9vJp7XdMi0gBCnMWFpFV9InGrPwOq', 20, 'N'),
	(33, 'andreea', '$2y$10$R.1e97DtzVr6u.95i7geiOoxu/4nLZZHkG2kDXitWZTHlvhrntgqi', 21, 'N'),
	(35, 'bianca', '$2y$10$By1oqqyK5pGQsHjteuxreuMXpEZ4J7aKgw7GmYeR8Xun9dIymzD3W', 23, 'N'),
	(46, 'anam', '$2y$10$wAmwW89nDpATkWSg7efJAOQhvVwbw/E9KVyN/scDbnEuMiF97Usr.', 34, 'N'),
	(47, 'andra', '$2y$10$JZDKzSTrl5pgn6B3KN32PO3dRE7TpJ6QXIcn.COSaJW7xWvsxvxbu', 35, 'N'),
	(48, 'raluca', '$2y$10$U2x2s6p4tdIyKuL3q3ihIOeOf44qSuKphnqZ.1i5huxbKUnZj0AEa', 36, 'N'),
	(54, 'eugen', '$2y$10$ZPWaQXeD7T8OnpaWgKmrR.z8mvYBbdlAW.EnWu4CnJ.FbA/tV6FAu', 42, 'N'),
	(61, '111111', '$2y$10$GFyo8TBiy5O76frX/O83re0QYF/p9vzSPdvTVEevd9Hay67tQOtxS', 49, 'N'),
	(63, 'alexandra', '$2y$10$zigAe.6X9r4PHz4wADxAjugmsFCGmDjkE9HBtzIHXWkwEf25bq/HO', 51, 'N');
/*!40000 ALTER TABLE `utilizatori` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
