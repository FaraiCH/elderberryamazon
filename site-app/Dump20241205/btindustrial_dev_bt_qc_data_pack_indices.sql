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
-- Table structure for table `bt_qc_data_pack_indices`
--

DROP TABLE IF EXISTS `bt_qc_data_pack_indices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_qc_data_pack_indices` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderno` int unsigned DEFAULT NULL,
  `abc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcatof` int unsigned DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_qc_data_pack_indices`
--

LOCK TABLES `bt_qc_data_pack_indices` WRITE;
/*!40000 ALTER TABLE `bt_qc_data_pack_indices` DISABLE KEYS */;
INSERT INTO `bt_qc_data_pack_indices` VALUES (1,'BT HOLD PROCEDURE',1,'A',0,'','2020-02-24 09:13:10','2020-02-24 09:13:10'),(2,'CERTIFICATE OF ANALYSIS (COA)',2,'B',0,'',NULL,'2021-07-02 08:34:30'),(3,'CERTIFICATE OF CONFORMANCE (COC)',3,'C',0,'',NULL,'2023-08-24 10:02:47'),(4,'MELT FLOW INDEX (MFI)',5,'D1',0,'',NULL,'2023-08-24 10:03:25'),(5,'OXIDATION INDUCTION TIME (OIT)',6,'D2',0,'',NULL,'2023-08-24 10:03:37'),(6,'INSPECTION SHEET',11,'C1',0,'',NULL,'2021-07-02 08:48:19'),(7,'HYDROSTATIC PRESSURE TEST',9,'D5',0,'',NULL,'2023-08-24 10:04:29'),(8,'LONGITUDINAL REVERSION TEST',8,'D3',0,'',NULL,'2023-08-24 10:04:00'),(10,'TENSILE TEST (ELONGATION AT BREAK)',7,'D4',0,'',NULL,'2023-08-24 10:04:16'),(11,'TEST REPORTS',4,'D',0,'',NULL,'2023-08-24 10:03:10'),(12,'CONTROLSHEET',10,'C',0,'','2021-03-30 12:44:46','2021-07-02 08:47:34'),(13,'PHOTOS OF SAMPLES',12,'E',0,'','2021-04-07 18:09:06','2023-08-24 10:04:48');
/*!40000 ALTER TABLE `bt_qc_data_pack_indices` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:35:44
