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
-- Table structure for table `bt_legal_categories`
--

DROP TABLE IF EXISTS `bt_legal_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_legal_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_legal_categories_created_by_index` (`created_by`),
  KEY `bt_legal_categories_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_legal_categories`
--

LOCK TABLES `bt_legal_categories` WRITE;
/*!40000 ALTER TABLE `bt_legal_categories` DISABLE KEYS */;
INSERT INTO `bt_legal_categories` VALUES (1,'Company Registration',1,NULL,'2021-02-11 13:02:00','2021-02-11 13:02:00'),(2,'Client Contacts',1,NULL,'2021-02-11 13:08:44','2021-02-11 13:08:44'),(3,'Company Policies',40,NULL,'2021-03-11 17:15:47','2021-03-11 17:15:47'),(4,'Company Loans',40,NULL,'2021-03-18 17:09:14','2021-03-18 17:09:14'),(5,'Agreements',45,45,'2021-08-20 09:24:36','2021-08-20 09:26:57'),(6,'Legal Compliance Documents',45,NULL,'2021-09-01 05:43:29','2021-09-01 05:43:29'),(7,'MM Trust',45,NULL,'2021-09-01 06:12:14','2021-09-01 06:12:14'),(8,'Human Resources',45,NULL,'2021-09-08 11:10:51','2021-09-08 11:10:51'),(9,'Quantity Surveying',45,NULL,'2021-09-23 07:12:14','2021-09-23 07:12:14'),(10,'Offers',45,NULL,'2021-11-24 12:34:46','2021-11-24 12:34:46'),(11,'Finance',45,NULL,'2021-11-24 12:42:30','2021-11-24 12:42:30'),(12,'Public Relations',45,NULL,'2021-11-24 13:17:50','2021-11-24 13:17:50'),(13,'HR Policies',45,NULL,'2022-05-26 12:21:17','2022-05-26 12:21:17'),(14,'Debit Order Mandate',45,NULL,'2022-10-17 07:32:40','2022-10-17 07:32:40'),(15,'Pinwheel Group SA',45,NULL,'2022-11-09 11:16:05','2022-11-09 11:16:05'),(16,'Company Secretary',45,NULL,'2023-01-18 08:37:49','2023-01-18 08:37:49'),(17,'Trademark',45,NULL,'2023-01-18 08:54:00','2023-01-18 08:54:00'),(18,'Jaylocom',40,NULL,'2024-09-21 16:31:04','2024-09-21 16:31:04');
/*!40000 ALTER TABLE `bt_legal_categories` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:32:47
