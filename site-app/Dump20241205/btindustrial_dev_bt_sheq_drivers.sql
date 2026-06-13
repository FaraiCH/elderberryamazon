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
-- Table structure for table `bt_sheq_drivers`
--

DROP TABLE IF EXISTS `bt_sheq_drivers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sheq_drivers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue` date NOT NULL,
  `expiry` date DEFAULT NULL,
  `status` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sheq_drivers`
--

LOCK TABLES `bt_sheq_drivers` WRITE;
/*!40000 ALTER TABLE `bt_sheq_drivers` DISABLE KEYS */;
INSERT INTO `bt_sheq_drivers` VALUES (4,'Daizy Kgabane','Malatji','2023-06-21','2025-06-21',1,'2021-06-14 09:25:26','2024-02-16 10:51:43'),(7,'Nophala','Mfanafuthi','2023-01-27','2025-01-27',1,'2021-06-14 09:31:47','2023-02-21 10:55:12'),(13,'Tumelo','Nhlapo','2021-08-30','2023-08-29',1,'2022-10-26 23:47:39','2022-10-26 23:47:39'),(14,'Tsepo','Mamaru','2022-10-14','2024-10-14',1,'2022-10-26 23:48:58','2024-02-16 10:43:37'),(15,'Bhekinkosi Lucky','Mbatha','2022-07-08','2024-07-08',1,'2022-11-29 11:11:15','2022-11-29 11:11:15'),(16,'Michael','Matolo','2023-02-06','2025-02-05',1,'2023-02-24 07:19:01','2023-02-24 07:19:01'),(17,'Sipho Gabriel','Buthelezi','2023-06-21','2025-06-21',1,'2023-07-21 08:19:12','2024-02-19 14:04:52'),(18,'Johan Ambros','Ngobeni','2023-04-29','2025-04-29',1,'2023-07-21 08:48:52','2024-02-19 13:54:34'),(19,'Siyabonga Zincome','Buthelezi','2022-04-02','2024-04-02',1,'2023-07-21 08:51:09','2024-02-19 16:02:15'),(21,'Sthembiso Eric','Zungu','2023-10-13','2025-10-13',1,'2024-02-16 10:50:19','2024-02-16 10:54:15'),(22,'Celimpilo','Mbatha','2023-02-24','2025-02-24',1,'2024-02-19 13:49:39','2024-02-19 13:49:39'),(23,'Reginald Mthobisi','Nguse','2022-01-10','2024-01-10',1,'2024-02-19 13:52:19','2024-02-19 13:52:19'),(24,'Sechaba','Malindi','2023-04-05','2025-04-05',1,'2024-02-28 09:11:51','2024-02-28 09:11:51'),(25,'Sive','Qongo','2022-02-24','2024-02-23',1,'2024-03-07 12:04:50','2024-03-07 12:04:59'),(26,'Renang Ignasius','Mabitso','2022-06-10','2024-06-10',1,'2024-03-07 12:07:01','2024-03-07 12:07:01'),(27,'Goodman Sbongakonke','Nxumalo','2021-04-07','2023-04-07',1,'2024-03-07 12:09:37','2024-03-07 12:09:37'),(28,'Sbusiso','Nkabinde','2023-11-15','2026-11-15',1,'2024-03-07 12:29:47','2024-03-07 12:29:47'),(29,'Tshepo','Radinne','2024-01-29','2026-01-29',1,'2024-03-07 12:59:45','2024-03-07 12:59:46'),(30,'Muzi','Sondiyazi','2022-02-16','2024-02-16',1,'2024-03-11 09:11:10','2024-03-11 09:11:10');
/*!40000 ALTER TABLE `bt_sheq_drivers` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:36:51
