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
-- Table structure for table `bt_legal_subs`
--

DROP TABLE IF EXISTS `bt_legal_subs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_legal_subs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int unsigned DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_legal_subs_category_id_index` (`category_id`),
  KEY `bt_legal_subs_created_by_index` (`created_by`),
  KEY `bt_legal_subs_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_legal_subs`
--

LOCK TABLES `bt_legal_subs` WRITE;
/*!40000 ALTER TABLE `bt_legal_subs` DISABLE KEYS */;
INSERT INTO `bt_legal_subs` VALUES (1,'CIPC',1,1,1,'2021-02-11 13:02:22','2021-02-11 13:02:38'),(2,'BEE',1,1,NULL,'2021-02-11 13:02:32','2021-02-11 13:02:32'),(3,'Share certificates',1,1,NULL,'2021-02-11 13:03:02','2021-02-11 13:03:02'),(4,'HDPE Clients',2,1,NULL,'2021-02-11 13:09:09','2021-02-11 13:09:09'),(5,'Medical Clients',2,1,NULL,'2021-02-11 13:09:45','2021-02-11 13:09:45'),(6,'Promotion of Access to Information',3,40,NULL,'2021-03-11 17:16:38','2021-03-11 17:16:38'),(7,'Small Enterprise Finance Agency Term Loan Transaction',4,40,NULL,'2021-03-18 17:10:23','2021-03-18 17:10:23'),(8,'HR Policies',3,45,NULL,'2021-08-18 09:35:19','2021-08-18 09:35:19'),(9,'Lease Agreement',5,45,NULL,'2021-08-20 09:26:47','2021-08-20 09:26:47'),(10,'Part One',6,45,NULL,'2021-09-01 05:44:53','2021-09-01 05:44:53'),(11,'Part Two',6,45,NULL,'2021-09-01 05:49:53','2021-09-01 05:49:53'),(12,'Part Three',6,45,NULL,'2021-09-01 05:51:56','2021-09-01 05:51:56'),(13,'Part Four',6,45,NULL,'2021-09-01 05:52:19','2021-09-01 05:52:19'),(14,'Part Five',6,45,NULL,'2021-09-01 05:52:34','2021-09-01 05:52:34'),(15,'Part Six',6,45,NULL,'2021-09-01 05:52:50','2021-09-01 05:52:50'),(16,'Part Seven',6,45,NULL,'2021-09-01 05:53:07','2021-09-01 05:53:07'),(17,'Legal & Compliance',7,45,NULL,'2021-09-01 06:12:44','2021-09-01 06:12:44'),(18,'Trust Deed',7,45,NULL,'2021-09-01 06:18:36','2021-09-01 06:18:36'),(19,'HR Management',8,45,NULL,'2021-09-08 11:12:46','2021-09-08 11:12:46'),(20,'Q A Certificates',9,45,NULL,'2021-09-23 07:15:24','2021-09-23 07:15:24'),(21,'Signed Agreements',5,45,NULL,'2021-11-23 07:35:04','2021-11-23 07:35:04'),(22,'Non-Disclosure Agreements',5,45,NULL,'2021-11-24 12:27:20','2021-11-24 12:27:20'),(23,'Follow up Offers',10,45,NULL,'2021-11-24 12:35:09','2021-11-24 12:35:09'),(24,'Financial Statements',11,45,45,'2021-11-24 12:43:27','2021-11-24 13:05:28'),(25,'Debtors and Creditors Age Analysis',11,45,45,'2021-11-24 12:43:44','2021-11-24 13:05:40'),(26,'Notices',12,45,NULL,'2021-11-24 13:20:30','2021-11-24 13:20:30'),(27,'Management Accounts',11,45,NULL,'2021-11-24 13:50:30','2021-11-24 13:50:30'),(28,'Assets and Liabilities',11,45,NULL,'2021-11-24 14:03:29','2021-11-24 14:03:29'),(29,'Invoices',11,45,NULL,'2021-12-13 13:27:50','2021-12-13 13:27:50'),(30,'Sales Agreements',11,45,NULL,'2021-12-13 13:28:27','2021-12-13 13:28:27'),(31,'Trust Resolution',7,45,NULL,'2022-03-16 14:22:11','2022-03-16 14:22:11'),(32,'HR Policies',8,45,NULL,'2022-05-26 12:23:01','2022-05-26 12:23:01'),(33,'Headroom Facility',1,45,NULL,'2022-05-26 12:34:58','2022-05-26 12:34:58'),(34,'Debit Orders',14,45,NULL,'2022-10-17 07:34:33','2022-10-17 07:34:33'),(35,'CIPC Documents',15,45,NULL,'2022-11-09 11:16:54','2022-11-09 11:16:54'),(36,'IDC Agreement',14,45,NULL,'2022-11-24 11:45:48','2022-11-24 11:45:48'),(37,'IDC Loan',4,45,NULL,'2022-11-24 11:46:20','2022-11-24 11:46:20'),(38,'Company Secretarial',16,45,NULL,'2023-01-18 08:41:38','2023-01-18 08:41:38'),(39,'Trademark Schedule 2022',17,45,NULL,'2023-01-18 08:57:31','2023-01-18 08:57:31'),(40,'Lease Agreements',18,40,NULL,'2024-09-21 16:31:27','2024-09-21 16:31:27');
/*!40000 ALTER TABLE `bt_legal_subs` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:53:15
