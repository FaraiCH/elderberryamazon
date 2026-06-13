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
-- Table structure for table `bt_hr_departments`
--

DROP TABLE IF EXISTS `bt_hr_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_hr_departments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emps_in_department` int DEFAULT NULL,
  `total_hours` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_hr_departments`
--

LOCK TABLES `bt_hr_departments` WRITE;
/*!40000 ALTER TABLE `bt_hr_departments` DISABLE KEYS */;
INSERT INTO `bt_hr_departments` VALUES (1,'Sales','2019-10-28 22:17:56','2019-10-28 22:17:56','Sales',5,45),(2,'Production','2019-10-28 22:17:56','2022-06-30 12:06:21','Production',24,45),(3,'Finance','2019-10-28 22:17:56','2019-10-28 22:17:56','Finance',5,45),(4,'IT','2020-01-07 10:30:25','2022-06-30 12:11:40','IT',3,45),(5,'Quality','2020-01-07 13:16:31','2020-01-07 13:16:31','Quality',5,45),(6,'Projects','2020-01-14 15:46:02','2020-01-14 15:46:02','Projects',5,45),(8,'HR','2020-01-19 12:33:30','2020-01-19 12:33:30','HR',5,45),(9,'Maintenance','2020-06-11 11:09:37','2022-06-30 12:09:19','Maintenance',10,45),(10,'Logistics','2020-06-11 11:10:24','2022-06-30 12:09:35','Logistics',11,45),(11,'BT Health','2020-06-11 11:13:04','2022-01-26 18:25:39','Health',5,45),(15,'Executive Manager','2022-10-11 12:37:55','2022-10-11 12:37:55','Executive',NULL,NULL),(17,'Reception','2023-07-04 10:40:44','2023-07-04 10:40:44','Reception',NULL,NULL),(18,'Warehouse','2023-07-04 10:42:28','2023-09-12 09:31:00','Warehouse',NULL,NULL),(19,'Sheq','2023-07-04 11:20:15','2023-07-04 11:20:15','Sheq',NULL,NULL),(20,'Cleaning','2023-10-10 13:21:43','2023-10-17 10:16:05','Cleaning',NULL,NULL),(21,'Office Administration','2023-11-02 09:49:45','2023-11-02 09:49:45','',NULL,NULL),(22,'Medical','2024-02-07 10:03:36','2024-02-07 10:03:36','Med',NULL,NULL);
/*!40000 ALTER TABLE `bt_hr_departments` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:41:21
