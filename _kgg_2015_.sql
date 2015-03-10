-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 22, 2015 at 11:45 AM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `_kgg_2015_`
--

-- --------------------------------------------------------

--
-- Table structure for table `duyurular`
--

CREATE TABLE IF NOT EXISTS `duyurular` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metin` varchar(5000) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `duyurular`
--

INSERT INTO `duyurular` (`id`, `metin`, `timestamp`) VALUES
(11, 'Ayhan is here!', '2015-02-10 19:58:45'),
(12, 'Kuş yuvaya iniş yaptı gençler.', '2015-02-10 19:58:49'),
(14, 'Bilmem nerdeki oturumumuz bilmem nereye alınmıştır.', '2015-02-10 20:42:15'),
(15, 'Başka bir duyuru yapıyoz.', '2015-02-10 20:56:12'),
(16, 'Speech is the vocalized form of human communication. It is based upon the syntactic combination of lexicals and names that are drawn from very large (usually about 10,000 different words) vocabularies.', '2015-02-10 20:56:36'),
(18, 'asdf', '2015-02-21 18:34:00'),
(19, 'I come before you tonight as a candidate for the Vice Presidency and as a man whose honesty and -- and integrity has been questioned.', '2015-02-21 19:01:30'),
(20, 'It is the storyteller''s job to make the world around us understandable. ', '2015-02-21 19:02:44');

-- --------------------------------------------------------

--
-- Table structure for table `katilimcilar`
--

CREATE TABLE IF NOT EXISTS `katilimcilar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isim` varchar(100) NOT NULL,
  `kurum` varchar(100) NOT NULL,
  `bolum` varchar(100) DEFAULT NULL,
  `sinif` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `zaman` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `katilimcilar`
--

INSERT INTO `katilimcilar` (`id`, `isim`, `kurum`, `bolum`, `sinif`, `email`, `zaman`) VALUES
(1, 'Baskın Burak Şenbaşlar', 'ODTÜ', 'Bilgisayar Mühendisliği', '2', 'basbursen@gmail.com', '2015-02-10 22:26:01'),
(2, 'asdf', 'ODTÜ', 'asdf@asd', 'Hazırlık', 'asdf@asd.co', '2015-02-21 18:09:34'),
(3, 'jobbala', 'ODTÜ', 'jobo', 'Hazırlık', 'jobo@job.job', '2015-02-21 19:13:12'),
(4, '123', 'ODTÜ', '123', 'Hazırlık', '123@123.123', '2015-02-21 21:43:29'),
(5, '123', 'ODTÜ', '123', 'Hazırlık', '123@123.123', '2015-02-21 21:43:58');

-- --------------------------------------------------------

--
-- Table structure for table `katilimci_oturum`
--

CREATE TABLE IF NOT EXISTS `katilimci_oturum` (
  `katilimciid` int(11) NOT NULL,
  `oturumid` int(11) NOT NULL,
  PRIMARY KEY (`katilimciid`,`oturumid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `katilimci_oturum`
--

INSERT INTO `katilimci_oturum` (`katilimciid`, `oturumid`) VALUES
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 9),
(1, 15),
(1, 17),
(2, 5),
(2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `oturumlar`
--

CREATE TABLE IF NOT EXISTS `oturumlar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oturum_isim` varchar(100) NOT NULL,
  `veren_isim` varchar(100) NOT NULL,
  `veren_unvan` varchar(100) NOT NULL,
  `salon` char(2) NOT NULL,
  `zaman` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `oturumlar`
--

-- --------------------------------------------------------

--
-- Table structure for table `print_queue`
--

CREATE TABLE IF NOT EXISTS `print_queue` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
