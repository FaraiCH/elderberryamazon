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
-- Table structure for table `bt_sales_quote_approvals`
--

DROP TABLE IF EXISTS `bt_sales_quote_approvals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sales_quote_approvals` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `quote_id` int unsigned DEFAULT NULL,
  `status_id` int unsigned DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_sales_quote_approvals_quote_id_index` (`quote_id`),
  KEY `bt_sales_quote_approvals_created_by_index` (`created_by`),
  KEY `bt_sales_quote_approvals_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sales_quote_approvals`
--

LOCK TABLES `bt_sales_quote_approvals` WRITE;
/*!40000 ALTER TABLE `bt_sales_quote_approvals` DISABLE KEYS */;
INSERT INTO `bt_sales_quote_approvals` VALUES (1,10458,1,59,59,NULL,'2024-01-19 08:06:16','2024-01-19 11:41:43'),(2,10512,1,8,NULL,NULL,'2024-01-23 13:45:52','2024-01-23 13:45:52'),(3,10451,1,8,NULL,NULL,'2024-01-23 16:43:49','2024-01-23 16:43:49'),(4,10548,1,59,NULL,NULL,'2024-01-29 07:18:44','2024-01-29 07:18:44'),(5,10568,1,59,NULL,NULL,'2024-02-01 07:12:38','2024-02-01 07:12:38'),(6,10558,1,59,NULL,NULL,'2024-02-01 08:27:12','2024-02-01 08:27:12'),(7,10551,1,59,NULL,NULL,'2024-02-01 09:06:41','2024-02-01 09:06:41'),(8,10556,1,59,NULL,NULL,'2024-02-08 14:27:31','2024-02-08 14:27:31'),(9,10682,1,10,NULL,'','2024-02-10 10:00:48','2024-02-10 10:00:48'),(10,10631,1,59,NULL,'We are taking a R 3266 loss against Nkewu\'s cost but if we were to add this loss to the current delivery price it will be too expensive for the order which is just over R70K. Therefore I am approving this order with the plan of prioritizing the delivery w','2024-02-15 17:53:57','2024-02-15 17:53:57'),(11,10725,1,59,NULL,'Hi Gary we are under recovering on this load. Nkewu is about R 23 535.50 and with BT Truck we are at R 18 828.40 while our delivery charge approved is at R 16 500.00 which translate to a deficit of R 2 328.40. We need to make sure we charge correctly next','2024-02-16 09:11:51','2024-02-16 09:11:51'),(12,10736,1,59,59,'','2024-02-16 17:18:35','2024-02-16 17:20:00'),(13,10742,1,8,NULL,'','2024-02-19 08:02:23','2024-02-19 08:02:23'),(14,10842,1,59,NULL,'','2024-02-28 14:31:51','2024-02-28 14:31:51'),(15,10721,1,59,NULL,'','2024-02-28 14:34:29','2024-02-28 14:34:29'),(16,10870,1,59,NULL,'','2024-03-01 07:53:12','2024-03-01 07:53:12'),(17,10925,1,59,NULL,'','2024-03-07 10:41:18','2024-03-07 10:41:18'),(18,11049,1,59,NULL,'','2024-03-15 09:16:41','2024-03-15 09:16:41'),(19,11046,1,59,NULL,'','2024-03-18 12:23:33','2024-03-18 12:23:33'),(20,11118,1,8,NULL,'','2024-03-25 07:37:36','2024-03-25 07:37:36'),(21,11162,1,59,NULL,'','2024-03-28 11:25:14','2024-03-28 11:25:14'),(22,11209,1,26,NULL,'Approved for production \r\nDelivery has been added to the quote \r\nQuote has been signed by client','2024-04-04 09:20:26','2024-04-04 09:20:26'),(23,11171,1,59,NULL,'','2024-04-05 09:47:16','2024-04-05 09:47:16'),(24,11307,0,59,NULL,'I would need to understand how this client is strategic, how we plan to recover deliveries for their future orders, and why we can\'t charge for delivery for this load, apart from them being strategic.','2024-04-08 18:44:46','2024-04-08 18:44:46'),(25,11307,0,59,NULL,'I would need to understand how this client is strategic, how we plan to recover deliveries for their future orders, and why we can\'t charge for delivery for this load, apart from them being strategic.','2024-04-08 18:45:01','2024-04-08 18:45:01'),(26,11307,0,59,NULL,'I would need to understand how this client is strategic, how we plan to recover deliveries for their future orders, and why we can\'t charge for delivery for this load apart from them being strategic.','2024-04-08 18:45:29','2024-04-08 18:45:29'),(27,11316,1,8,NULL,'','2024-04-11 07:16:10','2024-04-11 07:16:10'),(28,11367,1,8,NULL,'','2024-04-11 07:18:30','2024-04-11 07:18:30'),(29,11362,1,8,NULL,'','2024-04-11 09:01:51','2024-04-11 09:01:51'),(30,11379,1,59,NULL,'','2024-04-11 12:33:58','2024-04-11 12:33:58'),(31,11358,1,26,NULL,'Quote signed\r\nDelivery added to quote','2024-04-12 09:04:23','2024-04-12 09:04:23'),(32,11313,1,26,NULL,'PO signed\r\nDelivery added','2024-04-12 09:09:08','2024-04-12 09:09:08'),(33,11191,1,26,NULL,'PO signed\r\nQuote signed\r\nDelivery added','2024-04-12 09:14:33','2024-04-12 09:14:33'),(34,11407,1,26,NULL,'','2024-04-12 15:08:49','2024-04-12 15:08:49'),(35,11402,1,59,NULL,'','2024-04-12 17:13:36','2024-04-12 17:13:36'),(36,11201,1,26,NULL,'Deliver to Burgersdal (Local) by order KM\r\nMeshack phoned to request approval','2024-04-16 12:34:20','2024-04-16 12:34:20'),(37,11388,1,26,NULL,'Delivery requested\r\nWaiting for quote to be uploaded (with delivery)\r\nProduction wants to run only 17 of the 560 PN8 on 18/04/2024','2024-04-17 19:49:24','2024-04-17 19:49:24'),(38,11452,1,26,NULL,'Transport is included in price. (line item on BT Quote)','2024-04-18 07:03:07','2024-04-18 07:03:07'),(39,11334,1,26,NULL,'Delivery charges added to pricing.\r\nPO and Quote signed.','2024-04-18 08:11:20','2024-04-18 08:11:20'),(40,11334,1,8,NULL,'','2024-04-18 08:11:42','2024-04-18 08:11:42'),(41,11233,1,8,NULL,'','2024-04-18 09:20:20','2024-04-18 09:20:20'),(42,11401,1,8,NULL,'','2024-04-22 13:02:01','2024-04-22 13:02:01'),(43,11405,1,59,NULL,'','2024-04-24 06:43:15','2024-04-24 06:43:15'),(44,11479,1,26,NULL,'PO received, Delivery quoted on Quote','2024-04-25 13:49:48','2024-04-25 13:49:48'),(45,11731,0,59,59,'','2024-05-10 07:46:17','2024-05-20 12:11:37'),(46,12189,1,59,NULL,'AAs per KM discussion and approval','2024-06-25 13:37:00','2024-06-25 13:37:00'),(47,12352,1,8,NULL,'','2024-07-10 07:32:30','2024-07-10 07:32:30'),(48,12789,1,8,NULL,'','2024-09-13 10:34:10','2024-09-13 10:34:10'),(49,13302,1,8,NULL,'','2024-11-08 14:13:02','2024-11-08 14:13:02');
/*!40000 ALTER TABLE `bt_sales_quote_approvals` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:31:39
