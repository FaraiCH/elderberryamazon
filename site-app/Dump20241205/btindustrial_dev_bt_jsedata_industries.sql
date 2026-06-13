-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: btindustrial-prod-instance-1-cluster.cluster-cvui6jj4ovao.eu-west-1.rds.amazonaws.com    Database: btindustrial_dev
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '';

--
-- Table structure for table `bt_jsedata_industries`
--

DROP TABLE IF EXISTS `bt_jsedata_industries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_jsedata_industries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_jsedata_industries_created_by_index` (`created_by`),
  KEY `bt_jsedata_industries_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_jsedata_industries`
--

LOCK TABLES `bt_jsedata_industries` WRITE;
/*!40000 ALTER TABLE `bt_jsedata_industries` DISABLE KEYS */;
INSERT INTO `bt_jsedata_industries` VALUES (1,'Basic Materials',1,NULL,'2021-02-08 21:55:35','2021-02-08 21:55:35'),(2,'Communications',1,NULL,'2021-02-08 21:55:43','2021-02-08 21:55:43'),(3,'Consumer, Cyclical',1,NULL,'2021-02-08 21:55:51','2021-02-08 21:55:51'),(4,'Consumer, Non-cyclical',1,NULL,'2021-02-08 21:56:00','2021-02-08 21:56:00'),(5,'Diversified',1,NULL,'2021-02-08 21:56:12','2021-02-08 21:56:12'),(6,'Energy',1,NULL,'2021-02-08 21:56:23','2021-02-08 21:56:23'),(7,'General Industrials',1,38,'2021-02-08 21:56:37','2021-02-11 12:18:39'),(8,'Industry Sector',1,NULL,'2021-02-08 21:56:46','2021-02-08 21:56:46'),(9,'Technology Hardware & Equipment',1,38,'2021-02-08 21:56:56','2021-02-11 12:06:47'),(10,'Utilities',1,NULL,'2021-02-08 21:57:05','2021-02-08 21:57:05'),(11,'Financial Services',1,38,'2021-02-08 22:21:16','2021-02-11 11:43:33'),(12,'N/A',1,NULL,'2021-02-09 14:35:24','2021-02-09 14:35:24'),(13,'Real Estate Investment Trusts',38,NULL,'2021-02-11 11:49:05','2021-02-11 11:49:05'),(14,'Banks',38,NULL,'2021-02-11 11:52:20','2021-02-11 11:52:20'),(15,'Chemicals',38,NULL,'2021-02-11 11:56:08','2021-02-11 11:56:08'),(16,'Real Estate Investment & Services',38,NULL,'2021-02-11 11:56:23','2021-02-11 11:56:23'),(17,'Software & Computer Services',38,NULL,'2021-02-11 11:56:37','2021-02-11 11:56:37'),(18,'Pharmaceuticals & Biotechnology',38,NULL,'2021-02-11 11:57:19','2021-02-11 11:57:19'),(19,'Support Services',38,NULL,'2021-02-11 11:57:51','2021-02-11 11:57:51'),(20,'Health Care Equipment & Services',38,NULL,'2021-02-11 11:59:00','2021-02-11 11:59:00'),(21,'General Retailers',38,NULL,'2021-02-11 11:59:50','2021-02-11 11:59:50'),(22,'Media',38,NULL,'2021-02-11 12:01:41','2021-02-11 12:01:41'),(23,'Construction & Materials',38,NULL,'2021-02-11 12:04:18','2021-02-11 12:04:18'),(24,'Food Producers',38,NULL,'2021-02-11 12:05:06','2021-02-11 12:05:06'),(25,'Aerospace & Defense',38,NULL,'2021-02-11 12:05:48','2021-02-11 12:05:48'),(26,'Mining',38,NULL,'2021-02-11 12:07:13','2021-02-11 12:07:13'),(27,'Beverages',38,NULL,'2021-02-11 12:07:46','2021-02-11 12:07:46'),(28,'Personal Goods',38,NULL,'2021-02-11 12:08:36','2021-02-11 12:08:36'),(29,'Industrial Metals & Mining',38,NULL,'2021-02-11 12:09:29','2021-02-11 12:09:29'),(30,'Industrial Engineering',38,NULL,'2021-02-11 12:10:18','2021-02-11 12:10:18'),(31,'Tobacco',38,NULL,'2021-02-11 12:10:36','2021-02-11 12:10:36'),(32,'Oil Equipment, Services & Distribution',38,NULL,'2021-02-11 12:11:05','2021-02-11 12:11:05'),(33,'Electronic & Electrical Equipment',38,NULL,'2021-02-11 12:11:25','2021-02-11 12:11:25'),(34,'Industrial Transportation',38,NULL,'2021-02-11 12:13:37','2021-02-11 12:13:37'),(35,'Travel & Leisure',38,NULL,'2021-02-11 12:14:18','2021-02-11 12:14:18'),(36,'Food & Drug Retailers',38,NULL,'2021-02-11 12:14:44','2021-02-11 12:14:44'),(37,'Insurance',38,38,'2021-02-11 12:15:02','2021-02-11 12:26:37'),(38,'Oil & Gas Producers',38,NULL,'2021-02-11 12:17:00','2021-02-11 12:17:00'),(39,'Forestry & Paper',38,NULL,'2021-02-11 12:17:26','2021-02-11 12:17:26'),(40,'Automobiles & Parts',38,NULL,'2021-02-11 12:23:34','2021-02-11 12:23:34'),(41,'Household Goods & Home Construction',38,NULL,'2021-02-11 12:24:17','2021-02-11 12:24:17'),(42,'Electricity',38,NULL,'2021-02-12 12:17:05','2021-02-12 12:17:05'),(43,'Preference Shares',1,NULL,'2021-02-19 12:05:26','2021-02-19 12:05:26'),(45,'Life Insurance',1,NULL,'2021-02-19 12:12:42','2021-02-19 12:12:42'),(46,'Nonequity Investment',1,NULL,'2021-02-19 12:14:07','2021-02-19 12:14:07'),(47,'Equity Investment Instruments',1,NULL,'2021-02-19 12:16:42','2021-02-19 12:16:42');
/*!40000 ALTER TABLE `bt_jsedata_industries` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-05 17:38:17
