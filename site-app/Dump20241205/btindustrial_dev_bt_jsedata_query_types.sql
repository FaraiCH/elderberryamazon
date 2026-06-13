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
-- Table structure for table `bt_jsedata_query_types`
--

DROP TABLE IF EXISTS `bt_jsedata_query_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_jsedata_query_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_jsedata_query_types_created_by_index` (`created_by`),
  KEY `bt_jsedata_query_types_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_jsedata_query_types`
--

LOCK TABLES `bt_jsedata_query_types` WRITE;
/*!40000 ALTER TABLE `bt_jsedata_query_types` DISABLE KEYS */;
INSERT INTO `bt_jsedata_query_types` VALUES (1,'List By Month',1,1,'2021-02-10 12:15:07','2021-02-12 09:55:16'),(2,'List By Date',1,1,'2021-02-12 09:55:26','2021-02-12 09:55:41'),(3,'Long Term Debt = Non Interest Bearing loans + Interest bearing loans + other long term debt + Deferred Tax liability+ Retirement Obligation',1,1,'2021-02-17 12:31:46','2021-02-17 22:39:29'),(4,'Short Term Debt = Total Current Liabilities',1,1,'2021-02-17 12:51:10','2021-02-17 22:38:50'),(5,'Total Debt = Long term debt + Short term debt',1,1,'2021-02-17 12:53:12','2021-02-17 22:37:58'),(6,'Change In Debt = Current year debt – Previous year debt',1,NULL,'2021-02-17 21:47:38','2021-02-17 21:47:38'),(7,'Change In Equity = Total Shareholders Interest from current year – Total Shareholders Interest from previous year',1,NULL,'2021-02-17 22:52:03','2021-02-17 22:52:03'),(8,'M Fiscal = Number of Linked Units Issued (Actual)*Share price average Fiscal + Total Debt',1,NULL,'2021-02-28 10:15:43','2021-02-28 10:15:43'),(9,'M Closing = Number of Linked Units Issued (Actual)*Share price closing Fiscal + Total Debt',1,NULL,'2021-02-28 10:16:01','2021-02-28 10:16:01'),(10,'Intangible capital = Goodwill + Intangible Assets',1,NULL,'2021-03-04 10:41:51','2021-03-04 10:41:51'),(11,'I = Profit for the period + Depreciation- Dividends paid(this is from the cashflow statement) + Change in debt + Change in Equity + Increase in Intangible capital',1,NULL,'2021-03-04 11:25:24','2021-03-04 11:25:24');
/*!40000 ALTER TABLE `bt_jsedata_query_types` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:40:00
