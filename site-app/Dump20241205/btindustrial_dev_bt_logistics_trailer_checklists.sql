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
-- Table structure for table `bt_logistics_trailer_checklists`
--

DROP TABLE IF EXISTS `bt_logistics_trailer_checklists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_logistics_trailer_checklists` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `is_hazards_ok` int DEFAULT '0',
  `is_brakes_ok` int DEFAULT '0',
  `is_tires_ok` int DEFAULT '0',
  `is_lights_ok` int DEFAULT '0',
  `is_lefttires_ok` int DEFAULT '0',
  `brakes_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leftlights_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lights_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hazards_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tires_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trailer_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_logistics_trailer_checklists_trailer_id_index` (`trailer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_logistics_trailer_checklists`
--

LOCK TABLES `bt_logistics_trailer_checklists` WRITE;
/*!40000 ALTER TABLE `bt_logistics_trailer_checklists` DISABLE KEYS */;
INSERT INTO `bt_logistics_trailer_checklists` VALUES (1,'2022-04-08',1,1,1,1,1,'Good','Good','Good','Good','Good',1,'2022-04-08 12:46:00','2022-04-08 12:46:03'),(2,'2022-04-08',1,1,1,1,1,'Good','Good','Good','Good','Good',2,'2022-04-08 12:46:57','2022-04-08 12:47:00'),(3,'2022-04-08',1,1,1,1,1,'Good','Good','Good','Good','Good',3,'2022-04-08 13:01:47','2022-04-08 13:01:50'),(4,'2022-04-08',1,1,1,1,1,'Good','Good','Good','Good','Good',4,'2022-04-08 13:02:44','2022-04-08 13:02:46');
/*!40000 ALTER TABLE `bt_logistics_trailer_checklists` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:43:10
