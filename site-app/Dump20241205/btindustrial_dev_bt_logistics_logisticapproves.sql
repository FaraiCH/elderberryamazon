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
-- Table structure for table `bt_logistics_logisticapproves`
--

DROP TABLE IF EXISTS `bt_logistics_logisticapproves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_logistics_logisticapproves` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` int unsigned DEFAULT NULL,
  `status_approve` int unsigned DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_logistics_logisticapproves_schedule_id_index` (`schedule_id`),
  KEY `bt_logistics_logisticapproves_created_by_index` (`created_by`),
  KEY `bt_logistics_logisticapproves_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_logistics_logisticapproves`
--

LOCK TABLES `bt_logistics_logisticapproves` WRITE;
/*!40000 ALTER TABLE `bt_logistics_logisticapproves` DISABLE KEYS */;
INSERT INTO `bt_logistics_logisticapproves` VALUES (1,1,0,25,25,'2020-10-28 22:15:16','2020-10-28 22:16:01'),(2,3,0,25,NULL,'2020-10-28 22:16:52','2020-10-28 22:16:52'),(3,4,0,25,25,'2020-10-28 22:17:17','2020-10-29 12:45:57'),(4,5,0,25,25,'2020-10-28 22:27:50','2020-10-28 22:28:41'),(5,6,0,25,25,'2020-11-03 14:23:48','2020-11-03 14:28:45'),(6,9,0,20,NULL,'2022-03-07 12:50:35','2022-03-07 12:50:35'),(7,71,1,36,NULL,'2023-03-07 08:05:02','2023-03-07 08:05:02'),(8,72,1,36,NULL,'2023-03-07 08:05:27','2023-03-07 08:05:27'),(9,76,1,36,NULL,'2023-03-09 06:26:17','2023-03-09 06:26:17'),(10,74,1,36,NULL,'2023-03-09 06:36:34','2023-03-09 06:36:34'),(11,77,1,36,NULL,'2023-03-09 12:33:32','2023-03-09 12:33:32'),(12,80,1,36,NULL,'2023-03-13 06:51:54','2023-03-13 06:51:54'),(13,83,1,36,NULL,'2023-03-13 11:07:00','2023-03-13 11:07:00'),(14,81,1,36,36,'2023-03-13 12:18:25','2023-03-13 12:18:38'),(15,79,1,36,NULL,'2023-03-14 07:40:47','2023-03-14 07:40:47'),(16,86,1,36,NULL,'2023-03-22 14:04:55','2023-03-22 14:04:55'),(17,211,1,88,NULL,'2024-01-12 07:32:32','2024-01-12 07:32:32'),(18,212,1,88,NULL,'2024-02-07 14:04:11','2024-02-07 14:04:11'),(19,213,1,88,NULL,'2024-02-07 14:05:12','2024-02-07 14:05:12'),(20,214,1,88,NULL,'2024-03-05 07:06:52','2024-03-05 07:06:52'),(21,215,0,88,NULL,'2024-03-05 10:28:56','2024-03-05 10:28:56'),(22,216,0,88,NULL,'2024-03-14 07:32:02','2024-03-14 07:32:02'),(23,217,1,88,NULL,'2024-04-05 08:40:41','2024-04-05 08:40:41'),(24,218,1,88,NULL,'2024-04-05 08:45:00','2024-04-05 08:45:00'),(25,219,1,88,NULL,'2024-04-05 08:50:39','2024-04-05 08:50:39'),(26,220,1,88,NULL,'2024-04-17 09:03:51','2024-04-17 09:03:51'),(27,222,1,88,NULL,'2024-04-29 10:00:42','2024-04-29 10:00:42'),(28,225,1,88,NULL,'2024-05-28 08:01:59','2024-05-28 08:01:59');
/*!40000 ALTER TABLE `bt_logistics_logisticapproves` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:48:41
