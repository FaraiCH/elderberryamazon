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
-- Table structure for table `bt_hr_policies`
--

DROP TABLE IF EXISTS `bt_hr_policies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_hr_policies` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_visible` int DEFAULT '0',
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rev` int DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_hr_policies_created_by_index` (`created_by`),
  KEY `bt_hr_policies_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_hr_policies`
--

LOCK TABLES `bt_hr_policies` WRITE;
/*!40000 ALTER TABLE `bt_hr_policies` DISABLE KEYS */;
INSERT INTO `bt_hr_policies` VALUES (2,'Employment Equity Policy','',0,NULL,14,'2022-05-04 07:39:25','2022-05-27 09:41:29',NULL,'2022-05-27 09:35:41'),(3,'Exit Interview Policy','',0,NULL,14,'2022-05-04 07:42:03','2022-05-27 09:39:05',NULL,'2022-05-27 09:38:22'),(4,'Induction Policy','',0,NULL,14,'2022-05-04 07:46:09','2022-05-27 09:36:47',NULL,'2022-05-27 09:36:41'),(5,'Recruitment and Selection Policy','',0,NULL,14,'2022-05-04 07:50:40','2022-05-27 09:38:01',NULL,'2022-05-27 09:37:49'),(6,'Abuse of Company Property Policy','',0,14,NULL,'2022-05-27 09:40:24','2022-05-27 09:40:24',NULL,'2022-05-27 09:40:11'),(7,'Misconduct Policy','',0,14,NULL,'2022-05-27 09:41:10','2022-05-27 09:41:10',NULL,'2022-05-27 09:40:58'),(8,'Request for Private Trade','',0,14,NULL,'2022-05-27 09:42:18','2022-05-27 09:42:18',NULL,'2022-05-27 09:42:12'),(9,'Employee Loans and Advances Policy','',0,14,NULL,'2022-05-27 09:44:04','2022-05-27 09:44:04',NULL,'2022-05-27 09:43:59'),(10,'Study Assistance Scheme Policy','',0,14,NULL,'2022-05-27 09:45:21','2022-05-27 09:45:21',NULL,'2022-05-27 09:45:01'),(11,'Substance Abuse Policy','',0,14,NULL,'2022-05-27 09:46:30','2022-05-27 09:46:30',NULL,'2022-05-27 09:46:19'),(12,'Smoking Policy','',0,14,NULL,'2022-05-27 09:47:43','2022-05-27 09:47:43',NULL,'2022-05-27 09:47:06'),(13,'Dress Code Policy','',0,14,NULL,'2022-05-27 09:49:29','2022-05-27 09:49:29',NULL,'2022-05-27 09:49:21'),(14,'Gifts Favour and Use Of Company Property Policy','',0,14,NULL,'2022-05-27 09:50:27','2022-05-27 09:50:27',NULL,'2022-05-27 09:50:19'),(15,'Cell Phone Policy','',0,14,NULL,'2022-05-27 09:51:15','2022-05-27 09:51:15',NULL,'2022-05-27 09:51:11'),(16,'','',0,14,14,'2023-03-07 14:38:08','2023-03-07 14:39:18',NULL,'2023-03-07 14:36:27');
/*!40000 ALTER TABLE `bt_hr_policies` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:48:08
