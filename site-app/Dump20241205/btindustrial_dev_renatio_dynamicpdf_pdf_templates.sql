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
-- Table structure for table `renatio_dynamicpdf_pdf_templates`
--

DROP TABLE IF EXISTS `renatio_dynamicpdf_pdf_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `renatio_dynamicpdf_pdf_templates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `layout_id` int unsigned DEFAULT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content_html` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orientation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_custom` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `renatio_dynamicpdf_pdf_templates_code_unique` (`code`),
  KEY `renatio_dynamicpdf_pdf_templates_layout_id_index` (`layout_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `renatio_dynamicpdf_pdf_templates`
--

LOCK TABLES `renatio_dynamicpdf_pdf_templates` WRITE;
/*!40000 ALTER TABLE `renatio_dynamicpdf_pdf_templates` DISABLE KEYS */;
INSERT INTO `renatio_dynamicpdf_pdf_templates` VALUES (1,1,'renatio::invoice','Invoice','Example Invoice Template','<div class=\"content\">\r\n    <p class=\"small-txt\">Acme Company • Admin Person • Test Street • 31335 Berlin</p>\r\n\r\n    <p class=\"company-info\">\r\n        <strong>Happy Customer - Acme GmbH</strong><br>\r\n        <strong>Elbstr. 2</strong><br>\r\n        <strong>041340 Berlin</strong>\r\n    </p>\r\n\r\n    <p class=\"customer-info\">\r\n        <strong>Kundennummer:</strong> 1211<br>\r\n        <strong>Rechnungsnummer:</strong> 2015-ADG-1612<br>\r\n        <strong>Datum:</strong> 18.03.2015<br>\r\n        <strong>Zahlungsbedingungen:</strong> 2 Tage ohne Abzug<br>\r\n        <strong>Fällig am:</strong> 20.03.2015\r\n    </p>\r\n    <table class=\"summary\">\r\n        <tr>\r\n            <th>Menge</th>\r\n            <th>Beschreibung</th>\r\n            <th>Preis</th>\r\n            <th>Anzahlung 30%</th>\r\n        </tr>\r\n        <tr>\r\n            <td class=\"col-1\">1</td>\r\n            <td class=\"col-2\">4 Holzfenster</td>\r\n            <td class=\"col-3\">26.653,69 &euro;</td>\r\n            <td class=\"col-4\">7.996,11 &euro;</td>\r\n        </tr>\r\n        <tr>\r\n            <td class=\"col-1\">1</td>\r\n            <td class=\"col-2\">4 Holzfenster</td>\r\n            <td class=\"col-3\">26.653,69 &euro;</td>\r\n            <td class=\"col-4\">7.996,11 &euro;</td>\r\n        </tr>\r\n        {% for i in 0..5 %}\r\n            <tr>\r\n                <td class=\"col-1\">&nbsp;</td>\r\n                <td class=\"col-2\"></td>\r\n                <td class=\"col-3\"></td>\r\n                <td class=\"col-4\"></td>\r\n            </tr>\r\n        {% endfor %}\r\n        <tr class=\"sum-price\">\r\n            <td colspan=\"3\" class=\"col-3 bt\">Netto</td>\r\n            <td class=\"col-4\">7.996,11 &euro;</td>\r\n        </tr>\r\n        <tr class=\"sum-price\">\r\n            <td colspan=\"3\" class=\"col-3\">zzgl. 19% MwSt.</td>\r\n            <td class=\"col-4\">1.519,26 &euro;</td>\r\n        </tr>\r\n        <tr class=\"sum-price\">\r\n            <td colspan=\"3\" class=\"col-3\"><strong>Gesamt</strong></td>\r\n            <td class=\"col-4\">9.515,37 &euro;</td>\r\n        </tr>\r\n    </table>\r\n    <p><strong>Vielen Dank für Ihren Auftrag</strong></p>\r\n\r\n    <p>Gerichtsstand für alle Ansprüche aus diesem Auftrag ist Berlin.</p>\r\n</div>','2019-02-19 17:44:52','2021-02-22 19:47:57',NULL,NULL,1),(2,2,'questionnaire-answer','questionnaire-answer','','<div class=\"contentprint\">\r\n    <div class=\"pdfprint\">\r\n           \r\n        \r\n       <section class=\"page-title bg-4\">\r\n      <div class=\"container\">\r\n          <div class=\"row\">\r\n              <div class=\"col-md-12\">\r\n                  <div class=\"block text-center\">\r\n                      <span class=\"text-white\">&nbsp;</span>\r\n                        <h1>QUESTIONNAIRE:</h1>\r\n                        <h1>{{obj.questionnaire.name}}</h1>\r\n                        \r\n    \r\n                  </div>\r\n              </div>\r\n          </div>\r\n      </div>\r\n    </section>\r\n               \r\n   \r\n       \r\n    <br><br>\r\n       \r\n        \r\n     </div>\r\n</div>\r\n        <table style=\" width:100%\">\r\n           \r\n        <tr style=\"color:#032b5e\" class=\"col-md-6\">\r\n        <td ><strong><label>Name:</label></strong></td><td><label>{{obj.name}}</label></td>\r\n    \r\n        </tr> \r\n        <tr style=\"color:#032b5e\" class=\"col-md-6\">\r\n            <td  ><strong><label>Surname:</label></strong></td><td><label>{{obj.surname}}</label></td>\r\n        </tr>\r\n         <tr style=\"color:#032b5e\" class=\"col-md-6\">\r\n            <td  ><strong><label>Program:</label></strong></td><td><label>{{obj.questionnaire.name}}</label></td>\r\n        </tr>\r\n        <tr style=\"color:#032b5e\" class=\"col-md-6\">\r\n            <td  ><strong><label>Complete Date:</label></strong></td><td><label>{{obj.end_date}}</label></td>\r\n        </tr>\r\n            \r\n    </table>\r\n   <br><br>\r\n   \r\n   <div>\r\n           <p style=\"text-align:center; font-size: 25px; color: whitesmoke; background:#032b5e; border-radius: 10px\">Questionnaire Score: {{perc|round(1, \'floor\')}}%</p>\r\n   </div>\r\n\r\n{% set mainman = 0 %}\r\n{% set radio = 0 %}\r\n\r\n        \r\n<div>\r\n    <div>\r\n        {% set counter = 0 %}\r\n           \r\n        {% for startkey, questionnaire in questionobj %}\r\n    \r\n        <div>\r\n            <h2>{{questionobj[startkey][\'name\']}}</h2>\r\n        </div>\r\n       \r\n        <div>\r\n\r\n            {% for key, fields in questionobj[startkey][\'fields\'] %}\r\n            {% set count = 1 %}\r\n              <div class=\"printpdfrow col-sm-12\">\r\n                <div class=\"form-group row\">\r\n                    <label class=\"col-sm-4 col-form-label label-type-radio\" ><span>{{questionobj[startkey][\'label\'][key]}}</span></label>\r\n            <hr>\r\n            {% set track = 0 %}\r\n            {% for f_key, f in fields %}\r\n            {% if f[\'field_value_content\'] == questionobj[startkey][\'realanswer\'][key] %}\r\n      \r\n                <div class=\"col-sm-8\">\r\n                    <div class=\"checkpdf\">\r\n                        <div style=\"color: green\" class=\'form-check form-input-checkpdf\'>\r\n                            <input required class=\'form-check-input\'  name=\"{{radio}}\"  type=\'radio\'  checked=\"checked\">\r\n                            <label class=\'form-check-label\'>{{f[\'field_value_content\']}}</label>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n        \r\n            {% set track = questionobj[startkey][\'realanswer\'][key] %}\r\n            {% else %}\r\n                   <div class=\"col-sm-8\">\r\n                        <div class=\"checkpdf\">\r\n                            <div class=\'form-check form-input-checkpdf\'>\r\n                                <input required class=\'form-check-input\'  name=\"{{radio}}\"  type=\'radio\'>\r\n                                <label class=\'form-check-label\'>{{f[\'field_value_content\']}}</label>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n            {% endif %}\r\n            {% set count = count + 1 %}\r\n            {% endfor %}       \r\n          \r\n            {% if track == questionobj[startkey][\'youranswer\'][key] %}\r\n            <p><b>Your Answer: <span style=\"color: green\">{{questionobj[startkey][\'youranswer\'][key]}}</span><span class=\"text-center\" style=\"margin-left: 20px; min-width: 20px; color: whitesmoke; background: forestgreen; border-radius: 5px\">Correct Answer</span> </b></p>\r\n            {% set track = 0 %}\r\n            {% else %}\r\n                <p><b>Your Answer: <span style=\"color: red\">{{questionobj[startkey][\'youranswer\'][key]}} </span><span class=\"text-center\" style=\"margin-left: 20px; min-width: 20px; color: whitesmoke; background: maroon; border-radius: 5px\">Wrong Answer</span></b></p>\r\n            {% endif %}\r\n            <br>\r\n            <br>\r\n            {% endfor %}\r\n                   </div>\r\n            </div>\r\n        </div>\r\n        {% set radio = radio + 1 %}\r\n        {% endfor %}\r\n        \r\n    </div>\r\n</div>','2023-01-28 11:29:45','2023-01-30 11:48:14','','',1);
/*!40000 ALTER TABLE `renatio_dynamicpdf_pdf_templates` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:38:34
