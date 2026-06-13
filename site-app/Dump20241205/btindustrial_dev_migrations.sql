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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2013_10_01_000001_Db_Deferred_Bindings',1),(2,'2013_10_01_000002_Db_System_Files',1),(3,'2013_10_01_000003_Db_System_Plugin_Versions',1),(4,'2013_10_01_000004_Db_System_Plugin_History',1),(5,'2013_10_01_000005_Db_System_Settings',1),(6,'2013_10_01_000006_Db_System_Parameters',1),(7,'2013_10_01_000007_Db_System_Add_Disabled_Flag',1),(8,'2013_10_01_000008_Db_System_Mail_Templates',1),(9,'2013_10_01_000009_Db_System_Mail_Layouts',1),(10,'2014_10_01_000010_Db_Jobs',1),(11,'2014_10_01_000011_Db_System_Event_Logs',1),(12,'2014_10_01_000012_Db_System_Request_Logs',1),(13,'2014_10_01_000013_Db_System_Sessions',1),(14,'2015_10_01_000014_Db_System_Mail_Layout_Rename',1),(15,'2015_10_01_000015_Db_System_Add_Frozen_Flag',1),(16,'2015_10_01_000016_Db_Cache',1),(17,'2015_10_01_000017_Db_System_Revisions',1),(18,'2015_10_01_000018_Db_FailedJobs',1),(19,'2016_10_01_000019_Db_System_Plugin_History_Detail_Text',1),(20,'2016_10_01_000020_Db_System_Timestamp_Fix',1),(21,'2017_08_04_121309_Db_Deferred_Bindings_Add_Index_Session',1),(22,'2017_10_01_000021_Db_System_Sessions_Update',1),(23,'2017_10_01_000022_Db_Jobs_FailedJobs_Update',1),(24,'2017_10_01_000023_Db_System_Mail_Partials',1),(25,'2017_10_23_000024_Db_System_Mail_Layouts_Add_Options_Field',1),(26,'2013_10_01_000001_Db_Backend_Users',2),(27,'2013_10_01_000002_Db_Backend_User_Groups',2),(28,'2013_10_01_000003_Db_Backend_Users_Groups',2),(29,'2013_10_01_000004_Db_Backend_User_Throttle',2),(30,'2014_01_04_000005_Db_Backend_User_Preferences',2),(31,'2014_10_01_000006_Db_Backend_Access_Log',2),(32,'2014_10_01_000007_Db_Backend_Add_Description_Field',2),(33,'2015_10_01_000008_Db_Backend_Add_Superuser_Flag',2),(34,'2016_10_01_000009_Db_Backend_Timestamp_Fix',2),(35,'2017_10_01_000010_Db_Backend_User_Roles',2),(36,'2018_12_16_000011_Db_Backend_Add_Deleted_At',2),(37,'2014_10_01_000001_Db_Cms_Theme_Data',3),(38,'2016_10_01_000002_Db_Cms_Timestamp_Fix',3),(39,'2017_10_01_000003_Db_Cms_Theme_Logs',3),(40,'2018_11_01_000001_Db_Cms_Theme_Templates',4),(41,'2021_10_01_000025_Db_Add_Pivot_Data_To_Deferred_Bindings',5),(42,'2022_10_01_000026_Db_System_Site_Definitions',6),(43,'2023_10_01_000027_Db_Add_Site_To_Settings',6),(44,'2023_10_01_000028_Db_Add_Restrict_Roles_To_Sites',6),(45,'2023_10_01_000029_Db_System_Site_Groups',6),(46,'2023_10_01_000030_Db_Add_Group_To_Sites',6),(47,'2024_10_01_000031_Db_Add_Sort_Order_To_Deferred_Bindings',6),(48,'2024_10_01_000032_Db_Add_Fallback_Locale_To_Sites',6),(49,'2022_10_01_000012_Db_Backend_User_Roles_Sortable',7),(50,'2023_10_01_000013_Db_Add_Site_To_Preferences',7),(51,'2023_10_01_000014_Db_Add_User_Expired_Password',7),(52,'2023_10_01_000015_Db_Backend_Dashboards',7),(53,'2023_10_01_000016_Db_Backend_Report_Data_Cache',7),(54,'2023_10_01_000004_Db_Cms_Traffic_Stats_Pageviews',8),(55,'2021_05_01_000001_Db_Tailor_Globals',9),(56,'2021_05_01_000002_Db_Tailor_Content',9),(57,'2021_06_01_000003_Db_Tailor_PreviewToken',9),(58,'2023_10_01_000004_Db_Tailor_Content_Joins',9),(59,'2024_10_01_000005_Db_Add_Parent_To_Repeaters',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:54:49
