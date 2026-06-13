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
-- Table structure for table `bt_qc_qcreasons`
--

DROP TABLE IF EXISTS `bt_qc_qcreasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_qc_qcreasons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_qc_qcreasons`
--

LOCK TABLES `bt_qc_qcreasons` WRITE;
/*!40000 ALTER TABLE `bt_qc_qcreasons` DISABLE KEYS */;
INSERT INTO `bt_qc_qcreasons` VALUES (1,'OD Over Spec','2023-05-26 05:05:06','2023-09-27 09:04:34'),(2,'Wall thickness under spec','2023-05-26 08:02:48','2023-05-26 10:55:59'),(3,'Poor Workmanship roughness inside','2023-05-26 08:05:55','2023-09-27 10:12:26'),(4,'Poor Workmanship pin holes outside','2023-05-26 08:07:03','2023-09-28 15:01:45'),(5,'Poor workmanship outside pipe','2023-05-26 08:07:42','2023-11-09 12:43:42'),(6,'Ovality over Spec','2023-05-26 08:08:08','2023-09-27 09:05:27'),(7,'Porosity','2023-05-26 08:10:09','2023-05-26 10:53:12'),(8,'Coil kinking','2023-05-26 08:16:56','2023-05-26 10:52:39'),(9,'Forklift damaged','2023-05-26 08:22:57','2023-11-15 14:43:44'),(10,'Short Length','2023-09-13 10:37:02','2023-09-13 10:37:02'),(11,'Ripples On Pipes','2023-09-27 08:58:28','2023-09-27 08:58:28'),(12,'Rings Inside Pipe','2023-09-27 08:59:06','2023-12-02 23:28:34'),(13,'Scratch lines outside the pipe','2023-09-27 09:00:36','2023-09-27 10:09:53'),(14,'Wall Thickness Over Spec','2023-09-27 09:03:44','2023-09-27 09:03:44'),(15,'OD Under Spec','2023-09-27 09:04:58','2023-09-27 09:04:58'),(16,'Ovality Under Spec','2023-09-27 09:05:50','2023-09-27 09:05:50'),(17,'Water Marks','2023-09-27 10:04:37','2023-09-27 10:07:13'),(18,'Scratch lines inside the pipe','2023-09-27 10:10:58','2023-09-27 10:10:58'),(19,'Wrong Printing','2023-10-01 05:11:00','2023-10-01 05:11:00'),(20,'poor workmanship outside pipe Folding outside','2023-10-08 02:48:27','2023-10-17 06:25:59'),(21,'Poor Workmanship roughness outside','2023-10-17 06:25:02','2023-10-17 06:25:02'),(22,'No Printing','2023-11-09 11:57:16','2023-11-09 11:57:16'),(23,'To be down Graded(wall Underspec)','2023-11-14 05:38:22','2023-11-14 05:38:22'),(24,'Poorworkmanship Pinholes inside Pipe','2023-11-16 13:27:40','2023-11-16 13:27:40'),(25,'Off Centre','2023-12-01 03:47:44','2023-12-01 03:47:44'),(26,'Lenght Over','2024-03-14 06:17:27','2024-03-14 06:18:12'),(27,'To be Upgraded (wall Overspec)','2024-11-01 10:08:38','2024-11-01 10:11:51'),(28,'End Squares','2024-11-01 10:08:52','2024-11-01 10:08:52');
/*!40000 ALTER TABLE `bt_qc_qcreasons` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:28:39
