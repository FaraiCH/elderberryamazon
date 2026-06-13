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
-- Table structure for table `bt_production_purchaseitems`
--

DROP TABLE IF EXISTS `bt_production_purchaseitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_production_purchaseitems` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int DEFAULT NULL,
  `purchase_id` int DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `units` int DEFAULT NULL,
  `sell_price` decimal(15,2) DEFAULT NULL,
  `buy_price` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_production_purchaseitems_item_id_index` (`item_id`),
  KEY `bt_production_purchaseitems_purchase_id_index` (`purchase_id`),
  KEY `bt_production_purchaseitems_description_index` (`description`(191)),
  KEY `bt_production_purchaseitems_units_index` (`units`),
  KEY `bt_production_purchaseitems_sell_price_index` (`sell_price`),
  KEY `bt_production_purchaseitems_buy_price_index` (`buy_price`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_production_purchaseitems`
--

LOCK TABLES `bt_production_purchaseitems` WRITE;
/*!40000 ALTER TABLE `bt_production_purchaseitems` DISABLE KEYS */;
INSERT INTO `bt_production_purchaseitems` VALUES (4,6145,2,'HDPE PE100 250mm PN12 EQL T o/e',1,1760.75,1760.75,'2021-10-22 07:03:51','2021-10-22 07:03:51'),(6,6148,2,'HDPE PE100 110mm PN12 EQL T o/e',1,447.25,447.25,'2021-10-22 07:04:30','2021-10-22 07:04:30'),(7,6151,2,'HDPE PE100 200mm PN12 EQL T o/e',1,1167.58,1167.58,'2021-10-22 07:04:59','2021-10-22 07:04:59'),(8,6158,2,'HDPE PE100 110mm - 90mm PN12 Red Y o/e',1,649.17,649.17,'2021-10-22 07:05:12','2021-10-22 07:05:12'),(9,6163,2,'HDPE PE100 200mm - 160mm PN12 RED-T o/e',1,1268.00,1268.00,'2021-10-22 07:05:31','2021-10-22 07:05:31');
/*!40000 ALTER TABLE `bt_production_purchaseitems` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:49:39
