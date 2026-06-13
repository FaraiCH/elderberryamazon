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
-- Table structure for table `bt_production_breakdown_reasons`
--

DROP TABLE IF EXISTS `bt_production_breakdown_reasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_production_breakdown_reasons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_production_breakdown_reasons_created_by_index` (`created_by`),
  KEY `bt_production_breakdown_reasons_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_production_breakdown_reasons`
--

LOCK TABLES `bt_production_breakdown_reasons` WRITE;
/*!40000 ALTER TABLE `bt_production_breakdown_reasons` DISABLE KEYS */;
INSERT INTO `bt_production_breakdown_reasons` VALUES (1,'Main Motor tripping',46,44,'2023-03-30 08:28:29','2023-04-06 06:48:15'),(2,'Dryer mixer',46,NULL,'2023-03-30 08:29:08','2023-03-30 08:29:08'),(3,'Traverse motor alignment',46,NULL,'2023-03-30 08:30:24','2023-03-30 08:30:24'),(4,'Additional cooling adjustment',46,NULL,'2023-03-30 08:30:58','2023-03-30 08:30:58'),(5,'Die element overheating',46,NULL,'2023-03-30 08:31:19','2023-03-30 08:31:19'),(6,'Water failure',46,NULL,'2023-04-03 06:32:06','2023-04-03 06:32:06'),(7,'Shutdown coiler',46,NULL,'2023-04-03 06:32:36','2023-04-03 06:32:36'),(8,'Saw tripping',46,NULL,'2023-04-03 06:33:34','2023-04-03 06:33:34'),(9,'Coupling main motor',46,NULL,'2023-04-03 06:34:31','2023-04-03 06:34:31'),(10,'Jat  loader blocked',44,44,'2023-04-03 14:09:27','2023-04-03 14:12:19'),(11,'Mix does not load material(slow)',44,NULL,'2023-04-03 14:14:38','2023-04-03 14:14:38'),(12,'Calibrator blocked',44,NULL,'2023-04-04 12:06:00','2023-04-04 12:06:00'),(13,'Saw not cutting',44,NULL,'2023-04-04 12:34:18','2023-04-04 12:34:18'),(14,'MAIN MOTOR OVERLOADING AND HEATING UP',44,NULL,'2023-04-06 06:51:19','2023-04-06 06:51:19'),(15,'Machine vibrating(shaking)',44,NULL,'2023-04-11 12:02:27','2023-04-11 12:02:27'),(16,'Coilers switch buttons not working',44,NULL,'2023-04-12 06:33:16','2023-04-12 06:33:16'),(17,'Haul-off chain broken',44,44,'2023-04-12 06:42:11','2023-06-03 12:20:05'),(18,'Scale not working',44,NULL,'2023-04-21 06:36:41','2023-04-21 06:36:41'),(19,'Haul-off slippering',44,NULL,'2023-04-24 07:59:46','2023-04-24 07:59:46'),(20,'Vacuum pump tripped',44,NULL,'2023-05-03 11:18:43','2023-05-03 11:18:43'),(21,'Saw carriage not moving backward and forward',44,44,'2023-05-12 07:57:21','2023-05-25 08:44:34'),(22,'Handover to maintenance for shutdown.',44,44,'2023-05-12 12:59:23','2023-05-13 08:11:08'),(23,'Coiler width is too big for 25mm.',44,NULL,'2023-05-24 06:43:58','2023-05-24 06:43:58'),(24,'Supporting rollers are broken from the saw.',44,NULL,'2023-05-24 08:48:30','2023-05-24 08:48:30'),(25,'Haul-off scratching the pipe.',44,NULL,'2023-05-29 06:58:35','2023-05-29 06:58:35'),(26,'Haul-off breakdown',44,NULL,'2023-05-29 07:37:24','2023-05-29 07:37:24'),(27,'Strapping machine not working',44,NULL,'2023-06-01 12:22:12','2023-06-01 12:22:12'),(28,'Main water supplier pump breakdown',44,NULL,'2023-06-03 12:13:12','2023-06-03 12:13:12'),(29,'Stagnant water on Production Floor',44,NULL,'2023-10-10 12:52:28','2023-10-10 12:52:28'),(30,'Equipment wire protruding (Unsafe)',44,44,'2023-10-10 12:53:06','2023-10-10 12:53:23'),(31,'Rubber seals',44,NULL,'2023-10-10 12:53:58','2023-10-10 12:53:58'),(32,'Jet loader failure',44,NULL,'2023-10-19 09:12:39','2023-10-19 09:12:39');
/*!40000 ALTER TABLE `bt_production_breakdown_reasons` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:28:18
