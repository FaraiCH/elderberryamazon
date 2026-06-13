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
-- Table structure for table `bt_finance_requisition_projects`
--

DROP TABLE IF EXISTS `bt_finance_requisition_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_finance_requisition_projects` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_finance_requisition_projects`
--

LOCK TABLES `bt_finance_requisition_projects` WRITE;
/*!40000 ALTER TABLE `bt_finance_requisition_projects` DISABLE KEYS */;
INSERT INTO `bt_finance_requisition_projects` VALUES (1,'IT Related Purchases','IT Related Purchases','2023-10-23 12:23:54','2023-10-23 12:23:54'),(2,'Maintenance- Baila 6','1)','2023-10-23 14:22:38','2023-10-23 14:22:38'),(3,'Maintenance- Baila 5','Maintenance- Baila 5','2023-10-23 19:10:05','2023-10-23 19:10:05'),(4,'Maintenance- Baila 4','Maintenance- Baila 5','2023-10-23 19:11:06','2023-10-23 19:11:06'),(5,'Maintenance- Baila 3','Maintenance- Baila 3','2023-10-23 19:11:52','2023-10-23 19:11:52'),(6,'Maintenance- Baila 2','Maintenance- Baila 2','2023-10-23 19:12:37','2023-10-23 19:12:37'),(7,'Maintenance- Baila 1','Maintenance- Baila 1','2023-10-23 19:14:03','2023-10-23 19:14:03'),(8,'Factory ventilation Fans','Acquiring and installations of ventilation fans','2023-10-24 09:47:58','2023-10-24 09:47:58'),(9,'Logistics','Logistics Related Purchases','2023-10-24 12:10:08','2023-10-24 12:10:21'),(10,'Maintenance Team Further Studies','Tuition and study material fees','2023-10-24 14:12:09','2023-10-24 14:12:09'),(11,'QC','QC','2023-10-25 13:16:03','2023-10-25 13:16:03'),(12,'factory Walls and roofs','Repairs to factory walls and roofs','2023-11-03 12:01:13','2023-11-03 12:01:13'),(13,'Training & Development','Maintenance short courses and seminars to develop manpower','2023-11-09 13:53:15','2023-11-09 13:53:15'),(14,'BT Industrial Pipe Systems Design & Engineering','All Cost Pertaining BT Industrial Pipe Systems Design & Engineering','2023-11-13 07:35:44','2023-11-13 07:35:44'),(15,'Marketing & Website Costs','','2023-11-13 19:39:34','2023-11-13 19:39:34'),(16,'Fire protection','fire hydrants and fire extinguishers','2023-11-15 06:57:31','2023-11-15 06:57:31'),(17,'Training & Development - Logistics','','2024-01-29 10:11:31','2024-01-29 10:11:31'),(18,'BT Medical Stock','','2024-01-30 08:36:33','2024-01-30 08:36:33'),(19,'The Zone Rosebank Mall','All Rosebank Mall Invoices and Payments','2024-02-01 09:30:14','2024-02-01 09:30:42'),(20,'Yard maintainance','Demolish old weighbridge ramps, remove rubble and resurface.','2024-02-19 12:33:01','2024-02-19 12:33:01'),(21,'Warehouse','','2024-03-06 14:17:30','2024-03-06 14:17:30'),(22,'BT Network Analysis','','2024-05-07 13:22:42','2024-05-07 13:22:42'),(23,'The Riverside Mall Water Treatment Plant','All costs associated with The Riverside Mall Water Treatment Plant','2024-08-01 22:28:41','2024-08-01 22:28:41'),(24,'Office Maintenance','','2024-08-16 09:17:40','2024-08-16 09:17:40'),(25,'Make Up Liquid For Printers','','2024-08-27 13:07:32','2024-08-27 13:07:32'),(26,'Strapping for Pipes','','2024-08-27 13:07:45','2024-08-27 13:07:45');
/*!40000 ALTER TABLE `bt_finance_requisition_projects` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:33:44
