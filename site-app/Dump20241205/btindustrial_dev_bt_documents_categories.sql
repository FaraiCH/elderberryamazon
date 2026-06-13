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
-- Table structure for table `bt_documents_categories`
--

DROP TABLE IF EXISTS `bt_documents_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_documents_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_documents_categories_created_by_index` (`created_by`),
  KEY `bt_documents_categories_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_documents_categories`
--

LOCK TABLES `bt_documents_categories` WRITE;
/*!40000 ALTER TABLE `bt_documents_categories` DISABLE KEYS */;
INSERT INTO `bt_documents_categories` VALUES (2,'Weekly Meetings',1,NULL,'2019-07-08 15:48:46','2019-07-08 15:48:46'),(3,'QUALITY CONTROL',9,NULL,'2019-07-11 08:10:33','2019-07-11 08:10:33'),(4,'HR',10,1,'2019-07-17 14:41:46','2019-11-05 09:23:06'),(5,'SALES',3,NULL,'2019-10-01 11:33:03','2019-10-01 11:33:03'),(6,'External Projects',10,NULL,'2019-10-01 12:38:39','2019-10-01 12:38:39'),(7,'PM and QS Projects - Mhluzi Industrial Park',1,12,'2019-11-11 20:25:31','2020-02-13 11:50:51'),(8,'SHE',10,NULL,'2020-01-21 14:45:22','2020-01-21 14:45:22'),(9,'PM and QS Projects - Mphephethe Primary School',12,NULL,'2020-02-13 12:10:02','2020-02-13 12:10:02'),(10,'PM and QS Projects - Lebohang Leandra Sewer Network',12,NULL,'2020-02-13 12:16:34','2020-02-13 12:16:34'),(11,'PM and QS Projects - Junior Traffic Centres (Mvuso Primary School & Zikhupule Primary School)',12,NULL,'2020-02-13 12:19:39','2020-02-13 12:19:39'),(12,'PM and QS Projects -  Schoongezicht Pump Station Upgrade',12,NULL,'2020-02-13 12:22:53','2020-02-13 12:22:53'),(13,'BT Medical Devices',10,NULL,'2020-07-09 14:58:24','2020-07-09 14:58:24'),(14,'Trial',10,NULL,'2020-08-04 15:59:03','2020-08-04 15:59:03'),(15,'FINANCE',37,NULL,'2021-07-22 17:30:02','2021-07-22 17:30:02'),(16,'Logistics',28,NULL,'2022-11-10 08:22:24','2022-11-10 08:22:24'),(17,'Engineering',46,46,'2022-11-11 09:19:54','2022-11-11 09:21:31'),(18,'Finance IT Meetings',11,NULL,'2022-11-15 07:36:57','2022-11-15 07:36:57'),(19,'Maintenance',10,NULL,'2023-03-29 07:41:28','2023-03-29 07:41:28'),(20,'Weekly Management Meeting Agenda & Minutes',12,NULL,'2023-09-22 07:51:21','2023-09-22 07:51:21'),(21,'BT IT Department MEETINGS',82,NULL,'2023-10-18 11:43:52','2023-10-18 11:43:52'),(22,'BT Zambia',113,113,'2024-09-19 09:36:14','2024-09-19 09:37:01');
/*!40000 ALTER TABLE `bt_documents_categories` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:29:55
