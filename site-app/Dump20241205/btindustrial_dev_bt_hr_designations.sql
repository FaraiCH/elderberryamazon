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
-- Table structure for table `bt_hr_designations`
--

DROP TABLE IF EXISTS `bt_hr_designations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_hr_designations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_hr_designations`
--

LOCK TABLES `bt_hr_designations` WRITE;
/*!40000 ALTER TABLE `bt_hr_designations` DISABLE KEYS */;
INSERT INTO `bt_hr_designations` VALUES (1,'Executive Mgr','2019-10-28 22:17:56','2020-06-01 11:28:20'),(2,'Senior Management','2019-10-28 22:17:56','2019-10-28 22:17:56'),(3,'Professionaly Qualified','2019-10-28 22:17:56','2019-10-28 22:17:56'),(4,'Skilled Technical','2019-10-28 22:17:56','2019-10-28 22:17:56'),(5,'Semi-skilled','2019-10-28 22:17:56','2019-10-28 22:17:56'),(6,'Unskilled','2019-10-28 22:17:56','2019-10-28 22:17:56'),(7,'Unknown','2019-10-28 22:17:56','2019-10-28 22:17:56'),(8,'IT','2020-06-01 10:35:41','2020-06-01 10:35:41'),(9,'Internal Sales','2020-06-01 10:36:21','2020-06-01 11:18:54'),(10,'Finance Mgr','2020-06-01 10:38:30','2020-06-01 11:27:39'),(11,'Head Engineering','2020-06-01 11:14:32','2020-06-01 11:14:32'),(12,'Engineer: Support Functions','2020-06-01 11:15:10','2020-06-01 11:15:10'),(13,'Head Sales & Marketing','2020-06-01 11:15:33','2020-06-01 11:15:33'),(14,'Account Mgr','2020-06-01 11:16:08','2020-06-01 11:28:04'),(15,'Production Mgr','2020-06-01 11:16:20','2020-06-01 11:27:29'),(16,'QC Engineer','2020-06-01 11:16:47','2020-06-01 11:16:47'),(17,'Snr QC Inspector','2020-06-01 11:18:01','2020-06-01 11:18:01'),(18,'Production Supervisor','2020-06-01 11:18:38','2020-06-04 14:26:19'),(19,'Engineering Service Mgr','2020-06-01 11:27:22','2020-06-01 11:27:22'),(20,'SHE Officer','2020-06-11 11:08:47','2020-06-11 11:08:47'),(21,'Logistics','2020-06-17 15:37:26','2020-06-17 15:37:26'),(22,'Logistics Manager','2020-06-24 11:53:16','2020-06-24 11:53:16'),(23,'BT Health Projects','2020-06-24 15:07:21','2020-06-24 15:07:21'),(24,'Cleaning','2023-10-10 13:30:14','2023-10-10 13:30:14'),(25,'QC Supervisor','2023-10-10 13:49:57','2023-10-10 13:49:57'),(26,'Extrusion Operator','2023-10-10 13:50:36','2023-10-10 13:50:36'),(27,'Artisan Assistant','2023-10-11 08:47:32','2023-10-11 08:47:32'),(28,'Storeman','2023-10-11 08:47:54','2023-10-11 08:47:54'),(29,'Boilermaker','2023-10-11 08:48:10','2023-10-11 08:48:10'),(30,'Electrician','2023-10-11 08:48:28','2023-10-11 08:48:28'),(31,'Millwright','2023-10-11 08:48:55','2023-10-11 08:48:55'),(32,'Fitter & Turner','2023-10-11 08:49:33','2023-10-11 08:49:33'),(33,'Forklift Driver','2023-10-11 11:55:57','2023-10-11 11:55:57'),(34,'Production Supervisor','2023-10-11 11:56:27','2023-10-11 11:56:27'),(35,'Assistant Operator','2023-10-11 11:57:06','2023-10-11 11:57:06'),(36,'Operator','2023-10-11 11:57:19','2023-10-11 11:57:19'),(37,'Production Planner','2023-10-11 11:57:47','2023-10-11 11:57:47'),(38,'Raw Material Assistant','2023-10-11 12:00:03','2023-10-11 12:00:03'),(39,'General Assistant','2023-10-11 12:00:45','2023-10-11 12:00:45'),(40,'Supervisor','2023-10-11 12:01:50','2023-10-11 12:01:50'),(41,'Lab Assistant','2023-10-11 12:02:22','2023-10-11 12:02:22'),(42,'QC Assistant','2023-10-11 12:03:34','2023-10-11 12:03:34'),(43,'Quality Controller','2023-10-11 12:04:02','2023-10-11 12:04:02'),(44,'Dispatcher','2023-10-11 12:05:45','2023-10-11 12:05:45'),(45,'Analyst','2023-10-11 12:05:59','2023-10-11 12:05:59'),(46,'Superintendent','2023-10-11 12:06:34','2023-10-11 12:06:34'),(47,'Logistics Administrator','2023-10-11 12:07:06','2023-10-11 12:07:06'),(48,'Warehouse Supervisor','2023-10-12 07:42:28','2023-10-12 07:42:28'),(49,'Forklift supervisor','2023-10-12 08:02:43','2023-10-12 08:02:43'),(50,'Loader','2023-10-12 08:11:35','2023-10-12 08:11:35'),(51,'Loading Team Leader','2023-10-12 08:13:05','2023-10-12 08:43:03'),(52,'Driver','2023-10-12 08:25:46','2023-10-12 08:25:46'),(53,'Dispatch Supervisor','2023-10-12 08:30:45','2023-10-12 08:30:45'),(54,'Order Facilitator','2023-10-12 08:53:33','2023-10-12 08:53:33'),(55,'Cleaner','2023-10-17 10:17:31','2023-10-17 10:17:31'),(56,'Lab Technician','2023-10-18 08:05:42','2023-10-18 08:05:42'),(57,'ERP System Coordinator','2023-10-19 07:17:16','2023-10-19 07:17:16'),(58,'Software Developer','2023-10-19 14:00:31','2023-10-19 14:00:31'),(59,'Intermediate Software Developer','2023-10-19 14:01:14','2023-10-19 14:01:14'),(61,'Receptionist','2023-11-02 09:50:51','2023-11-02 09:50:51'),(62,'Welder','2023-11-02 12:40:54','2023-11-02 12:40:54'),(63,'Personal Assistant','2024-01-08 13:12:56','2024-01-08 13:12:56'),(64,'Consultant','2024-02-07 10:05:15','2024-02-07 10:05:15'),(65,'Administrator','2024-04-05 12:01:36','2024-04-05 12:01:36'),(66,'Bookkeeper','2024-04-11 09:51:32','2024-04-11 09:51:32'),(67,'Data Analyst Assistance','2024-05-22 14:06:07','2024-05-22 14:06:07');
/*!40000 ALTER TABLE `bt_hr_designations` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:43:15
