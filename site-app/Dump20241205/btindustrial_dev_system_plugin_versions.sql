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
-- Table structure for table `system_plugin_versions`
--

DROP TABLE IF EXISTS `system_plugin_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_plugin_versions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `version` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `is_disabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_frozen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `system_plugin_versions_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=672 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_plugin_versions`
--

LOCK TABLES `system_plugin_versions` WRITE;
/*!40000 ALTER TABLE `system_plugin_versions` DISABLE KEYS */;
INSERT INTO `system_plugin_versions` VALUES (1,'October.Demo','1.0.1','2019-02-10 20:17:26',0,0),(2,'RainLab.User','1.5.0','2020-08-14 08:08:42',0,0),(3,'RainLab.Blog','1.3.3','2020-08-14 08:08:42',0,0),(4,'RainLab.MailChimp','1.0.4','2019-02-10 20:24:19',0,0),(16,'Noezan.Bt','1.0.1','2019-02-19 17:44:52',0,0),(17,'Renatio.DynamicPDF','4.0.8','2021-05-08 06:43:10',0,0),(22,'October.Drivers','1.1.3','2021-05-08 06:43:10',0,0),(29,'PolloZen.SimpleGallery','1.1.3','2019-03-27 09:06:28',0,0),(97,'Bt.Documents','1.0.1','2019-07-06 21:25:32',0,0),(131,'Vdomah.Excel','3.0.1','2020-08-14 08:08:43',0,0),(167,'JanVince.SmallContactForm','1.32.1','2020-08-14 08:08:42',0,0),(174,'RainLab.Builder','1.0.26','2020-05-11 17:41:10',0,0),(178,'Bt.CRM','1.0.1','2020-05-16 21:36:48',0,0),(187,'Bt.Notify','1.0.1','2020-07-17 13:21:05',0,0),(189,'Bt.Floor','1.0.1','2020-08-09 13:23:38',0,0),(190,'Bt.Operator','1.0.1','2020-08-09 13:23:38',0,0),(191,'AhmadFatoni.ApiGenerator','1.0.2','2020-08-09 13:23:38',0,0),(195,'RainLab.Location','1.1.5','2020-08-17 23:57:40',0,0),(197,'Bt.Factory','1.0.1','2020-09-07 12:55:44',0,0),(221,'Bt.Legal','1.0.2','2021-02-11 12:38:44',0,0),(290,'Bt.Reporting','1.0.1','2021-10-23 03:53:24',0,0),(320,'Bt.JSEData','1.0.4','2022-03-07 09:16:50',0,0),(376,'Bt.Suppliers','1.0.1','2022-07-26 10:14:27',0,0),(390,'Bt.PLCommon','1.0.1','2022-11-29 07:09:08',0,0),(449,'Bt.Boardroom','1.0.1','2023-04-26 07:48:53',0,0),(460,'Bt.Logistics','1.0.8','2023-05-26 16:38:00',0,0),(501,'Bt.Maintenance','1.0.13','2023-10-03 09:53:59',0,0),(545,'Bt.SHEQ','1.1.8','2023-11-20 06:01:10',0,0),(549,'Bt.QC','1.0.11','2023-11-23 06:48:20',0,0),(551,'Bt.IT','1.0.3','2023-11-27 08:06:50',0,0),(575,'Bt.Finance','1.1.2','2024-05-28 13:51:19',0,0),(605,'Vdomah.JWTAuth','1.0.12','2024-08-09 15:30:58',0,0),(642,'Bt.Inventory','2.0.6','2024-09-18 10:24:58',0,0),(655,'Bt.Sales','2.1.17','2024-10-21 12:35:26',0,0),(670,'Bt.HR','1.0.9','2024-11-25 06:30:11',0,0),(671,'Bt.Production','4.0.5','2024-11-28 08:28:14',0,0);
/*!40000 ALTER TABLE `system_plugin_versions` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:50:53
