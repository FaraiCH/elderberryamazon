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
-- Table structure for table `bt_maintenance_vendors`
--

DROP TABLE IF EXISTS `bt_maintenance_vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_maintenance_vendors` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contactperson` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contactnumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacttel` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contactemail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `welike` int NOT NULL DEFAULT '1',
  `vendor_type_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `physical_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vatno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendorno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coreg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int unsigned DEFAULT NULL,
  `extra_contacts` text COLLATE utf8mb4_unicode_ci,
  `beestatus` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry_date_of_bee_cert` date DEFAULT NULL,
  `is_quality_accreditations` int DEFAULT '0',
  `details_of_accreditation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_of_accreditation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accreditation_body` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audits` text COLLATE utf8mb4_unicode_ci,
  `is_blacklisted` int DEFAULT '0',
  `blacklisted_notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `risklevel_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_maintenance_vendors_country_id_index` (`country_id`),
  KEY `bt_maintenance_vendors_created_by_index` (`created_by`),
  KEY `bt_maintenance_vendors_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_maintenance_vendors`
--

LOCK TABLES `bt_maintenance_vendors` WRITE;
/*!40000 ALTER TABLE `bt_maintenance_vendors` DISABLE KEYS */;
INSERT INTO `bt_maintenance_vendors` VALUES (1,'Spruitview Hardware','','','','','','','','South Africa','',1,1,'2019-05-27 13:41:12','2020-08-18 00:32:54','','','',NULL,'','',208,'[]','',NULL,0,'','','','[]',0,'',NULL,1,5),(2,'Alberton Steel And Pipes','Stephen','0119076620','0119076620','','','','','South Africa','',1,1,'2019-07-08 15:06:20','2020-08-18 00:33:11','','','',NULL,'','',208,'[]','',NULL,0,'','','','[]',0,'',NULL,1,3),(3,'Riasebetsa Security','Vanesh','0113159956','0113159956','','','','','South Africa','',1,1,'2019-07-08 15:09:35','2020-08-18 09:23:47','','','',NULL,'','',208,'[]','',NULL,0,'','','','[]',0,'',NULL,1,0);
/*!40000 ALTER TABLE `bt_maintenance_vendors` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:35:55
