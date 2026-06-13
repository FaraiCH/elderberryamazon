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
-- Table structure for table `backend_user_roles`
--

DROP TABLE IF EXISTS `backend_user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `backend_user_roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `permissions` text COLLATE utf8mb3_unicode_ci,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sort_order` int DEFAULT NULL,
  `color_background` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_unique` (`name`),
  KEY `role_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_user_roles`
--

LOCK TABLES `backend_user_roles` WRITE;
/*!40000 ALTER TABLE `backend_user_roles` DISABLE KEYS */;
INSERT INTO `backend_user_roles` VALUES (1,'Publisher','publisher','Site editor with access to publishing tools.','',1,'2019-02-10 20:17:27','2019-02-10 20:17:27',NULL,NULL),(2,'Developer','developer','Site administrator with access to developer tools.','',1,'2019-02-10 20:17:27','2019-02-10 20:17:27',NULL,NULL),(4,'Team','team','Team Level 2','',1,'2020-07-17 13:18:26','2020-07-17 13:18:26',NULL,NULL),(5,'Production Team','production','','',1,'2020-08-10 09:13:59','2020-08-18 09:37:56',NULL,NULL),(6,'QC Team','qc-team','QC Team','',0,'2020-08-18 09:35:16','2020-08-18 09:35:16',NULL,NULL),(7,'Logistic Team','logistic-team','','',0,'2020-08-18 09:38:37','2020-08-18 09:38:37',NULL,NULL),(8,'Legal-Team','Legal-Team','Legal-Team','{\"bt.legal.admin\":\"1\"}',0,'2021-02-11 12:40:08','2021-02-11 12:40:08',NULL,NULL),(9,'IT','IT','IT Team','{\"bt.inventory.rawmaterial\":\"1\",\"bt.inventory.materialrelease\":\"1\",\"bt.inventory.purchase\":\"1\",\"bt.inventory.recon\":\"1\",\"bt.inventory.incage\":\"1\",\"bt.inventory.products\":\"1\",\"bt.inventory.suppliers\":\"1\",\"bt.inventory.permission_release\":\"1\",\"bt.inventory.permission_incage\":\"1\",\"bt.inventory.permission_Request\":\"1\",\"bt.inventory.permission_used\":\"1\",\"bt.sales.sales\":\"1\",\"bt.sales.quotes\":\"1\",\"bt.sales.clientlist\":\"1\",\"bt.sales.product\":\"1\",\"bt.sales.priceperkg\":\"1\",\"bt.sales.quotestatus\":\"1\",\"bt.sales.catalogue\":\"1\",\"bt.sales.logiticsignature\":\"1\",\"bt.sales.management\":\"1\",\"bt.sales.supplier\":\"1\",\"bt.sales.fabrication\":\"1\",\"bt.sales.srn\":\"1\",\"bt.sales.pipeapprove\":\"1\",\"bt.sales.secrete\":\"1\",\"bt.sales.guest\":\"1\",\"bt.sales.person\":\"1\",\"bt.sales.dashboardmanagement\":\"1\",\"bt.inventory.buyouts\":\"1\",\"editor.access_editor\":\"1\",\"cms.manage_theme_options\":\"1\",\"cms.manage_themes\":\"1\",\"cms.manage_partials\":\"1\",\"cms.manage_layouts\":\"1\",\"cms.manage_pages\":\"1\",\"cms.manage_assets\":\"1\",\"cms.manage_content\":\"1\",\"backend.access_dashboard\":\"1\",\"system.manage_mail_templates\":\"1\",\"system.manage_mail_settings\":\"1\",\"system.access_logs\":\"1\",\"system.manage_updates\":\"1\",\"media.manage_media\":\"1\",\"backend.manage_branding\":\"1\",\"backend.manage_editor\":\"1\",\"backend.manage_preferences\":\"1\",\"backend.manage_users\":\"1\",\"backend.manage_default_dashboard\":\"1\",\"bt.sheq.covid\":\"1\",\"bt.sheq.general\":\"1\",\"bt.sheq.driver\":\"1\",\"bt.sheq.audits\":\"1\",\"bt.sheq.documents\":\"1\",\"bt.sheq.some_permission\":\"1\",\"bt.sheq.medical\":\"1\",\"bt.reporting.some_permission\":\"1\",\"bt.qc.setup\":\"1\",\"bt.qc.ncr\":\"1\",\"bt.qc.qms\":\"1\",\"bt.qc.lab\":\"1\",\"bt.qc.documents\":\"1\",\"bt.qc.some_permission\":\"1\",\"bt.qc.approval\":\"1\",\"rainlab.blog.access_posts\":\"1\",\"rainlab.blog.access_publish\":\"1\",\"rainlab.blog.access_import_export\":\"1\",\"rainlab.blog.access_other_posts\":\"1\",\"rainlab.blog.access_categories\":\"1\",\"rainlab.blog.manage_settings\":\"1\",\"renatio.dynamicpdf.manage_layouts\":\"1\",\"renatio.dynamicpdf.manage_templates\":\"1\",\"rainlab.users.impersonate_user\":\"1\",\"rainlab.users.access_settings\":\"1\",\"rainlab.users.access_groups\":\"1\",\"rainlab.users.access_users\":\"1\",\"rainlab.mailchimp.configure\":\"1\",\"rainlab.location.access_settings\":\"1\",\"janvince.smallcontactform.export_messages\":\"1\",\"janvince.smallcontactform.delete_messages\":\"1\",\"janvince.smallcontactform.access_settings\":\"1\",\"janvince.smallcontactform.access_messages\":\"1\",\"bt.suppliers.see\":\"1\",\"bt.maintenance.storeproductitem\":\"1\",\"bt.maintenance.tools\":\"1\",\"bt.maintenance.plant\":\"1\",\"bt.maintenance.vendors\":\"1\",\"bt.jobcard.management\":\"1\",\"bt.jobcard.guest\":\"1\",\"bt.jobcard.dashboard\":\"1\",\"bt.jobcard.approve\":\"1\",\"bt.maintenance.maintenance\":\"1\",\"bt.production.analysis\":\"1\",\"bt.production.btaccountmanager\":\"1\",\"bt.production.admin\":\"1\",\"bt.production.approve\":\"1\",\"bt.production.setup\":\"1\",\"bt.crm.some_permission\":\"1\",\"bt.floor.some_permission\":\"1\",\"bt.finance.reqList\":\"1\",\"bt.finance.cardrecords\":\"1\",\"bt.finance.approve\":\"1\",\"bt.finance.fin\":\"1\",\"bt.finance.linemanager\":\"1\",\"bt.finance.ho\":\"1\",\"bt.finance.tab\":\"1\",\"bt.factory.setup\":\"1\",\"bt.documents.some_permission\":\"1\",\"bt.boardroom.approve\":\"1\",\"bt.boardroom.tab\":\"1\",\"bt.hr.admin\":\"1\",\"bt.hr.manage\":\"1\",\"bt.hr.rates\":\"1\",\"bt.hr.developer\":\"1\",\"bt.hr.stats\":\"1\",\"admin.tableusers\":\"1\",\"bt.operator.some_permission\":\"1\",\"bt.notify.sendemail\":\"1\",\"bt.notify.upcomingproject\":\"1\",\"bt.logistics.schedule\":\"1\",\"bt.logistics.admin\":\"1\",\"bt.logistics.usagetype\":\"1\",\"bt.legal.admin\":\"1\",\"bt.jsedata.admin\":\"1\",\"bt.it.tasks\":\"1\",\"pollozen.simplegallery.manage_galleries\":\"1\"}',0,'2023-11-01 12:02:02','2023-11-01 12:02:02',NULL,NULL);
/*!40000 ALTER TABLE `backend_user_roles` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:59:34
