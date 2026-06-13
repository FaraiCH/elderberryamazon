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
-- Table structure for table `bt_qc_subs`
--

DROP TABLE IF EXISTS `bt_qc_subs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_qc_subs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int unsigned DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_qc_subs_category_id_index` (`category_id`),
  KEY `bt_qc_subs_created_by_index` (`created_by`),
  KEY `bt_qc_subs_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_qc_subs`
--

LOCK TABLES `bt_qc_subs` WRITE;
/*!40000 ALTER TABLE `bt_qc_subs` DISABLE KEYS */;
INSERT INTO `bt_qc_subs` VALUES (1,'MFI',1,13,13,'2020-01-09 16:14:38','2020-01-09 16:39:52'),(2,'OIT',1,13,NULL,'2020-01-09 16:40:09','2020-01-09 16:40:09'),(3,'TENSILE',1,13,NULL,'2020-01-09 16:40:28','2020-01-09 16:40:28'),(4,'THERMAL REVISION',1,13,NULL,'2020-01-09 16:40:44','2020-01-09 16:40:44'),(5,'HYDROSTATIC',1,13,NULL,'2020-01-09 16:41:02','2020-01-09 16:41:02'),(6,'PROCEDURES',1,1,1,'2020-01-14 17:24:36','2020-01-14 17:24:57'),(7,'CALIBRATION',1,13,NULL,'2020-01-19 12:58:33','2020-01-19 12:58:33'),(8,'MATERIAL',1,13,NULL,'2020-01-19 12:58:56','2020-01-19 12:58:56'),(9,'STANDARDS',1,13,NULL,'2020-02-04 09:14:07','2020-02-04 09:14:07'),(10,'TEMPLATES',1,13,NULL,'2020-02-05 03:37:57','2020-02-05 03:37:57'),(11,'Internal Audits',2,13,NULL,'2020-05-21 18:18:51','2020-05-21 18:18:51'),(12,'External Audits',2,13,NULL,'2020-05-21 18:19:16','2020-05-21 18:19:16'),(13,'Supplier Audits',2,13,NULL,'2020-05-21 18:19:43','2020-05-21 18:19:43'),(14,'Management Review Meeting',2,13,13,'2020-06-01 14:46:05','2020-06-01 14:47:11');
/*!40000 ALTER TABLE `bt_qc_subs` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:27:38
