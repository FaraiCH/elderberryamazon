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
-- Table structure for table `bt_production_raw_production_plan_items`
--

DROP TABLE IF EXISTS `bt_production_raw_production_plan_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_production_raw_production_plan_items` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `receiving_id` int NOT NULL,
  `raw_production_id` int NOT NULL,
  `weight_kg` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `used_kg` decimal(8,2) NOT NULL,
  `bag_batch_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_production_raw_production_plan_items_receiving_id_index` (`receiving_id`),
  KEY `bt_production_raw_production_plan_items_raw_production_id_index` (`raw_production_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_production_raw_production_plan_items`
--

LOCK TABLES `bt_production_raw_production_plan_items` WRITE;
/*!40000 ALTER TABLE `bt_production_raw_production_plan_items` DISABLE KEYS */;
INSERT INTO `bt_production_raw_production_plan_items` VALUES (1,1635,1,10000.00,'2023-10-02 12:48:41','2023-10-02 12:48:41',0.00,0),(2,1635,1,5000.00,'2023-10-03 09:18:35','2023-10-03 09:18:35',0.00,0),(3,1641,1,10000.00,'2023-10-13 10:00:28','2023-10-13 10:00:28',0.00,0),(4,1641,2,49.80,'2023-10-16 09:53:08','2023-10-16 09:53:08',0.00,0),(5,1879,4,1257.50,'2024-09-18 10:29:05','2024-09-18 10:29:05',0.00,25);
/*!40000 ALTER TABLE `bt_production_raw_production_plan_items` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:56:58
