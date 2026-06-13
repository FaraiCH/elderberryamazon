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
-- Table structure for table `bt_floor_scrappipes`
--

DROP TABLE IF EXISTS `bt_floor_scrappipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_floor_scrappipes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `quote_id` int unsigned DEFAULT NULL,
  `shedule_id` int unsigned DEFAULT NULL,
  `line_id` int unsigned DEFAULT NULL,
  `scrap_out_id` int unsigned DEFAULT NULL,
  `datestored` datetime DEFAULT NULL,
  `weight_kg` decimal(15,1) DEFAULT '0.0',
  `pipediameter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pipelenghts` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_floor_scrappipes_user_id_index` (`user_id`),
  KEY `bt_floor_scrappipes_quote_id_index` (`quote_id`),
  KEY `bt_floor_scrappipes_shedule_id_index` (`shedule_id`),
  KEY `bt_floor_scrappipes_line_id_index` (`line_id`),
  KEY `bt_floor_scrappipes_scrap_out_id_index` (`scrap_out_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_floor_scrappipes`
--

LOCK TABLES `bt_floor_scrappipes` WRITE;
/*!40000 ALTER TABLE `bt_floor_scrappipes` DISABLE KEYS */;
INSERT INTO `bt_floor_scrappipes` VALUES (17,NULL,NULL,NULL,NULL,NULL,'2019-09-26 14:58:56',0.0,NULL,NULL,NULL,'Add scrap to balance Invoice BT 007 (Scrap of 10127 kg)','2019-09-26 15:00:20','2019-09-26 15:00:20'),(18,NULL,NULL,NULL,NULL,NULL,'2019-10-08 12:48:26',0.0,NULL,NULL,NULL,'Noezan And Takesure add scrap','2019-10-08 12:49:18','2019-10-08 12:49:18'),(19,NULL,NULL,NULL,NULL,NULL,'2020-06-18 14:04:51',1795.0,NULL,NULL,NULL,'scrap pipe from BT Account for updating pipes on the floor','2020-06-18 14:09:27','2020-06-18 14:09:33'),(20,NULL,NULL,NULL,NULL,NULL,'2020-06-19 10:05:37',228.0,NULL,NULL,NULL,'Two coils where short length less 50mm','2020-06-19 10:06:31','2020-06-19 10:06:31'),(21,NULL,NULL,NULL,NULL,NULL,'2020-06-22 09:20:00',1017.0,NULL,NULL,NULL,'coils with kinking due to poor handling','2020-06-26 12:13:09','2020-06-26 12:29:12'),(22,NULL,NULL,NULL,NULL,NULL,'2020-06-29 14:28:43',111.0,NULL,NULL,NULL,'PN10 110mm 50mt coil have kinking on it','2020-06-29 14:30:52','2020-06-29 14:30:52'),(23,NULL,NULL,NULL,NULL,NULL,'2020-07-17 11:30:00',51.0,NULL,NULL,NULL,'200 PN12.5 6M OVALITY WAS THE COURSE TO BE REJECTED','2020-07-17 12:33:46','2020-07-17 12:33:46'),(24,NULL,NULL,NULL,NULL,NULL,'2020-07-24 13:11:16',1411.0,NULL,NULL,NULL,'PIPES FROM QUALITY TUBE WHICH HAS POROSITY WHICH WAS REPLACED BY GOOD ONES','2020-07-24 13:12:23','2020-07-29 09:04:00'),(25,NULL,NULL,NULL,NULL,NULL,'2020-07-30 17:05:49',1725.0,NULL,NULL,NULL,'Pipes from Decon which where  welded. 160mm PN12.5 and PN10.','2020-07-30 17:08:17','2020-07-30 17:08:17'),(26,NULL,NULL,NULL,NULL,NULL,'2020-07-30 17:23:26',113.0,NULL,NULL,NULL,'coil rejected due to kicked for plastic-tech','2020-07-30 17:23:30','2020-07-30 17:25:39'),(27,NULL,NULL,NULL,NULL,NULL,'2020-08-05 14:37:11',753.0,NULL,NULL,NULL,'pipes from floor which where bad','2020-08-05 14:45:27','2020-08-05 14:45:27'),(28,NULL,NULL,NULL,NULL,NULL,'2020-08-05 07:53:13',70.0,NULL,NULL,NULL,'Off cut from 450mm which was 12m. 2 X 35kg 1mt\r\n11m was sold for plasti-tech','2020-08-07 07:55:09','2020-08-07 07:55:09'),(29,NULL,NULL,NULL,NULL,NULL,'2020-08-05 15:07:32',2927.0,NULL,NULL,NULL,'off cuts from Barona','2020-08-07 15:07:38','2020-08-07 15:07:38'),(30,NULL,NULL,NULL,NULL,NULL,'2020-08-14 10:17:55',21020.0,NULL,NULL,NULL,'scrape pipe from BT-Account','2020-08-17 10:19:40','2020-09-17 11:23:04'),(31,NULL,NULL,NULL,NULL,NULL,'2020-08-17 11:43:23',2735.0,NULL,NULL,NULL,'scrap pipes due to bad work man-ship pipe is not black its gray and sum have white color','2020-08-17 11:47:07','2020-08-18 09:27:34'),(32,NULL,NULL,NULL,NULL,NULL,'2020-08-21 14:21:41',182.0,NULL,NULL,NULL,'HDPE PLUMPING  SEND THE SCRAP TO US','2020-08-21 14:22:30','2020-08-21 14:22:30'),(33,NULL,NULL,NULL,NULL,NULL,'2020-08-23 15:50:52',4694.0,NULL,NULL,NULL,'scrap pipe from the floor poor handling and QC Fail','2020-08-26 15:51:47','2020-10-01 11:39:36'),(34,NULL,NULL,NULL,NULL,NULL,'2020-09-08 16:30:22',14969.2,NULL,NULL,NULL,'scrap that was delivered using 12mt truck and sum of the pipes was rejected on stock','2020-09-09 16:32:30','2020-09-30 14:46:45'),(35,NULL,NULL,NULL,NULL,NULL,'2020-10-10 09:46:25',43763.0,NULL,NULL,NULL,'scraped pipe which were made for client since they did collect them and we needed to open the yard we had to send the pipe to Robus to be Reworked','2020-10-12 09:43:04','2020-10-29 15:10:09'),(36,NULL,NULL,NULL,NULL,NULL,'2020-10-20 11:11:02',183.0,NULL,NULL,NULL,'SCRAPE COIL FROM ALLIE STEELRODE AND MERCURY','2020-10-21 11:04:09','2020-10-22 13:53:59'),(37,NULL,NULL,NULL,NULL,NULL,'2020-11-05 14:01:11',8801.0,NULL,NULL,NULL,'Scrap from Siriti \r\n1. Truck 1 on 04/11/2020','2020-11-05 13:55:43','2020-11-24 10:29:06'),(38,NULL,NULL,NULL,NULL,NULL,'2020-11-26 09:33:38',15100.0,NULL,NULL,NULL,'pipe from the floor rejected due to bad batch of material','2020-12-12 09:26:59','2020-12-12 09:26:59'),(39,NULL,NULL,NULL,NULL,NULL,'2021-02-03 14:21:50',322.0,NULL,NULL,NULL,'scrap pipe from production short length','2021-02-03 14:12:36','2021-02-03 14:12:36'),(40,NULL,NULL,NULL,NULL,NULL,'2021-02-12 16:36:51',2026.0,NULL,NULL,NULL,'unweight scrap','2021-02-15 16:28:27','2021-02-15 16:31:05'),(41,NULL,NULL,NULL,NULL,NULL,'2021-04-07 15:40:55',3882.0,NULL,NULL,NULL,'OLD PIPES ON THE FLOOR','2021-04-08 15:41:12','2021-09-28 06:39:17'),(42,NULL,NULL,NULL,NULL,NULL,'2021-05-11 00:00:00',4487.0,NULL,NULL,NULL,'Scraped pipes from  BT-Account stock','2021-05-12 06:54:59','2021-05-12 06:54:59'),(43,NULL,NULL,NULL,NULL,NULL,'2021-08-25 12:34:05',23647.4,NULL,NULL,NULL,'SCRAPED PRODUCTION AND ALSO WITH 630MM PN16 RETUN FROM CLIENT','2021-08-25 12:35:01','2021-09-13 11:47:55'),(44,NULL,NULL,NULL,NULL,NULL,'2021-09-08 09:23:25',10996.3,NULL,NULL,NULL,'un accountable scrap since the scale was not working','2021-09-09 09:22:39','2021-09-28 06:40:20'),(45,NULL,NULL,NULL,NULL,NULL,'2021-09-10 11:43:36',8140.0,NULL,NULL,NULL,'COILS FROM SEKUNJALO 90MM PN16 100MTS','2021-09-13 11:42:44','2021-09-13 11:42:44'),(46,NULL,NULL,NULL,NULL,NULL,'2021-09-28 13:21:36',4994.6,NULL,NULL,NULL,'Scrap pipes from long weekend of heritage. 400mm PN10 12mts X 8 length and 250mm PN12.5 abayila','2021-09-28 13:21:29','2021-09-28 13:23:00'),(47,NULL,NULL,NULL,NULL,NULL,'2021-10-04 10:45:23',7783.0,NULL,NULL,NULL,'400mm PN 12MTS for mercury wall was under spec and ovality x 7length','2021-10-04 10:44:44','2021-10-05 11:30:47'),(48,NULL,NULL,NULL,NULL,NULL,'2021-10-06 13:17:35',3988.0,NULL,NULL,NULL,'110mm PN6.3 6mts HDPE Plumbing 405 were rejected due no client name on the pipe and 50mm PN8 100mts X 11 coils were rejected due to poor work manship','2021-10-07 13:17:18','2021-10-07 13:18:28'),(49,NULL,NULL,NULL,NULL,NULL,'2021-10-22 14:59:17',7800.0,NULL,NULL,NULL,'SCRAP FROM BEND IT','2021-10-24 14:59:13','2021-10-24 14:59:13'),(50,NULL,NULL,NULL,NULL,NULL,'2021-11-11 09:40:25',3802.0,NULL,NULL,NULL,'COLLECTED SCRAP FROM APS ON Thursday and send it to H.B Plastics for recycling','2021-11-12 09:40:52','2021-11-12 09:40:52');
/*!40000 ALTER TABLE `bt_floor_scrappipes` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:30:12
