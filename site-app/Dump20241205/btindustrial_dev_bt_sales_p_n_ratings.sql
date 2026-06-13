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
-- Table structure for table `bt_sales_p_n_ratings`
--

DROP TABLE IF EXISTS `bt_sales_p_n_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sales_p_n_ratings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `premiumprice` decimal(15,2) DEFAULT '0.00',
  `alert` int DEFAULT '0',
  `sdr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sales_p_n_ratings`
--

LOCK TABLES `bt_sales_p_n_ratings` WRITE;
/*!40000 ALTER TABLE `bt_sales_p_n_ratings` DISABLE KEYS */;
INSERT INTO `bt_sales_p_n_ratings` VALUES (1,'PN4 (SDR41)','2019-02-17 11:55:14','2022-09-20 08:18:40',38.78,1,'SDR41'),(2,'PN5 (SDR33)','2019-02-17 11:55:14','2022-09-20 08:21:17',38.78,1,'SDR33'),(3,'PN6 (SDR26)','2019-02-17 11:55:14','2022-09-20 08:21:29',38.78,1,'SDR26'),(4,'PN8 (SDR21)','2019-02-17 11:55:14','2022-09-20 08:21:44',38.78,1,'SDR21'),(5,'PN10 (SDR17)','2019-02-17 11:55:14','2022-09-20 08:21:55',38.78,0,'SDR17'),(6,'PN12.5 (SDR13.6)','2019-02-17 11:55:14','2022-09-20 08:22:18',38.78,0,'SDR13.6'),(7,'PN16 (SDR11)','2019-02-17 11:55:14','2022-09-20 08:22:06',38.78,0,'SDR11'),(8,'PN20 (SDR9)','2019-02-17 11:55:14','2022-09-20 08:22:30',38.78,0,'SDR9'),(9,'PN25 (SDR7.4)','2019-02-17 11:55:14','2022-09-20 08:22:42',38.78,0,'SDR7.4'),(10,'PN34 (SDR6)','2019-02-17 11:55:14','2022-09-20 08:22:52',38.78,0,'SDR6'),(11,'Polycop','2021-03-29 03:32:47','2021-12-07 05:36:08',38.78,0,'');
/*!40000 ALTER TABLE `bt_sales_p_n_ratings` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:55:00
