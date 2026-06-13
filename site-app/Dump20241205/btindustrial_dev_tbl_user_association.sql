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
-- Table structure for table `tbl_user_association`
--

DROP TABLE IF EXISTS `tbl_user_association`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_user_association` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `association__id` int unsigned DEFAULT NULL,
  `tbl_association_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_association__id` int unsigned DEFAULT NULL,
  `association__record_active` tinyint(1) NOT NULL DEFAULT '1',
  `association__datetime_to` datetime DEFAULT NULL,
  `user_rights` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_user_association_association__id_index` (`association__id`),
  KEY `tbl_user_association_tbl_association__id_index` (`tbl_association__id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_association`
--

LOCK TABLES `tbl_user_association` WRITE;
/*!40000 ALTER TABLE `tbl_user_association` DISABLE KEYS */;
INSERT INTO `tbl_user_association` VALUES (1,368,'Backend\\Models\\User',40,1,NULL,1,NULL,NULL,NULL),(2,505,'Backend\\Models\\User',165,1,NULL,1,NULL,NULL,NULL),(3,505,'Backend\\Models\\User',158,1,NULL,1,NULL,NULL,NULL),(4,505,'Backend\\Models\\User',161,1,NULL,1,NULL,NULL,NULL),(5,505,'Backend\\Models\\User',7,1,NULL,1,NULL,NULL,NULL),(6,505,'Backend\\Models\\User',164,1,NULL,1,NULL,NULL,NULL),(7,506,'Backend\\Models\\User',164,1,NULL,0,NULL,NULL,NULL),(8,506,'Backend\\Models\\User',158,1,NULL,0,NULL,NULL,NULL),(9,506,'Backend\\Models\\User',161,1,NULL,0,NULL,NULL,NULL),(10,506,'Backend\\Models\\User',165,1,NULL,0,NULL,NULL,NULL),(11,506,'Backend\\Models\\User',7,1,NULL,0,NULL,NULL,NULL),(12,507,'Backend\\Models\\User',164,1,NULL,1,NULL,NULL,NULL),(13,507,'Backend\\Models\\User',165,1,NULL,1,NULL,NULL,NULL),(14,507,'Backend\\Models\\User',7,1,NULL,1,NULL,NULL,NULL),(15,507,'Backend\\Models\\User',158,1,NULL,1,NULL,NULL,NULL),(16,507,'Backend\\Models\\User',161,1,NULL,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_user_association` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:36:17
