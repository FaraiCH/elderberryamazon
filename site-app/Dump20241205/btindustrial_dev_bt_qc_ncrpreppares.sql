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
-- Table structure for table `bt_qc_ncrpreppares`
--

DROP TABLE IF EXISTS `bt_qc_ncrpreppares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_qc_ncrpreppares` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ncr_id` int unsigned DEFAULT NULL,
  `status_id` int unsigned DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_qc_ncrpreppares_ncr_id_index` (`ncr_id`),
  KEY `bt_qc_ncrpreppares_created_by_index` (`created_by`),
  KEY `bt_qc_ncrpreppares_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_qc_ncrpreppares`
--

LOCK TABLES `bt_qc_ncrpreppares` WRITE;
/*!40000 ALTER TABLE `bt_qc_ncrpreppares` DISABLE KEYS */;
INSERT INTO `bt_qc_ncrpreppares` VALUES (1,11,1,13,NULL,'','2020-07-31 14:26:39','2020-07-31 14:26:39'),(2,12,1,13,NULL,'','2020-08-06 10:18:34','2020-08-06 10:18:34'),(3,13,1,13,NULL,'','2020-08-06 11:06:13','2020-08-06 11:06:13'),(4,10,1,13,NULL,'','2020-08-06 11:30:09','2020-08-06 11:30:09'),(5,1,1,13,NULL,'','2020-08-06 11:33:57','2020-08-06 11:33:57'),(6,14,1,13,NULL,'','2020-08-11 12:54:00','2020-08-11 12:54:00'),(7,15,1,13,NULL,'','2020-08-18 08:39:30','2020-08-18 08:39:30'),(8,16,1,13,NULL,'','2020-08-18 13:28:20','2020-08-18 13:28:20'),(9,3,1,13,NULL,'','2020-08-19 13:44:47','2020-08-19 13:44:47'),(10,2,1,13,NULL,'','2020-08-19 13:45:07','2020-08-19 13:45:07'),(11,4,1,13,NULL,'','2020-08-19 13:45:29','2020-08-19 13:45:29'),(12,6,1,13,NULL,'','2020-08-19 13:45:42','2020-08-19 13:45:42'),(13,8,1,13,NULL,'','2020-08-19 13:45:57','2020-08-19 13:45:57'),(14,18,1,13,NULL,'','2020-09-08 13:37:18','2020-09-08 13:37:18'),(15,20,1,9,NULL,'','2020-10-21 16:43:11','2020-10-21 16:43:11'),(16,19,1,9,NULL,'','2020-10-21 16:44:01','2020-10-21 16:44:01'),(17,21,1,9,NULL,'','2021-09-08 11:35:58','2021-09-08 11:35:58');
/*!40000 ALTER TABLE `bt_qc_ncrpreppares` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:32:06
