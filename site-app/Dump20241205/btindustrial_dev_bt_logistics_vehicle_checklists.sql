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
-- Table structure for table `bt_logistics_vehicle_checklists`
--

DROP TABLE IF EXISTS `bt_logistics_vehicle_checklists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_logistics_vehicle_checklists` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `is_brakes_ok` int DEFAULT '0',
  `is_engine_ok` int DEFAULT '0',
  `is_hazards_ok` int DEFAULT '0',
  `is_doors_ok` int DEFAULT '0',
  `is_mirrors_ok` int DEFAULT '0',
  `is_tires_ok` int DEFAULT '0',
  `is_fuel_ok` int DEFAULT '0',
  `is_oil_ok` int DEFAULT '0',
  `is_belt_ok` int DEFAULT '0',
  `is_horn_ok` int DEFAULT '0',
  `is_wipers_ok` int DEFAULT '0',
  `is_battery_ok` int DEFAULT '0',
  `is_lights_ok` int DEFAULT '0',
  `is_vehicle_ok` int DEFAULT '0',
  `vehicle_id` int unsigned DEFAULT NULL,
  `current_mileage` int unsigned DEFAULT NULL,
  `brakes_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `engine_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lights_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hazards_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doors_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mirrors_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tires_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuel_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oil_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `battery_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehiclecon_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `belt_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `horn_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wipers_comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_logistics_vehicle_checklists_vehicle_id_index` (`vehicle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_logistics_vehicle_checklists`
--

LOCK TABLES `bt_logistics_vehicle_checklists` WRITE;
/*!40000 ALTER TABLE `bt_logistics_vehicle_checklists` DISABLE KEYS */;
INSERT INTO `bt_logistics_vehicle_checklists` VALUES (1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,3,387514,'Good condition','Working well','Good condition','Good condition','Good condition','Good condition','Good condition','Full tank','Good oil','Functioning well','Good condition','Good condition','Good condition','Good condition','2022-04-04 08:10:49','2022-04-04 10:23:51','2022-04-04'),(2,1,1,1,1,1,1,1,1,1,1,1,1,1,0,3,387000,'Good condition','Service has been done.','','','','','New tyres are bought for the horse, new tyres for link needs to be bought.','Diesel filter was packing up.','Service has been done','','','Good condition','','','2022-04-04 08:42:07','2022-08-01 16:24:32','2022-04-03'),(3,1,1,1,1,1,0,1,1,1,1,1,1,1,0,1,105783,'Good Condition','Good Condition','Good Condition','Good Condition','Good Condition','Good Condition','three good tires and two bad condition tires','Full Tank','Good Condition','Good Condition','left hand side is damage','Good Condition','Good Condition','Good Condition','2022-04-05 06:53:58','2022-04-08 08:15:44','2022-04-05'),(4,1,1,1,1,1,0,1,1,1,1,1,1,0,1,3,389861,'Good Condition','Good Condition','replace two heads light','Good Condition','Good Condition','Good Condition','Need three new tires','Quarter tank','Good Condition','Good Condition','Good Condition','Good Condition','Good Condition','Good Condition','2022-04-12 09:13:05','2022-04-12 09:37:48','2022-04-12'),(5,1,1,1,0,0,0,1,1,0,1,1,1,0,0,2,NULL,'Bakkie serviced','Bakkie serviced','Head lamp needs to be replaced','Bakkie serviced','','','','Bakkie serviced','Bakkie serviced','Still within life span.','','','Bakkie serviced','Bakkie serviced','2022-08-01 16:27:56','2022-08-01 16:34:34',NULL);
/*!40000 ALTER TABLE `bt_logistics_vehicle_checklists` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:59:00
