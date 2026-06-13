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
-- Table structure for table `bt_qc_ncrappproves`
--

DROP TABLE IF EXISTS `bt_qc_ncrappproves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_qc_ncrappproves` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ncr_id` int unsigned DEFAULT NULL,
  `status_id` int unsigned DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_qc_ncrappproves_ncr_id_index` (`ncr_id`),
  KEY `bt_qc_ncrappproves_created_by_index` (`created_by`),
  KEY `bt_qc_ncrappproves_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_qc_ncrappproves`
--

LOCK TABLES `bt_qc_ncrappproves` WRITE;
/*!40000 ALTER TABLE `bt_qc_ncrappproves` DISABLE KEYS */;
INSERT INTO `bt_qc_ncrappproves` VALUES (1,13,1,20,NULL,'','2020-08-06 14:26:22','2020-08-06 14:26:22'),(2,16,1,5,NULL,'','2020-08-18 14:29:54','2020-08-18 14:29:54'),(3,14,1,5,NULL,'','2020-08-18 14:30:12','2020-08-18 14:30:12'),(4,10,1,5,NULL,'','2020-08-18 14:30:30','2020-08-18 14:30:30'),(5,2,1,5,NULL,'','2020-08-18 14:30:47','2020-08-18 14:30:47'),(6,3,1,5,NULL,'','2020-08-18 14:31:05','2020-08-18 14:31:05'),(7,6,1,5,NULL,'','2020-08-18 14:31:20','2020-08-18 14:31:20'),(8,15,1,20,NULL,'','2020-08-18 14:33:33','2020-08-18 14:33:33'),(9,20,1,30,30,'','2020-10-22 08:26:15','2020-11-30 09:57:31'),(10,21,1,9,NULL,'','2022-05-18 06:59:12','2022-05-18 06:59:12');
/*!40000 ALTER TABLE `bt_qc_ncrappproves` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:55:34
