-- MySQL dump 10.13  Distrib 5.1.63, for pc-linux-gnu (i686)
--
-- Host: localhost    Database: k7878351_dinua
-- ------------------------------------------------------
-- Server version	5.1.63-cll

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `email` varchar(120) DEFAULT '',
  `password` varchar(200) DEFAULT NULL,
  `created` int(11) DEFAULT '0',
  `gender` enum('M','F') DEFAULT NULL,
  `avatar` varchar(300) DEFAULT 'uploads/avatars/',
  `realname` varchar(25) DEFAULT NULL,
  `about_me` varchar(200) DEFAULT NULL,
  `birthday` int(11) DEFAULT NULL,
  `country` varchar(50) DEFAULT 'Indonesia',
  `city` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `occupation` varchar(25) DEFAULT NULL,
  `work_at` varchar(25) DEFAULT NULL,
  `settings` text,
  `disabled` tinyint(1) DEFAULT '2',
  `lastlogin` int(11) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `salt` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=417 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

--
-- Temporary table structure for view `accounts_active`
--

DROP TABLE IF EXISTS `accounts_active`;
/*!50001 DROP VIEW IF EXISTS `accounts_active`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `accounts_active` (
  `id` int(9),
  `email` varchar(120),
  `password` varchar(200),
  `created` int(11),
  `gender` enum('M','F'),
  `avatar` varchar(300),
  `realname` varchar(25),
  `about_me` varchar(200),
  `birthday` int(11),
  `country` varchar(50),
  `city` varchar(50),
  `address` varchar(100),
  `occupation` varchar(25),
  `work_at` varchar(25),
  `settings` text,
  `disabled` tinyint(1),
  `lastlogin` int(11),
  `ip` varchar(16),
  `salt` varchar(10)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `admin_accounts`
--

DROP TABLE IF EXISTS `admin_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_accounts` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(120) DEFAULT '',
  `password` varchar(32) DEFAULT NULL,
  `created` int(11) DEFAULT '0',
  `realname` varchar(30) DEFAULT NULL,
  `gender` enum('M','F') DEFAULT NULL,
  `avatar` int(11) DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT NULL,
  `lastlogin` int(11) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `level` enum('A','E','O') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_accounts`
--

LOCK TABLES `admin_accounts` WRITE;
/*!40000 ALTER TABLE `admin_accounts` DISABLE KEYS */;
INSERT INTO `admin_accounts` (`id`, `username`, `password`, `created`, `realname`, `gender`, `avatar`, `disabled`, `lastlogin`, `ip`, `level`) VALUES (2,'admin','d46744722b3d363d8bad0a78657449ba',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `admin_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `captcha`
--

DROP TABLE IF EXISTS `captcha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `captcha` (
  `captcha_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `captcha`
--

LOCK TABLES `captcha` WRITE;
/*!40000 ALTER TABLE `captcha` DISABLE KEYS */;
/*!40000 ALTER TABLE `captcha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) DEFAULT NULL,
  `tid` int(9) DEFAULT NULL,
  `message` varchar(200) DEFAULT NULL,
  `content` enum('S','E','N','I','EA','NA','IA') DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT NULL,
  `ext` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comments_accounts` (`uid`),
  CONSTRAINT `FK_comments_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=360 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

--
-- Table structure for table `ebook_albums`
--

DROP TABLE IF EXISTS `ebook_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ebook_albums` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) DEFAULT NULL,
  `name` varchar(50) DEFAULT 'Belum ada judul',
  `des` varchar(200) DEFAULT NULL,
  `thumb` varchar(100) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `disabled` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ebook_albums_accounts` (`uid`),
  CONSTRAINT `FK_ebook_albums_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ebook_albums`
--

LOCK TABLES `ebook_albums` WRITE;
/*!40000 ALTER TABLE `ebook_albums` DISABLE KEYS */;
INSERT INTO `ebook_albums` (`id`, `uid`, `name`, `des`, `thumb`, `created`, `disabled`) VALUES (8,336,'contoh','',NULL,1336353867,NULL),(9,335,'Buku Elektronik','Ini untuk test',NULL,1336561862,NULL),(10,328,'E-book','',NULL,1336747237,NULL),(11,328,'E-book','',NULL,1336747239,NULL);
/*!40000 ALTER TABLE `ebook_albums` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_upd_ebookalbums` BEFORE UPDATE ON `ebook_albums` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							UPDATE dan HAPUS E-BOOK ALBUMS
================================================================*/
/*update ebook*/
UPDATE  comments, ebook_albums SET tid=NEW.id WHERE tid=OLD.id AND comments.content='EA'; 

/*update like*/
UPDATE  likes, ebook_albums SET tid=NEW.id WHERE tid=OLD.id AND likes.content='EA'; 

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_del_ebookalbums` BEFORE DELETE ON `ebook_albums` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							HAPUS E-BOOK ALBUMS
================================================================*/
/*delete ebook albums*/

/*hapus ebooknya dulu*/
DELETE FROM  ebooks WHERE aid=old.id; 

/*hapus komentarnya*/
DELETE FROM  comments WHERE tid=old.id AND comments.content='EA'; 

/*hapus LIKES*/
DELETE FROM  likes WHERE tid=old.id AND likes.content='EA'; 
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ebooks`
--

DROP TABLE IF EXISTS `ebooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ebooks` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `aid` int(9) DEFAULT NULL,
  `uid` int(9) DEFAULT NULL,
  `name` varchar(50) DEFAULT 'Belum ada judul',
  `des` varchar(200) DEFAULT 'Belum ada deskripsi',
  `url` varchar(100) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `disabled` int(1) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ebooks_ebook_albums` (`aid`),
  KEY `FK_ebooks_accounts` (`uid`),
  CONSTRAINT `FK_ebooks_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`),
  CONSTRAINT `FK_ebooks_ebook_albums` FOREIGN KEY (`aid`) REFERENCES `ebook_albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ebooks`
--

LOCK TABLES `ebooks` WRITE;
/*!40000 ALTER TABLE `ebooks` DISABLE KEYS */;
INSERT INTO `ebooks` (`id`, `aid`, `uid`, `name`, `des`, `url`, `created`, `disabled`, `pages`) VALUES (1,9,335,'Belum ada judul','Belum ada deskripsi','bbe920bb1cef6ba3b4a7f084cd36c27d.pdf',1336562829,NULL,NULL),(2,9,335,'Belum ada judul','Hei','3d5959a6d6463da37befc6df10615b29.pdf',1342668140,NULL,NULL);
/*!40000 ALTER TABLE `ebooks` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_upd_ebooks` BEFORE UPDATE ON `ebooks` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							UPDATE E-BOOK
================================================================*/
/*update comments*/
UPDATE  comments, ebooks SET tid=NEW.id WHERE tid=OLD.id AND comments.content='E'; 

