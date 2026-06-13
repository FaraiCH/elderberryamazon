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
-- Table structure for table `bt_inventory_material_cats`
--

DROP TABLE IF EXISTS `bt_inventory_material_cats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_inventory_material_cats` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_inventory_material_cats_created_by_index` (`created_by`),
  KEY `bt_inventory_material_cats_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_inventory_material_cats`
--

LOCK TABLES `bt_inventory_material_cats` WRITE;
/*!40000 ALTER TABLE `bt_inventory_material_cats` DISABLE KEYS */;
INSERT INTO `bt_inventory_material_cats` VALUES (1,'Virgin','',1,NULL,'2020-07-13 14:06:52','2020-07-13 14:06:52'),(2,'BT Regrind','',1,NULL,'2020-07-13 14:07:19','2020-07-13 14:07:19'),(3,'BT Regrind PE 100','Requested for new BT Regrind name by QC',37,NULL,'2021-09-29 09:47:29','2021-09-29 09:47:29'),(4,'BuyOut','',15,NULL,'2022-06-07 09:05:08','2022-06-07 09:05:08'),(5,'MASTERBATCH','',15,NULL,'2023-05-15 07:20:52','2023-05-15 07:20:52'),(6,'DESICCANT','',48,NULL,'2023-06-28 06:50:58','2023-06-28 06:50:58'),(7,'BT-REGRIND REWORKS','',15,NULL,'2023-09-07 09:23:07','2023-09-07 09:23:07'),(8,'REGRIND','',85,NULL,'2024-05-16 10:38:59','2024-05-16 10:38:59'),(9,'Addictive','',37,NULL,'2024-08-01 12:07:41','2024-08-01 12:07:41'),(10,'PE100','',46,NULL,'2024-08-07 13:28:32','2024-08-07 13:28:32');
/*!40000 ALTER TABLE `bt_inventory_material_cats` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:31:50
