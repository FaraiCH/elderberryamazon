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
-- Table structure for table `bt_factory_assettypes`
--

DROP TABLE IF EXISTS `bt_factory_assettypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_factory_assettypes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `assettype` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specification` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `haswarranty` int DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_factory_assettypes_created_by_index` (`created_by`),
  KEY `bt_factory_assettypes_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_factory_assettypes`
--

LOCK TABLES `bt_factory_assettypes` WRITE;
/*!40000 ALTER TABLE `bt_factory_assettypes` DISABLE KEYS */;
INSERT INTO `bt_factory_assettypes` VALUES (1,'Laptop - Core™ i7','DELL','Intel® Core™ i7, 8GB RAM',3,1,'Work place Issue',25,25,'2020-09-07 14:39:00','2020-09-07 14:46:41'),(2,'Laptop- Core™ i5','DELL','Intel® Core™ i5  8GB RAM',4,1,'Employee issue',25,25,'2020-09-07 14:41:29','2020-09-07 14:46:22'),(3,'Laptop - Core i5 ®  8GB RAM','LENOVO','Intel® Core i5 ®  8GB RAM',7,1,'Employee issue.',25,25,'2020-09-07 16:11:46','2020-09-07 16:35:44'),(4,'LapTop - Core™ i3 ,4GB RAM','DELL','Intel® Core™ i3 	  4GB',4,1,'Employee issue',25,25,'2020-09-07 16:22:52','2020-09-07 16:35:14'),(5,'LapTop - Celeron','LENOVO','Intel® Celeron ®  4GB',1,1,'Employee issue',25,NULL,'2020-09-07 16:44:25','2020-09-07 16:44:25'),(6,'13th Gen Intel® Core™ i7','DELL','13th Gen Intel® Core™ i7, GB RAM',5,1,'Work',46,NULL,'2023-05-31 13:54:09','2023-05-31 13:54:09');
/*!40000 ALTER TABLE `bt_factory_assettypes` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:48:52
