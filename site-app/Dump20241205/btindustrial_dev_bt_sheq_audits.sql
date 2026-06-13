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
-- Table structure for table `bt_sheq_audits`
--

DROP TABLE IF EXISTS `bt_sheq_audits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sheq_audits` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `auditdate` datetime DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `bt_sheq_audits_created_by_index` (`created_by`),
  KEY `bt_sheq_audits_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sheq_audits`
--

LOCK TABLES `bt_sheq_audits` WRITE;
/*!40000 ALTER TABLE `bt_sheq_audits` DISABLE KEYS */;
INSERT INTO `bt_sheq_audits` VALUES (2,'2020-07-28 09:00:00','SABS (HDPE Product Audit)','1st CERTIFICATION EXTERNAL AUDIT (HDPE) - SANS 4427-2',13,34,'2020-06-02 09:01:36','2021-08-17 11:38:30',1),(3,'2020-08-20 08:00:00','DEKRA (System)','1st CERTIFICATION EXTERNAL AUDIT (HDPE) - ISO 9001:2015',13,34,'2020-07-07 19:17:26','2021-08-17 11:28:00',1),(4,'2020-05-28 09:00:00','Kwa-Dhewa','3rd Party Internal Audit (HDPE) for ISO 9001:2015',13,34,'2020-07-20 04:52:20','2021-08-17 11:17:16',1),(5,'2021-04-21 11:00:00','SABS (HDPE Product Audit)','EXTERNAL AUDIT (HDPE) - SANS 4427-2 :2008 1st Surveillance Audit',37,34,'2021-01-28 09:23:05','2021-08-17 11:42:07',1),(6,'2021-10-26 11:00:00','SABS ( HDPE Product Audit )','SABS - SANS 4427-2 :2008 2nd Surveillance Audit',37,34,'2021-01-28 09:23:51','2021-11-18 10:09:06',1),(7,'2021-06-01 11:00:00','SABS (Medical Product Audit)','SABS - SANS 50149 :2003',34,34,'2021-02-19 13:45:07','2021-08-17 11:32:18',1),(8,'2021-12-10 08:00:00','SACAS ( Medical System)','ISO 13485:2016 Surveillance Audit',34,34,'2021-02-26 11:08:34','2022-03-31 11:10:10',1),(9,'2021-04-09 08:30:00','ZRT','3rd Party Internal Audit (HDPE)',34,34,'2021-03-17 12:18:51','2021-08-17 11:20:47',1),(10,'2021-08-20 08:00:00','KwaDhewa Services Pty Ltd','3rd Party HDPE Internal Audit for ISO 9001: 2015',34,34,'2021-08-17 11:06:20','2021-08-24 09:33:49',1),(11,'2021-08-20 08:00:00','KwaDhewa Services Pty Ltd','3rd Party Internal Audit for ISO 13485:2016',34,34,'2021-08-17 11:08:49','2021-11-18 10:08:34',1),(12,'2021-09-03 08:30:00','Dekra ( System Audit )','ISO 9001:2015 HDPE Surveillance Audit',34,34,'2021-08-17 11:58:43','2021-10-29 08:01:32',1),(13,'2021-11-12 08:30:00','DEKRA (Medical System Audit)','ISO 9001:2015 Medical Surveillance Audit',34,34,'2021-11-18 10:18:38','2021-11-18 10:19:09',1),(14,'2022-02-24 09:00:00','SABS ( Product Audit ) - Sampling','SANS 4427-2 External Audit ( HDPE )',34,34,'2022-02-03 08:58:17','2022-03-31 09:10:57',1),(15,'2023-04-20 17:00:00','SABS - Product Audit','SANS 4427-2 External Audit ( HDPE )',34,34,'2022-03-31 09:08:08','2023-05-16 21:29:39',1),(16,'2023-10-18 08:00:00','Dekra','ISO 9001:2015 By Dekra \r\n18 & 19 October 2023\r\nBy Hein Jonck',46,34,'2023-04-25 11:41:30','2023-09-04 10:36:58',0),(17,'2023-05-03 09:00:00','KwaDhewa Services Pty Ltd','3rd Party Internal Audit',34,NULL,'2023-05-16 21:09:23','2023-05-16 21:09:23',1),(18,'2023-02-07 08:30:00','SABS: SANS 50149','SABS: SANS 50149',34,34,'2023-07-14 13:13:56','2023-07-14 13:14:23',1),(19,'2023-10-03 08:30:00','SABS: SANS 4427','SABS: SANS 4427',34,34,'2023-07-14 13:16:33','2023-10-13 13:00:19',1);
/*!40000 ALTER TABLE `bt_sheq_audits` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:33:25
