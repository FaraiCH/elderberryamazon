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
-- Table structure for table `bt_sales_quote_statuses`
--

DROP TABLE IF EXISTS `bt_sales_quote_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sales_quote_statuses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_groups_id` int unsigned DEFAULT NULL,
  `candelete` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `bt_sales_quote_statuses_email_groups_id_index` (`email_groups_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sales_quote_statuses`
--

LOCK TABLES `bt_sales_quote_statuses` WRITE;
/*!40000 ALTER TABLE `bt_sales_quote_statuses` DISABLE KEYS */;
INSERT INTO `bt_sales_quote_statuses` VALUES (1,'New Quote','New Quote','2019-04-21 17:56:36','2019-07-14 23:36:19',10,0),(2,'InComplete For Edit','InComplete For Edit','2019-04-21 17:56:36','2019-04-21 17:56:36',NULL,1),(3,'Delivery Requested','Request Delivery','2019-04-21 17:56:36','2019-07-14 22:32:45',11,1),(4,'Delivery Approved','Approve Delivery','2019-04-21 17:56:36','2019-04-21 17:56:36',NULL,1),(5,'Discount Requested','Request Discount','2019-04-21 17:56:36','2019-07-14 22:40:17',12,1),(6,'Discount Approved','Approve Discount','2019-04-21 17:56:36','2019-04-21 17:56:36',NULL,1),(7,'Manager Approved Quote','Manager Approved Quote','2019-04-21 17:56:36','2019-07-15 08:38:22',NULL,1),(8,'Quote Sent To Client','Complete Quote and Send To Client','2019-04-21 17:56:36','2019-04-21 17:56:36',NULL,1),(9,'Quote Signed By Client','Upload Signed Quote','2019-04-21 17:56:36','2019-04-21 17:56:36',NULL,1),(10,'Purchase Order','Upload Purchase Order','2019-04-21 17:56:36','2019-07-15 09:34:09',NULL,1),(11,'Invoiced','Create Invoice','2019-04-21 17:56:36','2019-07-15 09:34:46',NULL,1),(12,'Waiting For Payment','Waiting For Payment','2019-04-21 17:56:36','2019-07-15 09:35:16',NULL,1),(13,'Payment Received','Payment Received','2019-04-21 17:56:36','2019-07-15 09:35:58',NULL,1),(14,'In Production','Send To Production','2019-04-21 17:56:36','2019-07-14 22:42:23',13,0),(15,'Quote Canceled','Cancel Quote','2019-04-21 17:56:36','2019-04-21 17:56:36',NULL,1),(16,'Production Started','Production Started','2019-05-02 12:32:33','2019-05-02 12:32:33',NULL,0),(17,'Production Completed','Production Completed','2019-05-02 12:32:33','2019-05-02 12:32:33',NULL,1),(18,'Production OnHold','Production OnHold','2019-05-02 12:32:33','2019-05-02 12:32:33',NULL,1),(19,'Notify Finance','Notify Finance','2020-02-09 08:33:34','2020-02-09 08:33:34',5,1),(20,'Production Cancel','Production Cancel','2020-02-23 09:18:01','2020-02-23 09:18:01',17,1),(21,'Order Cancelled','Order Cancelled','2020-10-20 13:45:35','2020-10-20 13:45:35',4,1);
/*!40000 ALTER TABLE `bt_sales_quote_statuses` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:42:30
