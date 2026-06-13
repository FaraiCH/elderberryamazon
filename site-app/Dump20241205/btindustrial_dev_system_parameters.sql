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
-- Table structure for table `system_parameters`
--

DROP TABLE IF EXISTS `system_parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_parameters` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `namespace` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `group` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `item` varchar(150) COLLATE utf8mb3_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb3_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `item_index` (`namespace`,`group`,`item`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_parameters`
--

LOCK TABLES `system_parameters` WRITE;
/*!40000 ALTER TABLE `system_parameters` DISABLE KEYS */;
INSERT INTO `system_parameters` VALUES (1,'system','update','count','11'),(2,'system','update','retry','1730193129'),(3,'system','theme','history','{\"Hambern.hambern-blank-bootstrap-4\":\"hambern-hambern-blank-bootstrap-4\"}'),(4,'cms','theme','active','\"hambern-hambern-blank-bootstrap-4\"'),(5,'system','core','build','\"13\"'),(6,'system','core','hash','\"3847185f0253b1ae8c30bb1375795b66\"'),(7,'backend','reportwidgets','default.dashboard','{\"report_container_dashboard_2\":{\"class\":\"Bt\\\\Sales\\\\ReportWidgets\\\\ReportDeliveryDistance\",\"configuration\":{\"title\":\"Report Delivery Distance Report Widget\",\"ocWidgetWidth\":\"12\"},\"sortOrder\":\"52\"},\"report_container_dashboard_3\":{\"class\":\"Bt\\\\Factory\\\\ReportWidgets\\\\TV\",\"configuration\":{\"title\":\"T V Report Widget\",\"ocWidgetWidth\":\"12\"},\"sortOrder\":\"51\"}}'),(8,'system','project','key','\"0ZwN1ZGVgZwLkZwtmYJZkBTR5AwyvBQOyLJR1ZwIuAwVkAzEuZTLlAQqvLmR1\"'),(9,'system','project','id','261283'),(10,'system','project','name','\"BT-HDPE\"'),(11,'system','project','owner','\"noezan\"'),(12,'system','project','is_active','true'),(13,'system','update','versions','{\"count\":11,\"core\":\"2.2.34\",\"plugins\":{\"AhmadFatoni.ApiGenerator\":\"1.0.8\",\"JanVince.SmallContactForm\":\"1.68.0\",\"October.Drivers\":\"2.0.1\",\"RainLab.Blog\":\"1.7.1\",\"RainLab.Builder\":\"2.0.6\",\"RainLab.Location\":\"2.0.0\",\"RainLab.MailChimp\":\"1.0.5\",\"RainLab.User\":\"3.1.3\",\"Renatio.DynamicPDF\":\"7.1.2\",\"Vdomah.Excel\":\"3.0.5\"}}');
/*!40000 ALTER TABLE `system_parameters` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:50:29
