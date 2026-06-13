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
-- Table structure for table `bt_factory_assetuses`
--

DROP TABLE IF EXISTS `bt_factory_assetuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_factory_assetuses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assettype_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serialnum` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pre-damage` int DEFAULT NULL,
  `post-damage` int DEFAULT NULL,
  `theft` int DEFAULT NULL,
  `dateissue` date DEFAULT NULL,
  `date-return` date DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_factory_assetuses_employee_id_index` (`employee_id`),
  KEY `bt_factory_assetuses_assettype_id_index` (`assettype_id`),
  KEY `bt_factory_assetuses_created_by_index` (`created_by`),
  KEY `bt_factory_assetuses_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_factory_assetuses`
--

LOCK TABLES `bt_factory_assetuses` WRITE;
/*!40000 ALTER TABLE `bt_factory_assetuses` DISABLE KEYS */;
INSERT INTO `bt_factory_assetuses` VALUES (1,'2','1','7B9W4P2',0,0,NULL,'2020-08-31',NULL,25,25,'2020-09-07 14:47:27','2020-09-07 14:49:33'),(2,'3','1','769W4P2',0,0,NULL,'2020-09-01',NULL,25,NULL,'2020-09-07 15:57:24','2020-09-07 15:57:24'),(4,'7','2','6C3CX23',0,0,NULL,'2020-09-01',NULL,25,NULL,'2020-09-07 16:00:37','2020-09-07 16:00:37'),(5,'11','2','CHWSC33',0,0,NULL,'2020-09-01',NULL,25,NULL,'2020-09-07 16:01:23','2020-09-07 16:01:23'),(6,'12','2','7K3CX23',0,0,NULL,'2020-09-01',NULL,25,NULL,'2020-09-07 16:02:23','2020-09-07 16:02:23'),(7,'13','3','5CD72862RH',0,0,NULL,'2020-09-01',NULL,25,NULL,'2020-09-07 16:13:14','2020-09-07 16:13:14'),(8,'62','3','9BHTC33',0,0,NULL,'2020-09-01',NULL,25,NULL,'2020-09-07 16:14:51','2020-09-07 16:14:51'),(9,'77','3','PF13KKU1',0,0,NULL,'2020-08-31',NULL,25,25,'2020-09-07 16:15:50','2020-09-07 16:16:08'),(10,'66','2','PF13K2T2',0,0,NULL,'2020-09-01',NULL,25,NULL,'2020-09-07 16:16:46','2020-09-07 16:16:46'),(11,'59','2','PF13NL30',0,0,NULL,'2020-09-01',NULL,25,NULL,'2020-09-07 16:17:30','2020-09-07 16:17:30'),(12,'78','2','PF13NL5Q',0,0,NULL,'2020-09-01',NULL,25,NULL,'2020-09-07 16:17:57','2020-09-07 16:17:57'),(13,'6','6','735NKS3',0,0,NULL,'2023-05-08',NULL,25,46,'2020-09-07 16:34:51','2023-05-31 13:56:48'),(14,'4','4','JBY11C2',0,0,NULL,'2020-09-01',NULL,25,NULL,'2020-09-07 16:37:35','2020-09-07 16:37:35'),(15,'14','5','PF1D40GS',0,0,NULL,'2020-09-01',NULL,25,NULL,'2020-09-07 16:45:12','2020-09-07 16:45:12'),(16,'143','6','325NKS3',0,0,NULL,'2023-05-08',NULL,46,NULL,'2023-05-31 13:56:02','2023-05-31 13:56:02'),(17,'108','6','G25NKS3',0,0,NULL,'2023-05-08',NULL,46,NULL,'2023-05-31 13:57:36','2023-05-31 13:57:36'),(18,'175','6','BDKSC33',0,0,NULL,'2023-05-08',NULL,46,NULL,'2023-05-31 13:58:13','2023-05-31 13:58:13'),(19,'176','6','345NKS3',0,0,NULL,'2023-05-08',NULL,46,NULL,'2023-05-31 13:59:06','2023-05-31 13:59:06');
/*!40000 ALTER TABLE `bt_factory_assetuses` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:42:53
