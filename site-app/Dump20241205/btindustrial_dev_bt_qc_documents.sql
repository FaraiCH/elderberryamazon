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
-- Table structure for table `bt_qc_documents`
--

DROP TABLE IF EXISTS `bt_qc_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_qc_documents` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int unsigned DEFAULT NULL,
  `sub_id` int unsigned DEFAULT NULL,
  `datapack_id` int unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assinged_date` date DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_qc_documents_category_id_index` (`category_id`),
  KEY `bt_qc_documents_sub_id_index` (`sub_id`),
  KEY `bt_qc_documents_datapack_id_index` (`datapack_id`),
  KEY `bt_qc_documents_created_by_index` (`created_by`),
  KEY `bt_qc_documents_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_qc_documents`
--

LOCK TABLES `bt_qc_documents` WRITE;
/*!40000 ALTER TABLE `bt_qc_documents` DISABLE KEYS */;
INSERT INTO `bt_qc_documents` VALUES (13,1,6,NULL,'PROCEDURE','PROCEDURE DOCUMENTS',NULL,13,9,'2020-02-04 09:12:31','2022-11-15 09:29:05'),(14,1,9,NULL,'SANS and ISO Standards','',NULL,13,9,'2020-02-04 09:15:27','2022-11-15 09:25:27'),(19,1,10,NULL,'LAB BLANK TEMPLATES FOR TEST REPORT AND REGISTER','',NULL,13,9,'2020-02-05 03:39:18','2024-01-05 09:45:51'),(20,2,12,NULL,'ISO 9001:2015 External Audit Report','','2019-09-26',13,122,'2020-05-21 18:23:26','2024-10-16 02:29:53'),(21,2,12,NULL,'SANS External Audit Report','','2019-06-05',13,13,'2020-05-21 18:24:54','2020-06-01 19:43:17'),(22,2,13,NULL,'Robus Audits Report','','2020-01-27',13,93,'2020-05-21 19:08:41','2024-11-01 22:07:35'),(23,2,14,NULL,'BT - Management Review','',NULL,13,NULL,'2020-06-01 19:39:53','2020-06-01 19:39:53'),(24,2,11,NULL,'BT-Industrial Internal Audit Report (ISO 9001:2015 & SANS 4427-2)','Internal Audits And external Audits','2020-05-28',13,9,'2020-06-03 08:18:45','2022-05-18 06:56:26');
/*!40000 ALTER TABLE `bt_qc_documents` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:53:26
