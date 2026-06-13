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
-- Table structure for table `bt_maintenance_checklists`
--

DROP TABLE IF EXISTS `bt_maintenance_checklists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_maintenance_checklists` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_maintenance_checklists_created_by_index` (`created_by`),
  KEY `bt_maintenance_checklists_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_maintenance_checklists`
--

LOCK TABLES `bt_maintenance_checklists` WRITE;
/*!40000 ALTER TABLE `bt_maintenance_checklists` DISABLE KEYS */;
INSERT INTO `bt_maintenance_checklists` VALUES (1,'Forklift: Daily Maintenance','Forklift operators should perform daily maintenance at the beginning of each shift.  They should visually inspect for leaks, obvious damage, and tyre condition, the operation of safety lights, service, parking brakes, horn, and steering. They should then',1,1,'2019-07-08 13:18:16','2019-07-08 13:18:26'),(2,'Forklift Monthly Maintenance','Performed after every 200 hours of operation by a trained mechanic',1,6,'2019-07-08 13:28:40','2019-07-09 09:16:52'),(3,'Forklift Quarterly Maintenance','Performed every 3 Months  of operation by a trained mechanic',6,6,'2019-07-09 09:17:57','2019-07-09 09:18:40'),(4,'Baila1','',6,NULL,'2019-08-27 11:13:59','2019-08-27 11:13:59'),(5,'Air Compressor Maintenance Schedule','',1,NULL,'2020-03-23 11:12:14','2020-03-23 11:12:14'),(6,'TAC-09CHS-BQ','CHECKUP',13,NULL,'2020-06-20 14:12:17','2020-06-20 14:12:17'),(7,'ALL Bailer - Oil Checklist','Check oil level on bailer',1,1,'2021-02-22 12:57:58','2021-02-22 12:59:13'),(8,'Oil Level','Check level on site glass. Top up if necessary',38,NULL,'2021-02-22 13:33:44','2021-02-22 13:33:44'),(9,'Oil leaks','Check condition of oil seal, replace where necessary',38,NULL,'2021-02-22 13:57:20','2021-02-22 13:57:20'),(10,'Oil Quality','Get oil samples and send for checks. Replace oil based on results',38,NULL,'2021-02-22 14:11:08','2021-02-22 14:11:08'),(11,'Cooling system','Remove heat exchanges and clean off rust and dirty',38,NULL,'2021-02-22 14:12:20','2021-02-22 14:12:20'),(12,'Couplings','Check and ensure coupling pins are intact',38,NULL,'2021-02-22 14:14:50','2021-02-22 14:14:50'),(13,'Generator Monthly Maintenance','Check Required list',37,37,'2021-04-27 17:41:09','2021-04-27 17:50:29'),(14,'Air Compressors Maintenance','Reminder on Maintenance',36,NULL,'2021-08-03 10:37:08','2021-08-03 10:37:08'),(15,'Car Service Weekly Checklist','Complete the checklist every Monday and upload',1,NULL,'2022-04-11 10:33:13','2022-04-11 10:33:13'),(16,'Trailer Checklist','Complete the checklist every Monday and upload',46,NULL,'2022-04-11 11:14:56','2022-04-11 11:14:56');
/*!40000 ALTER TABLE `bt_maintenance_checklists` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:37:19
