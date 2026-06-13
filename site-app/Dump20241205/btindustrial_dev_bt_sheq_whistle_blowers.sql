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
-- Table structure for table `bt_sheq_whistle_blowers`
--

DROP TABLE IF EXISTS `bt_sheq_whistle_blowers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sheq_whistle_blowers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `who` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `where` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `what` text COLLATE utf8mb4_unicode_ci,
  `how` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sheq_whistle_blowers`
--

LOCK TABLES `bt_sheq_whistle_blowers` WRITE;
/*!40000 ALTER TABLE `bt_sheq_whistle_blowers` DISABLE KEYS */;
INSERT INTO `bt_sheq_whistle_blowers` VALUES (1,'0200-11-13','Noezan Sithole Test','BT Industrial','Test','Test','2023-11-22 07:43:28','2023-11-22 07:43:28'),(2,'2023-11-13','Noezan Sithole Test','BT Industrial','ddd','dffffg','2023-11-22 07:48:06','2023-11-22 07:48:06'),(3,'2023-11-23','Test','test','test','test','2023-11-23 07:28:38','2023-11-23 07:28:38'),(4,'2024-01-14','Rain','Benoni','It rained','The weather','2024-01-15 11:10:06','2024-01-15 11:10:06'),(5,'2024-01-14','Rain','Benoni','It rained','The weather','2024-01-15 11:10:24','2024-01-15 11:10:24'),(6,'2024-01-14','Rain','Benoni','It rained','The weather','2024-01-15 11:10:31','2024-01-15 11:10:31');
/*!40000 ALTER TABLE `bt_sheq_whistle_blowers` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:29:44
