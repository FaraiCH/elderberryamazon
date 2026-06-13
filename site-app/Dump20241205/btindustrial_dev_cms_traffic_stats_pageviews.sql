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
-- Table structure for table `cms_traffic_stats_pageviews`
--

DROP TABLE IF EXISTS `cms_traffic_stats_pageviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cms_traffic_stats_pageviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ev_datetime` datetime DEFAULT NULL,
  `ev_date` date DEFAULT NULL,
  `ev_year_month_day` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ev_year_month` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ev_year_quarter` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ev_year_week` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ev_year` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ev_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_authenticated` tinyint(1) DEFAULT NULL,
  `client_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_time_visit` tinyint(1) NOT NULL DEFAULT '0',
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cms_traffic_stats_pageviews_ev_datetime_index` (`ev_datetime`),
  KEY `cms_traffic_stats_pageviews_ev_date_index` (`ev_date`),
  KEY `cms_traffic_stats_pageviews_ev_year_month_day_index` (`ev_year_month_day`),
  KEY `cms_traffic_stats_pageviews_ev_year_month_index` (`ev_year_month`),
  KEY `cms_traffic_stats_pageviews_ev_year_quarter_index` (`ev_year_quarter`),
  KEY `cms_traffic_stats_pageviews_ev_year_week_index` (`ev_year_week`),
  KEY `cms_traffic_stats_pageviews_ev_year_index` (`ev_year`),
  KEY `cms_traffic_stats_pageviews_ev_timestamp_index` (`ev_timestamp`),
  KEY `cms_traffic_stats_pageviews_user_authenticated_index` (`user_authenticated`),
  KEY `cms_traffic_stats_pageviews_client_id_index` (`client_id`),
  KEY `cms_traffic_stats_pageviews_first_time_visit_index` (`first_time_visit`),
  KEY `cms_traffic_stats_pageviews_user_agent_index` (`user_agent`),
  KEY `cms_traffic_stats_pageviews_page_path_index` (`page_path`),
  KEY `cms_traffic_stats_pageviews_city_index` (`city`),
  KEY `cms_traffic_stats_pageviews_country_index` (`country`),
  KEY `cms_traffic_stats_pageviews_referral_domain_index` (`referral_domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_traffic_stats_pageviews`
--

LOCK TABLES `cms_traffic_stats_pageviews` WRITE;
/*!40000 ALTER TABLE `cms_traffic_stats_pageviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_traffic_stats_pageviews` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:33:09
