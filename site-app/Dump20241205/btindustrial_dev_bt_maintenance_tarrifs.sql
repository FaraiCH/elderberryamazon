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
-- Table structure for table `bt_maintenance_tarrifs`
--

DROP TABLE IF EXISTS `bt_maintenance_tarrifs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_maintenance_tarrifs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `meter_charge` decimal(15,2) DEFAULT NULL,
  `net_access_charge` decimal(15,2) DEFAULT NULL,
  `maximum_kva` decimal(15,2) DEFAULT NULL,
  `peak` decimal(15,2) DEFAULT NULL,
  `standard` decimal(15,2) DEFAULT NULL,
  `off_peak` decimal(15,2) DEFAULT NULL,
  `rand_per_kwh` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_maintenance_tarrifs`
--

LOCK TABLES `bt_maintenance_tarrifs` WRITE;
/*!40000 ALTER TABLE `bt_maintenance_tarrifs` DISABLE KEYS */;
INSERT INTO `bt_maintenance_tarrifs` VALUES (1,'2023-07-01 11:04:12','2023-07-31 11:04:15',3998.78,63.77,96.28,7.98,2.29,1.34,2.50,'2023-07-03 11:05:48','2023-07-17 06:38:13'),(2,'2023-06-01 12:20:50','2023-06-30 12:21:05',3972.53,57.78,96.28,5.87,2.06,1.24,2.50,'2023-07-03 12:22:14','2023-07-04 06:49:40'),(3,'2023-05-01 12:22:24','2023-05-31 12:22:27',3972.53,57.78,96.28,2.18,1.43,1.13,2.50,'2023-07-03 12:23:24','2023-07-04 06:38:41'),(4,'2023-04-01 12:23:37','2023-04-30 12:23:42',3972.53,57.78,96.28,2.18,1.43,1.13,2.50,'2023-07-03 12:24:37','2023-07-04 06:49:06'),(5,'2023-03-01 12:24:49','2023-03-31 12:24:54',3972.53,57.78,96.28,2.18,1.43,1.13,2.50,'2023-07-03 12:25:45','2023-07-04 06:51:44'),(6,'2023-08-01 07:20:36','2023-08-31 07:20:39',3972.53,57.78,96.28,2.18,1.43,1.13,2.50,'2023-08-08 07:20:58','2023-08-08 07:22:51'),(7,'2023-09-01 06:45:32','2023-09-30 06:45:35',4598.00,73.34,119.31,9.17,2.63,1.54,2.50,'2023-09-11 06:48:34','2023-09-11 06:48:34'),(8,'2023-10-01 07:00:46','2023-10-31 07:00:48',4598.59,73.34,119.30,2.89,1.90,1.43,2.50,'2023-10-02 07:39:01','2023-10-02 07:39:01');
/*!40000 ALTER TABLE `bt_maintenance_tarrifs` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:31:34
