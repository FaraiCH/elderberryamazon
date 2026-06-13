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
-- Table structure for table `renatio_dynamicpdf_pdf_layouts`
--

DROP TABLE IF EXISTS `renatio_dynamicpdf_pdf_layouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `renatio_dynamicpdf_pdf_layouts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_html` text COLLATE utf8mb4_unicode_ci,
  `content_css` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `renatio_dynamicpdf_pdf_layouts_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `renatio_dynamicpdf_pdf_layouts`
--

LOCK TABLES `renatio_dynamicpdf_pdf_layouts` WRITE;
/*!40000 ALTER TABLE `renatio_dynamicpdf_pdf_layouts` DISABLE KEYS */;
INSERT INTO `renatio_dynamicpdf_pdf_layouts` VALUES (1,'renatio::invoice','Invoice','<html>\n    <head>\n        <style type=\"text/css\" media=\"screen\">\n            {{ css|raw }}\n        </style>\n    </head>\n    <body style=\"background: url({{ background_img }}) top left no-repeat;\">\n        <div class=\"header\">\n            <p class=\"left\"><strong>www.example.com</strong></p>\n            <p class=\"right\">\n                <strong>Acme Company</strong><br>\n                Admin Person<br>\n                Test Street<br>\n                34131 Berlin\n            </p>\n        </div>\n        <div class=\"footer\">\n            <p class=\"left\">\n                Tel. 4141414144<br>\n                Fax: 41414141414<br>\n                E-mail: test@test.com<br>\n                USt-IdNr.: 34131 Berlin\n            </p>\n            <p class=\"right\">\n                Bank: Acme Company<br>\n                Kontoinhaber: Admin Person<br>\n                IBAN: DE41413113131<br>\n                BIC: 341314\n            </p>\n        </div>\n        {{ content_html|raw }}\n    </body>\n</html>','@font-face {\n    font-family: \'Open Sans\';\n    src: url(\'plugins/renatio/dynamicpdf/assets/fonts/OpenSans-Regular.ttf\');\n}\n\n@font-face {\n    font-family: \'Open Sans\';\n    font-weight: bold;\n    src: url(\'plugins/renatio/dynamicpdf/assets/fonts/OpenSans-Bold.ttf\');\n}\n\n@font-face {\n    font-family: \'Open Sans\';\n    font-style: italic;\n    src: url(\'plugins/renatio/dynamicpdf/assets/fonts/OpenSans-Italic.ttf\');\n}\n\n@font-face {\n    font-family: \'Open Sans\';\n    font-style: italic;\n    font-weight: bold;\n    src: url(\'plugins/renatio/dynamicpdf/assets/fonts/OpenSans-BoldItalic.ttf\');\n}\n\n@page {\n    margin: 0;\n    padding: 0;\n}\n\nbody {\n    font-family: \'Open Sans\', sans-serif;\n    font-size: 14px;\n}\n\n.header {\n    position: fixed;\n    top: 3%;\n    left: 30%;\n}\n\n.header .left {\n    color: #373430;\n    font-size: .9em;\n    text-transform: uppercase;\n    width: 60%;\n    display: inline-block;\n}\n\n.header .right {\n    font-size: .7em;\n    color: #545554;\n    line-height: 1em;\n    text-align: right;\n    display: inline-block;\n    width: 30%;\n    padding-top: 1%;\n}\n\n.footer {\n    position: fixed;\n    bottom: 0;\n    left: 5%;\n    height: 12%;\n    font-size: .7em;\n    color: #545554;\n    line-height: 1em;\n}\n\n.footer .left {\n    display: inline-block;\n    width: 25%;\n}\n\n.footer .right {\n    display: inline-block;\n    width: 30%;\n    padding-top: 7%;\n}\n\n.content {\n    margin: 12% 0 0 10%;\n}\n\n.small-txt {\n    font-size: .7em;\n}\n\n.company-info {\n    display: inline-block;\n    width: 55%;\n    line-height: 1.1em;\n    font-size: 1.1em;\n}\n\n.customer-info {\n    display: inline-block;\n    width: 45%;\n    font-size: .9em;\n    height: 10%;\n}\n\n.summary {\n    margin: 10% 0 5% 0;\n    border-collapse: collapse;\n    width: 90%;\n}\n\n.summary th {\n    background-color: #BEBEBE;\n    border: 1px solid #000;\n    padding: 5px;\n}\n\n.summary td {\n    padding: 5px 10px;\n    border-right: 1px solid #000;\n}\n\n.summary .col-1 {\n    width: 15%;\n    text-align: center;\n    border-left: 1px solid #000;\n}\n\n.summary .col-2 {\n    width: 50%;\n}\n\n.summary .col-3 {\n    width: 15%;\n    text-align: right;\n}\n\n.summary .col-4 {\n    width: 20%;\n    text-align: right;\n}\n\n.summary .bt {\n    border-top: 1px solid #000;\n}\n\n.summary .sum-price .col-4 {\n    border-top: 1px solid #000;\n    border-bottom: 1px solid #000;\n}','2019-02-19 17:44:52','2019-02-19 17:44:52',0),(2,'bt-questionnaire-theme','BT Questionnaire Theme','<!DOCTYPE html>\r\n<html>\r\n    <head>\r\n        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>\r\n        <title>Document</title>\r\n        <style type=\"text/css\" media=\"screen\">\r\n            {{ css|raw }}\r\n        </style>\r\n             <link href=\"{{\'assets/css/sb-admin.css\'|theme }}\" rel=\"stylesheet\">\r\n             <link rel=\"icon\" type=\"image/png\" href=\"https://bt-industrial.co.za/wp-content/uploads/2021/05/BT_Logo-favicon.jpg\" />\r\n<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\r\n<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\r\n    \r\n    </head>\r\n    <body>\r\n   <div class=\"container\">\r\n    <div class=\"header-img\">\r\n      <div class=\"row\">\r\n          <div class=\"col-sm-10\">\r\n            <img src=\"https://bt-industrial.co.za/wp-content/uploads/2021/01/Small-x2-197x74-1.png\">\r\n          </div>\r\n          </div>\r\n    </div>\r\n   </div>\r\n        {{ content_html|raw }}\r\n   <br>\r\n   <br>\r\n   <br>\r\n<div class=\"footer-holder\">\r\n  <div class=\"container\">\r\n    <div class=\"footer-inner\">\r\n      <div class=\"copyright\" style=\"font-size: 14px\">\r\n        &copy; {{ \"now\"|date(\"Y\") }} - Copyright Reserved to <span class=\"text-color\">BT-INDUSTRIAL.</span>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>\r\n\r\n\r\n    </body>\r\n</html>','html{\r\n      height: 100%;\r\n      }\r\n      body{ \r\n\r\n        color: #212529;font-size: 12px;\r\n        font-family: sans-serif;\r\n        word-wrap: break-word;\r\n        background: url(http://bailaerp.bt-industrial.co.za/themes/hambern-hambern-blank-bootstrap-4/assets/images/Background.gif) no-repeat center center;\r\n    }\r\n        \r\n\r\n      \r\n\r\n      a{\r\n      color: #273265;\r\n      }\r\n\r\n      a:hover{\r\n      color: #5d606c;\r\n      }\r\n      .header-img{\r\n            padding: 20px 0px;\r\n      }\r\n\r\n      .content{\r\n            padding-top: 40px;\r\n      }\r\n\r\n      .q-icon{\r\n            padding: 40px 0px;\r\n            background: #223e77;\r\n            margin: 0px auto;\r\n            border-radius: 4px;\r\n      }\r\n      .q-icon img{\r\n            max-width: 100%;\r\n      }\r\n\r\n      .page-title {\r\n        position: relative;\r\n        background: #032b5e;  \r\n        padding: 40px;\r\n      }\r\n\r\n\r\n\r\n      .page-title h1{\r\n               color: #032b5e;  \r\n            font-size: 30px;color: #ffffff;line-height: 35px;text-align: center;font-weight: 300;;\r\n      }\r\n      \r\n      .label-type-radio{\r\n       font-weight: bold;\r\n      }\r\n       .page-title p{\r\n            font-size: 19px;\r\n            color: #ffffff;\r\n            line-height: 27px;\r\n            text-align: center;\r\n            font-weight: 300; \r\n            font-family: \'Source Sans Pro\';\r\n            \r\n      }\r\n      .card-program h3{\r\n          font-size: 24px;\r\n          color: #273265;\r\n          line-height: 20px;\r\n          font-weight: 400;\r\n          font-family: \'Roboto Condensed\';\r\n          margin: 2px 0px 15px 0px;\r\n      }\r\n      \r\n     h2{\r\n\r\n          color: #032b5e;\r\n          font-family: \'Roboto Condensed\';\r\n\r\n      }\r\n\r\n      .card-program .card-text{\r\n            font-size: 16px;\r\n            color: #232425;\r\n            line-height: 27px;\r\n            \r\n            font-weight: 300; \r\n            font-family: \'Roboto\';\r\n             margin: 2px 0px 20px 0px;\r\n            \r\n      }\r\n\r\n      .card-program .btn-primary,.btn-cst,.nextbtn{\r\n            background-color: #032b5e;\r\n            color: #ffffff;\r\n            border-radius: 4px;\r\n            -moz-border-radius: 4px;\r\n            -webkit-border-radius: 4px;\r\n            overflow: hidden;\r\n            line-height: 34px;\r\n            font-size: 22px;\r\n            font-weight: 300;\r\n            font-family: \'Roboto Condensed\';\r\n            padding-left: 1.1364em;\r\n            padding-right: 1.1364em;\r\n            border: 0px;\r\n\r\n\r\n      }\r\n      .card-program .btn-primary:hover,.btn-cst:hover,.nextbtn:hover{\r\n            background-color: #848484;color: #fff;\r\n      }\r\n\r\n\r\n\r\n      div.blob{\r\n            background-color: #f9f9f9;\r\n            padding:  25px 25px;\r\n            border-radius: 20px;\r\n            margin-bottom: 20px;\r\n      }\r\n\r\n      .nav-tabs-custom{\r\n            font-weight: 300;\r\n            font-family: \'Roboto\';\r\n      }\r\n      .nav-tabs-custom li.active .nav-link{\r\n            background-color: #032b5e;\r\n            color: #ffffff;\r\n\r\n      }\r\n      .nav-tabs {\r\n            border-bottom: 1px solid #032b5e;\r\n      }     \r\n      #body_qtab{\r\n           \r\n            background: #fff;\r\n            padding: 20px 20px;\r\n      }\r\n      .nav-link {\r\n          display: block;\r\n          padding: 4px 6px;\r\n      }\r\n      .qheader{\r\n          color: #032b5e;  \r\n      }\r\n\r\n        .row{\r\n            left: 30px\r\n        }\r\n      .form-input-checkpdf{\r\n            padding-bottom: 10px;\r\n      }\r\n      input[type=\"radio\"] {\r\n          margin-top: 10px;\r\n          margin-right: 10px;\r\n        }\r\n\r\n      .box-footer{\r\n          \r\n           margin: 0px -10px -10px -10px; text-align: center;\r\n           padding: 10px;\r\n      }\r\n\r\n            @media screen and (min-width: 992px) {\r\n              div.contactForm .form-group{\r\n                  clear: both;\r\n                  margin-top: 20px;\r\n\r\n              }\r\n\r\n              div.contactForm .control-label{\r\n                  float: left !important;\r\n                  width: 50%;\r\n\r\n              }\r\n\r\n              div.contactForm .form-control{\r\n                  float: left !important;\r\n                  width: 50%;\r\n                  margin-bottom: 15px;\r\n              }\r\n\r\n            }','2023-01-28 11:30:04','2023-01-29 06:50:01',0);
/*!40000 ALTER TABLE `renatio_dynamicpdf_pdf_layouts` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:30:30
