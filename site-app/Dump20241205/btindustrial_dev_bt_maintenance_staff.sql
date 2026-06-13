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
-- Table structure for table `bt_maintenance_staff`
--

DROP TABLE IF EXISTS `bt_maintenance_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_maintenance_staff` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cell` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_supervisor` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_maintenance_staff`
--

LOCK TABLES `bt_maintenance_staff` WRITE;
/*!40000 ALTER TABLE `bt_maintenance_staff` DISABLE KEYS */;
INSERT INTO `bt_maintenance_staff` VALUES (1,'Phillium Tamirepi','ptm@bt-industrial.co.za','',NULL,'2019-07-03 08:16:56',0),(2,'Farai Chamisa','fc@bt-industrial.co.za','','2019-07-03 08:17:35','2019-07-03 08:17:35',0),(4,'Shadrack Molopa','smp@bt-industrial.co.za','','2019-07-03 08:18:40','2019-07-03 08:18:40',0),(5,'Albert Ramaqele','','','2019-08-28 14:13:14','2024-07-04 07:01:32',1),(6,'Nicol Tsekela','','','2019-08-28 14:13:49','2019-08-28 14:13:49',0),(9,'Velile Sathula','','','2019-08-28 14:14:54','2019-08-28 14:14:54',0),(10,'Concions	Zingoni','','','2019-08-28 14:15:20','2019-08-28 14:15:20',0),(11,'William 	Khumalo','','','2019-08-28 14:15:41','2019-08-28 14:15:41',0),(12,'Dixon Gqangeni','','','2019-08-28 14:16:02','2019-08-28 14:16:02',0),(14,'Mapudi Motjamela','','','2020-03-03 11:47:22','2020-11-23 10:01:54',0),(17,'Petrus Lebatla','','','2020-04-20 08:36:44','2020-06-23 10:19:00',0),(18,'Tumelo Nhlapo','','','2020-04-23 08:50:36','2023-02-09 11:11:24',1),(20,'Lovemore Hora','','','2020-08-14 09:00:47','2020-08-14 09:00:47',0),(21,'AMPFARISON  NEMAVHOLA','','','2021-03-24 09:01:09','2021-03-24 09:01:09',0),(22,'Ellen Kaliramombe','','','2021-04-15 08:38:05','2021-04-15 08:38:05',0),(23,'Del-Travor Magwenzi','','','2021-04-15 08:39:00','2021-08-26 06:33:33',0),(24,'Edwin Mokone','','','2021-04-15 08:39:25','2023-01-16 10:51:06',1),(25,'Silas Matsika','','','2021-04-15 08:40:50','2021-04-15 08:41:04',0),(26,'Bafana Ndaba','','','2021-04-15 08:43:32','2021-04-15 08:43:32',0),(29,'Justin Ramashala','','','2021-05-27 07:54:31','2021-05-27 07:54:31',0),(30,'Tshiamo','','','2021-06-17 06:53:13','2022-03-10 10:29:02',0),(31,'Caleb Kekana','caleb.kekana@gmail.com','','2021-08-26 06:34:12','2022-12-05 07:23:20',1),(36,'Thabiso Ngwenya','','','2021-11-16 07:16:18','2021-11-16 07:16:18',0),(37,'Hector  Shabalala','','','2021-11-16 10:49:12','2023-02-09 11:09:35',0),(39,'Thabiso Mnyani','','','2021-11-19 04:22:53','2021-11-19 04:22:53',0),(40,'Atlehang Mokgoantle','','','2022-02-07 13:06:15','2023-10-06 08:50:35',0),(41,'Ayanda Mdlalose','','','2022-03-07 10:37:57','2023-02-09 11:08:51',0),(42,'Thabo Tsekela','','','2022-04-04 07:01:40','2022-04-04 07:01:40',0),(43,'Disema  Dlamini','','','2022-04-11 11:23:00','2023-02-09 11:08:22',0),(44,'Kgomotso Phutiyagae','','','2022-05-09 12:01:04','2022-05-09 12:01:04',0),(46,'Andries Ramoadi','','','2022-07-11 08:28:41','2022-07-11 08:28:41',0),(47,'Goodman  Nxumalo','','','2022-08-30 06:50:43','2023-02-09 11:07:54',0),(49,'Renang  Mabitso','','','2022-09-22 07:18:04','2023-02-09 11:07:35',0),(51,'BT Tech','bttech@bt-industrial.co.za','','2022-12-02 07:15:49','2022-12-05 07:25:20',0),(52,'Kabelo   Moriti','','','2023-02-09 11:10:42','2023-02-09 11:10:42',0),(53,'Frans Matlou','','','2023-03-13 07:30:50','2023-03-13 07:30:50',0),(54,'Alfred Mbhatha','','','2023-03-13 07:32:25','2023-03-13 07:32:25',0),(55,'Karabo Matlatsa','','','2023-03-13 07:32:56','2023-03-13 07:32:56',0),(56,'Matala  Ramabulo','','','2023-03-16 08:30:26','2023-03-16 08:30:26',0),(57,'Thami Dlamini','','','2023-06-12 07:48:26','2023-06-12 07:48:26',0),(58,'Mfundo Letlatla','','','2023-06-27 09:10:17','2023-10-02 08:22:17',0),(59,'Skhumbuzo Buthelezi','','','2023-07-31 13:36:22','2023-07-31 13:36:22',0),(60,'Sifiso Mazumbuko','','','2023-08-25 13:22:40','2023-08-25 13:22:40',0),(61,'Tebogo Motsoene','','','2023-08-25 13:23:37','2023-08-25 13:23:37',0),(62,'Tomforce Hakunavanhu','','','2023-08-25 13:24:14','2023-08-25 13:24:14',0),(63,'Minnie Phungeni','','','2023-08-25 13:25:54','2023-08-25 13:25:54',0),(64,'Percival Motaung','','','2023-08-25 13:26:18','2023-08-25 13:26:18',0),(65,'Ellen Madumira','','','2023-08-25 13:27:08','2023-08-25 13:27:08',0),(66,'Consions Zingoni','','','2023-08-25 13:28:47','2023-08-25 13:28:47',0),(67,'Dixon Nqangeni','','','2023-08-25 13:29:21','2023-08-25 13:29:21',0),(68,'Layton Malapane','','','2023-08-25 13:29:43','2023-08-25 13:29:43',0),(69,'Tshepo Molala','','','2023-08-30 09:20:18','2023-08-30 09:20:18',0),(70,'Derrick Mbothwe','','','2023-09-01 08:16:22','2023-09-01 08:16:22',0),(71,'Maintenance','maintenance1@bt-industrial.co.za','','2023-11-06 13:54:17','2023-11-06 13:54:17',1),(72,'Maintenance 2','maintenance2@bt-industrial.co.za','','2023-11-16 13:11:37','2023-11-16 13:11:37',1),(73,'Never Hlatini','','','2023-11-17 10:38:47','2023-11-17 10:38:47',0),(74,'Vusi Mkhuhlane','','','2024-01-17 12:34:49','2024-01-17 12:34:49',0),(75,'Alfred Mohapi','','','2024-01-17 14:16:09','2024-01-17 14:16:09',0),(76,'Molebatsi Motshoeneng','','','2024-02-13 08:17:38','2024-02-26 06:54:33',0),(77,'Jan Masetla','','','2024-02-14 11:09:16','2024-02-14 11:09:16',0),(78,'Ndivhuwo Mutale','','','2024-02-15 08:57:58','2024-02-15 08:57:58',0),(79,'Bheki Sekatane','','','2024-02-26 14:08:30','2024-02-26 14:08:30',0);
/*!40000 ALTER TABLE `bt_maintenance_staff` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:31:55
