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
-- Table structure for table `bt_inventory_print_sticker_items`
--

DROP TABLE IF EXISTS `bt_inventory_print_sticker_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_inventory_print_sticker_items` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sticker_id` int unsigned DEFAULT NULL,
  `material_id` int unsigned DEFAULT NULL,
  `schedule_date` datetime DEFAULT NULL,
  `units` int unsigned NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `weight` decimal(15,1) DEFAULT '0.0',
  PRIMARY KEY (`id`),
  KEY `bt_inventory_print_sticker_items_sticker_id_index` (`sticker_id`),
  KEY `bt_inventory_print_sticker_items_material_id_index` (`material_id`),
  KEY `bt_inventory_print_sticker_items_created_by_index` (`created_by`),
  KEY `bt_inventory_print_sticker_items_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_inventory_print_sticker_items`
--

LOCK TABLES `bt_inventory_print_sticker_items` WRITE;
/*!40000 ALTER TABLE `bt_inventory_print_sticker_items` DISABLE KEYS */;
INSERT INTO `bt_inventory_print_sticker_items` VALUES (12,2,63,NULL,2,'',9,NULL,'2019-12-10 08:59:30','2019-12-10 08:59:30',1000.0),(14,3,62,NULL,16,'',9,NULL,'2019-12-10 09:04:36','2019-12-10 09:04:36',1375.0),(20,4,71,NULL,2,'Comply',9,9,'2020-01-18 13:41:42','2020-01-18 13:43:04',1375.0),(21,5,74,NULL,4,'COMPLY',9,9,'2020-01-20 10:36:17','2020-01-20 10:36:23',1000.0),(24,6,91,NULL,23,'Compy',9,9,'2020-01-30 15:38:07','2020-03-02 10:10:25',1375.0),(25,7,93,NULL,24,'COMPLY',9,9,'2020-03-13 16:43:32','2020-03-13 16:43:35',1375.0),(26,8,100,NULL,5,'COMPLY',9,9,'2020-03-19 15:56:34','2020-03-19 15:56:38',1375.0),(27,9,128,NULL,18,'COMPLY',9,9,'2020-03-19 15:59:08','2020-05-10 10:05:57',1375.0),(28,10,135,NULL,31,'COMPLY',9,9,'2020-05-15 15:52:11','2020-05-15 15:52:18',1375.0),(29,10,138,NULL,93,'COMPLY',9,NULL,'2020-05-15 15:53:08','2020-05-15 15:53:08',1375.0),(30,11,135,NULL,18,'COMPLY',9,9,'2020-05-26 16:22:37','2020-05-26 16:22:49',1375.0),(31,12,181,NULL,52,'COMPLY',9,9,'2020-07-03 09:13:15','2020-07-03 09:13:18',1375.0),(32,NULL,185,NULL,18,'COMPLY',9,NULL,'2020-07-06 16:39:56','2020-07-06 16:39:56',1000.0),(35,13,252,NULL,26,'PASSED QC',9,NULL,'2020-09-18 15:16:15','2020-09-18 15:16:15',1375.0);
/*!40000 ALTER TABLE `bt_inventory_print_sticker_items` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:31:05
