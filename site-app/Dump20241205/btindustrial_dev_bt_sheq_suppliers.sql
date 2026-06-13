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
-- Table structure for table `bt_sheq_suppliers`
--

DROP TABLE IF EXISTS `bt_sheq_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sheq_suppliers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` int DEFAULT NULL,
  `tax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bbbee` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sheq_suppliers`
--

LOCK TABLES `bt_sheq_suppliers` WRITE;
/*!40000 ALTER TABLE `bt_sheq_suppliers` DISABLE KEYS */;
INSERT INTO `bt_sheq_suppliers` VALUES (1,'Eminence Hygine','Deep Cleaning','Deep Cleaning Services','SA','Zinhle','zinhle@eminencehygiene.co.za.',797755597,'Yes','Yes','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(2,'Supplywise','Medical Safety Supplies','Tacky Mats','SA','Michelle van der Merwe','michelle@supplywise.co.za',10,'Yes','Yes','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(3,'Savy Trading Solutions','Safety Supplies','Medical Safety Signs','SA','Wisani Shirilele','sales@savvyts.co.za',641737088,'Yes','Yes','Yes','2021-08-20 07:30:20','2021-08-20 07:30:20'),(4,'Mnnk Projects','Flooring','Carpertsing & Vinyl Flooring Supply and Install','SA',NULL,NULL,733396010,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(5,'Dawtech Pty Ltd','Structures','Structures/Walls/Doors/Windows/HVAC Units','SA','Chris Daw','jade@dawtech.co.za',83,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(6,'Watters Stationery','Stationery Supplier','Stationery','SA','Soleil','soleil@watters.co.za',112344182,'Yes','Yes','Yes','2021-08-20 07:30:20','2021-08-20 07:30:20'),(7,'ZHANGJIAGANG CITY','Mask Line','Ear loops, Nose wire, Hot air cotton, Out layer non-woven, Inner layer non-woven, Melt blown material','China','Mr Wang',NULL,NULL,'No','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(8,'Dongguan Yicai Machinery Co.,Ltd',NULL,'PRINTER','China',NULL,NULL,NULL,NULL,NULL,NULL,'2021-08-20 07:30:20','2021-08-20 07:30:20'),(9,'Foshan Land packaging Machinery Co Ltd','Machinery','Packaging Machinery','China','Tina Tang','Sale06@landpacking.com',2147483647,'No','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(10,'SA Cleaning Equipment/ thenowgroup','Trolley Bins','Bins','SA',NULL,NULL,NULL,NULL,NULL,NULL,'2021-08-20 07:30:20','2021-08-20 07:30:20'),(11,'Quantum Office Funtiture','Furniture','Office Chairs','SA','Anzel Boylan','Anzel@quantumoffice.co.za',847799061,NULL,NULL,NULL,'2021-08-20 07:30:20','2021-08-20 07:30:20'),(12,'Changzahou W7J InstrumentCo.Ltd','Scale','Fabric Digital Scale','China','Claire Dai','eunice@weighinginstru.com',0,'No','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(13,'Advanced Labs','Microscope','Microscope','SA','Reza Theunissen','rezat@advancedlab.co.za',788046344,NULL,NULL,NULL,'2021-08-20 07:30:20','2021-08-20 07:30:20'),(14,'BMG',NULL,'Sundries','SA','Brett Mare','wadevillesales2@bmgworld.net',0,'Yes','Yes','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(15,'ADENDORFF',NULL,'Sundries','SA','Francois Landsberg','FLandsberg@adendorff.co.za',0,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(16,'ALBERTON HARDWARE',NULL,'Sundries','SA',NULL,'Ansu Worthington',11,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(17,'BOLTS & ENGINEERING DISTRIBUTORS',NULL,'Sundries','SA','Bianca Jansen van Vuuren','bianca@bolteng.co.za',118247500,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(18,'LUKA ABRESIVES SA',NULL,'Sundries','SA','charmaine','charmaineg@lukas.co.za',0,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(19,'DYNAMIC BEARINGS',NULL,'Sundries','SA','Darryl Rabie','darryl@dyneamic.co.za',0,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(20,'Supply Ryte',NULL,'Sundries',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-08-20 07:30:20','2021-08-20 07:30:20'),(21,'jiamgsu Acemech Machinery Co LTD','Mask Line','PP Non-Woven fabric, PP Hot cotton Fabric, PP Melt Blow Fabric','China','Fiann','Sales1@acemechcorp.com',2147483647,'No','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(22,'Kiarah Chem','Chemicals','Cleaning Chemicals','SA','Nombuso','sales@kiarahchem.co.za',11,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(23,'Andtech Barcode Systems','Labels','Printer Labels','SA',NULL,'sales@andthech.co.za',12,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(24,'Numatics SA',NULL,'Spares','SA',NULL,'accounts@neumaticsa.co.za',11,'No','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(25,'Xtreme Hose Technologies',NULL,'Meltblown Dye Repair','SA',NULL,'sales@xtremehose.co.za',11,'No','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(26,'Omnisurge',NULL,'Cleanroom PPE','SA','Bathabile Dlamini','reception02@omnisurge.co.za',NULL,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(27,'Gibela Packaging',NULL,'Cleanroom Material','SA',NULL,'0832643915',83,'Yes',NULL,'No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(28,'MBSA Masterbatch',NULL,'Masterbatch, Desiccent','SA','Warren','warren@masterbatch.co.za',71,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(29,'INDEPENDED ELEMENTS & CONTROLS CC',NULL,'Electric Spares','SA','SANET','element@mweb.co.za',118490258,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(30,'ACDC EXPRESS New market',NULL,'Electric Spares','SA',NULL,NULL,NULL,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(31,'Nuton Consulting CC',NULL,'Cleamroom power factor correcting panel','SA',NULL,'infonutonconsulting@gmail.com',82,'Yes',NULL,'No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(32,'MOCON COATING',NULL,'Paint','SA','LINDA','linda@miconcoatings.co.za',2147483647,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(33,'AFROX',NULL,'Sundries','SA','Afrox Customer Services','customer.service.email@afrox.linde.com',860,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(34,'AIR PRODUCTS',NULL,'Sundries','SA',NULL,NULL,NULL,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:30:20'),(35,'AIR LIQUIDE','','Sundries','SA','','',860020202,'No','No','No','2021-08-20 07:30:20','2021-08-20 07:40:01'),(36,'Kiddo Road Assist','','Truck Repair Parts','SA','Tshepo','kidooge@gmail.com',658063531,'Yes','No','No','2021-08-20 07:30:20','2021-08-20 07:39:40');
/*!40000 ALTER TABLE `bt_sheq_suppliers` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:39:14
