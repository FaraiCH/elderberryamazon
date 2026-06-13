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
-- Table structure for table `bt_it_task_responses`
--

DROP TABLE IF EXISTS `bt_it_task_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_it_task_responses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int unsigned DEFAULT NULL,
  `isolved` int DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_it_task_responses_job_id_index` (`job_id`),
  KEY `bt_it_task_responses_created_by_index` (`created_by`),
  KEY `bt_it_task_responses_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_it_task_responses`
--

LOCK TABLES `bt_it_task_responses` WRITE;
/*!40000 ALTER TABLE `bt_it_task_responses` DISABLE KEYS */;
INSERT INTO `bt_it_task_responses` VALUES (1,71,0,'File Modified','<p>tes</p>',1,NULL,'2020-10-28 09:12:28','2020-10-28 09:12:28'),(2,69,0,'Files Modified','<p>bt/logistics/controllers/schedule/update.htm</p>\r\n\r\n<p>bt/logistics/controllers/schedule/_approve.htm</p>\r\n\r\n<p>bt/logistics/controllers/Schedule.php</p>\r\n\r\n<p>bt/logistics/controllers/schedule/config_relation.yaml</p>\r\n\r\n<p>\r\n	<br>\r\n</p>\r\n\r\n<p>bt/logistics/models/schedule/_approved_columns.htm</p>\r\n\r\n<p>bt/logistics/models/schedule/columns.yaml</p>\r\n\r\n<p>bt/logistics/models/schedule/fields.yaml</p>\r\n\r\n<p>bt/logistics/models/Schedule.php</p>\r\n\r\n<p>\r\n	<br>\r\n</p>\r\n\r\n<p>bt/logistics/models/logisticapprove/fields.yaml</p>\r\n\r\n<p>bt/logistics/models/logisticapprove/columns.yaml</p>\r\n\r\n<p>bt/logistics/models/Logisticapprove.php</p>\r\n\r\n<p>\r\n	<br>\r\n</p>\r\n\r\n<p>bt/logistics/updates/create_logisticapproves_table.php</p>\r\n\r\n<p>bt/logistics/updates/create_schedules_table.php</p>\r\n\r\n<p>bt/logistics/updates/version.yaml</p>\r\n\r\n<p>\r\n	<br>\r\n</p>\r\n\r\n<p>bt/logistics/controllers/Home.php</p>',25,NULL,'2020-10-28 13:39:01','2020-10-28 13:39:01'),(3,79,0,'Back Order Progress','<p>Adjusted Back Orders for sales. Table formatting still needs to be fixed.</p>',37,NULL,'2020-10-29 14:59:06','2020-10-29 14:59:06'),(4,72,0,'Files','<p>File</p>',1,NULL,'2020-11-02 13:12:12','2020-11-02 13:12:12'),(5,72,0,'COC/COA Datapack Reflection','<p>Sales will make a request to QC for the COC/COA for the product. QC will process the request and will only give the COC and COA of products that have been completed. Sales will have the certificate and analysis reflected on their particular quote where they can download the COC and COA via links</p>',37,NULL,'2020-11-02 18:41:07','2020-11-02 18:41:07'),(6,72,0,'Progress','<p>Created Sales Request Tab</p>',37,NULL,'2020-11-03 20:55:20','2020-11-03 20:55:20');
/*!40000 ALTER TABLE `bt_it_task_responses` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:30:36
