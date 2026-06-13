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
-- Table structure for table `bt_legal_documents`
--

DROP TABLE IF EXISTS `bt_legal_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_legal_documents` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int unsigned DEFAULT NULL,
  `sub_id` int unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assinged_date` date DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_legal_documents_category_id_index` (`category_id`),
  KEY `bt_legal_documents_sub_id_index` (`sub_id`),
  KEY `bt_legal_documents_created_by_index` (`created_by`),
  KEY `bt_legal_documents_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_legal_documents`
--

LOCK TABLES `bt_legal_documents` WRITE;
/*!40000 ALTER TABLE `bt_legal_documents` DISABLE KEYS */;
INSERT INTO `bt_legal_documents` VALUES (1,1,2,'Test Noezan file','<p>This is a test</p>','2020-02-07',1,NULL,'2021-02-11 13:11:17','2021-02-11 13:11:17'),(2,3,6,'Master Agency Agreement Standard Terms & Conditions (Execution)','<p>This agreement relates to...</p>','2021-03-10',40,39,'2021-03-11 17:21:37','2021-03-15 09:57:50'),(4,3,8,'HR Manager','<p>HR Managers Documents</p>',NULL,45,45,'2021-08-18 10:16:14','2021-08-18 10:17:08'),(5,5,9,'Lease Agreement','<p>Lease Agreement between Cumulative Properties Ltd and BT Industries Pty Ltd</p>',NULL,45,NULL,'2021-08-20 09:41:55','2021-08-20 09:41:55'),(6,6,10,'Compliance Documents','',NULL,45,NULL,'2021-09-01 05:47:57','2021-09-01 05:47:57'),(7,6,11,'Company Asset Register','',NULL,45,45,'2021-09-01 05:51:21','2021-09-01 05:57:41'),(8,6,12,'All Service or Supplier Agreements','',NULL,45,NULL,'2021-09-01 05:56:52','2021-09-01 05:56:52'),(9,6,13,'Credit Policy','',NULL,45,NULL,'2021-09-01 05:59:18','2021-09-01 05:59:18'),(10,6,14,'Financial Statements & Employee Register','',NULL,45,NULL,'2021-09-01 06:01:28','2021-09-01 06:01:28'),(11,6,15,'Management Accounts from 2018 to date','',NULL,45,NULL,'2021-09-01 06:06:23','2021-09-01 06:06:23'),(12,6,16,'Insurance Documents & Proof of Residency','',NULL,45,NULL,'2021-09-01 06:08:24','2021-09-01 06:08:24'),(13,7,17,'Signed Letters of Representation, Minutes & AFS','',NULL,45,NULL,'2021-09-01 06:16:48','2021-09-01 06:16:48'),(14,7,18,'Trust Deed','',NULL,45,NULL,'2021-09-01 06:19:38','2021-09-01 06:19:38'),(15,8,19,'Mutual Separation Agreement & Resignation Letter','',NULL,45,NULL,'2021-09-08 11:15:38','2021-09-08 11:15:38'),(16,9,20,'Quantity Assurance Certificates','',NULL,45,NULL,'2021-09-23 07:17:34','2021-09-23 07:17:34'),(17,5,21,'Africa Weather Group','',NULL,45,NULL,'2021-11-23 07:36:50','2021-11-23 07:36:50'),(18,5,21,'Africa Weather Group- Formal Offer','',NULL,45,NULL,'2021-11-24 12:25:29','2021-11-24 12:25:29'),(19,5,22,'NDA- Vodacom','',NULL,45,NULL,'2021-11-24 12:30:11','2021-11-24 12:30:11'),(20,10,23,'Revised Follow up Offer to EOI- RAI','',NULL,45,NULL,'2021-11-24 12:37:17','2021-11-24 12:37:17'),(21,11,25,'Debtors and Creditors Analysis August to October 2021','',NULL,45,NULL,'2021-11-24 13:11:07','2021-11-24 13:11:07'),(22,5,22,'Non-Circumvention Agreement','',NULL,45,NULL,'2021-11-24 13:17:05','2021-11-24 13:17:05'),(23,12,26,'Notice to Stakeholders','',NULL,45,NULL,'2021-11-24 13:22:14','2021-11-24 13:22:14'),(24,11,24,'Annual Financial Statements- Spartan','',NULL,45,NULL,'2021-11-24 13:37:48','2021-11-24 13:37:48'),(25,11,25,'Debtors and Creditors Analysis- Spartan','',NULL,45,NULL,'2021-11-24 13:46:56','2021-11-24 13:46:56'),(26,11,27,'Management Accounts- Spartan','',NULL,45,NULL,'2021-11-24 13:53:40','2021-11-24 13:53:40'),(27,11,25,'Debtors and Creditors Analysis- Spartan','',NULL,45,NULL,'2021-11-24 13:56:57','2021-11-24 13:56:57'),(28,11,28,'Statement of Assets and Liabilities','',NULL,45,NULL,'2021-11-24 14:04:55','2021-11-24 14:04:55'),(29,11,29,'Tax Invoice- North Safety','',NULL,45,NULL,'2021-12-13 13:30:29','2021-12-13 13:30:29'),(30,11,30,'Sale of Assets Agreement','',NULL,45,NULL,'2021-12-13 13:31:30','2021-12-13 13:31:30'),(31,7,31,'Round Robin Trustees Resolution','',NULL,45,NULL,'2022-03-16 14:24:07','2022-03-16 14:24:07'),(32,5,21,'Barnsley Street Sale Agreement','',NULL,45,NULL,'2022-04-20 06:58:24','2022-04-20 06:58:24'),(33,8,32,'Human Resource Policies','',NULL,45,NULL,'2022-05-26 12:31:50','2022-05-26 12:31:50'),(34,1,33,'Headroom Facility','',NULL,45,NULL,'2022-05-26 12:36:59','2022-05-26 12:36:59'),(35,7,17,'Letter of Representation','',NULL,45,NULL,'2022-08-24 07:56:14','2022-08-24 07:56:14'),(36,7,17,'Engagement Letter','',NULL,45,NULL,'2022-08-24 07:58:06','2022-08-24 07:58:06'),(38,5,21,'Solvency Affidavit - Donovan','',NULL,45,NULL,'2022-08-24 08:05:44','2022-08-24 08:05:44'),(39,5,21,'Sale of Shares - Donovan','',NULL,45,NULL,'2022-08-24 08:07:09','2022-08-24 08:07:09'),(40,5,21,'Signed Sale Agreement','',NULL,45,NULL,'2022-08-25 07:42:41','2022-08-25 07:42:41'),(41,5,21,'Private Label Agreement','',NULL,45,NULL,'2022-08-30 12:33:44','2022-08-30 12:33:44'),(42,5,21,'Proposed Sale of Shares','<p>Binding Offer between Donovan and Lautin Industrial</p>',NULL,45,NULL,'2022-09-01 09:41:29','2022-09-01 09:41:29'),(43,5,21,'Collaboration Agreement','<p>Collaboration Agreement Between BT Industrial and Ntshesopele Kgatelopele Development Corporation</p>',NULL,45,NULL,'2022-10-17 07:26:32','2022-10-17 07:26:32'),(44,5,21,'Collaboration Agreement','<p>Collaboration Agreement between BTI and NKDC</p>',NULL,45,NULL,'2022-10-17 07:30:33','2022-10-17 07:30:33'),(45,14,34,'Debit Order Mandate','',NULL,45,NULL,'2022-10-17 07:35:21','2022-10-17 07:35:21'),(46,15,35,'CIPC Documents','',NULL,45,NULL,'2022-11-09 11:28:17','2022-11-09 11:28:17'),(47,4,37,'IDC Loan Agreement','',NULL,45,NULL,'2022-11-24 11:47:35','2022-11-24 11:47:35'),(48,14,36,'IDC Debit Order Mandate','',NULL,45,NULL,'2022-11-24 11:48:31','2022-11-24 11:48:31'),(49,7,31,'MM Trust Shares Resolution','',NULL,45,NULL,'2022-11-24 11:51:24','2022-11-24 11:51:24'),(50,16,38,'Company Amendment','',NULL,45,NULL,'2023-01-18 08:43:09','2023-01-18 08:43:09'),(51,17,39,'Trademark Schedule','',NULL,45,NULL,'2023-01-18 09:01:01','2023-01-18 09:01:01'),(52,5,22,'NDA - BTI','',NULL,45,NULL,'2023-01-18 09:23:46','2023-01-18 09:23:46');
/*!40000 ALTER TABLE `bt_legal_documents` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:53:04
