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
-- Table structure for table `bt_logistics_vehicle_fuel_usages`
--

DROP TABLE IF EXISTS `bt_logistics_vehicle_fuel_usages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_logistics_vehicle_fuel_usages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `vehicle_id` int unsigned DEFAULT NULL,
  `fueltype_id` int unsigned DEFAULT NULL,
  `fuel_intake` decimal(15,2) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price_per_litre` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_logistics_vehicle_fuel_usages_vehicle_id_index` (`vehicle_id`),
  KEY `bt_logistics_vehicle_fuel_usages_fueltype_id_index` (`fueltype_id`),
  KEY `bt_logistics_vehicle_fuel_usages_fuel_intake_index` (`fuel_intake`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_logistics_vehicle_fuel_usages`
--

LOCK TABLES `bt_logistics_vehicle_fuel_usages` WRITE;
/*!40000 ALTER TABLE `bt_logistics_vehicle_fuel_usages` DISABLE KEYS */;
INSERT INTO `bt_logistics_vehicle_fuel_usages` VALUES (2,'2022-06-09',3,3,500.00,'2022-06-09 13:44:21','2022-06-11 12:46:04',25.20),(3,'2022-06-13',3,3,119.05,'2022-06-13 09:21:23','2022-06-13 11:46:44',25.20),(9,'2022-06-13',2,3,63.59,'2022-06-13 14:13:12','2022-06-13 14:14:50',25.16),(10,'2022-05-26',2,3,41.51,'2022-06-13 14:28:14','2022-06-13 14:32:12',24.09),(11,'2022-05-25',2,3,8.17,'2022-06-13 14:37:24','2022-06-13 14:37:24',24.49),(12,'2022-05-17',3,3,50.81,'2022-06-14 06:10:43','2022-06-14 06:11:10',24.09),(13,'2022-06-14',2,3,76.77,'2022-06-14 06:12:42','2022-06-14 06:14:38',24.09),(14,'2022-06-14',3,3,120.38,'2022-06-14 06:16:56','2022-06-14 06:16:56',24.09),(15,'2022-05-18',3,3,209.28,'2022-06-14 06:19:22','2022-06-14 06:19:53',23.87),(16,'2022-06-13',3,3,115.26,'2022-06-14 06:21:27','2022-06-14 06:22:46',25.16),(17,'2022-05-16',2,3,12.46,'2022-06-14 06:39:46','2022-06-14 06:39:46',24.09),(18,'2022-06-02',2,3,69.45,'2022-06-14 08:07:50','2022-06-14 08:08:45',25.16),(19,'2022-06-01',2,3,75.52,'2022-06-14 08:12:50','2022-06-14 08:12:50',25.16),(20,'2022-06-16',2,3,67.25,'2022-06-16 06:16:58','2022-06-16 06:17:27',25.28),(21,'2022-06-16',3,3,118.67,'2022-06-16 06:22:56','2022-06-16 06:22:56',25.28),(22,'2022-06-23',2,3,69.18,'2022-06-23 08:41:25','2022-06-23 08:41:38',25.20),(23,'2022-06-29',2,3,79.21,'2022-06-30 07:33:54','2022-06-30 07:33:54',25.25),(24,'2022-06-29',3,3,194.75,'2022-06-30 07:35:48','2022-06-30 07:35:48',25.16),(25,'2022-07-01',2,3,40.80,'2022-07-01 11:17:32','2022-07-01 11:17:32',25.59),(26,'2022-07-05',2,3,68.47,'2022-07-05 07:19:38','2022-07-05 07:19:38',24.83),(27,'2022-07-21',3,3,269.48,'2022-07-21 09:38:22','2022-07-21 09:38:22',27.46),(28,'2022-09-20',3,3,26.10,'2022-09-23 07:46:24','2022-09-23 07:46:24',111.11),(29,'2022-09-23',3,3,26.10,'2022-09-23 07:48:05','2022-09-23 07:48:05',360.22),(30,'2022-09-15',3,3,26.10,'2022-09-23 07:56:33','2022-09-23 07:56:33',111.11),(31,'2022-10-10',1,1,22.36,'2022-10-11 06:49:15','2022-10-11 06:50:17',67.87),(32,'2022-10-10',2,3,26.19,'2022-10-11 06:54:32','2022-10-11 06:54:32',19.10);
/*!40000 ALTER TABLE `bt_logistics_vehicle_fuel_usages` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:34:13
