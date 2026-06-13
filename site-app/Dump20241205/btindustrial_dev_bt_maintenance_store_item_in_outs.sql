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
-- Table structure for table `bt_maintenance_store_item_in_outs`
--

DROP TABLE IF EXISTS `bt_maintenance_store_item_in_outs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_maintenance_store_item_in_outs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `quantity` int DEFAULT NULL,
  `in_out_status_status_id` int DEFAULT '1',
  `storeproductitem_id` int unsigned DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_maintenance_store_item_in_outs_storeproductitem_id_index` (`storeproductitem_id`),
  KEY `bt_maintenance_store_item_in_outs_created_by_index` (`created_by`),
  KEY `bt_maintenance_store_item_in_outs_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_maintenance_store_item_in_outs`
--

LOCK TABLES `bt_maintenance_store_item_in_outs` WRITE;
/*!40000 ALTER TABLE `bt_maintenance_store_item_in_outs` DISABLE KEYS */;
INSERT INTO `bt_maintenance_store_item_in_outs` VALUES (2,50,0,2,50,NULL,'2023-07-03 12:33:23','2023-07-03 12:33:23'),(3,10,1,15,46,NULL,'2023-07-05 08:34:27','2023-07-05 08:34:27'),(4,10,1,14,46,NULL,'2023-07-05 08:34:44','2023-07-05 08:34:44'),(5,5,1,13,46,NULL,'2023-07-05 08:35:02','2023-07-05 08:35:02'),(6,10,1,12,46,NULL,'2023-07-05 08:35:20','2023-07-05 08:35:20'),(7,5,1,11,46,NULL,'2023-07-05 08:35:37','2023-07-05 08:35:37'),(8,10,1,11,46,NULL,'2023-07-05 08:35:55','2023-07-05 08:35:55'),(9,10,1,10,46,NULL,'2023-07-05 08:36:18','2023-07-05 08:36:18'),(10,8,1,9,46,NULL,'2023-07-05 08:36:35','2023-07-05 08:36:35'),(11,10,1,8,46,NULL,'2023-07-05 08:36:53','2023-07-05 08:36:53'),(12,8,1,7,46,NULL,'2023-07-05 08:37:32','2023-07-05 08:37:32'),(13,9,1,6,46,NULL,'2023-07-05 08:38:18','2023-07-05 08:38:18');
/*!40000 ALTER TABLE `bt_maintenance_store_item_in_outs` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:49:22
