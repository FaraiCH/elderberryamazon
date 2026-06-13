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
-- Table structure for table `rainlab_blog_categories`
--

DROP TABLE IF EXISTS `rainlab_blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rainlab_blog_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `parent_id` int unsigned DEFAULT NULL,
  `nest_left` int DEFAULT NULL,
  `nest_right` int DEFAULT NULL,
  `nest_depth` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rainlab_blog_categories_slug_index` (`slug`),
  KEY `rainlab_blog_categories_parent_id_index` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_blog_categories`
--

LOCK TABLES `rainlab_blog_categories` WRITE;
/*!40000 ALTER TABLE `rainlab_blog_categories` DISABLE KEYS */;
INSERT INTO `rainlab_blog_categories` VALUES (1,'rainlab.blog::lang.categories.uncategorized','uncategorized',NULL,NULL,NULL,1,2,0,'2019-02-10 20:24:07','2019-02-10 20:24:07'),(2,'help','help',NULL,'',NULL,3,4,0,'2019-03-27 07:44:42','2019-03-27 07:44:42'),(3,'inventory','inventory',NULL,'',NULL,5,6,0,'2019-03-27 22:01:27','2019-03-27 22:01:27'),(4,'general','general',NULL,'',NULL,7,8,0,'2019-03-27 22:01:49','2019-03-27 22:01:49'),(5,'Production','production',NULL,'',NULL,9,10,0,'2019-03-27 22:02:12','2020-07-12 21:18:34'),(6,'sales','sales',NULL,'',NULL,11,12,0,'2019-03-27 22:02:46','2019-03-27 22:02:46'),(7,'lab','lab',NULL,'',NULL,13,14,0,'2020-03-17 13:47:22','2020-03-17 13:47:22'),(8,'Finance','finance',NULL,'',NULL,15,16,0,'2020-06-26 12:27:06','2020-06-26 12:27:06'),(9,'Raw Material','raw-material',NULL,'',NULL,17,18,0,'2020-07-12 20:22:04','2020-07-12 20:22:04'),(10,'Maintenance','maintenance',NULL,'',NULL,19,20,0,'2020-07-12 20:40:47','2020-07-12 20:40:47'),(11,'Quality Control','quality-control',NULL,'',NULL,21,22,0,'2020-07-20 10:26:36','2020-07-20 10:26:36'),(12,'Operator','operator',NULL,'',NULL,23,24,0,'2020-07-23 14:35:52','2020-07-23 14:35:52'),(13,'Safety, Health, Environment and Quality','safety-health-environment-and-quality',NULL,'',NULL,25,26,0,'2020-07-23 14:57:56','2020-07-23 14:57:56'),(14,'Videos','videos',NULL,'',NULL,27,28,NULL,'2022-06-13 07:32:07','2022-06-13 07:32:07');
/*!40000 ALTER TABLE `rainlab_blog_categories` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:44:45
