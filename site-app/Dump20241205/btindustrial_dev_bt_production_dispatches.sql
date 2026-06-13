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
-- Table structure for table `bt_production_dispatches`
--

DROP TABLE IF EXISTS `bt_production_dispatches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_production_dispatches` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pickslip_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transport_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_registration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_full_names` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trailers_registration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entry_weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entry_weight_timestamp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exit_weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exit_weight_timestamp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_production_dispatches_pickslip_id_index` (`pickslip_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_production_dispatches`
--

LOCK TABLES `bt_production_dispatches` WRITE;
/*!40000 ALTER TABLE `bt_production_dispatches` DISABLE KEYS */;
INSERT INTO `bt_production_dispatches` VALUES (1,'6200','Sizavusi Investments','Delivery','123 abc mp','tom cruise','456 abc mp, 789 abc mp','0','2024-08-22 11:14:11','0','2024-08-22 11:19:22','2024-08-22 11:14:11','2024-08-22 11:19:22'),(2,'5990','GLOBAL PIPE TECH','Collection','123 abc gp','john snow','456 abc gp','0','2024-08-22 11:14:54','0','2024-08-22 11:19:09','2024-08-22 11:14:54','2024-08-22 11:19:09'),(3,'115','MUSAN TRADING ENTERPRISE','Delivery','123 abc l','jack black','456 abc l','0','2024-08-22 11:15:48','0','2024-08-22 11:18:58','2024-08-22 11:15:48','2024-08-22 11:18:58'),(4,'6203','CITY PLASTICS','Collection','123 abc mp','ice man',NULL,'665','2024-08-22 12:09:04','0','2024-08-29 09:09:37','2024-08-22 12:09:04','2024-08-29 09:09:37'),(5,'6210','Buzaphi Constructions','Delivery','123 abc gp','king von','456 abc gp','0','2024-08-23 10:58:11','0','2024-08-23 11:00:02','2024-08-23 10:58:11','2024-08-23 11:00:02'),(6,'6212','IMS Lowveld','Delivery','123 ABC GP','kulani',NULL,'0','2024-08-23 11:14:49','0','2024-08-23 11:15:39','2024-08-23 11:14:49','2024-08-23 11:15:39'),(7,'6233','PLASSON SA','Delivery','HM85WWGP','Malatji','VRP228GP','2570','2024-08-29 09:21:42','2570','2024-08-29 09:22:39','2024-08-29 09:21:42','2024-08-29 09:22:39'),(8,'6247','IMS Lowveld','Collection','fwg 415 mp','gerald',NULL,'7310','2024-08-29 09:53:25','8970','2024-08-29 11:24:13','2024-08-29 09:53:25','2024-08-29 11:24:13'),(9,'6254','PN COMPOSITES (PTY) LTD','Collection','HFC 768 GP','BEN',NULL,'2620','2024-09-03 09:39:55','2660','2024-09-03 10:16:55','2024-09-03 09:39:55','2024-09-03 10:16:55'),(10,'6255','Sizavusi Investments (PTY) LTD','Collection','KZG610MP','LUCKY',NULL,'8580','2024-09-03 11:38:40','11030','2024-09-03 13:54:12','2024-09-03 11:38:40','2024-09-03 13:54:12'),(11,'6262','ROTA THRUST (PTY) LTD','Collection','HW 87 LH GP','MARIUS',NULL,'10070','2024-09-04 08:04:09','13330','2024-09-04 09:13:49','2024-09-04 08:04:09','2024-09-04 09:13:49'),(12,'6261','FLOTEK DUNDEE (PTY) LTD.','Delivery','LW 35 GM GP','LUCAS MASHA','LW 35 FT GP','12270','2024-09-04 08:15:09','12480','2024-09-04 08:27:45','2024-09-04 08:15:09','2024-09-04 08:27:45'),(13,'6261','FLOTEK DUNDEE (PTY) LTD.','Delivery','LW 35 GM GP','LUCAS MASHA','LW 35 FT GP','12480','2024-09-04 08:29:02','16040','2024-09-04 09:59:39','2024-09-04 08:29:02','2024-09-04 09:59:39'),(14,'6263','Buzaphi Constructions','Delivery','LW 35 HJ GP','BHEKI','LW 35 FT GP','12330','2024-09-05 06:58:46','20090','2024-09-05 08:29:02','2024-09-05 06:58:46','2024-09-05 08:29:02'),(15,'6267','SIZAMANZI PIPE & FITTINGS','Collection','CZ 07FF GP','TAKALANI',NULL,'3830','2024-09-05 07:49:02',NULL,NULL,'2024-09-05 07:49:02','2024-09-05 07:49:02'),(16,'6269','VORTEX HOLDINGS (PTY) LTD','Collection','FJ 77 YF GP','JOHANNES',NULL,'3540','2024-09-05 08:57:24','4020','2024-09-05 09:57:19','2024-09-05 08:57:24','2024-09-05 09:57:19'),(17,'6269','VORTEX HOLDINGS (PTY) LTD','Collection','FJ 77 XF GP','JOHANNES',NULL,'3540','2024-09-05 08:58:15','4020','2024-09-05 09:56:36','2024-09-05 08:58:15','2024-09-05 09:56:36'),(18,'6266','Sebetsa Trading (Pty) Ltd','Delivery','LW 35 GM GP','LUCAS','LW 35 FD GP','16520','2024-09-05 10:25:05','27510','2024-09-06 07:07:48','2024-09-05 10:25:05','2024-09-06 07:07:48'),(19,'6271','VORTEX HOLDINGS (PTY) LTD','Delivery','HN 85 WW GP','LAJIS','VRP 288 GP','2400','2024-09-06 07:16:46','4220','2024-09-06 08:41:16','2024-09-06 07:16:46','2024-09-06 08:41:16'),(20,'6276','VORTEX HOLDINGS (PTY) LTD','Delivery','HN 85 WW GP','LAJIS','VRP 288 GP','2410','2024-09-09 08:09:47','3270','2024-09-09 09:56:38','2024-09-09 08:09:47','2024-09-09 09:56:38'),(21,'6279','RamPiping Systems (Pty)Ltd','Delivery','LW35HJGP','BHEKI MBATHA','LW35FTGP','12390','2024-09-09 12:48:04','13270','2024-09-10 06:52:00','2024-09-09 12:48:04','2024-09-10 06:52:00'),(22,'6282','Quality Plastics','Collection','FYD 990 FS','DANI',NULL,'8910','2024-09-10 09:45:43','10380','2024-09-10 10:51:40','2024-09-10 09:45:43','2024-09-10 10:51:40'),(23,'6285','FLOTEK DUNDEE (PTY) LTD.','Delivery','LW 35 HJ GP','BHEKI','LW 35 FT GP','12580','2024-09-11 07:30:15',NULL,NULL,'2024-09-11 07:30:15','2024-09-11 07:30:15');
/*!40000 ALTER TABLE `bt_production_dispatches` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:57:32
