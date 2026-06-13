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
-- Table structure for table `bt_sales_goods_returns`
--

DROP TABLE IF EXISTS `bt_sales_goods_returns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sales_goods_returns` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `client_id` int unsigned DEFAULT NULL,
  `reasonforreturn_id` int unsigned DEFAULT NULL,
  `quote_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_sales_goods_returns_created_by_index` (`created_by`),
  KEY `bt_sales_goods_returns_updated_by_index` (`updated_by`),
  KEY `bt_sales_goods_returns_reasonforreturn_id_index` (`reasonforreturn_id`),
  KEY `bt_sales_goods_returns_quote_id_index` (`quote_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sales_goods_returns`
--

LOCK TABLES `bt_sales_goods_returns` WRITE;
/*!40000 ALTER TABLE `bt_sales_goods_returns` DISABLE KEYS */;
INSERT INTO `bt_sales_goods_returns` VALUES (1,'2022-06-08','','','[{\"ponumber\":\"3492\",\"quantity_return\":20,\"size\":\"50\",\"pipe_desc\":\"pn16\",\"batch_no\":\"2134-1881\",\"invoice_no\":\"2941\"}]',50,37,225,5,5590,'2022-06-01 13:21:45','2022-06-03 07:14:26'),(2,'2022-07-06','Poor handling of Pipes',NULL,'[{\"ponumber\":\"681\",\"quantity_return\":2,\"size\":\"110mm 12m\",\"pipe_desc\":\"PN16\",\"batch_no\":\"\",\"invoice_no\":\"DN3214\"},{\"ponumber\":\"681\",\"quantity_return\":5,\"size\":\"315mm 12m\",\"pipe_desc\":\"PN16 \",\"batch_no\":\"2746 2564\",\"invoice_no\":\"DN3214\"}]',50,50,18,1,6660,'2022-07-09 06:41:34','2022-07-09 06:45:04'),(3,'2022-08-25','Pipe returned in good condition and they were sold to another customer',NULL,'[{\"ponumber\":\"PO 1336147\",\"quantity_return\":4,\"size\":\"110mm \",\"pipe_desc\":\"PN16 6m\",\"batch_no\":\"DN3292\",\"invoice_no\":\"0053288\"},{\"ponumber\":\"PO 1336147\",\"quantity_return\":2,\"size\":\"63mm\",\"pipe_desc\":\"PN16 6m\",\"batch_no\":\"DN3292\",\"invoice_no\":\"0053288\"}]',50,50,300,5,6822,'2022-09-08 10:48:40','2022-09-08 10:48:48'),(4,'2022-09-16','It\'s a Duplicate Order',NULL,'[{\"ponumber\":\"PO26931\",\"quantity_return\":20,\"size\":\"110mm\",\"pipe_desc\":\"HDPE 100 PN10 110mm 6m\",\"batch_no\":\"\",\"invoice_no\":\"DN3342\"},{\"ponumber\":\"PO26931\",\"quantity_return\":20,\"size\":\"63mm\",\"pipe_desc\":\"HDPE 100 PN10 63mm 6m\",\"batch_no\":\"\",\"invoice_no\":\"DN3342\"},{\"ponumber\":\"PO26931\",\"quantity_return\":2,\"size\":\"90mm\",\"pipe_desc\":\"HDPE 100 PN10 90mm 6m\",\"batch_no\":\"\",\"invoice_no\":\"DN3342\"}]',50,50,289,6,6843,'2022-09-20 10:46:03','2022-09-20 10:46:12'),(5,'2022-10-20','Goods returned in good condition',NULL,'[{\"ponumber\":\"PO100245\",\"quantity_return\":14,\"size\":\"110mm\",\"pipe_desc\":\"6m PN12.5\",\"batch_no\":\"\",\"invoice_no\":\"INV001829\"}]',50,50,232,5,3615,'2022-10-25 05:42:14','2022-10-25 06:45:09'),(6,'2022-11-14','Returned because it Damaged',NULL,'[{\"ponumber\":\"PO00420\",\"quantity_return\":1,\"size\":\"355mm \",\"pipe_desc\":\"355mm PN16 \",\"batch_no\":\"\",\"invoice_no\":\"9\"}]',50,50,225,1,7715,'2022-11-25 08:45:59','2022-11-25 08:46:08'),(7,'2023-01-30','Damage goods returned',NULL,'[{\"ponumber\":\"POA12515\",\"quantity_return\":2,\"size\":\"200mm\",\"pipe_desc\":\"PN10 * 12M\",\"batch_no\":\"2915-2749\",\"invoice_no\":\"INV0003804\"}]',50,50,256,1,7176,'2023-02-01 06:21:36','2023-02-01 06:23:48'),(8,'2024-02-07','Customer cancelled, Tanya emailed Gary 31-08-2023',NULL,'[{\"ponumber\":\"10386\",\"quantity_return\":7,\"size\":\"315 and 200mm\",\"pipe_desc\":\"315 PN16 equal tee, 200PN10@6m by 6\",\"batch_no\":\"\",\"invoice_no\":\"Inv0005454 \\/DN5812\"},{\"ponumber\":\"\",\"quantity_return\":null,\"size\":\"\",\"pipe_desc\":\"\",\"batch_no\":\"\",\"invoice_no\":\"\"}]',88,88,133,5,10386,'2024-02-08 11:04:49','2024-02-08 11:05:56');
/*!40000 ALTER TABLE `bt_sales_goods_returns` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:27:14
