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
-- Table structure for table `bt_sales_quote_approval_intro`
--

DROP TABLE IF EXISTS `bt_sales_quote_approval_intro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sales_quote_approval_intro` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `quote_id` int unsigned NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_sales_quote_approval_intro_quote_id_index` (`quote_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sales_quote_approval_intro`
--

LOCK TABLES `bt_sales_quote_approval_intro` WRITE;
/*!40000 ALTER TABLE `bt_sales_quote_approval_intro` DISABLE KEYS */;
INSERT INTO `bt_sales_quote_approval_intro` VALUES (2,10385,'BT Quote Approval - Ref-#10385','<p>Dear <strong>Dewald Crafford</strong></p>\n                        <p><strong>Gary Els</strong> has finished the quotation that needs your approval. The details are provided below</p>\n                        <p><strong>Quote Ref:</strong> #10385</p>\n                        <p><strong>Expiry Date:</strong> 2024-01-31</p>\n                        <p><strong>Links:</strong></p>\n                        <p><a href=\"https://bailaerp.bt-industrial.co.za/quoteapproval/2y10CKTmuV0zTLAdVCqCLOtSwuSPeob0fxwda4L9OK6fYvnAEtKV.3bm./10385\" target=\"_blank\">Client quote approval link</a></p>\n                        <p>Thank you for your attention to this matter.</p>\n                        <p><strong>Best regards</strong></p>\n                        <p>BT Team</p>','2024-01-11 12:33:54','2024-01-11 12:33:54'),(4,10476,'BT Quote Approval - Ref-#10476','<p>Dear <strong>Emmanuel</strong></p>\n                        <p><strong>Meshack Mashifane</strong> has finished the quotation that needs your approval. The details are provided below</p>\n                        <p><strong>Quote Ref:</strong> #10476</p>\n                        <p><strong>Expiry Date:</strong> 2024-02-29</p>\n                        <p><strong>Links:</strong></p>\n                        <p><a href=\"https://bailaerp.bt-industrial.co.za/quoteapproval/2y10C1L7yD7e0phy5flrxf0PQOS82X5TPnp7xIs74f6b1G.DeKWew9ox./10476\" target=\"_blank\">Client quote approval link</a></p>\n                        <p>Thank you for your attention to this matter.</p>\n                        <p><strong>Best regards</strong></p>\n                        <p>BT Team</p>','2024-01-19 08:12:18','2024-01-19 08:12:18'),(5,10319,'BT Quote Approval - Ref-#10319','<p>Dear <strong>Gunter Nieuwenhuis</strong></p>\n                        <p><strong>Emile Schoeman</strong> has finished the quotation that needs your approval. The details are provided below</p>\n                        <p><strong>Quote Ref:</strong> #10319</p>\n                        <p><strong>Expiry Date:</strong> 0000-00-00</p>\n                        <p><strong>Links:</strong></p>\n                        <p><a href=\"https://bailaerp.bt-industrial.co.za/quoteapproval/2y10Y23K6kp3yAtEOhJGMr2HN.V7vECMNFYQ9Wuo9p9XnPyR5Qijm.QxG/10319\" target=\"_blank\">Client quote approval link</a></p>\n                        <p>Thank you for your attention to this matter.</p>\n                        <p><strong>Best regards</strong></p>\n                        <p>BT Team</p>','2024-01-19 08:15:56','2024-01-19 08:15:56');
/*!40000 ALTER TABLE `bt_sales_quote_approval_intro` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:36:57
