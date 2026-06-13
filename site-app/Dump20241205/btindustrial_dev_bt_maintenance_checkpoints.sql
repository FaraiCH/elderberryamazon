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
-- Table structure for table `bt_maintenance_checkpoints`
--

DROP TABLE IF EXISTS `bt_maintenance_checkpoints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_maintenance_checkpoints` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `checklist_id` int unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `orderby` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `bt_maintenance_checkpoints_checklist_id_index` (`checklist_id`),
  KEY `bt_maintenance_checkpoints_created_by_index` (`created_by`),
  KEY `bt_maintenance_checkpoints_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_maintenance_checkpoints`
--

LOCK TABLES `bt_maintenance_checkpoints` WRITE;
/*!40000 ALTER TABLE `bt_maintenance_checkpoints` DISABLE KEYS */;
INSERT INTO `bt_maintenance_checkpoints` VALUES (1,1,'Engine oil',1,NULL,'2019-07-08 13:25:39','2019-07-08 13:25:39',0),(2,1,'Fuel',1,NULL,'2019-07-08 13:25:55','2019-07-08 13:25:55',0),(3,1,'Radiator Water',1,NULL,'2019-07-08 13:26:12','2019-07-08 13:26:12',0),(4,1,'Hydraulic Fluid',1,6,'2019-07-08 13:26:25','2019-07-09 09:27:37',0),(5,1,'Overall Sound',1,NULL,'2019-07-08 13:26:44','2019-07-08 13:26:44',0),(6,2,'Lubrication of chassis',1,NULL,'2019-07-08 13:29:05','2019-07-08 13:29:05',0),(7,2,'Lubrication of mast components',1,NULL,'2019-07-08 13:29:22','2019-07-08 13:29:22',0),(8,2,'Replacement of engine oil',1,NULL,'2019-07-08 13:29:30','2019-07-08 13:29:30',0),(9,2,'Cleaning of the air filter element',1,NULL,'2019-07-08 13:29:39','2019-07-08 13:29:39',0),(10,2,'Adjustment of engine idle speed',1,NULL,'2019-07-08 13:29:54','2019-07-08 13:29:54',0),(11,2,'Adjustment of  ignition timing on engine powered trucks',1,NULL,'2019-07-08 13:30:20','2019-07-08 13:30:20',0),(12,2,'Inspection of lift',1,NULL,'2019-07-08 13:30:33','2019-07-08 13:30:33',0),(13,2,'Inspection of tilt cylinder operation',1,NULL,'2019-07-08 13:31:08','2019-07-08 13:31:08',0),(14,2,'Inspection of drive belt tension',1,NULL,'2019-07-08 13:31:30','2019-07-08 13:31:30',0),(15,2,'Inspection of spark plugs',1,NULL,'2019-07-08 13:31:52','2019-07-08 13:31:52',0),(16,2,'Inspection of  distributor point',1,NULL,'2019-07-08 13:32:13','2019-07-08 13:32:13',0),(17,3,'Replace engine oil',6,NULL,'2019-07-09 09:19:50','2019-07-09 09:19:50',0),(18,3,'Install New Wheels',6,NULL,'2019-07-09 09:20:48','2019-07-09 09:20:48',0),(19,5,'1.1 V-belts tension',1,NULL,'2020-03-23 11:15:45','2020-03-23 11:15:45',1),(20,5,'1.2 Coupling alignment',1,NULL,'2020-03-23 11:16:01','2020-03-23 11:16:01',2),(21,5,'2.1 Foot mountings: Motor bolts',1,NULL,'2020-03-23 11:17:10','2020-03-23 11:17:10',3),(22,5,'2.2 Compressor mount bolts',1,NULL,'2020-03-23 11:17:22','2020-03-23 11:17:22',4),(23,5,'3.1 Motor: cable condition',1,NULL,'2020-03-23 11:17:33','2020-03-23 11:17:33',5),(24,5,'3.2 Terminal connections',1,NULL,'2020-03-23 11:17:45','2020-03-23 11:17:45',6),(25,5,'3.3 Fan and fan cover',1,NULL,'2020-03-23 11:17:57','2020-03-23 11:17:57',7),(26,5,'4.1 Compressor: oil level',1,NULL,'2020-03-23 11:18:19','2020-03-23 11:18:19',8),(27,5,'4.2 Oil colour',1,NULL,'2020-03-23 11:18:31','2020-03-23 11:18:31',9),(28,5,'4.3 Cooling fins condition',1,NULL,'2020-03-23 11:18:41','2020-03-23 11:18:41',10),(29,5,'4.4 Oil filter',1,1,'2020-03-23 11:18:50','2020-03-23 11:18:55',11),(30,5,'4.5 Air filter',1,NULL,'2020-03-23 11:19:06','2020-03-23 11:19:06',12),(31,5,'5.1 Accumulator Drum',1,NULL,'2020-03-23 11:19:27','2020-03-23 11:19:27',13),(32,5,'5.2 Purging valve condition',1,NULL,'2020-03-23 11:19:39','2020-03-23 11:19:39',14),(33,5,'5.3 Drain condensate',1,NULL,'2020-03-23 11:19:51','2020-03-23 11:19:51',15),(34,5,'5.4 Condition of Pressure gauge',1,NULL,'2020-03-23 11:20:04','2020-03-23 11:20:04',16),(35,5,'5.5 Condition of Auto switch',1,NULL,'2020-03-23 11:20:13','2020-03-23 11:20:13',17),(36,5,'6.1 Power supply',1,NULL,'2020-03-23 11:20:45','2020-03-23 11:20:45',18),(37,5,'6.2 Condition of power circuit',1,NULL,'2020-03-23 11:20:57','2020-03-23 11:20:57',19),(38,5,'6.3 Condition of components',1,NULL,'2020-03-23 11:21:10','2020-03-23 11:21:10',20),(39,5,'7.1 On Running',1,NULL,'2020-03-23 11:21:30','2020-03-23 11:21:30',21),(40,5,'7.2 Bubble soap test for leaks',1,NULL,'2020-03-23 11:21:43','2020-03-23 11:21:43',22),(41,5,'7.3 Drain regulator condensate',1,NULL,'2020-03-23 11:21:56','2020-03-23 11:21:56',23),(42,5,'8.1 Housekeeping',1,NULL,'2020-03-23 11:22:09','2020-03-23 11:22:09',24),(43,5,'8.2 Oil leaks',1,NULL,'2020-03-23 11:22:23','2020-03-23 11:22:23',25),(44,5,'8.3 Area around Compressor',1,NULL,'2020-03-23 11:22:34','2020-03-23 11:22:34',26),(45,5,'8.4 Electrical power pane',1,NULL,'2020-03-23 11:22:46','2020-03-23 11:22:46',27),(46,7,'Bailer 1',1,NULL,'2021-02-22 12:59:23','2021-02-22 12:59:23',NULL),(47,7,'Bailer 2',1,NULL,'2021-02-22 12:59:51','2021-02-22 12:59:51',2),(48,7,'Bailer 3',1,NULL,'2021-02-22 13:00:02','2021-02-22 13:00:02',3),(49,8,'Baila 1',38,37,'2021-02-22 13:35:01','2021-04-27 12:28:18',0),(50,8,'Baila 2',38,37,'2021-02-22 13:35:11','2021-04-27 12:28:14',0),(51,8,'Baila 3',38,37,'2021-02-22 13:35:18','2021-04-27 12:28:10',0),(52,9,'Baila 1',38,37,'2021-02-22 13:58:58','2021-04-27 12:27:44',0),(53,9,'Baila 2',38,37,'2021-02-22 13:59:06','2021-04-27 12:27:40',0),(54,9,'Baila 3',38,37,'2021-02-22 13:59:41','2021-04-27 12:27:35',0),(55,10,'Baila 1',38,37,'2021-02-22 14:11:34','2021-04-27 12:15:40',0),(56,10,'Baila 2',38,37,'2021-02-22 14:11:42','2021-04-27 12:15:35',0),(57,10,'Baila 3',38,37,'2021-02-22 14:11:49','2021-04-27 12:15:31',0),(58,11,'Baila 1',38,37,'2021-02-22 14:12:37','2021-04-27 12:29:10',0),(59,11,'Baila 2',38,37,'2021-02-22 14:12:51','2021-04-27 12:29:06',0),(60,11,'Baila 3',38,37,'2021-02-22 14:12:59','2021-04-27 12:29:02',0),(61,12,'Baila 1',38,37,'2021-02-22 14:15:14','2021-04-27 12:28:47',0),(62,12,'Baila 2',38,37,'2021-02-22 14:15:21','2021-04-27 12:28:43',0),(63,12,'Baila 3',38,37,'2021-02-22 14:15:33','2021-04-27 12:28:39',0),(64,13,'Battery terminals, connections, acid condition and voltage',37,37,'2021-04-27 17:42:09','2021-04-27 17:43:50',0),(65,13,'Electrical connections on controller and generator terminals',37,NULL,'2021-04-27 17:44:23','2021-04-27 17:44:23',0),(66,13,'Foot mountings: Motor bolts . Engine shock mounting. Check and clean air filter',37,37,'2021-04-27 17:44:50','2021-04-27 17:45:42',0),(67,13,'Cooling water level and top up. Oil level and top up. Diesel level and top up',37,37,'2021-04-27 17:46:40','2021-04-27 17:47:41',0),(68,13,'Signs of fluids leakage. Housekeeping inside housing and around.',37,NULL,'2021-04-27 17:48:20','2021-04-27 17:48:20',0),(69,13,'Run for 2 minutes on no load and check voltages',37,NULL,'2021-04-27 17:48:42','2021-04-27 17:48:42',0),(70,13,'Listen to engine sound.',37,NULL,'2021-04-27 17:49:11','2021-04-27 17:49:11',0),(71,13,'Check and record running hours.',37,NULL,'2021-04-27 17:49:49','2021-04-27 17:49:49',0),(72,13,'Check condition of fire extinguisher',37,NULL,'2021-04-27 17:50:13','2021-04-27 17:50:13',0),(73,14,'Minor Service',36,36,'2021-08-03 10:37:38','2021-08-03 10:38:01',1),(74,14,'Major Service',36,NULL,'2021-08-03 10:37:52','2021-08-03 10:37:52',2),(75,15,'Tire Condition',1,NULL,'2022-04-11 10:33:48','2022-04-11 10:33:48',1),(76,15,'Lights',1,NULL,'2022-04-11 10:33:59','2022-04-11 10:33:59',2),(77,15,'Oil',1,NULL,'2022-04-11 10:34:15','2022-04-11 10:34:15',3),(78,15,'License Disk',1,NULL,'2022-04-11 10:34:33','2022-04-11 10:34:33',5),(79,15,'Hazards',46,NULL,'2022-04-11 11:05:00','2022-04-11 11:05:00',4),(80,15,'Mirrors',46,NULL,'2022-04-11 11:05:27','2022-04-11 11:05:27',6),(81,15,'Engine',46,NULL,'2022-04-11 11:05:49','2022-04-11 11:05:49',7),(82,15,'Brakes',46,NULL,'2022-04-11 11:06:26','2022-04-11 11:06:26',8),(83,15,'Doors',46,NULL,'2022-04-11 11:08:16','2022-04-11 11:08:16',9),(84,15,'Fuel',46,46,'2022-04-11 11:08:40','2022-04-11 11:08:52',10),(85,15,'Battery',46,NULL,'2022-04-11 11:09:17','2022-04-11 11:09:17',11),(86,15,'Safety Belt',46,46,'2022-04-11 11:09:50','2022-04-11 11:10:02',12),(87,15,'Horn',46,NULL,'2022-04-11 11:10:23','2022-04-11 11:10:23',13),(88,15,'Wipers',46,NULL,'2022-04-11 11:10:57','2022-04-11 11:10:57',14),(89,15,'Car Condition(Body)',46,NULL,'2022-04-11 11:11:47','2022-04-11 11:11:47',15),(90,16,'Lights',46,NULL,'2022-04-11 11:15:38','2022-04-11 11:15:38',1),(91,16,'Hazards',46,NULL,'2022-04-11 11:15:56','2022-04-11 11:15:56',2),(92,16,'Brakes',46,NULL,'2022-04-11 11:16:10','2022-04-11 11:16:10',3),(93,16,'Right Tires',46,NULL,'2022-04-11 11:16:30','2022-04-11 11:16:30',4),(94,16,'Left Tires',46,NULL,'2022-04-11 11:16:44','2022-04-11 11:16:44',5);
/*!40000 ALTER TABLE `bt_maintenance_checkpoints` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:58:49
