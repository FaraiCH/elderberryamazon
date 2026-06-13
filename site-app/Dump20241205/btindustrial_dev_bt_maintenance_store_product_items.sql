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
-- Table structure for table `bt_maintenance_store_product_items`
--

DROP TABLE IF EXISTS `bt_maintenance_store_product_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_maintenance_store_product_items` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_maintenance_store_product_items_created_by_index` (`created_by`),
  KEY `bt_maintenance_store_product_items_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_maintenance_store_product_items`
--

LOCK TABLES `bt_maintenance_store_product_items` WRITE;
/*!40000 ALTER TABLE `bt_maintenance_store_product_items` DISABLE KEYS */;
INSERT INTO `bt_maintenance_store_product_items` VALUES (2,'Cap screw','M20 10mm',50,NULL,'2023-07-03 12:32:52','2023-07-03 12:32:52'),(3,'Fisher Plugs','6m x 70',46,NULL,'2023-07-04 13:42:54','2023-07-04 13:42:54'),(4,'PVC Saddles','20m',46,NULL,'2023-07-04 13:43:23','2023-07-04 13:43:23'),(5,'Bolts and nuts','M8 x 16mm',46,NULL,'2023-07-04 13:43:50','2023-07-04 13:43:50'),(6,'Capscrew','M8 x 16mm',46,NULL,'2023-07-04 13:44:30','2023-07-04 13:44:30'),(7,'Gavvanized','Tee 3/4',46,NULL,'2023-07-04 13:44:56','2023-07-04 13:44:56'),(8,'Flat and spring washers','M8',46,NULL,'2023-07-04 13:48:21','2023-07-04 13:48:21'),(9,'Elbow pneumatire fitting','8',46,NULL,'2023-07-04 13:49:05','2023-07-04 13:49:05'),(10,'Reducer bush','1/2 - 1/4 pipe',46,NULL,'2023-07-04 13:49:42','2023-07-04 13:49:42'),(11,'Pipe nibble','1/4',46,46,'2023-07-04 13:50:15','2023-07-04 13:51:59'),(12,'Pipe','1/2',46,46,'2023-07-04 13:50:34','2023-07-04 13:51:48'),(13,'Galvanised tee','1/2',46,NULL,'2023-07-04 13:51:20','2023-07-04 13:51:20'),(14,'Nipple pipe','1',46,NULL,'2023-07-04 13:51:36','2023-07-04 13:51:36'),(15,'Raw bolts','M16',46,NULL,'2023-07-04 13:52:36','2023-07-04 13:52:36');
/*!40000 ALTER TABLE `bt_maintenance_store_product_items` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:42:13
