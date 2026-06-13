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
-- Table structure for table `bt_hr_leave_types`
--

DROP TABLE IF EXISTS `bt_hr_leave_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_hr_leave_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_hr_leave_types`
--

LOCK TABLES `bt_hr_leave_types` WRITE;
/*!40000 ALTER TABLE `bt_hr_leave_types` DISABLE KEYS */;
INSERT INTO `bt_hr_leave_types` VALUES (1,'Annual Leave','2019-10-28 22:17:56','2022-06-23 07:51:22'),(2,'Sick Leave','2019-10-28 22:17:56','2019-10-28 22:17:56'),(3,'Absence','2019-10-28 22:17:56','2019-10-28 22:17:56'),(4,'Suspended','2019-10-28 22:17:56','2019-10-28 22:17:56'),(5,'Sick without sicknote','2022-06-23 07:42:52','2022-06-23 07:50:44'),(6,'P Holiday','2022-06-23 07:43:55','2022-06-23 07:43:55'),(7,'P Holiday worked','2022-06-23 07:44:44','2022-06-23 07:44:44'),(8,'Shift cancelled','2022-06-23 07:46:13','2022-06-23 07:46:13'),(9,'Family Responsibility','2022-06-23 07:48:15','2022-06-23 07:48:15'),(10,'Study leave','2022-06-23 07:49:00','2022-06-23 07:49:00'),(11,'Worked on A Public Holiday (DO NOT USE)','2023-12-13 08:52:17','2023-12-18 17:12:49'),(12,'Other','2024-11-14 07:32:56','2024-11-14 07:32:56'),(13,'Half day','2024-11-14 07:34:55','2024-11-14 07:34:55');
/*!40000 ALTER TABLE `bt_hr_leave_types` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:55:18
