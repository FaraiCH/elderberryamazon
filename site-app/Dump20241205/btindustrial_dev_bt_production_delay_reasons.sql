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
-- Table structure for table `bt_production_delay_reasons`
--

DROP TABLE IF EXISTS `bt_production_delay_reasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_production_delay_reasons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_production_delay_reasons_created_by_index` (`created_by`),
  KEY `bt_production_delay_reasons_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_production_delay_reasons`
--

LOCK TABLES `bt_production_delay_reasons` WRITE;
/*!40000 ALTER TABLE `bt_production_delay_reasons` DISABLE KEYS */;
INSERT INTO `bt_production_delay_reasons` VALUES (1,'Main extruder tripped',44,NULL,'2023-03-06 08:36:14','2023-03-06 08:36:14'),(2,'LINE CHANGE',44,1,'2023-03-06 08:39:59','2023-03-06 09:02:14'),(3,'DIE CHANGE',44,1,'2023-03-06 08:40:54','2023-03-06 09:01:53'),(4,'LOAD SHEDDING',44,1,'2023-03-06 08:41:59','2023-03-06 09:02:29'),(5,'POOR QAULITY OF MATERIAL',44,NULL,'2023-03-06 08:43:14','2023-03-06 08:43:14'),(6,'WATER PROBLEMS',44,NULL,'2023-03-06 08:43:54','2023-03-06 08:43:54'),(7,'PRESSURE PROBLEMS',44,NULL,'2023-03-06 08:44:18','2023-03-06 08:44:18'),(8,'SHORTAGE OF STUFF',44,NULL,'2023-03-06 08:46:03','2023-03-06 08:46:03'),(9,'SHORTAGE OF MATERIAL',44,NULL,'2023-03-06 08:47:32','2023-03-06 08:47:32'),(10,'MACHINE BREAKDOWNS',44,NULL,'2023-03-06 08:48:22','2023-03-06 08:48:22'),(11,'INADEQUATE FORKLIFTS',44,NULL,'2023-03-06 08:50:14','2023-03-06 08:50:14'),(12,'SHORTAGE OF TOOLS AND EQUIPMENT',44,NULL,'2023-03-06 08:51:50','2023-03-06 08:51:50'),(13,'POWER DEEPS',44,NULL,'2023-03-06 08:52:54','2023-03-06 08:52:54'),(14,'START AND RUN',1,NULL,'2023-03-06 09:00:48','2023-03-06 09:00:48'),(15,'VACUME TANK TRIPPING',1,NULL,'2023-03-06 09:01:18','2023-03-06 09:01:18'),(16,'TIP CHANGE',46,NULL,'2023-10-10 11:14:50','2023-10-10 11:14:50'),(17,'HOUSING',46,NULL,'2023-10-10 11:15:04','2023-10-10 11:15:04');
/*!40000 ALTER TABLE `bt_production_delay_reasons` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:57:48
