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
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_groups` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_groups_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'Guest','guest','Default group for guest users.','2019-02-10 20:23:39','2019-02-10 20:23:39'),(2,'Registered','registered','Default group for registered users.','2019-02-10 20:23:39','2019-02-10 20:23:39'),(3,'Sales','sales','','2019-03-04 07:03:50','2019-03-04 07:03:50'),(4,'Production Manager','production','','2019-03-04 07:04:04','2019-03-06 23:31:51'),(5,'Finance Manager','finance','','2019-03-04 07:04:19','2019-03-06 23:30:59'),(6,'Executive User','executive-user','','2019-03-04 07:05:44','2019-03-06 23:34:33'),(7,'Stock Room Clerk','stock-room-clerk','','2019-03-06 23:32:57','2019-03-06 23:32:57'),(8,'Notify','notify','Test','2019-05-31 08:32:53','2019-05-31 08:32:53'),(9,'Raw Material Notification','raw-material-notification','','2019-07-07 08:02:17','2019-07-07 08:02:17'),(10,'New quote notify','new-quote-notify','','2019-07-14 00:28:09','2019-07-14 00:28:09'),(11,'Request Delivery Email Notify','request-delivery-email-notify','','2019-07-14 00:29:17','2019-07-14 00:29:17'),(12,'Request Discount Email Notify','request-discount-email-notify','','2019-07-14 00:29:40','2019-07-14 00:29:40'),(13,'Quote Production Email Notify','quote-production-email-notify','','2019-07-14 00:36:03','2019-07-14 00:36:03'),(14,'Production Approval','production-approval','Production Approval','2019-08-11 09:01:40','2019-08-11 09:01:40'),(15,'Delivery Plan Notify','delivery-plan-notify','','2019-08-30 00:49:38','2019-08-30 00:49:38'),(16,'Head Office','head-office','Head Office - Noezan And Lekola','2020-02-21 08:25:50','2020-02-21 08:25:50'),(17,'Production Team','production-team','Production Team','2020-02-23 09:15:37','2020-02-23 09:15:37'),(18,'Completed Order Notify','completed-order-notify','','2020-05-23 21:03:40','2020-05-23 21:03:40'),(19,'Delivered/Collected Notify','delivered-collected-notify','','2020-05-23 21:05:11','2020-05-23 21:09:14'),(20,'QC approval','qc-approval','qc-approval','2020-06-11 12:55:15','2020-06-11 12:55:15'),(21,'Checklist Notify','checklist-notify','Checklist Notify','2020-06-17 12:02:57','2020-06-17 12:02:57'),(22,'Return Note Notification','return-note-notification','','2020-07-09 14:00:57','2020-07-09 14:00:57'),(23,'Management Notify','management-notify','','2020-10-05 20:03:44','2020-10-05 20:03:44'),(24,'Logistics Schedule Approval','logistics-schedule-approval','Mail to logistics group to approve Schedules','2020-10-28 22:19:51','2020-10-28 22:19:51'),(25,'Dev','dev','','2020-11-03 08:49:59','2020-11-03 08:49:59'),(26,'PN Rating Notice','pn-rating-notice','','2021-04-12 14:07:04','2021-04-12 14:07:04'),(27,'Petty Cash Notification','petty-cash-notification','Petty Cash Notification','2022-02-10 09:54:26','2022-02-10 09:54:26'),(28,'Maintenance Jobcard','maintenance-jobcard','','2022-03-09 08:57:25','2022-03-09 08:57:25'),(29,'Vehicle Notification','vehicle-notification','','2022-04-26 10:23:58','2022-04-26 10:23:58'),(30,'Job-Card Notification','job-card-notification','','2022-04-26 10:24:20','2022-04-26 10:24:20'),(31,'Pipe Approval','pipe-approval','','2022-05-30 10:45:56','2022-05-30 10:45:56'),(32,'Coc Request','coc-request','','2022-06-13 08:28:05','2022-06-13 08:28:05'),(33,'Boardroom Booking','boardroom-booking','','2023-02-20 12:42:43','2023-02-20 12:42:43'),(34,'Baila Breakdown','baila-breakdown','','2023-03-29 12:59:57','2023-03-29 12:59:57'),(35,'Visitor','visitor','','2023-04-26 10:30:15','2023-04-26 10:30:15'),(36,'Production Tablets','tablets','','2023-05-24 11:25:11','2023-05-26 09:24:47'),(37,'Pipe Failed Notify','pipe-failed-notify','This is to notify QC and Production Team of a pipe that has been marked as failed','2023-05-26 09:16:01','2023-05-26 09:16:01'),(38,'Finance PO Notification','finance-po-notification','','2023-11-30 07:22:26','2023-11-30 07:22:26'),(39,'QC Override','qc-override','Override QC','2024-05-09 07:48:49','2024-05-09 07:48:49'),(40,'Production Counter','production-counter','Show counter for production','2024-08-17 14:42:25','2024-08-17 14:42:25'),(41,'Quality Counter','quality-counter','Show Qulaity the counter for pipes passed','2024-08-17 14:46:51','2024-08-17 14:47:20'),(42,'Logistics Counter','logistics-counter','Show logistics counter for how many pipes with the same batch on a pick slip','2024-08-17 14:47:02','2024-08-17 14:47:49');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:59:59
