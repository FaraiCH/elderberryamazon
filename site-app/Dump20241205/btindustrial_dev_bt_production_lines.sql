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
-- Table structure for table `bt_production_lines`
--

DROP TABLE IF EXISTS `bt_production_lines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_production_lines` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `online` int DEFAULT '1',
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` int DEFAULT '0',
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `max_weight` int DEFAULT '0',
  `min_weight` int DEFAULT '0',
  `pipes` text COLLATE utf8mb4_unicode_ci,
  `bt_meter_id` int unsigned DEFAULT NULL,
  `sort_order` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_production_lines_created_by_index` (`created_by`),
  KEY `bt_production_lines_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_production_lines`
--

LOCK TABLES `bt_production_lines` WRITE;
/*!40000 ALTER TABLE `bt_production_lines` DISABLE KEYS */;
INSERT INTO `bt_production_lines` VALUES (1,'BAILA II','2019-05-08 23:10:53','2023-12-12 06:50:55',1,'',600,NULL,NULL,0,0,NULL,2,2),(2,'BAILA I','2019-05-08 23:10:53','2024-10-01 06:27:07',1,'',600,NULL,NULL,0,0,NULL,1,1),(3,'BAILA III','2019-08-15 11:32:30','2023-12-12 06:51:20',1,'',350,NULL,NULL,0,0,NULL,3,3),(4,'BAILA IV','2021-03-29 03:28:21','2024-10-01 06:27:45',1,'',220,NULL,NULL,0,0,NULL,4,4),(5,'BAILA V','2023-04-25 12:53:18','2024-10-01 06:27:30',0,'',240,NULL,NULL,NULL,NULL,NULL,5,5),(6,'BAILA VI','2023-10-05 10:52:28','2023-12-12 06:51:42',0,'',350,NULL,NULL,0,NULL,NULL,6,6);
/*!40000 ALTER TABLE `bt_production_lines` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:49:44
