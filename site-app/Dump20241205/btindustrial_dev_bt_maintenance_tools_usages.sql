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
-- Table structure for table `bt_maintenance_tools_usages`
--

DROP TABLE IF EXISTS `bt_maintenance_tools_usages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_maintenance_tools_usages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tool_id` int DEFAULT '0',
  `opendate` datetime DEFAULT NULL,
  `inout_id` int DEFAULT '0',
  `quantity` int NOT NULL DEFAULT '1',
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usedby_id` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_maintenance_tools_usages_created_by_index` (`created_by`),
  KEY `bt_maintenance_tools_usages_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_maintenance_tools_usages`
--

LOCK TABLES `bt_maintenance_tools_usages` WRITE;
/*!40000 ALTER TABLE `bt_maintenance_tools_usages` DISABLE KEYS */;
INSERT INTO `bt_maintenance_tools_usages` VALUES (1,324,'2019-07-08 13:42:19',2,1,'Use on the floor','1',1,'2019-07-08 13:42:48','2019-07-08 13:42:48',NULL,NULL),(2,324,'2019-07-08 06:30:00',1,1,'Close Of business','2',1,'2019-07-08 15:22:31','2019-07-08 15:41:14',NULL,1),(3,324,'2019-07-08 15:22:46',3,1,'Doing stock take','3',1,'2019-07-08 15:23:05','2019-07-08 15:23:05',NULL,NULL),(4,325,'2019-07-09 08:56:32',3,1,'On the floor, scratched','2',4,'2019-07-09 08:57:23','2019-07-09 08:57:23',9,NULL),(5,326,'2019-07-09 14:45:28',3,1,'On the floor','1',1,'2019-07-09 14:46:34','2019-07-09 14:46:34',1,NULL),(6,82,'2019-07-17 14:55:40',2,1,'for production','1',2,'2019-07-17 14:56:31','2019-07-17 14:56:31',10,NULL),(7,354,'2020-05-16 11:55:00',2,1,'STRAP PIPES/COILS','1',3,'2020-06-04 14:14:13','2020-06-04 14:14:13',19,NULL),(8,356,'2020-05-27 14:26:53',2,4,'NA','1',1,'2020-06-04 14:27:23','2020-06-04 14:27:23',19,NULL);
/*!40000 ALTER TABLE `bt_maintenance_tools_usages` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 18:00:20