/*update likes*/
UPDATE  likes, ebooks SET tid=NEW.id WHERE tid=OLD.id AND likes.content='E'; 

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_del_ebooks` BEFORE DELETE ON `ebooks` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							HAPUS E-BOOK
================================================================*/
/*delete comments*/
DELETE FROM  comments WHERE tid=old.id AND comments.content='E'; 

/*delete likes*/
DELETE FROM  likes WHERE tid=old.id AND likes.content='E'; 

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `followers`
--

DROP TABLE IF EXISTS `followers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `followers` (
  `uid` int(9) DEFAULT NULL,
  `tid` int(9) DEFAULT NULL,
  `created` int(11) DEFAULT '0',
  `disabled` int(1) DEFAULT NULL,
  KEY `FK_followers_accounts` (`uid`),
  KEY `FK_followers_accounts_2` (`tid`),
  CONSTRAINT `FK_followers_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_followers_accounts_2` FOREIGN KEY (`tid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `followers`
--

LOCK TABLES `followers` WRITE;
/*!40000 ALTER TABLE `followers` DISABLE KEYS */;
/*!40000 ALTER TABLE `followers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forbiden_words`
--

DROP TABLE IF EXISTS `forbiden_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forbiden_words` (
  `category` int(1) NOT NULL DEFAULT '0',
  `words` text,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forbiden_words`
--

LOCK TABLES `forbiden_words` WRITE;
/*!40000 ALTER TABLE `forbiden_words` DISABLE KEYS */;
INSERT INTO `forbiden_words` (`category`, `words`, `updated`) VALUES (1,'bugil;telanjang;kontol;memek;asu;sex;sundel',NULL),(2,'anjing;babi;monyet;setan',NULL);
/*!40000 ALTER TABLE `forbiden_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friend_requests`
--

DROP TABLE IF EXISTS `friend_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friend_requests` (
  `uid` int(9) DEFAULT '0',
  `tid` int(9) DEFAULT '0',
  `type` char(1) DEFAULT NULL,
  `created` int(11) DEFAULT '0',
  `msg` varchar(200) DEFAULT NULL,
  `ignored` int(1) DEFAULT NULL,
  KEY `FK_friend_requests_accounts` (`uid`),
  KEY `FK_friend_requests_accounts_2` (`tid`),
  CONSTRAINT `FK_friend_requests_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_friend_requests_accounts_2` FOREIGN KEY (`tid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend_requests`
--

LOCK TABLES `friend_requests` WRITE;
/*!40000 ALTER TABLE `friend_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `friend_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `uid` int(9) DEFAULT '0',
  `tid` int(9) DEFAULT '0',
  `type` char(2) DEFAULT NULL,
  `created` int(11) DEFAULT '0',
  `disabled` int(1) DEFAULT NULL,
  KEY `FK_friends_accounts` (`uid`),
  KEY `FK_friends_accounts_2` (`tid`),
  CONSTRAINT `FK_friends_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_friends_accounts_2` FOREIGN KEY (`tid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` (`uid`, `tid`, `type`, `created`, `disabled`) VALUES (327,326,'Y',1336189773,NULL),(336,335,'Y',1336353331,NULL),(335,339,'Y',1336359860,NULL),(335,337,'RQ',1336359870,NULL),(335,340,'Y',1336360262,NULL),(335,341,'RQ',1336367332,NULL),(335,350,'Y',1336369054,NULL),(335,328,'Y',1336369256,NULL),(350,340,'Y',1336370438,NULL),(351,335,'Y',1336370441,NULL),(335,353,'Y',1336374467,NULL),(353,327,'RQ',1336374874,NULL),(350,327,'RQ',1336375222,NULL),(335,352,'Y',1336375519,NULL),(336,340,'Y',1336377109,NULL),(336,351,'RQ',1336377118,NULL),(336,353,'Y',1336377129,NULL),(336,328,'Y',1336377132,NULL),(336,350,'Y',1336377154,NULL),(336,339,'RQ',1336377174,NULL),(354,328,'Y',1336377465,NULL),(354,340,'Y',1336377476,NULL),(354,341,'RQ',1336377490,NULL),(354,353,'Y',1336377795,NULL),(352,336,'Y',1336378561,NULL),(352,337,'RQ',1336378609,NULL),(335,354,'RQ',1336378846,NULL),(335,355,'RQ',1336378857,NULL),(335,327,'RQ',1336379955,NULL),(335,358,'RQ',1336382775,NULL),(340,328,'Y',1336383032,NULL),(340,352,'RQ',1336383087,NULL),(360,328,'Y',1336398802,NULL),(360,352,'RQ',1336398807,NULL),(360,340,'Y',1336398816,NULL),(360,358,'RQ',1336398817,NULL),(360,350,'Y',1336398827,NULL),(360,354,'RQ',1336398828,NULL),(360,353,'Y',1336399028,NULL),(360,335,'Y',1336399029,NULL),(335,361,'Y',1336438194,NULL),(336,359,'RQ',1336440206,NULL),(336,358,'RQ',1336440242,NULL),(350,361,'Y',1336459078,NULL),(340,361,'RQ',1336626052,NULL),(335,369,'RQ',1336653055,NULL),(335,367,'RQ',1336653083,NULL),(335,368,'RQ',1336657050,NULL),(353,369,'RQ',1336723697,NULL),(353,361,'RQ',1336723744,NULL),(335,371,'RQ',1336900878,NULL),(336,354,'RQ',1337052657,NULL),(336,367,'RQ',1337052783,NULL),(336,355,'RQ',1337052804,NULL),(335,326,'RQ',1337063934,NULL),(350,353,'RQ',1337186382,NULL),(373,360,'RQ',1337239149,NULL),(373,335,'Y',1337239161,NULL),(373,353,'RQ',1337239171,NULL),(373,336,'Y',1337239188,NULL),(373,350,'Y',1337239220,NULL),(373,361,'RQ',1337239234,NULL),(335,374,'RQ',1337313866,NULL),(376,359,'RQ',1337331914,NULL),(376,328,'Y',1337331939,NULL),(376,375,'Y',1337331958,NULL),(376,351,'RQ',1337331989,NULL),(377,376,'RQ',1337396878,NULL),(335,377,'RQ',1337559697,NULL),(335,379,'RQ',1337825090,NULL),(335,376,'RQ',1337825129,NULL),(380,361,'RQ',1338266351,NULL),(335,380,'RQ',1338450433,NULL),(375,360,'RQ',1338469256,NULL),(384,351,'RQ',1338965958,NULL),(375,328,'Y',1339035724,NULL),(335,375,'Y',1340141542,NULL),(335,394,'Y',1340146465,NULL),(335,384,'RQ',1341035423,NULL),(403,394,'RQ',1341295271,NULL),(406,373,'RQ',1341431587,NULL),(406,350,'RQ',1341431624,NULL),(406,340,'RQ',1341431700,NULL),(406,335,'Y',1341431757,NULL),(406,354,'RQ',1341432146,NULL),(406,353,'RQ',1341432164,NULL),(406,360,'RQ',1341432246,NULL),(411,335,'Y',1342352822,NULL),(335,401,'RQ',1342661594,NULL),(413,335,'Y',1342669783,NULL),(416,376,'RQ',1343662621,NULL),(335,408,'RQ',1343822076,NULL);
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_categories`
--

DROP TABLE IF EXISTS `group_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_categories` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `des` varchar(200) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_categories`
--

LOCK TABLES `group_categories` WRITE;
/*!40000 ALTER TABLE `group_categories` DISABLE KEYS */;
INSERT INTO `group_categories` (`id`, `name`, `des`, `created`, `disabled`) VALUES (1,'Fisika',NULL,NULL,NULL),(2,'Kimia',NULL,NULL,NULL);
/*!40000 ALTER TABLE `group_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_sections`
--

DROP TABLE IF EXISTS `group_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_sections` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `ctgr_id` int(9) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `des` varchar(200) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_group_sections_group_categories` (`ctgr_id`),
  CONSTRAINT `FK_group_sections_group_categories` FOREIGN KEY (`ctgr_id`) REFERENCES `group_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_sections`
--

LOCK TABLES `group_sections` WRITE;
/*!40000 ALTER TABLE `group_sections` DISABLE KEYS */;
INSERT INTO `group_sections` (`id`, `ctgr_id`, `name`, `des`, `created`, `disabled`) VALUES (1,1,'fisika kelas X',NULL,NULL,NULL);
/*!40000 ALTER TABLE `group_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `sect_id` int(9) DEFAULT '0',
  `name` varchar(50) DEFAULT '',
  `des` varchar(200) DEFAULT NULL,
  `open` tinyint(1) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `image` int(11) DEFAULT NULL,
  `settings` text,
  `moderators` varchar(200) DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_groups_group_sections` (`sect_id`),
  CONSTRAINT `FK_groups_group_sections` FOREIGN KEY (`sect_id`) REFERENCES `group_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `help`
--

DROP TABLE IF EXISTS `help`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `help` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `section` varchar(200) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `content` text,
  `created` int(11) DEFAULT NULL,
  `reds` int(11) DEFAULT NULL,
  `disabled` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `help`
--

LOCK TABLES `help` WRITE;
/*!40000 ALTER TABLE `help` DISABLE KEYS */;
/*!40000 ALTER TABLE `help` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) DEFAULT NULL,
  `tid` int(9) DEFAULT NULL,
  `content` enum('S','E','N','I','EA','NA','IA') DEFAULT NULL,
  `created` char(1) DEFAULT NULL,
  `ext` varchar(20) DEFAULT NULL,
  `disabled` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_likes_accounts` (`uid`),
  CONSTRAINT `FK_likes_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` (`id`, `uid`, `tid`, `content`, `created`, `ext`, `disabled`) VALUES (10,326,49,'S','1',NULL,NULL),(11,326,48,'S','1',NULL,NULL),(12,335,50,'S','1',NULL,NULL),(13,336,51,'S','1',NULL,NULL),(14,336,50,'S','1',NULL,NULL),(15,339,54,'S','1',NULL,NULL),(16,335,54,'S','1',NULL,NULL),(18,336,52,'S','1',NULL,NULL),(19,354,61,'S','1',NULL,NULL),(20,340,61,'S','1',NULL,NULL),(21,340,62,'S','1',NULL,NULL),(22,328,64,'S','1',NULL,NULL),(23,350,55,'S','1',NULL,NULL),(26,335,67,'S','1',NULL,NULL),(27,350,72,'S','1',NULL,NULL),(34,335,73,'S','1',NULL,NULL),(35,335,53,'S','1',NULL,NULL),(36,336,65,'S','1',NULL,NULL),(37,361,73,'S','1',NULL,NULL),(38,340,69,'S','1',NULL,NULL),(39,335,162,'S','1',NULL,NULL),(40,353,164,'S','1',NULL,NULL),(41,328,66,'S','1',NULL,NULL),(42,340,165,'S','1',NULL,NULL),(43,372,184,'S','1',NULL,NULL),(45,376,65,'S','1',NULL,NULL),(46,376,66,'S','1',NULL,NULL),(47,376,59,'S','1',NULL,NULL),(48,335,196,'S','1',NULL,NULL),(49,335,195,'S','1',NULL,NULL),(50,384,186,'S','1',NULL,NULL),(51,384,186,'S','1',NULL,NULL),(52,340,200,'S','1',NULL,NULL),(53,403,219,'S','1',NULL,NULL),(54,406,222,'S','1',NULL,NULL),(55,406,212,'S','1',NULL,NULL),(56,406,226,'S','1',NULL,NULL),(57,406,70,'S','1',NULL,NULL),(58,416,229,'S','1',NULL,NULL),(59,416,230,'S','1',NULL,NULL);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lookup`
--

DROP TABLE IF EXISTS `lookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lookup` (
  `type` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lookup`
--

LOCK TABLES `lookup` WRITE;
/*!40000 ALTER TABLE `lookup` DISABLE KEYS */;
INSERT INTO `lookup` (`type`, `code`, `value`) VALUES ('countrycode','GBR','United Kingdom'),('countrycode','USA','United States'),('countrycode','AUS','Australia'),('countrycode','CAN','Canada'),('countrycode','AFG','Afghanistan'),('countrycode','ALB','Albania'),('countrycode','DZA','Algeria'),('countrycode','ASM','American Samoa'),('countrycode','AND','Andorra'),('countrycode','AGO','Angola'),('countrycode','AIA','Anguilla'),('countrycode','ATA','Antarctica'),('countrycode','ATG','Antigua and Barbuda'),('countrycode','ARG','Argentina'),('countrycode','ARM','Armenia'),('countrycode','ABW','Aruba'),('countrycode','AUT','Austria'),('countrycode','AZE','Azerbaijan'),('countrycode','BHS','Bahamas'),('countrycode','BHR','Bahrain'),('countrycode','BGD','Bangladesh'),('countrycode','BRB','Barbados'),('countrycode','BLR','Belarus'),('countrycode','BEL','Belgium'),('countrycode','BLZ','Belize'),('countrycode','BEN','Benin'),('countrycode','BMU','Bermuda'),('countrycode','BTN','Bhutan'),('countrycode','BOL','Bolivia'),('countrycode','BIH','Bosnia and Herzegowina'),('countrycode','BWA','Botswana'),('countrycode','BVT','Bouvet Island'),('countrycode','BRA','Brazil'),('countrycode','IOT','British Indian Ocean Terr.'),('countrycode','BRN','Brunei Darussalam'),('countrycode','BGR','Bulgaria'),('countrycode','BFA','Burkina Faso'),('countrycode','BDI','Burundi'),('countrycode','KHM','Cambodia'),('countrycode','CMR','Cameroon'),('countrycode','CPV','Cape Verde'),('countrycode','CYM','Cayman Islands'),('countrycode','CAF','Central African Republic'),('countrycode','TCD','Chad'),('countrycode','CHL','Chile'),('countrycode','CHN','China'),('countrycode','CXR','Christmas Island'),('countrycode','CCK','Cocos (Keeling); Islands'),('countrycode','COL','Colombia'),('countrycode','COM','Comoros'),('countrycode','COG','Congo'),('countrycode','COK','Cook Islands'),('countrycode','CRI','Costa Rica'),('countrycode','CIV','Cote d`Ivoire'),('countrycode','HRV','Croatia (Hrvatska);'),('countrycode','CUB','Cuba'),('countrycode','CYP','Cyprus'),('countrycode','CZE','Czech Republic'),('countrycode','DNK','Denmark'),('countrycode','DJI','Djibouti'),('countrycode','DMA','Dominica'),('countrycode','DOM','Dominican Republic'),('countrycode','TMP','East Timor'),('countrycode','ECU','Ecuador'),('countrycode','EGY','Egypt'),('countrycode','SLV','El Salvador'),('countrycode','GNQ','Equatorial Guinea'),('countrycode','ERI','Eritrea'),('countrycode','EST','Estonia'),('countrycode','ETH','Ethiopia'),('countrycode','FLK','Falkland Islands/Malvinas'),('countrycode','FRO','Faroe Islands'),('countrycode','FJI','Fiji'),('countrycode','FIN','Finland'),('countrycode','FRA','France'),('countrycode','FXX','France, Metropolitan'),('countrycode','GUF','French Guiana'),('countrycode','PYF','French Polynesia'),('countrycode','ATF','French Southern Terr.'),('countrycode','GAB','Gabon'),('countrycode','GMB','Gambia'),('countrycode','GEO','Georgia'),('countrycode','DEU','Germany'),('countrycode','GHA','Ghana'),('countrycode','GIB','Gibraltar'),('countrycode','GRC','Greece'),('countrycode','GRL','Greenland'),('countrycode','GRD','Grenada'),('countrycode','GLP','Guadeloupe'),('countrycode','GUM','Guam'),('countrycode','GTM','Guatemala'),('countrycode','GIN','Guinea'),('countrycode','GNB','Guinea-Bissau'),('countrycode','GUY','Guyana'),('countrycode','HTI','Haiti'),('countrycode','HMD','Heard & McDonald Is.'),('countrycode','HND','Honduras'),('countrycode','HKG','Hong Kong'),('countrycode','HUN','Hungary'),('countrycode','ISL','Iceland'),('countrycode','IND','India'),('countrycode','IDN','Indonesia'),('countrycode','IRN','Iran'),('countrycode','IRQ','Iraq'),('countrycode','IRL','Ireland'),('countrycode','ISR','Israel'),('countrycode','ITA','Italy'),('countrycode','JAM','Jamaica'),('countrycode','JPN','Japan'),('countrycode','JOR','Jordan'),('countrycode','KAZ','Kazakhstan'),('countrycode','KEN','Kenya'),('countrycode','KIR','Kiribati'),('countrycode','PRK','Korea, North'),('countrycode','KOR','Korea, South'),('countrycode','KWT','Kuwait'),('countrycode','KGZ','Kyrgyzstan'),('countrycode','LAO','Lao People`s Dem. Rep.'),('countrycode','LVA','Latvia'),('countrycode','LBN','Lebanon'),('countrycode','LSO','Lesotho'),('countrycode','LBR','Liberia'),('countrycode','LBY','Libyan Arab Jamahiriya'),('countrycode','LIE','Liechtenstein'),('countrycode','LTU','Lithuania'),('countrycode','LUX','Luxembourg'),('countrycode','MAC','Macau'),('countrycode','MKD','Macedonia'),('countrycode','MDG','Madagascar'),('countrycode','MWI','Malawi'),('countrycode','MYS','Malaysia'),('countrycode','MDV','Maldives'),('countrycode','MLI','Mali'),('countrycode','MLT','Malta'),('countrycode','MHL','Marshall Islands'),('countrycode','MTQ','Martinique'),('countrycode','MRT','Mauritania'),('countrycode','MUS','Mauritius'),('countrycode','MYT','Mayotte'),('countrycode','MEX','Mexico'),('countrycode','FSM','Micronesia'),('countrycode','MDA','Moldova'),('countrycode','MCO','Monaco'),('countrycode','MNG','Mongolia'),('countrycode','MSR','Montserrat'),('countrycode','MAR','Morocco'),('countrycode','MOZ','Mozambique'),('countrycode','MMR','Myanmar'),('countrycode','NAM','Namibia'),('countrycode','NRU','Nauru'),('countrycode','NPL','Nepal'),('countrycode','NLD','Netherlands'),('countrycode','ANT','Netherlands Antilles'),('countrycode','NCL','New Caledonia'),('countrycode','NZL','New Zealand'),('countrycode','NIC','Nicaragua'),('countrycode','NER','Niger'),('countrycode','NGA','Nigeria'),('countrycode','NIU','Niue'),('countrycode','NFK','Norfolk Island'),('countrycode','MNP','Northern Mariana Is.'),('countrycode','NOR','Norway'),('countrycode','OMN','Oman'),('countrycode','PAK','Pakistan'),('countrycode','PLW','Palau'),('countrycode','PAN','Panama'),('countrycode','PNG','Papua New Guinea'),('countrycode','PRY','Paraguay'),('countrycode','PER','Peru'),('countrycode','PHL','Philippines'),('countrycode','PCN','Pitcairn'),('countrycode','POL','Poland'),('countrycode','PRT','Portugal'),('countrycode','PRI','Puerto Rico'),('countrycode','QAT','Qatar'),('countrycode','REU','Reunion'),('countrycode','ROM','Romania'),('countrycode','RUS','Russian Federation'),('countrycode','RWA','Rwanda'),('countrycode','KNA','Saint Kitts and Nevis'),('countrycode','LCA','Saint Lucia'),('countrycode','VCT','St. Vincent & Grenadines'),('countrycode','WSM','Samoa'),('countrycode','SMR','San Marino'),('countrycode','STP','Sao Tome & Principe'),('countrycode','SAU','Saudi Arabia'),('countrycode','SEN','Senegal'),('countrycode','SYC','Seychelles'),('countrycode','SLE','Sierra Leone'),('countrycode','SGP','Singapore'),('countrycode','SVK','Slovakia (Slovak Republic);'),('countrycode','SVN','Slovenia'),('countrycode','SLB','Solomon Islands'),('countrycode','SOM','Somalia'),('countrycode','ZAF','South Africa'),('countrycode','SGS','S.Georgia & S.Sandwich Is.'),('countrycode','ESP','Spain'),('countrycode','LKA','Sri Lanka'),('countrycode','SHN','St. Helena'),('countrycode','SPM','St. Pierre & Miquelon'),('countrycode','SDN','Sudan'),('countrycode','SUR','Suriname'),('countrycode','SJM','Svalbard & Jan Mayen Is.'),('countrycode','SWZ','Swaziland'),('countrycode','SWE','Sweden'),('countrycode','CHE','Switzerland'),('countrycode','SYR','Syrian Arab Republic'),('countrycode','TWN','Taiwan'),('countrycode','TJK','Tajikistan'),('countrycode','TZA','Tanzania'),('countrycode','THA','Thailand'),('countrycode','TGO','Togo'),('countrycode','TKL','Tokelau'),('countrycode','TON','Tonga'),('countrycode','TTO','Trinidad and Tobago'),('countrycode','TUN','Tunisia'),('countrycode','TUR','Turkey'),('countrycode','TKM','Turkmenistan'),('countrycode','TCA','Turks & Caicos Islands'),('countrycode','TUV','Tuvalu'),('countrycode','UGA','Uganda'),('countrycode','UKR','Ukraine'),('countrycode','ARE','United Arab Emirates'),('countrycode','UMI','U.S. Minor Outlying Is.'),('countrycode','URY','Uruguay'),('countrycode','UZB','Uzbekistan'),('countrycode','VUT','Vanuatu'),('countrycode','VAT','Vatican (Holy See);'),('countrycode','VEN','Venezuela'),('countrycode','VNM','Viet Nam'),('countrycode','VGB','Virgin Islands (British);'),('countrycode','VIR','Virgin Islands (U.S.);'),('countrycode','WLF','Wallis & Futuna Is.'),('countrycode','ESH','Western Sahara'),('countrycode','YEM','Yemen'),('countrycode','YUG','Yugoslavia'),('countrycode','ZAR','Zaire'),('countrycode','ZMB','Zambia'),('countrycode','ZWE','Zimbabwe');
/*!40000 ALTER TABLE `lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) DEFAULT NULL,
  `tid` int(9) DEFAULT NULL,
  `message` text,
  `created` int(11) DEFAULT NULL,
  `disabled` int(1) DEFAULT NULL,
  `readed` enum('Y','N') DEFAULT 'N',
  `checked` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `FK_messages_accounts` (`uid`),
  KEY `FK_messages_accounts_2` (`tid`),
  CONSTRAINT `FK_messages_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_messages_accounts_2` FOREIGN KEY (`tid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=741 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id`, `uid`, `tid`, `message`, `created`, `disabled`, `readed`, `checked`) VALUES (541,335,336,'ayaaaank :)',1336353361,NULL,'Y','Y'),(542,336,335,'aaayaaank',1336353415,NULL,'Y','Y'),(543,335,336,'ayaaank',1336353416,NULL,'Y','Y'),(544,336,335,'^_^',1336353419,NULL,'Y','Y'),(545,335,336,'hehehehe....',1336353426,NULL,'Y','Y'),(546,336,335,'cie cie',1336353428,NULL,'Y','Y'),(547,335,336,'apanya???',1336353433,NULL,'Y','Y'),(548,335,336,'ayank... ganti PP-nya coba :)',1336353464,NULL,'Y','Y'),(549,336,335,'dah',1336353646,NULL,'Y','Y'),(550,335,336,'hihihi PPnya setengah',1336353733,NULL,'Y','Y'),(551,336,335,'gk',1336353768,NULL,'Y','Y'),(552,336,335,'semua',1336353772,NULL,'Y','Y'),(553,335,336,'hohoho.... hmmm... apanya yang masih kurang???',1336353796,NULL,'Y','Y'),(554,336,335,'gk ada',1336353855,NULL,'Y','Y'),(555,335,336,'hmmm coba bales status kita :)',1336353904,NULL,'Y','Y'),(556,336,335,'dah',1336354073,NULL,'Y','Y'),(557,335,336,'hmmm',1336354289,NULL,'Y','Y'),(561,336,335,'hmm',1336354373,NULL,'Y','Y'),(564,335,336,'yank??',1336354525,NULL,'Y','Y'),(565,336,335,'apa??',1336354552,NULL,'Y','Y'),(566,335,336,'ada yang kurang??',1336354573,NULL,'Y','Y'),(567,335,336,'ada yang kurang??',1336354613,NULL,'Y','Y'),(568,336,335,'gk ada',1336354635,NULL,'Y','Y'),(569,336,335,'ow ada',1336354644,NULL,'Y','Y'),(570,335,336,'apa??',1336354649,NULL,'Y','Y'),(571,336,335,'mana gambar shipoo boo bee mdan ank2nya',1336354655,NULL,'Y','Y'),(572,335,336,'hahahahaha.. upload dong',1336354693,NULL,'Y','Y'),(573,336,335,'di laptop tmptnya',1336354716,NULL,'Y','Y'),(574,335,336,'hahahaha... ya...',1336354758,NULL,'Y','Y'),(575,335,336,'ini kita upload dia',1336354778,NULL,'Y','Y'),(576,336,335,'ayo buat tlsannya',1336354795,NULL,'Y','Y'),(577,335,336,'iya :)',1336354823,NULL,'Y','Y'),(578,335,336,'makasih ya... ilove u',1336354830,NULL,'Y','Y'),(579,335,336,'kebawah dulu :)',1336354906,NULL,'Y','Y'),(580,336,335,'love u...<3',1336355020,NULL,'Y','Y'),(581,335,340,'Oi win',1336360319,NULL,'Y','Y'),(582,335,337,'terimkasih telah mau mencoba dinua',1336360333,NULL,'Y','Y'),(583,335,339,'terimkasih telah mau mencoba dinua',1336360339,NULL,'Y','Y'),(584,339,335,'bagus bro :)\ntrs dikembangin.. salut buat nt',1336360361,NULL,'Y','Y'),(585,335,339,'sama2... bro. mari berkembang sama2... terimaksih bro',1336360405,NULL,'Y','Y'),(586,339,335,':)',1336360498,NULL,'Y','Y'),(587,339,335,'autoresize image saat upload lom ada ya bro..',1336360520,NULL,'Y','Y'),(588,339,335,'aku coba upload pic yg ukurannya besar sekali... gagal upload',1336360543,NULL,'Y','Y'),(589,340,335,'oi..\nge mn koq gak bisa ganti pp',1336360643,NULL,'Y','Y'),(590,335,339,'udah bro... cuma dari sever hostingnya sendiri batesin 2MB',1336360650,NULL,'Y','Y'),(591,335,339,'dan untuk ebook servernya masih belum sopport',1336360675,NULL,'Y','Y'),(592,335,340,'bisaa.... upload dulu',1336360747,NULL,'Y','Y'),(593,335,340,'gambarnya',1336360751,NULL,'Y','Y'),(594,340,335,'udah hep..\nkeren',1336361673,NULL,'Y','Y'),(595,335,340,'ndak nahan PP-nya...',1336361695,NULL,'Y','Y'),(596,339,335,'oh :)',1336361723,NULL,'Y','Y'),(597,340,335,'ndak nahan mau boker',1336361959,NULL,'Y','Y'),(598,335,340,'wakakakakaka... mna anak2 tu???',1336361970,NULL,'Y','Y'),(599,340,335,'blm dtg..ktnya masi bimbingan,,ntr sy suruh daftar dinua',1336361992,NULL,'Y','Y'),(600,335,340,'wakakakak... makasih ya :)',1336362028,NULL,'Y','Y'),(601,340,335,'ya hep..\nsetil ente hep',1336362043,NULL,'Y','Y'),(602,335,340,'hahahaha... kan berkat kamu juga... :)',1336362063,NULL,'Y','Y'),(603,335,339,'maaf atas kekuranganya',1336362093,NULL,'N','Y'),(604,335,350,'oe sat..',1336369065,NULL,'Y','Y'),(605,350,335,'udah broo',1336369443,NULL,'Y','Y'),(606,350,335,'saya pake leptop novi berhasil login pake krome',1336369489,NULL,'Y','Y'),(607,350,335,'poto fropil gimana caraxa iyan',1336370019,NULL,'Y','Y'),(608,335,351,'oi... hehe... upload dulu fotonya',1336371316,NULL,'Y','Y'),(609,335,350,'sat... upload dulu fotonya...',1336371373,NULL,'Y','Y'),(610,350,335,'sippp',1336371702,NULL,'Y','Y'),(611,335,353,'terimkasih telah turut serta menggunakan dinua.net',1336374488,NULL,'Y','Y'),(612,353,335,'sama-sama ^_^',1336374707,NULL,'Y','Y'),(613,335,353,'mohon kritik dan sarannya',1336374795,NULL,'Y','Y'),(614,353,335,'gmn ganti foto profilnya??',1336374818,NULL,'Y','Y'),(615,335,353,'silahkan upload dulu fotonya... klik foto-> kemudian buat album baru-> pilih albumnya-> upload foto',1336374928,NULL,'Y','Y'),(616,335,353,'bisa???',1336375060,NULL,'Y','Y'),(617,336,353,'tes',1336377202,NULL,'N','Y'),(618,336,350,'tes',1336377207,NULL,'Y','Y'),(619,335,352,'beranda ada pojok kiri atas... dinua',1336378712,NULL,'Y','Y'),(620,335,352,'lho??',1336378726,NULL,'Y','Y'),(621,328,335,'tes',1336378916,NULL,'Y','Y'),(622,328,354,'tes',1336378919,NULL,'N','N'),(623,335,328,'ape??',1336378925,NULL,'Y','Y'),(624,335,328,'lagi dimana???',1336378935,NULL,'Y','Y'),(625,335,328,'mana anak2 tu??',1336378942,NULL,'Y','Y'),(626,335,355,'makasih sudah daftar',1336379223,NULL,'Y','Y'),(627,328,335,'kok ada pesan begini hep...\n\nA Database Error Occurred\n\nError Number: 1064\n\nYou have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to',1336379530,NULL,'Y','Y'),(628,328,335,'SELECT * FROM (`friends`) WHERE (uid = or tid = ) and (type= \"Y\")',1336379554,NULL,'Y','Y'),(629,335,328,'pass mana hep???',1336379555,NULL,'Y','Y'),(630,335,328,'halaman apa???',1336379583,NULL,'Y','Y'),(631,328,335,'http://dinua.net/?fid=1\'',1336379603,NULL,'Y','Y'),(632,335,328,'hahahahaha.... ya saya hialngin error reponsenya dulu',1336379635,NULL,'Y','Y'),(633,335,328,'coba lgi...',1336379779,NULL,'Y','Y'),(634,328,335,'ia hep,,ilang dy',1336379813,NULL,'Y','Y'),(635,328,335,'ia hep,,ilang dy',1336379837,NULL,'Y','Y'),(636,328,335,'kok gak bisa bwt link ia',1336380100,NULL,'Y','Y'),(637,335,328,'link apa???',1336380161,NULL,'Y','Y'),(638,328,335,'maksudnya pas link redirect pas bikin tautan,,hehe',1336380457,NULL,'Y','Y'),(639,335,328,'lho??? kamu ngapain???',1336380487,NULL,'Y','Y'),(640,328,335,'kiraen da tautan,,,hehhe',1336380514,NULL,'Y','Y'),(641,335,328,'hehehehe... belum hep',1336380551,NULL,'Y','Y'),(642,335,350,'Cobaaaa ',1336384421,NULL,'Y','Y'),(643,335,336,'Kirim pesaan ',1336384482,NULL,'Y','Y'),(644,335,352,'jo???',1336384782,NULL,'N','N'),(645,335,355,'Terima kasih sudah mau menggunakan dinua ',1336384833,NULL,'N','N'),(646,335,340,'oi win',1336391678,NULL,'Y','Y'),(647,335,340,'mana anak2 tu?',1336392624,NULL,'N','Y'),(648,350,340,'wayaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',1336393762,NULL,'N','Y'),(649,350,340,'wayaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',1336393772,NULL,'N','Y'),(650,335,350,'masih dia kecil sat???',1336394691,NULL,'Y','Y'),(651,350,336,'sippp udah besar dia ',1336394978,NULL,'Y','Y'),(652,335,350,'apa yang kurang lagi hep???',1336395489,NULL,'Y','Y'),(653,350,335,'iya tak cari dulu..ni :)',1336395719,NULL,'Y','Y'),(654,335,350,'gimna tampilannya?',1336395934,NULL,'Y','Y'),(655,350,335,'lumayan broo mirip twiter',1336396014,NULL,'Y','Y'),(656,335,350,'haha...',1336396278,NULL,'Y','Y'),(657,350,335,'tapi agak terganggu saya broo ma text di samping kiri gak bisa dibuat dia rata',1336396279,NULL,'Y','Y'),(658,335,350,'maksunya...',1336396303,NULL,'Y','Y'),(659,335,350,'?',1336396306,NULL,'Y','Y'),(660,350,335,'di tulisan perhatian',1336396335,NULL,'Y','Y'),(661,350,335,'dinua saat ini',1336396342,NULL,'Y','Y'),(662,336,335,'woi',1336396349,NULL,'Y','Y'),(663,336,335,'ayank ',1336396427,NULL,'Y','Y'),(664,335,336,'ntar dulu...',1336396442,NULL,'Y','Y'),(665,335,336,'ada yang salh',1336396447,NULL,'Y','Y'),(666,336,335,'ayank ',1336396478,NULL,'Y','Y'),(667,336,335,'nooo',1336396512,NULL,'Y','Y'),(668,350,335,'aduh ini iyan bahaya...kok komen saya masuk semua ni ke komen yang lain.....yang ada di dinding saya...',1336396586,NULL,'Y','Y'),(669,335,350,'lho maksudnya??',1336396622,NULL,'Y','Y'),(670,350,335,'komen di dinding orang bisa satu..tapi lo saya komen sendiri di dinding saya pesan komenxa masuk ke semua..pesan di dinding saya pas saya refres',1336396867,NULL,'Y','Y'),(671,350,335,'coba dah masuk pake akun saya:satria_zoro@yahoo.com pass:zoro1010 terus klik beranda..liat terus komenxa',1336397064,NULL,'Y','Y'),(672,350,336,'tessssssssssss',1336397088,NULL,'Y','Y'),(673,335,350,'iya udah tak liat... hmmm coba lagi',1336397089,NULL,'Y','Y'),(674,350,335,'masih iyan tadi tak komen di pesan ke ijang..eh dia masuk ke semua',1336397812,NULL,'Y','Y'),(675,350,335,'biarin dahh bisa kirim ke semua orang jadixa ni hehehe',1336397887,NULL,'Y','Y'),(676,350,335,'jangan di perbaiki dulu iyan saya mau buat puisi niii biar kebaca ma semua hahaha',1336398085,NULL,'Y','Y'),(677,335,350,'udah bro',1336398652,NULL,'Y','Y'),(678,350,335,'iya gagal tak kirim tadi..kata2 saya tersaring',1336398706,NULL,'Y','Y'),(679,350,335,'masih..iyan..',1336398833,NULL,'Y','Y'),(680,335,360,'maho ngapain???',1336399209,NULL,'Y','Y'),(681,360,335,'sampi',1336399320,NULL,'Y','Y'),(682,360,335,'knapa ga muncul chat koe?',1336399326,NULL,'Y','Y'),(683,350,335,'aduh kebayang dah pusingxa dirimu broo (maaf broo gak bisa bantu,,,cuman bisa bantu cari buckxa aja)',1336399387,NULL,'Y','Y'),(684,350,360,'tess',1336399524,NULL,'Y','Y'),(685,335,350,'sudah tu bro... makasih ya...',1336399703,NULL,'Y','Y'),(686,335,360,'maksudnya???',1336399714,NULL,'Y','Y'),(687,335,360,'dimna mangkal???',1336399722,NULL,'Y','Y'),(688,335,360,'fajar... kenapa namamu gitu???',1336399800,NULL,'Y','Y'),(689,350,335,'sip  iya udah bisa niii sakti ente niii',1336400398,NULL,'Y','Y'),(690,360,335,'kanap?',1336400417,NULL,'Y','Y'),(691,360,335,'mentang admin',1336400430,NULL,'Y','Y'),(692,336,335,'ayank',1336400434,NULL,'Y','Y'),(693,360,335,'ganti ganti sy punya',1336400435,NULL,'Y','Y'),(694,336,350,'tes 1 2 3',1336400449,NULL,'Y','Y'),(695,336,350,'Ganti',1336400450,NULL,'Y','Y'),(696,360,335,'awas sy hek ntr',1336400484,NULL,'Y','Y'),(697,350,336,'udah di perbaik..ganti',1336400496,NULL,'Y','Y'),(698,335,350,'wakakaka.... biasa aja hep..',1336401453,NULL,'Y','Y'),(699,335,360,'becanda jar...',1336401477,NULL,'Y','Y'),(700,335,360,'hihihihih',1336401482,NULL,'Y','Y'),(702,335,358,'Terima permintaan pertemanan saya.... ',1336438590,NULL,'N','N'),(703,336,335,'woi',1336439651,NULL,'Y','Y'),(704,336,335,'ayank',1336440364,NULL,'Y','Y'),(705,336,335,'mana galileo galileinya??',1336440374,NULL,'Y','Y'),(706,335,336,'ya sayang...',1336440854,NULL,'Y','Y'),(707,335,336,'ndak ada...',1336440866,NULL,'Y','Y'),(708,361,335,'gimana cara mengupload foto profile ?',1336444488,NULL,'Y','Y'),(709,361,335,'Mengganti foto profile',1336444599,NULL,'Y','Y'),(710,335,350,'dimna sat???',1336464436,NULL,'Y','Y'),(711,350,335,'rumah ni broo ada pa?',1336493249,NULL,'Y','Y'),(712,350,335,'iyan lo kita mau hapus..pas udah ke hapus kok pilihan hapus ma batalxa gak pergi2',1336493409,NULL,'Y','Y'),(713,350,335,'apa gak bisa di buat otomatis dia..tampa tekan x',1336493451,NULL,'Y','Y'),(715,335,336,'ya...',1336551663,NULL,'N','Y'),(716,336,335,'tes',1336551670,NULL,'N','Y'),(717,335,353,'oi.... :)',1336555343,NULL,'Y','Y'),(718,335,353,'hmmmm',1336558462,NULL,'N','Y'),(719,350,335,'mana yang lain nii',1336563594,NULL,'Y','Y'),(720,335,350,'hahahahaha :) yayayaya ... masih belum... lagi bikin laporan neh :)',1336563761,NULL,'Y','Y'),(721,335,350,'lagi dimana??',1336563769,NULL,'Y','Y'),(722,335,361,'selamat pagi pak',1336620119,NULL,'N','Y'),(723,335,340,'oi darwin',1336652992,NULL,'N','Y'),(724,335,369,'Terima kasih...\nMohon kritik dan sarannya. ',1336653379,NULL,'N','N'),(725,335,368,'Terimakasih sudah mau daftar di dinua ;) ',1336657072,NULL,'N','N'),(726,335,375,'Halo Akun Test 2 ini dari Akun Test 1',1337579660,NULL,'Y','Y'),(727,335,375,'Halo Akun Test 2 ini dari Akun Test 1',1337580293,NULL,'N','Y'),(728,335,375,'Halo Akun Test 2 ini dari Akun Test 1',1337580371,NULL,'N','Y'),(729,335,375,'Hai, ini pesan Akun Test 1 ke Akun Test 2',1337604887,NULL,'N','Y'),(730,335,380,'Makasih udah mau nyoba :) ',1338450505,NULL,'N','N'),(731,375,335,' Hai',1338466748,NULL,'Y','Y'),(732,375,350,'Oi satria ',1338466794,NULL,'N','Y'),(733,335,337,'Lho???',1338469719,NULL,'N','N'),(734,350,335,'way adminnnn besok kekampus gak',1338470520,NULL,'N','Y'),(735,328,335,'oiii',1338470941,NULL,'N','Y'),(736,335,328,'gimna kewirausahaaan hep??',1338621248,NULL,'N','Y'),(737,335,350,'lho??? sat ',1338856845,NULL,'N','N'),(738,335,375,'Hai Aun Testing 2 ini dari Akun Testing 1',1340141657,NULL,'Y','Y'),(739,411,335,'Hai Akun Test 1',1342352898,NULL,'Y','Y'),(740,335,411,'Hai Akun Test 2',1342352914,NULL,'N','Y');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note_albums`
--

DROP TABLE IF EXISTS `note_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note_albums` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) DEFAULT NULL,
  `name` varchar(50) DEFAULT 'Belum ada judul',
  `des` varchar(100) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `disabled` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_note_albums_accounts` (`uid`),
  CONSTRAINT `FK_note_albums_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note_albums`
--

LOCK TABLES `note_albums` WRITE;
/*!40000 ALTER TABLE `note_albums` DISABLE KEYS */;
INSERT INTO `note_albums` (`id`, `uid`, `name`, `des`, `created`, `disabled`) VALUES (2,335,'Testing','',1336349769,NULL),(3,336,'catatan ','',1336377268,NULL),(4,350,'puisi ku','cinta aku tak mengerti misterimu\nkadang kau buat kami gerbira bagai \nsosok sang saja disinggah sanan',1336398366,NULL),(5,328,'Catatan !!!','',1336727456,NULL),(6,375,'Testing','',1340112976,NULL),(7,394,'testing','',1340146649,NULL),(8,416,'dfasf','sdfasfas',1343663017,NULL);
/*!40000 ALTER TABLE `note_albums` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_upd_notealbums` BEFORE UPDATE ON `note_albums` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							UPDATE NOTE ALBUMS
================================================================*/
/*update comments*/
UPDATE  comments, note_albums SET tid=NEW.id WHERE tid=OLD.id AND comments.content='NA'; 

/*update like*/
UPDATE  likes, note_albums SET tid=NEW.id WHERE tid=OLD.id AND likes.content='NA'; 

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_del_notealbums` BEFORE DELETE ON `note_albums` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							HAPUS NOTE ALBUMS
================================================================*/
/*delete ebook albums*/

/*hapus NOTES dulu*/
DELETE FROM  notes WHERE aid=old.id; 

/*hapus Komentarnya*/
DELETE FROM  comments WHERE tid=old.id AND comments.content='NA'; 

/*hapus LIKES*/
DELETE FROM  likes WHERE tid=old.id AND likes.content='NA'; 

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `aid` int(9) DEFAULT NULL,
  `uid` int(9) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `note` text,
  `created` int(11) DEFAULT NULL,
  `disabled` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_notes_note_albums` (`aid`),
  CONSTRAINT `FK_notes_note_albums` FOREIGN KEY (`aid`) REFERENCES `note_albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` (`id`, `aid`, `uid`, `name`, `note`, `created`, `disabled`) VALUES (22,3,336,'belajar','<p><strong>belajar</strong></p>\n<p>em>belajar</em></p>\n<p>span style=\"text-decoration: underline;\">belajar</span></p>',1336377323,NULL),(23,3,336,'belajar','<p><strong>belajar</strong></p>\n<p>em>belajar</em></p>\n<p>span style=\"text-decoration: underline;\">belajar</span></p>',1336377327,NULL),(28,2,335,'testing','<p>Cobaaaa catgory1</p>',1337586703,NULL),(29,2,335,'testing','<p>Cobaaaa category1</p>',1337586720,NULL),(30,2,335,'testing','<p>Cobaaaa category1</p>',1337586740,NULL),(31,2,335,'testing','<p>Coba c*******2</p>',1337587007,NULL),(32,6,375,'Coba','',1340113068,NULL),(34,7,394,'testing','',1340146666,NULL),(35,7,394,'testing','',1340146669,NULL);
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_upd_notes` BEFORE UPDATE ON `notes` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							UPDATE dan HAPUS NOTES
================================================================*/
/*update comments*/
UPDATE  comments, notes SET tid=NEW.id WHERE tid=OLD.id AND comments.content='N'; 

/*update likes*/
UPDATE  likes, notes SET tid=NEW.id WHERE tid=OLD.id AND likes.content='N'; 
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_del_notes` BEFORE DELETE ON `notes` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
						HAPUS NOTES
================================================================*/
/*delete comments*/
DELETE FROM  comments WHERE tid=old.id AND comments.content='N'; 

/*delete likes*/
DELETE FROM  likes WHERE tid=old.id AND likes.content='N'; 

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `notify`
--

DROP TABLE IF EXISTS `notify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notify` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) DEFAULT '0',
  `tid` int(9) DEFAULT '0',
  `content` enum('S','F') DEFAULT NULL,
  `checked` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notify`
--

LOCK TABLES `notify` WRITE;
/*!40000 ALTER TABLE `notify` DISABLE KEYS */;
INSERT INTO `notify` (`id`, `uid`, `tid`, `content`, `checked`) VALUES (5,336,322,'F','N'),(10,335,337,'F','N'),(13,335,341,'F','N'),(22,353,327,'F','N'),(23,350,327,'F','N'),(27,336,351,'F','N'),(31,336,339,'F','N'),(34,354,341,'F','N'),(37,352,337,'F','N'),(38,335,354,'F','N'),(39,335,355,'F','N'),(40,335,327,'F','N'),(41,335,327,'F','N'),(42,335,358,'F','N'),(44,340,352,'F','N'),(49,360,352,'F','N'),(51,360,358,'F','N'),(53,360,354,'F','N'),(58,336,359,'F','N'),(59,336,358,'F','N'),(66,340,361,'F','N'),(67,335,369,'F','N'),(68,335,367,'F','N'),(69,335,368,'F','N'),(71,353,369,'F','N'),(72,353,361,'F','N'),(73,335,353,'S','N'),(74,335,371,'F','N'),(75,336,353,'S','N'),(76,336,354,'F','N'),(77,336,367,'F','N'),(78,336,355,'F','N'),(79,335,326,'F','N'),(80,350,353,'F','N'),(81,373,360,'F','N'),(83,373,353,'F','N'),(86,373,361,'F','N'),(87,335,374,'F','N'),(89,376,359,'F','N'),(92,376,351,'F','N'),(93,377,376,'F','N'),(94,335,377,'F','N'),(98,335,379,'F','N'),(99,335,376,'F','N'),(100,380,361,'F','N'),(101,335,380,'F','N'),(104,335,360,'S','N'),(108,375,360,'F','N'),(110,335,353,'S','N'),(112,335,352,'S','N'),(113,384,351,'F','N'),(114,335,384,'F','N'),(115,403,394,'F','N'),(116,406,373,'F','N'),(117,406,350,'F','N'),(118,406,340,'F','N'),(120,406,354,'F','N'),(121,406,353,'F','N'),(122,406,360,'F','N'),(124,335,401,'F','N'),(125,416,376,'F','N'),(126,335,408,'F','N');
/*!40000 ALTER TABLE `notify` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_settings`
--

DROP TABLE IF EXISTS `page_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_settings` (
  `page` varchar(100) NOT NULL DEFAULT '',
  `settings` text,
  PRIMARY KEY (`page`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_settings`
--

LOCK TABLES `page_settings` WRITE;
/*!40000 ALTER TABLE `page_settings` DISABLE KEYS */;
INSERT INTO `page_settings` (`page`, `settings`) VALUES ('info','a:2:{s:4:\"page\";s:11:\"vw_info.php\";s:10:\"body_class\";s:0:\"\";}'),('login','a:3:{s:10:\"signup_msg\";s:43:\"Silahkan mendaftar agar Anda bisa terhubung\";s:4:\"page\";s:12:\"vw_login.php\";s:10:\"body_class\";s:4:\"home\";}');
/*!40000 ALTER TABLE `page_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo_albums`
--

DROP TABLE IF EXISTS `photo_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo_albums` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) DEFAULT NULL,
  `name` varchar(50) DEFAULT 'Belum ada judul',
  `des` varchar(200) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `disabled` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_photo_albums_accounts` (`uid`),
  CONSTRAINT `FK_photo_albums_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo_albums`
--

LOCK TABLES `photo_albums` WRITE;
/*!40000 ALTER TABLE `photo_albums` DISABLE KEYS */;
INSERT INTO `photo_albums` (`id`, `uid`, `name`, `des`, `created`, `disabled`) VALUES (16,326,'Shipoo,,dll','ada Boo,,Bee,,Kuro,,dll',1336191987,NULL),(18,336,'HuJ4N','',1336353540,NULL),(19,339,'Disini aja','Tes :)',1336360262,NULL),(20,340,'my self','',1336360742,NULL),(21,350,'coba','',1336369820,NULL),(23,354,'jenk','',1336377228,NULL),(27,328,'Profil','',1336379092,NULL),(28,352,'aku','',1336379099,NULL),(29,358,'My Profil','it\'s me',1336380479,NULL),(30,360,'me','',1336400592,NULL),(31,361,'Coba','coba-coba',1336444153,NULL),(33,353,'Kami','',1336551888,NULL),(35,372,'tes','',1337048224,NULL),(36,373,'Q','',1337239331,NULL),(37,374,'qw','asd',1337285380,NULL),(38,376,'p3','taek',1337331794,NULL),(39,377,'coba','',1337397065,NULL),(40,377,'coba','',1337397065,NULL),(41,380,'and die','',1338265796,NULL),(42,380,'and die','',1338265799,NULL),(43,384,'RaveN','Apa aja dah...',1338965989,NULL),(44,335,'Testing','Hanya untuk uji coba',1339991050,NULL),(45,335,'Testing','Hanya untuk uji coba',1339991051,NULL),(46,375,'Testing','Hanya untuk coba',1340112210,NULL),(47,394,'testing','',1340146688,NULL),(48,403,'Testing','Ini untuk uji coba',1341295442,NULL),(49,403,'Testing','Ini untuk uji coba',1341295457,NULL),(50,406,'younk','',1341431832,NULL),(51,416,'dark','ini adalah darkcry',1343143210,NULL);
/*!40000 ALTER TABLE `photo_albums` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_upd_photoalbums` BEFORE UPDATE ON `photo_albums` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							UPDATE photo albums
================================================================*/
/*update comments*/
UPDATE  comments, photo_albums SET tid=NEW.id WHERE tid=OLD.id AND comments.content='IA'; 

/*update like*/
UPDATE  likes, photo_albums SET tid=NEW.id WHERE tid=OLD.id AND likes.content='IA'; 

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_del_photoalbums` BEFORE DELETE ON `photo_albums` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							HAPUS Photos ALBUMS
================================================================*/
/*delete ebook albums*/

/*hapus photo dulu*/
DELETE FROM  photos WHERE aid=old.id; 

/*hapus comentarnya*/
DELETE FROM  comments WHERE tid=old.id AND comments.content='IA'; 

/*hapus LIKES*/
DELETE FROM  likes WHERE tid=old.id AND likes.content='IA'; 
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `aid` int(9) DEFAULT NULL,
  `uid` int(9) DEFAULT NULL,
  `des` varchar(200) DEFAULT '',
  `url` varchar(100) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `disabled` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_photos_photo_albums` (`aid`),
  KEY `FK_photos_accounts` (`uid`),
  CONSTRAINT `FK_photos_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_photos_photo_albums` FOREIGN KEY (`aid`) REFERENCES `photo_albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
INSERT INTO `photos` (`id`, `aid`, `uid`, `des`, `url`, `created`, `disabled`) VALUES (90,18,336,'','46510cbbb12c500eb0ce0a56ba47bb94.jpg',1336353601,NULL),(91,18,336,'','74155eb0a0e69c04528ec776f275dfaa.jpg',1336353624,NULL),(94,20,340,'','396992fd99615b516666cb26dd770fa1.jpg',1336361585,NULL),(95,20,340,'','90497972df070dbfbab1e521b1787521.jpg',1336361593,NULL),(96,20,340,'','97d9f214730a0f376710aeb35efb4ce0.jpg',1336362233,NULL),(97,21,350,'','5fa9316a32ac2e47aca208a5f7343787.jpg',1336369865,NULL),(98,21,350,'','563df1a60b8b5bca8f6315eee94a2cd1.jpg',1336369892,NULL),(99,23,354,'','82cbe692c3bd9c9d821dd28f55929a2c.jpg',1336377585,NULL),(100,23,354,'','d52b3a743d5490ee576962cb5778e1f5.jpg',1336377609,NULL),(101,23,354,'','2e87ddb7f05fd4042344caa243cba282.jpg',1336377645,NULL),(104,27,328,'','0ff49023fdbd84d32922236090c58941.jpg',1336379284,NULL),(106,30,360,'','6cfc02ece72a47f6051d9ae130ce12bf.jpg',1336400617,NULL),(107,31,361,'','0b595e0301aaf1079d8e1dbc9728a207.jpg',1336444260,NULL),(108,31,361,'','e79ce3750976b0eb066dde02b21428b7.jpg',1336444305,NULL),(109,33,353,'','25ddf310bb8d6c4b4a5158dd6f4a1132.jpg',1336722841,NULL),(110,33,353,'','550cd0926582cf225c123f155238674f.jpg',1336723177,NULL),(113,33,353,'','299ff58b9dc02ab42719b6ab07053358.jpg',1336723373,NULL),(114,33,353,'','7e8005de705a0f1531c32a742e8cf056.jpg',1336723380,NULL),(115,20,340,'','f7254dea1735acd14bc540102dfac694.jpg',1336906636,NULL),(116,35,372,'','84f0b5ef95bb50668eeab4f906c59d81.jpg',1337048309,NULL),(117,36,373,'','98b5da73bad9e2cdc7063906eb1c9cd4.jpg',1337239696,NULL),(119,36,373,'','6a8f14580aaec4344802dfdccd92371b.jpg',1337240153,NULL),(120,38,376,'','ffbc50c789f56c3019917ff576e632a6.jpg',1337331822,NULL),(121,39,377,'','6fde5973171610276d4ca40059a1f944.jpg',1337397209,NULL),(122,42,380,'','f7e3279dc92645fd026cb41a5bc6281e.jpg',1338266121,NULL),(124,45,335,'','dab942314bc30e37bf88895d0a23c63a.jpg',1339991081,NULL),(125,46,375,'','9b47714782de3347bffd37db19ca1a2c.jpg',1340112248,NULL),(126,45,335,'','975bfd8cb7d73345f97f617801113f6e.jpg',1340141997,NULL),(127,45,335,'','df450932939cff7feda51fad09e41c5a.jpg',1340142036,NULL),(128,45,335,'','064cd1cc3bb4336714a05aa42d6d2d32.jpg',1340143394,NULL),(129,47,394,'','1a4322e8ba87ade237c1071d4fa311cc.jpg',1340146711,NULL),(130,45,335,'','84e78bdbd51a55223c835bf996922d27.jpg',1341200787,NULL),(132,50,406,'','befbe480cc9954cbaebea0b027d49d8d.jpg',1341431964,NULL),(133,50,406,'','97e2a2c6ec57ceb95ac8e519d5524801.jpg',1341432003,NULL),(134,50,406,'','c35f01fd80f8f0e5e61f2275c9c1ff11.jpg',1341432051,NULL),(135,50,406,'','29bee5bcd4d2656eca53a0f5aca61a6b.jpg',1341432068,NULL),(136,51,416,'','5e475f6507aed56692350bd2a43c8ced.jpg',1343143270,NULL);
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_upd_photos` BEFORE UPDATE ON `photos` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							UPDATE dan HAPUS E-BOOK
================================================================*/
/*update ebook*/
UPDATE  comments, photos SET tid=NEW.id WHERE tid=OLD.id AND comments.content='I'; 

/*update likes*/
UPDATE  likes, photos SET tid=NEW.id WHERE tid=OLD.id AND likes.content='I'; 
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_del_photos` BEFORE DELETE ON `photos` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
						 HAPUS PHOTOS
================================================================*/
/*delete comments*/
DELETE FROM  comments WHERE tid=old.id AND comments.content='I'; 

/*delete likes*/
DELETE FROM  likes WHERE tid=old.id AND likes.content='I'; 

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) DEFAULT NULL,
  `tid` int(9) DEFAULT NULL,
  `content` enum('S','E','N','I','EA','NA','IA') DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `message` text,
  `hasread` tinyint(1) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` (`id`, `uid`, `tid`, `content`, `url`, `message`, `hasread`, `created`) VALUES (12,375,0,'',NULL,'User ini mencoba memasukan data Album dengan kata tersaring',NULL,1340111726),(13,375,0,'',NULL,'User ini mencoba memasukan data Album dengan kata tersaring',NULL,1340111740),(14,403,0,'S',NULL,'User ini mencoba memasukan status dengan kata tersaring',NULL,1341295362),(15,403,220,'S',NULL,'Sofyan Hadi A telah melaporkan ini, pada 2012-07-03T13:09:22Q',NULL,1341295762),(16,403,0,'S',NULL,'User ini mencoba memasukan status dengan kata tersaring',NULL,1341297535),(17,335,0,'N',NULL,'User ini mencoba memasukan Komentar dengan kata tersaring',NULL,1342668886),(18,335,0,'N',NULL,'User ini mencoba memasukan Komentar dengan kata tersaring',NULL,1342668891),(19,335,0,'N',NULL,'User ini mencoba memasukan Komentar dengan kata tersaring',NULL,1342668897),(20,335,0,'N',NULL,'User ini mencoba memasukan Komentar dengan kata tersaring',NULL,1342668922),(21,413,0,'S',NULL,'User ini mencoba memasukan status dengan kata tersaring',NULL,1342669666),(22,335,0,'N',NULL,'User ini mencoba memasukan Komentar dengan kata tersaring',NULL,1342670050);
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES ('e16952121bb0fbd48bc68229c4fb8cca','180.249.187.216','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11',1343821932,'a:3:{s:2:\"id\";s:3:\"335\";s:9:\"logged_in\";b:1;s:4:\"page\";s:10:\"mywall.php\";}');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tid` int(11) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `groups` char(1) DEFAULT NULL,
  `disabled` int(1) DEFAULT NULL,
  `readed` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`id`, `uid`, `tid`, `message`, `created`, `groups`, `disabled`, `readed`) VALUES (7,322,322,'Hmmmmm',1335544317,NULL,NULL,''),(8,319,322,'Hei hei hei :)',1335586192,NULL,NULL,''),(9,322,322,'oi',1335685043,NULL,NULL,''),(10,322,319,'Ini statusnya tyas...',1335697276,NULL,NULL,''),(11,322,322,'Oi',1335709812,NULL,NULL,''),(12,322,322,'fdfdf',1335709865,NULL,NULL,''),(28,322,322,'trtrtrt',1335714184,NULL,NULL,'Y'),(29,322,322,'ewewe',1335714200,NULL,NULL,'Y'),(30,322,322,'r33r3r',1335714225,NULL,NULL,'Y'),(31,322,319,'yoh????',1335714266,NULL,NULL,'Y'),(32,322,322,'trtrtt',1335714284,NULL,NULL,'Y'),(33,322,322,'wyqrwyqrywr163w462vtsyfqwysd 6wd6r6rwydxwcfdfwdfwfdfdddddddddddddddddysyqadfyafdyafydfayfdyafdyfa dyfadfad dfayfdadcadgcagcda dyfaydfyadadasdsd',1335851405,NULL,NULL,'Y'),(34,322,322,'swwsd\r\nsad\r\ndada\r\nda\r\ndadadada',1335851416,NULL,NULL,'Y'),(35,322,322,'1w21w  wqwq  wqwq  wqwq  wqwqw  wqw  wqwq  ',1335851425,NULL,NULL,'Y'),(36,319,322,'Dari tyass',1335925281,NULL,NULL,'Y'),(37,323,323,'Hadduuu baru neh',1336021807,NULL,NULL,'Y'),(38,322,323,'oi',1336021967,NULL,NULL,'Y'),(39,322,322,'Allll right... done :)',1336022076,NULL,NULL,'Y'),(41,322,319,'xxx',1336063279,NULL,NULL,'Y'),(42,322,319,'xxx',1336063346,NULL,NULL,'Y'),(43,322,319,'fdfdfdf',1336063376,NULL,NULL,'Y'),(44,322,319,'sasasa',1336063444,NULL,NULL,'Y'),(45,322,319,'gfgfgfg',1336063466,NULL,NULL,'Y'),(46,322,319,'XXXX',1336063499,NULL,NULL,'Y'),(48,327,327,'tes lagi',1336190641,NULL,NULL,'Y'),(49,326,326,'Tes..1..2..3',1336191887,NULL,NULL,'Y'),(50,335,335,'Hmmmm',1336348534,NULL,NULL,'Y'),(51,336,336,'tulis sesuatu,,,,,',1336353748,NULL,NULL,'Y'),(52,335,336,'tinggal eBook ayank :)',1336353813,NULL,NULL,'Y'),(53,336,335,'permisi',1336354089,NULL,NULL,'Y'),(54,339,339,'Bagus nih :)',1336360166,NULL,NULL,'Y'),(55,335,340,'Waduh :)',1336361451,NULL,NULL,'Y'),(57,351,351,'kenapa nama saya cuma sampe O\nkan gk lengkap jadi na nama saya nee...\nadooohhhh.....\ninaq saya sampe gorok sampi tetangga buat nama saya eee...\nnapa dia cuma sepeleng disini....',1336370011,NULL,NULL,'Y'),(58,351,351,'Gimana cara na ganti foto profil?????',1336370355,NULL,NULL,'Y'),(59,351,351,'kenapa gk ada jawaban?????',1336370405,NULL,NULL,'Y'),(61,354,354,'masukin foto saya belum bisa...:(',1336377441,NULL,NULL,'Y'),(62,354,354,'hehehehhe.... good job\n',1336377779,NULL,NULL,'Y'),(63,352,352,'mantap yan\n\nmari kembangkan\n\nbiar indonesia juga punya',1336378474,NULL,NULL,'Y'),(64,328,328,'jadi anak SLTP ato SLTA.....hhehe\n',1336378822,NULL,NULL,'Y'),(65,359,359,'haloo',1336397015,NULL,NULL,'Y'),(66,335,328,'Cobaaaaa',1336397364,NULL,NULL,'Y'),(67,335,340,'Hmmmm',1336397768,NULL,NULL,'Y'),(69,335,340,'Hmmmm darwin???',1336398680,NULL,NULL,'Y'),(70,360,360,'Testing...',1336398884,NULL,NULL,'Y'),(71,360,360,'ASSOOOOOOOOOOOOOOOOYYYYYYYYYYYYYY..............................',1336399063,NULL,NULL,'Y'),(72,335,360,'lho kok namamu gitu???',1336399778,NULL,NULL,'Y'),(73,361,361,'tes',1336437095,NULL,NULL,'Y'),(74,361,361,'Gantiin foto profil saya dong...',1336444903,NULL,NULL,'Y'),(75,361,361,'Gantiin foto profil saya dong...\n',1336444933,NULL,NULL,'Y'),(76,361,361,'Gantiin foto profil saya dong...\n',1336444935,NULL,NULL,'Y'),(77,361,361,'Gantiin foto profil saya dong...\n',1336444936,NULL,NULL,'Y'),(78,361,361,'Gantiin foto profil saya dong...\n',1336444937,NULL,NULL,'Y'),(79,361,335,'Cara ganti foto profil ?',1336445301,NULL,NULL,'Y'),(80,361,335,'Cara ganti foto profil ?',1336445302,NULL,NULL,'Y'),(81,361,335,'Cara ganti foto profil ?',1336445303,NULL,NULL,'Y'),(82,335,361,'oh maaf pak, saya baru login. untuk merubah foto profil bapak sulahkan untuk menambahkan album pada bagian foto, kemudian silahkan bapak mengupload foto baru pada album yang telah dibuat. setelah itu ',1336448359,NULL,NULL,'Y'),(83,335,361,'sepertinya bapak sudah upload foto. silahkan Bapak taruh mouse diatas foto dan pilih opsi jadikan foto profil.\nmaaf pak bantuannya belum selese saya ketik.',1336448491,NULL,NULL,'Y'),(84,366,366,'Ini status saya',1336453143,NULL,NULL,'Y'),(85,335,350,'Oi satria....',1336464484,NULL,NULL,'Y'),(86,335,350,'Oi satria....',1336464484,NULL,NULL,'Y'),(88,0,0,'Tuliskan Sesuatu...',1336486979,NULL,NULL,'N'),(89,0,0,'Tuliskan Sesuatu...',1336486979,NULL,NULL,'N'),(90,0,0,'Tuliskan Sesuatu...',1336486979,NULL,NULL,'N'),(91,0,0,'Tuliskan Sesuatu...',1336486979,NULL,NULL,'N'),(92,0,0,'Tuliskan Sesuatu...',1336486979,NULL,NULL,'N'),(93,0,0,'Tuliskan Sesuatu...',1336486979,NULL,NULL,'N'),(94,0,0,'Tuliskan Sesuatu...',1336486979,NULL,NULL,'N'),(95,0,0,'Tuliskan Sesuatu...',1336486985,NULL,NULL,'N'),(96,0,0,'Tuliskan Sesuatu...',1336486993,NULL,NULL,'N'),(97,0,0,'Tuliskan Sesuatu...',1336486993,NULL,NULL,'N'),(98,0,0,'Tuliskan Sesuatu...',1336486993,NULL,NULL,'N'),(99,0,0,'Tuliskan Sesuatu...',1336486993,NULL,NULL,'N'),(100,0,0,'Tuliskan Sesuatu...',1336486993,NULL,NULL,'N'),(101,0,0,'Tuliskan Sesuatu...',1336486993,NULL,NULL,'N'),(102,0,0,'Tuliskan Sesuatu...',1336486993,NULL,NULL,'N'),(103,0,0,'Tuliskan Sesuatu...',1336486994,NULL,NULL,'N'),(104,0,0,'Tuliskan Sesuatu...',1336487002,NULL,NULL,'N'),(105,0,0,'Tuliskan Sesuatu...',1336487002,NULL,NULL,'N'),(106,0,0,'Tuliskan Sesuatu...',1336487002,NULL,NULL,'N'),(107,0,0,'Tuliskan Sesuatu...',1336487002,NULL,NULL,'N'),(108,0,0,'Tuliskan Sesuatu...',1336487002,NULL,NULL,'N'),(109,0,0,'Tuliskan Sesuatu...',1336487002,NULL,NULL,'N'),(110,0,0,'Tuliskan Sesuatu...',1336487002,NULL,NULL,'N'),(111,0,0,'Tuliskan Sesuatu...',1336487002,NULL,NULL,'N'),(112,0,0,'Tuliskan Sesuatu...',1336487002,NULL,NULL,'N'),(113,0,0,'Tuliskan Sesuatu...',1336487003,NULL,NULL,'N'),(114,0,0,'Tuliskan Sesuatu...',1336487005,NULL,NULL,'N'),(115,0,0,'Tuliskan Sesuatu...',1336487005,NULL,NULL,'N'),(116,0,0,'Tuliskan Sesuatu...',1336487005,NULL,NULL,'N'),(117,0,0,'Tuliskan Sesuatu...',1336487005,NULL,NULL,'N'),(118,0,0,'Tuliskan Sesuatu...',1336487013,NULL,NULL,'N'),(119,0,0,'Tuliskan Sesuatu...',1336487014,NULL,NULL,'N'),(120,0,0,'Tuliskan Sesuatu...',1336487014,NULL,NULL,'N'),(121,0,0,'Tuliskan Sesuatu...',1336487014,NULL,NULL,'N'),(122,0,0,'Tuliskan Sesuatu...',1336487019,NULL,NULL,'N'),(123,0,0,'Tuliskan Sesuatu...',1336487021,NULL,NULL,'N'),(124,0,0,'Tuliskan Sesuatu...',1336487021,NULL,NULL,'N'),(125,0,0,'Tuliskan Sesuatu...',1336487026,NULL,NULL,'N'),(126,0,0,'Tuliskan Sesuatu...',1336487028,NULL,NULL,'N'),(127,0,0,'Tuliskan Sesuatu...',1336487028,NULL,NULL,'N'),(128,0,0,'Tuliskan Sesuatu...',1336487030,NULL,NULL,'N'),(129,0,0,'Tuliskan Sesuatu...',1336487030,NULL,NULL,'N'),(130,0,0,'Tuliskan Sesuatu...',1336487032,NULL,NULL,'N'),(131,0,0,'Tuliskan Sesuatu...',1336487036,NULL,NULL,'N'),(132,0,0,'Tuliskan Sesuatu...',1336487036,NULL,NULL,'N'),(133,0,0,'Tuliskan Sesuatu...',1336487036,NULL,NULL,'N'),(134,0,0,'Tuliskan Sesuatu...',1336487036,NULL,NULL,'N'),(135,0,0,'Tuliskan Sesuatu...',1336487036,NULL,NULL,'N'),(136,0,0,'Tuliskan Sesuatu...',1336487036,NULL,NULL,'N'),(137,0,0,'Tuliskan Sesuatu...',1336487036,NULL,NULL,'N'),(138,0,0,'Tuliskan Sesuatu...',1336487036,NULL,NULL,'N'),(139,0,0,'Tuliskan Sesuatu...',1336487036,NULL,NULL,'N'),(140,0,0,'Tuliskan Sesuatu...',1336487037,NULL,NULL,'N'),(141,0,0,'Tuliskan Sesuatu...',1336487038,NULL,NULL,'N'),(142,0,0,'Tuliskan Sesuatu...',1336487038,NULL,NULL,'N'),(143,0,0,'Tuliskan Sesuatu...',1336487046,NULL,NULL,'N'),(144,0,0,'Tuliskan Sesuatu...',1336487046,NULL,NULL,'N'),(145,0,0,'Tuliskan Sesuatu...',1336487046,NULL,NULL,'N'),(146,0,0,'Tuliskan Sesuatu...',1336487052,NULL,NULL,'N'),(147,0,0,'Tuliskan Sesuatu...',1336487052,NULL,NULL,'N'),(148,0,0,'Tuliskan Sesuatu...',1336487054,NULL,NULL,'N'),(149,0,0,'Tuliskan Sesuatu...',1336487054,NULL,NULL,'N'),(150,0,0,'Tuliskan Sesuatu...',1336487055,NULL,NULL,'N'),(151,0,0,'Tuliskan Sesuatu...',1336487055,NULL,NULL,'N'),(152,0,0,'Tuliskan Sesuatu...',1336487057,NULL,NULL,'N'),(153,0,0,'Tuliskan Sesuatu...',1336487354,NULL,NULL,'N'),(154,0,0,'Tuliskan Sesuatu...',1336487356,NULL,NULL,'N'),(155,0,0,'Tuliskan Sesuatu...',1336487358,NULL,NULL,'N'),(156,0,0,'Tuliskan Sesuatu...',1336487360,NULL,NULL,'N'),(157,0,0,'Tuliskan Sesuatu...',1336487365,NULL,NULL,'N'),(158,0,0,'Tuliskan Sesuatu...',1336487366,NULL,NULL,'N'),(160,335,335,'Tuliskan Sesuatu...',1336491149,NULL,NULL,'Y'),(162,369,369,'congratulations for the launch of \"dinua\" _social networking...^_^\nBismillah... ',1336612112,NULL,NULL,'Y'),(163,361,361,'Masih belum bisa ubah foto profile',1336620132,NULL,NULL,'Y'),(164,353,335,'pian makasih udh bisa ^_^',1336723578,NULL,NULL,'Y'),(165,335,353,'Makasih ya.... udah mau gabung :)',1336822718,NULL,NULL,'Y'),(166,340,340,'I feel I’m growing older',1336906383,NULL,NULL,'Y'),(184,372,372,'nama a****g saya ....',1337048349,NULL,NULL,'Y'),(186,336,353,'rame bgt akun yg satu ne,,,',1337052607,NULL,NULL,'Y'),(187,350,350,'password saya yang dulu di hapus iya yan?',1337186251,NULL,NULL,'Y'),(192,375,375,'Ini status saya',1337604418,NULL,NULL,'Y'),(195,380,380,'My Name is Andi Rianto',1338265170,NULL,NULL,'Y'),(196,380,380,'My Name is Andi Rianto',1338265176,NULL,NULL,'Y'),(198,335,350,'Oi satria :)',1338465744,NULL,NULL,'Y'),(199,335,360,'Maho',1338465756,NULL,NULL,'Y'),(200,335,340,'Win',1338465780,NULL,NULL,'Y'),(201,335,328,'Oi Jank',1338465793,NULL,NULL,'Y'),(202,335,328,'Ijaaaaaank :)',1338469631,NULL,NULL,'Y'),(205,375,375,'c*******2',1339979776,NULL,NULL,'Y'),(206,375,375,'Saya mengunggah foto baru <div width=\"50\" height=\"50\"><img src=\"uploads/photos/f61d6947467ccd3aa5af24db320235dd/thumb_9b47714782de3347bffd37db19ca1a2c.jpg\" /></div>',1340112248,NULL,NULL,'Y'),(208,335,375,'Hai Akun Testing 2, ini dari Akun Testing 1',1340139952,NULL,NULL,'Y'),(211,335,335,'Aku membuat tulisan baru dengan judul : <b>Testing</b> ayo lihat</div>',1340142576,NULL,NULL,'Y'),(212,335,335,'Ini status saya',1340142812,NULL,NULL,'Y'),(214,394,394,'Hai',1340146092,NULL,NULL,'Y'),(215,394,394,'Aku membuat tulisan baru dengan judul : <b>testing</b> ayo lihat</div>',1340146666,NULL,NULL,'Y'),(216,394,394,'Aku membuat tulisan baru dengan judul : <b>testing</b> ayo lihat</div>',1340146670,NULL,NULL,'Y'),(217,394,394,'Aku mengunggah foto baru <div width=\"50\" height=\"50\"><img src=\"uploads/photos/28f0b864598a1291557bed248a998d4e/thumb_1a4322e8ba87ade237c1071d4fa311cc.jpg\" /></div>',1340146711,NULL,NULL,'Y'),(219,403,403,'Ini status 1',1341295319,NULL,NULL,'Y'),(221,403,403,'c*******2',1341297548,NULL,NULL,'Y'),(222,406,406,'bagus.....',1341431519,NULL,NULL,'Y'),(223,406,406,'Aku mengunggah foto baru <div width=\"50\" height=\"50\"><img src=\"http://dinua.net/uploads/photos/8cb22bdd0b7ba1ab13d742e22eed8da2/thumb_ff3dc0cf0214a20c6c6c43da30ab8d42.jpg\" /></div>',1341431948,NULL,NULL,'Y'),(224,406,406,'Aku mengunggah foto baru <div width=\"50\" height=\"50\"><img src=\"http://dinua.net/uploads/photos/8cb22bdd0b7ba1ab13d742e22eed8da2/thumb_befbe480cc9954cbaebea0b027d49d8d.jpg\" /></div>',1341431964,NULL,NULL,'Y'),(225,406,406,'Aku mengunggah foto baru <div width=\"50\" height=\"50\"><img src=\"http://dinua.net/uploads/photos/8cb22bdd0b7ba1ab13d742e22eed8da2/thumb_97e2a2c6ec57ceb95ac8e519d5524801.jpg\" /></div>',1341432003,NULL,NULL,'Y'),(226,406,406,'Aku mengunggah foto baru <div width=\"50\" height=\"50\"><img src=\"http://dinua.net/uploads/photos/8cb22bdd0b7ba1ab13d742e22eed8da2/thumb_c35f01fd80f8f0e5e61f2275c9c1ff11.jpg\" /></div>',1341432051,NULL,NULL,'Y'),(227,406,406,'Aku mengunggah foto baru <div width=\"50\" height=\"50\"><img src=\"http://dinua.net/uploads/photos/8cb22bdd0b7ba1ab13d742e22eed8da2/thumb_29bee5bcd4d2656eca53a0f5aca61a6b.jpg\" /></div>',1341432067,NULL,NULL,'Y'),(228,413,413,'a****g',1342669674,NULL,NULL,'Y'),(229,416,416,'jangan nakal ya nak.',1343143133,NULL,NULL,'Y'),(230,416,416,'Aku mengunggah foto baru <div width=\"50\" height=\"50\"><img src=\"http://dinua.net/uploads/photos/8fe0093bb30d6f8c31474bd0764e6ac0/thumb_5e475f6507aed56692350bd2a43c8ced.jpg\" /></div>',1343143269,NULL,NULL,'Y'),(231,335,335,'Akhirnya aku di ACC... gimana ya nasib Dinua??? bisa lebih berkembang ato gimna yah :(',1343821979,NULL,NULL,'Y');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_upd_status` BEFORE UPDATE ON `status` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							UPDATE STATUS
================================================================*/
/*update COMMENTS*/
UPDATE  comments SET tid=NEW.id WHERE tid=OLD.id AND comments.content='S'; 

/*update likes*/
UPDATE  likes SET tid=NEW.id WHERE tid=OLD.id AND likes.content='S'; 
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`k7878351`@`localhost`*/ /*!50003 TRIGGER `trgr_del_status` BEFORE DELETE ON `status` FOR EACH ROW /* TRIGGER INI DIGUNAKAN UNTUK MENJAGA AGAR TID COMMENTS 
TETAP SAMA DENGAN ID KONTEN YANG DIKOMENTARI SERTA OTOMATIS MENGHAPUS JIKA 
KONTEN YANG DIKOMENTARI DIHAPUS 
21 - FEBRURAI - 2011
SOFYAN HADI A.*/

BEGIN
/*================================================================
							HAPUS STATUS
================================================================*/
/*delete comments*/
DELETE FROM  comments WHERE tid=old.id AND comments.content='S'; 

/*delete likes*/
DELETE FROM  likes WHERE tid=old.id AND likes.content='S'; 

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `warning`
--

DROP TABLE IF EXISTS `warning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warning` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_warning_accounts` (`uid`),
  CONSTRAINT `FK_warning_accounts` FOREIGN KEY (`uid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warning`
--

LOCK TABLES `warning` WRITE;
/*!40000 ALTER TABLE `warning` DISABLE KEYS */;
/*!40000 ALTER TABLE `warning` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'k7878351_dinua'
--

--
-- Final view structure for view `accounts_active`
--

/*!50001 DROP TABLE IF EXISTS `accounts_active`*/;
/*!50001 DROP VIEW IF EXISTS `accounts_active`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`k7878351`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `accounts_active` AS select `accounts`.`id` AS `id`,`accounts`.`email` AS `email`,`accounts`.`password` AS `password`,`accounts`.`created` AS `created`,`accounts`.`gender` AS `gender`,`accounts`.`avatar` AS `avatar`,`accounts`.`realname` AS `realname`,`accounts`.`about_me` AS `about_me`,`accounts`.`birthday` AS `birthday`,`accounts`.`country` AS `country`,`accounts`.`city` AS `city`,`accounts`.`address` AS `address`,`accounts`.`occupation` AS `occupation`,`accounts`.`work_at` AS `work_at`,`accounts`.`settings` AS `settings`,`accounts`.`disabled` AS `disabled`,`accounts`.`lastlogin` AS `lastlogin`,`accounts`.`ip` AS `ip`,`accounts`.`salt` AS `salt` from `accounts` where isnull(`accounts`.`disabled`) */
/*!50002 WITH CASCADED CHECK OPTION */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-08-01 11:57:32
