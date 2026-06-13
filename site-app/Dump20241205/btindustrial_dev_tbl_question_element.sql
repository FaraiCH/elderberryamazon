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
-- Table structure for table `tbl_question_element`
--

DROP TABLE IF EXISTS `tbl_question_element`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_question_element` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `questions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `questionelement_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_question_element_questionelement_id_index` (`questionelement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_question_element`
--

LOCK TABLES `tbl_question_element` WRITE;
/*!40000 ALTER TABLE `tbl_question_element` DISABLE KEYS */;
INSERT INTO `tbl_question_element` VALUES (1,'Introduction To ERP','Introduction To ERP','[{\"question\":\"1\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"2\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"3\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-01-20 11:04:09','2023-01-31 07:41:52',2),(3,'SRN General Knowldge','SRN General Knowldge','[{\"question\":\"4\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"5\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"6\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"7\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"14\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"25\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"26\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-01-24 10:15:27','2023-02-01 08:28:47',1),(4,'Advanced SRN Knowledge','Advanced SRN Knowledge','[{\"question\":\"17\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"18\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"8\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"9\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"10\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"23\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"24\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"22\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-01-24 10:20:23','2023-01-30 09:46:12',1),(5,'Completion Of SRN','Completion Of SRN','[{\"question\":\"19\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"20\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"15\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"16\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"21\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-01-24 13:05:26','2023-01-30 09:46:27',1),(6,'Logistic Floor Safety','Logistic Floor Safety','[{\"question\":\"27\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"28\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-01-24 13:06:13','2023-01-30 09:46:42',1),(7,'SHEQ NCR  General','SHEQ NCR  General','[{\"question\":\"39\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"40\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"41\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"42\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"43\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"44\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-01-30 19:09:48','2023-01-30 19:35:06',NULL),(8,'Quality Control General','Quality Control General','[{\"question\":\"29\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"30\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"31\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"45\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"46\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"47\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"48\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"49\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"50\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"51\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-01-31 07:40:46','2023-01-31 07:42:05',2),(9,'Exercise 1','Exercise 1','[{\"question\":\"53\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"54\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"55\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"56\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"57\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"58\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"59\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-01-31 09:41:59','2023-01-31 10:02:04',3),(10,'Exercise 2','Exercise 2','[{\"question\":\"60\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"61\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"62\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"63\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"64\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"65\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-01-31 09:43:06','2023-02-01 08:22:31',3),(11,'Fabrication','Fabrication','[{\"question\":\"70\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"71\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"72\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"73\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"74\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"75\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-02-06 06:54:46','2023-02-06 07:03:14',4),(12,'Pick Slip','Pick Slip','[{\"question\":\"66\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"67\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"68\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"69\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-02-06 06:55:53','2023-02-06 07:03:24',4),(13,'Linking Pipes','Linking Pipes','[{\"question\":\"76\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"77\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"78\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"79\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"80\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"81\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"82\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-02-06 06:57:29','2023-02-06 07:03:31',4),(14,'Cutting Pipes','Cutting Pipes','[{\"question\":\"83\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"84\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"85\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-02-06 06:59:08','2023-02-06 07:03:41',4),(15,'Microsoft Teams Exercise 1','Exercise 1','[{\"question\":\"87\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"88\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"89\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"90\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"91\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"92\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"93\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"94\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"95\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"96\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-11-09 09:31:31','2023-11-09 12:58:57',5),(16,'Microsoft Teams Exercise 2','Exercise 2','[{\"question\":\"97\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"98\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"99\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"100\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"101\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"102\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"103\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"104\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"105\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"106\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-11-09 12:50:32','2023-11-09 12:58:57',5),(17,'Phishing Email Exercise','Exercise 1','[{\"question\":\"107\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"108\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"109\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"110\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"111\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"112\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"113\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"114\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-11-10 12:39:35','2023-11-10 12:42:17',6),(18,'Phishing Email Exercise 2','Exercise 2','[{\"question\":\"115\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"116\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"117\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"118\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"119\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"120\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"121\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"122\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-11-10 12:41:01','2023-11-10 12:43:45',6),(19,'Phishing Email Exercise 3','Exercise 3','[{\"question\":\"123\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"124\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"125\",\"newlabel\":\"\",\"cssgrid\":\"\"},{\"question\":\"126\",\"newlabel\":\"\",\"cssgrid\":\"\"}]','2023-11-13 10:03:01','2023-11-13 10:03:29',6);
/*!40000 ALTER TABLE `tbl_question_element` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:45:41
