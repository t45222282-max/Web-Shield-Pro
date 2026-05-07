-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: dd
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `psec_bad-words`
--

DROP TABLE IF EXISTS `psec_bad-words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_bad-words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_bad-words`
--

LOCK TABLES `psec_bad-words` WRITE;
/*!40000 ALTER TABLE `psec_bad-words` DISABLE KEYS */;
INSERT INTO `psec_bad-words` VALUES (1,'&#34;TestHack&#34;'),(2,'FakeProduct'),(3,'FakeProduct.'),(4,'قليل ادب');
/*!40000 ALTER TABLE `psec_bad-words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psec_bans`
--

DROP TABLE IF EXISTS `psec_bans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_bans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` tinyint(1) NOT NULL DEFAULT 0,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autoban` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_bans`
--

LOCK TABLES `psec_bans` WRITE;
/*!40000 ALTER TABLE `psec_bans` DISABLE KEYS */;
/*!40000 ALTER TABLE `psec_bans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psec_bans-country`
--

DROP TABLE IF EXISTS `psec_bans-country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_bans-country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` tinyint(1) NOT NULL DEFAULT 0,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_bans-country`
--

LOCK TABLES `psec_bans-country` WRITE;
/*!40000 ALTER TABLE `psec_bans-country` DISABLE KEYS */;
/*!40000 ALTER TABLE `psec_bans-country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psec_bans-other`
--

DROP TABLE IF EXISTS `psec_bans-other`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_bans-other` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_bans-other`
--

LOCK TABLES `psec_bans-other` WRITE;
/*!40000 ALTER TABLE `psec_bans-other` DISABLE KEYS */;
/*!40000 ALTER TABLE `psec_bans-other` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psec_bans-ranges`
--

DROP TABLE IF EXISTS `psec_bans-ranges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_bans-ranges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_range` char(19) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_bans-ranges`
--

LOCK TABLES `psec_bans-ranges` WRITE;
/*!40000 ALTER TABLE `psec_bans-ranges` DISABLE KEYS */;
/*!40000 ALTER TABLE `psec_bans-ranges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psec_dnsbl-databases`
--

DROP TABLE IF EXISTS `psec_dnsbl-databases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_dnsbl-databases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `database` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_dnsbl-databases`
--

LOCK TABLES `psec_dnsbl-databases` WRITE;
/*!40000 ALTER TABLE `psec_dnsbl-databases` DISABLE KEYS */;
INSERT INTO `psec_dnsbl-databases` VALUES (1,'bl.spamcop.net');
/*!40000 ALTER TABLE `psec_dnsbl-databases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psec_file-whitelist`
--

DROP TABLE IF EXISTS `psec_file-whitelist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_file-whitelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_file-whitelist`
--

LOCK TABLES `psec_file-whitelist` WRITE;
/*!40000 ALTER TABLE `psec_file-whitelist` DISABLE KEYS */;
/*!40000 ALTER TABLE `psec_file-whitelist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psec_ip-whitelist`
--

DROP TABLE IF EXISTS `psec_ip-whitelist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_ip-whitelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_ip-whitelist`
--

LOCK TABLES `psec_ip-whitelist` WRITE;
/*!40000 ALTER TABLE `psec_ip-whitelist` DISABLE KEYS */;
/*!40000 ALTER TABLE `psec_ip-whitelist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psec_live-traffic`
--

DROP TABLE IF EXISTS `psec_live-traffic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_live-traffic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `useragent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os_code` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_type` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'XX',
  `request_uri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bot` tinyint(1) NOT NULL DEFAULT 0,
  `date` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uniquev` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_live-traffic`
--

LOCK TABLES `psec_live-traffic` WRITE;
/*!40000 ALTER TABLE `psec_live-traffic` DISABLE KEYS */;
INSERT INTO `psec_live-traffic` VALUES (1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','Google Chrome','chrome','Windows 10','win-6','Computer','Unknown','XX','/pro1/Market/details.php?id=1%27%20OR%20%271%27=%271','localhost','',0,'06 May 2026','04:18',1),(2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36','Google Chrome','chrome','Windows 10','win-6','Computer','Unknown','XX','/pro1/Market/','localhost','',0,'06 May 2026','04:52',1),(3,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36','Google Chrome','chrome','Windows 10','win-6','Computer','Unknown','XX','/pro1/Market/search.php?value=FakeProduct&search=Submit','localhost','http://localhost/pro1/Market/',0,'06 May 2026','04:53',0),(4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36','Google Chrome','chrome','Windows 10','win-6','Computer','Unknown','XX','/pro1/Market/search.php?value=%D9%82%D9%84%D9%8A%D9%84+%D8%A7%D8%AF%D8%A8&search=Submit','localhost','http://localhost/pro1/Market/search.php?value=FakeProduct&search=Submit',0,'06 May 2026','04:57',0),(5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','Google Chrome','chrome','Windows 10','win-6','Computer','Unknown','XX','/pro1/Market/details.php?id=','localhost','',0,'06 May 2026','05:12',0),(6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','Google Chrome','chrome','Windows 10','win-6','Computer','Unknown','XX','/pro1/Market/details.php?id=','localhost','',0,'06 May 2026','05:21',0),(7,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','Google Chrome','chrome','Windows 10','win-6','Computer','Unknown','XX','/pro1/Market/details.php','localhost','',0,'06 May 2026','05:21',0),(8,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','Google Chrome','chrome','Windows 10','win-6','Computer','Unknown','XX','/pro1/Market/','localhost','',0,'06 May 2026','05:21',0),(9,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','Google Chrome','chrome','Windows 10','win-6','Computer','Unknown','XX','/pro1/Market/details.php?id=','localhost','',0,'06 May 2026','09:00',0);
/*!40000 ALTER TABLE `psec_live-traffic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psec_logins`
--

DROP TABLE IF EXISTS `psec_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` char(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `successful` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_logins`
--

LOCK TABLES `psec_logins` WRITE;
/*!40000 ALTER TABLE `psec_logins` DISABLE KEYS */;
INSERT INTO `psec_logins` VALUES (1,'admin','127.0.0.1','06 May 2026','05:32',1),(2,'admin','127.0.0.1','06 May 2026','09:01',1),(3,'admin','127.0.0.1','06 May 2026','10:59',1);
/*!40000 ALTER TABLE `psec_logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psec_logs`
--

DROP TABLE IF EXISTS `psec_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `query` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `browser_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `os_code` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'XX',
  `region` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `city` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `latitude` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `longitude` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `useragent` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `referer_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_logs`
--

LOCK TABLES `psec_logs` WRITE;
/*!40000 ALTER TABLE `psec_logs` DISABLE KEYS */;
INSERT INTO `psec_logs` VALUES (1,'127.0.0.1','06 May 2026','04:28','/pro1/Market/details.php','id=1%27%20OR%20%271%27=%271','SQLi','Google Chrome 128.0.0.0','chrome','Windows 10 x64','win-6','Unknown','XX','Unknown','Unknown','0','0','Unknown','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36',''),(2,'127.0.0.1','06 May 2026','04:47','/pro1/Market/details.php','id=1%27%20OR%201=1','SQLi','Google Chrome 147.0.0.0','chrome','Windows 10 x64','win-6','Unknown','XX','Unknown','Unknown','0','0','Unknown','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0',''),(3,'127.0.0.1','06 May 2026','04:49','/pro1/Market/details.php','id=../../../../etc/passwd','SQLi','Google Chrome 147.0.0.0','chrome','Windows 10 x64','win-6','Unknown','XX','Unknown','Unknown','0','0','Unknown','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0',''),(4,'127.0.0.1','06 May 2026','05:02','/pro1/Market/index.php','','Bad Bot','curl 8.13.0','null','','null','Unknown','XX','Unknown','Unknown','0','0','Unknown','curl/8.13.0',''),(5,'127.0.0.1','06 May 2026','05:07','/pro1/Market/details.php','id=2%27--','SQLi','Google Chrome 128.0.0.0','chrome','Windows 10 x64','win-6','Unknown','XX','Unknown','Unknown','0','0','Unknown','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36',''),(6,'127.0.0.1','06 May 2026','05:08','/pro1/Market/details.php','id=1%27--','SQLi','Google Chrome 128.0.0.0','chrome','Windows 10 x64','win-6','Unknown','XX','Unknown','Unknown','0','0','Unknown','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36',''),(7,'127.0.0.1','06 May 2026','05:19','/pro1/Market/details.php','id=','Bad Bot','Unknown','null','','null','Unknown','XX','Unknown','Unknown','0','0','Unknown','BlackWidow',''),(8,'192.168.1.5','06 May 2026','05:30','/pro1/Market/index.php','','Proxy','curl 8.13.0','null','','null','Unknown','XX','Unknown','Unknown','0','0','Unknown','curl/8.13.0','');
/*!40000 ALTER TABLE `psec_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psec_pages-layolt`
--

DROP TABLE IF EXISTS `psec_pages-layolt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `psec_pages-layolt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psec_pages-layolt`
--

LOCK TABLES `psec_pages-layolt` WRITE;
/*!40000 ALTER TABLE `psec_pages-layolt` DISABLE KEYS */;
INSERT INTO `psec_pages-layolt` VALUES (1,'Banned','You are banned and you cannot continue to the website'),(2,'Blocked','Malicious request was detected'),(3,'Proxy','Access to the website via Proxy, VPN, TOR is not allowed (Disable Browser Data Compression if you have it enabled)'),(4,'Spam','You are in the Blacklist of Spammers and you cannot continue to the website'),(5,'Banned_Country','Sorry, but your country is banned and you cannot continue to the website'),(6,'Blocked_Browser','Access to the website through your Browser is not allowed, please use another Internet Browser'),(7,'Blocked_OS','Access to the website through your Operating System is not allowed'),(8,'Blocked_ISP','Your Internet Service Provider is blacklisted and you cannot continue to the website'),(9,'Blocked_RFR','Your referrer url is blocked and you cannot continue to the website');
/*!40000 ALTER TABLE `psec_pages-layolt` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-07  3:54:56
