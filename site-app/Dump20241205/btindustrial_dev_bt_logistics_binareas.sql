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
-- Table structure for table `bt_logistics_binareas`
--

DROP TABLE IF EXISTS `bt_logistics_binareas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_logistics_binareas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_pipe` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `num_plate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_length` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_logistics_binareas_created_by_index` (`created_by`),
  KEY `bt_logistics_binareas_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_logistics_binareas`
--

LOCK TABLES `bt_logistics_binareas` WRITE;
/*!40000 ALTER TABLE `bt_logistics_binareas` DISABLE KEYS */;
INSERT INTO `bt_logistics_binareas` VALUES (1,'A',20,1,'',NULL,37,46,'2023-05-25 07:26:46','2023-09-06 10:03:20','1 TO 3',20),(2,'B',10,1,'',NULL,37,46,'2023-05-26 18:55:03','2023-09-06 10:03:12','1 TO 4',24),(3,'C',10,1,'',NULL,37,46,'2023-05-26 18:55:48','2023-09-06 10:03:04','1 TO 3',18),(4,'D',10,0,'',NULL,37,46,'2023-05-26 18:56:49','2023-09-06 10:02:55','1 TO 3',18),(5,'E',10,1,'OVERFLOW AREA No RACKS',NULL,37,46,'2023-05-26 18:57:25','2023-09-06 10:02:45','1 TO 4',20),(6,'F',10,1,'',NULL,37,46,'2023-05-26 18:58:42','2023-09-06 10:02:35','1 TO 2',12),(7,'G',10,1,'',NULL,37,46,'2023-05-26 18:59:26','2023-09-06 10:02:27','1 TO 2',12),(8,'H',10,1,'',NULL,37,46,'2023-05-26 19:00:39','2023-09-06 10:02:18','1 TO 2',12),(9,'I',10,1,'',NULL,37,46,'2023-05-26 19:01:52','2023-09-06 10:02:10','1 TO 10',0),(10,'J',10,1,'',NULL,37,46,'2023-05-26 19:02:26','2023-09-06 10:01:56','1 TO 10',0),(11,'K',10,1,'',NULL,37,46,'2023-05-26 19:03:03','2023-09-06 10:01:46','1 TO 10',0),(12,'L',10,1,'',NULL,37,46,'2023-05-26 19:04:09','2023-09-06 10:01:36','NONE',0),(13,'M',10,1,'',NULL,37,46,'2023-05-26 19:04:32','2023-09-06 10:01:27','NONE',0),(14,'N',10,1,'',NULL,37,46,'2023-05-26 19:04:59','2023-09-06 10:03:34','NONE',0),(15,'O',10,1,'',NULL,37,46,'2023-05-26 19:05:28','2023-09-06 10:01:10','NONE',0),(16,'P',10,1,'',NULL,37,46,'2023-05-26 19:06:03','2023-09-06 10:01:01','NONE',0),(17,'Q',10,1,'RESELLS AND 6M PIPES',NULL,37,46,'2023-05-26 19:06:55','2023-09-06 10:00:51','1 TO 6',0),(18,'R',20,1,'',NULL,37,NULL,'2023-09-06 11:04:13','2023-09-06 11:04:13','NONE',0);
/*!40000 ALTER TABLE `bt_logistics_binareas` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:56:36
