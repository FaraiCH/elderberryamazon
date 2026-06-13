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
-- Table structure for table `bt_notify_projectdates`
--

DROP TABLE IF EXISTS `bt_notify_projectdates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_notify_projectdates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int unsigned DEFAULT '1',
  `projectdate` datetime DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `status` int DEFAULT '0',
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_notify_projectdates_project_id_index` (`project_id`),
  KEY `bt_notify_projectdates_created_by_index` (`created_by`),
  KEY `bt_notify_projectdates_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_notify_projectdates`
--

LOCK TABLES `bt_notify_projectdates` WRITE;
/*!40000 ALTER TABLE `bt_notify_projectdates` DISABLE KEYS */;
INSERT INTO `bt_notify_projectdates` VALUES (3,1,'2023-04-25 12:00:00','Bailer 5 Launch','<p><img src=\"https://bailaerp.bt-industrial.co.za/storage/app/media/uploaded-files/hdpe.jpg\" style=\"height:100px;\" class=\"fr-fic fr-dib\"></p>',0,1,37,'2020-07-17 13:48:46','2023-05-03 19:50:24'),(4,1,'2023-09-06 08:00:00','Dekra Audit Notification','<p><img src=\"https://bailaerp.bt-industrial.co.za/storage/app/media/uploaded-files/dekras.png\" style=\"height: 70%;\" class=\"fr-fic fr-dib\"></p>',1,37,37,'2021-02-23 13:29:30','2023-04-26 07:29:46'),(5,2,'2023-04-01 12:00:00','BT Syringes','<p><img src=\"https://bailaerp.bt-industrial.co.za/storage/app/media/uploaded-files/Bt%20Image.jpg\" style=\"height: 200px; width: 400px;\" class=\"fr-fic fr-dib\"></p>',1,37,37,'2023-06-30 08:57:49','2023-06-30 11:41:00');
/*!40000 ALTER TABLE `bt_notify_projectdates` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:58:05
