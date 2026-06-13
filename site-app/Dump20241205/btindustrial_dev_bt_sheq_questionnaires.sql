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
-- Table structure for table `bt_sheq_questionnaires`
--

DROP TABLE IF EXISTS `bt_sheq_questionnaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sheq_questionnaires` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` int DEFAULT '0',
  `introduction` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `bt_sheq_questionnaires_created_by_index` (`created_by`),
  KEY `bt_sheq_questionnaires_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sheq_questionnaires`
--

LOCK TABLES `bt_sheq_questionnaires` WRITE;
/*!40000 ALTER TABLE `bt_sheq_questionnaires` DISABLE KEYS */;
INSERT INTO `bt_sheq_questionnaires` VALUES (1,'Logistics Test on ERP','All Logistics BT employees take this test on a monthly basis. This will act as a training course and an introduction to ERP functionality.',2,1,1,'2023-01-23 11:45:05','2023-11-09 09:44:29',0,''),(2,'Quality Control(QC) Test','All BT  Quality Control employees take this test on a monthly basis. This will act as a training course and introduction to ERP functionality.',10,46,1,'2023-01-24 13:24:16','2023-11-09 09:44:23',0,''),(3,'BT Fun Facts','<p style=\"text-align: center\">Fun Facts about BT Industrial. <br>Estimated time of completion: <b>4 Min</b>. Watch the video and complete the questionnaire.</p>\r\n<iframe width=\"100%\" height=\"450\" src=\"https://www.youtube.com/embed/fluK-2_K_SI?si=uF89qCaP2Zak28-Q\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>',1,1,1,'2023-01-31 06:32:31','2023-11-10 08:21:09',1,'Fun Facts about BT Industrial. Estimated time of completion: 3 Min'),(4,'Logistics Test Advanced','Logistics Test Advanced is a thorough test of all areas of creating SRNs on the ERP.',3,46,1,'2023-02-06 07:03:03','2023-11-09 09:44:15',0,''),(5,'Microsoft Teams Training','Estimated time of completion: <b>30 Min</b>. Watch the video and complete the questionnaire.<br><br> \r\n<iframe width=\"100%\" height=\"450\" src=\"https://www.youtube.com/embed/z6IUiamE3-U?si=gQc2SW1_fq9XCN5r\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>',1,1,1,'2023-11-08 11:51:40','2023-11-09 13:33:40',1,'Estimated time of completion: <b>30 Min</b>. Click on the START PROGRAM button to watch the video and complete the questionnaire.'),(6,'IT Security: Spot Phishing Emails','<p style=\"text-align: center\">All BT Employees with access to the internet and emails are requested to complete this program. <br>Estimated time of completion: <b>4 Min</b>. <br>Watch the video and complete the questionnaire.</p>\r\n<iframe width=\"100%\" height=\"450px\" src=\"https://www.youtube.com/embed/o0btqyGWIQw?si=NTMhQe5WfeJlLRwz\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>',3,1,1,'2023-11-10 07:25:20','2023-11-10 07:44:36',1,'All BT Employees with access to the internet and emails are requested to complete this program. Estimated time of completion: <b>4 Min</b>. Click on the START PROGRAM button to watch the video and complete the questionnaire.');
/*!40000 ALTER TABLE `bt_sheq_questionnaires` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:41:51
