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
-- Table structure for table `bt_maintenance_equipment_types`
--

DROP TABLE IF EXISTS `bt_maintenance_equipment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_maintenance_equipment_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_maintenance_equipment_types`
--

LOCK TABLES `bt_maintenance_equipment_types` WRITE;
/*!40000 ALTER TABLE `bt_maintenance_equipment_types` DISABLE KEYS */;
INSERT INTO `bt_maintenance_equipment_types` VALUES (1,'General','2019-07-01 15:11:47','2019-07-01 15:11:47'),(2,'XINLAI ELECTRICALS','2019-07-01 13:48:02','2019-07-01 13:48:02'),(3,'XINLAI MECHANICAL','2019-07-01 13:48:20','2019-07-01 13:48:20'),(4,'YILI ELECTRICAL','2019-07-01 13:48:38','2019-07-01 13:48:38'),(5,'YILI MECHANICAL','2019-07-01 13:48:54','2019-07-01 13:48:54'),(6,'WORKSHOP MECH','2019-07-01 13:49:08','2019-07-01 13:49:08'),(7,'WORKSHOP ELEC','2019-07-01 13:49:31','2019-07-01 13:49:31'),(8,'WORKSHOP MECH 3','2019-07-01 13:49:56','2019-07-01 13:49:56'),(9,'Factory Auto Mobiles','2019-07-08 13:27:03','2019-07-09 09:09:59'),(10,'Production Tools','2019-07-09 09:06:03','2019-07-09 09:06:03'),(11,'Asset: Admin Office','2019-07-09 14:40:44','2019-07-09 14:40:44'),(12,'BAILA 3 MACHINERY','2019-07-09 14:40:44','2019-07-09 14:40:44'),(13,'QC LAB EQUIPMENTS HDPE','2020-08-21 14:23:06','2020-08-21 14:24:24'),(14,'Vehicle','2022-01-31 12:48:35','2022-01-31 12:48:35'),(15,'Baila 4 Extruder','2022-07-20 12:51:18','2022-07-20 12:51:18');
/*!40000 ALTER TABLE `bt_maintenance_equipment_types` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:48:36
