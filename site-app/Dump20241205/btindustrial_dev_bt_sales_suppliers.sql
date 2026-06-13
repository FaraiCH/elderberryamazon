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
-- Table structure for table `bt_sales_suppliers`
--

DROP TABLE IF EXISTS `bt_sales_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sales_suppliers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `physical_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `physical_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vatno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendorno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coreg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_sales_suppliers_created_by_index` (`created_by`),
  KEY `bt_sales_suppliers_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sales_suppliers`
--

LOCK TABLES `bt_sales_suppliers` WRITE;
/*!40000 ALTER TABLE `bt_sales_suppliers` DISABLE KEYS */;
INSERT INTO `bt_sales_suppliers` VALUES (1,'Broadway Mining Supplies','','','','119 High Rd, Bredell, 1619 Kempton Park, Gauteng','2007','','','4370278493',NULL,'',NULL,NULL,'2019-09-05 20:48:24','2023-06-21 08:42:07'),(2,'BEND IT','CHRISTO SWANEPOEL','christo@megasurfwifi.co.za','0845497078','35 Nanescol, Vanderbijlpark','1900','PO BOX 3884, Vanderbijlpark','1911','',NULL,'2010/078114/23',NULL,NULL,'2019-09-10 13:46:01','2023-06-21 08:25:31'),(3,'CAB-PROCESS PIPE','SHARI OLSEN','ShariO@processpipejhb.co.za','0116092066/0113977400','5 FUCHS STREET ALRODE ALBERTON','1451','5 FUCHS STREET ALRODE ALBERTON','1451','4230115943',NULL,'1969/008153/07',NULL,NULL,'2019-09-10 13:52:55','2019-09-10 13:53:17'),(4,'FORCEFLO','SANETTE MARITZ','projects@forceflow.co.za','072140 0776','12 KING STREET, PARYS','9585','PO BOX 1201, PARYS','9585','4180304109',NULL,'',NULL,NULL,'2019-09-10 13:55:25','2023-06-21 08:52:53'),(5,'MR STUBMAN','Beverley Le Roux','mrstubman@vodamail.co.za','011 6601064','12 MOULD STREET BOLTONIA KRUGERSDORP','1740','12 MOULD STREET BOLTONIA KRUGERSDORP','1740','4810211906',NULL,'. 2003/060812/23',NULL,NULL,'2019-09-10 14:01:30','2019-09-10 14:01:30'),(6,'MACSTEEL','EENOK MOATA','Eenok.Moata@mactrading.co.za','0118215000','3 TIELMAN ROOS STREET WADEVILLE GERMISTON','1422','3 TIELMAN ROOS STREET GERMISTON','1422','',NULL,'',NULL,NULL,'2019-09-10 14:07:50','2019-09-10 14:07:50'),(7,'DECON PROJECTS','JACO VAN HEERDEN','jade@decon.co.za','0121117279','','','','','',NULL,'2017/101986/07',NULL,NULL,'2019-09-10 14:16:17','2019-09-10 14:16:17'),(8,'SL PIPING','SIYA','SLPIPING@OUTLOOK.COM','0660000400','200 CAPE ROAD MILPARK PORT ELIZABETH','200 CAPE ROAD MILPARK PORT ELIZABETH','0','0','',NULL,'',NULL,NULL,'2020-01-14 14:54:06','2020-01-14 14:58:40'),(9,'AMINI TRADE','GEORGE SLABERT','gs@amini.co.za','0828088186','22 DUBHE STREET MIDSTREAM RIDGE MIDRAND','22 DUBHE STREET MIDSTREAM RIDGE MIDRAND','0000','0000','4410279378',NULL,'',NULL,NULL,'2020-02-04 08:49:36','2020-02-04 08:49:36'),(10,'P&L MOVING AND RIGGING','VASCO DA FONTE','ops@plmmr.co.za','0833043004','02 DURANDT ROAD PUTTFONTEIN','1513','02 DURANDT ROAD PUTTFONTEIN','1513','4820163059',NULL,'2019/404540/07',NULL,NULL,'2020-08-04 11:54:46','2020-08-04 11:54:46'),(11,'GALATION TRADING ENTERPRISES (Pty) Ltd','YUGESHNEE LAWRENCE','yugeshnee@galationtrading.co.za','0795763567 / 0118961054','PVT BAG X5 ELSPARK GERMISTON','1420','PVT BAG X5 ELSPARK GERMISTON','1420','4770277137',NULL,'2015/315568/07',NULL,NULL,'2020-08-04 13:52:45','2020-08-04 13:52:45'),(12,'SEKUNJALO','RONALD MOODLEY','ronald@sekunjalopiping.co.za','082 887 8755','17 AXIE DRIVE CLAYVILLE OLIFANTSFONTEIN','2060','P O BOX 3968 CRAMMERVIEW','2060','4110271089',NULL,'2015/306464/07',NULL,NULL,'2020-08-07 09:17:57','2020-08-07 09:17:57'),(13,'City Plastics Industrial Piping (Pty) ltd','','sales@cityplastics.co.za','+27 11 397 5180','5 Charlie Lane, Jet Park Boksburg, Johannesburg, Gauteng, South Africa','5 Charlie Lane, Jet Park Boksburg, Johannesburg, Gauteng, South Africa','','','',NULL,'',NULL,NULL,'2021-10-25 08:51:53','2021-10-25 08:51:53'),(14,'Emeraude','Trevor Moroney - Managing Director','trevor@emeraudetrading.co.za','+2772 2244221','','','','','4800288898',NULL,'',NULL,NULL,'2023-10-20 12:10:49','2023-10-20 12:10:49');
/*!40000 ALTER TABLE `bt_sales_suppliers` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:46:08
