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
-- Table structure for table `bt_qc_qc_equipments`
--

DROP TABLE IF EXISTS `bt_qc_qc_equipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_qc_qc_equipments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caliberation_date` date DEFAULT NULL,
  `caliberation_expiry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_qc_qc_equipments`
--

LOCK TABLES `bt_qc_qc_equipments` WRITE;
/*!40000 ALTER TABLE `bt_qc_qc_equipments` DISABLE KEYS */;
INSERT INTO `bt_qc_qc_equipments` VALUES (1,'ZF-DSC-DIH (OIT Machine)','','','20210807','2022-02-22','2023-02-23','2022-05-13 16:55:43','2022-05-13 17:08:35'),(2,'Universal Testing Machine (Tensille)','','','2019622','2022-02-22','2023-02-22','2022-05-13 17:05:48','2022-05-13 17:05:48'),(3,'Melt Flow Index Machine','','','2017690','2022-02-22','2023-02-22','2022-05-13 17:15:10','2022-05-13 17:15:10'),(4,'Hydrostatic Test Machine (Pressure Test)','','','3/4/',NULL,NULL,'2022-05-13 17:21:31','2022-05-13 17:51:01'),(5,'Platform Scale','','7263','008050183','2021-09-14','2022-09-13','2022-05-13 17:34:09','2022-05-13 17:34:09'),(6,'Precision Scale','','','200804001','2022-02-23','2023-02-23','2022-05-13 17:41:20','2022-05-13 17:42:13'),(7,'Micro Aize Scale','','','E1902145','2022-02-23','2023-02-23','2022-05-13 17:49:26','2022-05-13 17:49:26'),(8,'GLASS THERMOMETER','','','BT-LAB07','2022-05-11','2023-05-11','2022-06-14 12:34:56','2022-06-14 12:34:56');
/*!40000 ALTER TABLE `bt_qc_qc_equipments` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:52:47
