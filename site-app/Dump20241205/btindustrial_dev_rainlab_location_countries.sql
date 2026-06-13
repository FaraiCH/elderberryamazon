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
-- Table structure for table `rainlab_location_countries`
--

DROP TABLE IF EXISTS `rainlab_location_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rainlab_location_countries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rainlab_location_countries_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_location_countries`
--

LOCK TABLES `rainlab_location_countries` WRITE;
/*!40000 ALTER TABLE `rainlab_location_countries` DISABLE KEYS */;
INSERT INTO `rainlab_location_countries` VALUES (1,1,'Australia','AU',1),(2,1,'Canada','CA',1),(3,1,'United Kingdom','GB',1),(4,1,'United States','US',1),(5,0,'Afghanistan','AF',0),(6,0,'Aland Islands ','AX',0),(7,0,'Albania','AL',0),(8,0,'Algeria','DZ',0),(9,0,'American Samoa','AS',0),(10,0,'Andorra','AD',0),(11,0,'Angola','AO',0),(12,0,'Anguilla','AI',0),(13,0,'Antarctica','AQ',0),(14,0,'Antigua and Barbuda','AG',0),(15,0,'Argentina','AR',0),(16,0,'Armenia','AM',0),(17,0,'Aruba','AW',0),(18,0,'Austria','AT',0),(19,0,'Azerbaijan','AZ',0),(20,0,'Bahamas','BS',0),(21,0,'Bahrain','BH',0),(22,0,'Bangladesh','BD',0),(23,0,'Barbados','BB',0),(24,0,'Belarus','BY',0),(25,0,'Belgium','BE',0),(26,0,'Belize','BZ',0),(27,0,'Benin','BJ',0),(28,0,'Bermuda','BM',0),(29,0,'Bhutan','BT',0),(30,0,'Bolivia, Plurinational State of','BO',0),(31,0,'Bonaire, Sint Eustatius and Saba','BQ',0),(32,0,'Bosnia and Herzegovina','BA',0),(33,0,'Botswana','BW',0),(34,0,'Bouvet Island','BV',0),(35,0,'Brazil','BR',0),(36,0,'British Indian Ocean Territory','IO',0),(37,0,'Brunei Darussalam','BN',0),(38,0,'Bulgaria','BG',0),(39,0,'Burkina Faso','BF',0),(40,0,'Burundi','BI',0),(41,0,'Cambodia','KH',0),(42,0,'Cameroon','CM',0),(43,0,'Cape Verde','CV',0),(44,0,'Cayman Islands','KY',0),(45,0,'Central African Republic','CF',0),(46,0,'Chad','TD',0),(47,0,'Chile','CL',0),(48,0,'China','CN',0),(49,0,'Christmas Island','CX',0),(50,0,'Cocos (Keeling) Islands','CC',0),(51,0,'Colombia','CO',0),(52,0,'Comoros','KM',0),(53,0,'Congo','CG',0),(54,0,'Congo, the Democratic Republic of the','CD',0),(55,0,'Cook Islands','CK',0),(56,0,'Costa Rica','CR',0),(57,0,'Cote d\'Ivoire','CI',0),(58,0,'Croatia','HR',0),(59,0,'Cuba','CU',0),(60,0,'Curaçao','CW',0),(61,0,'Cyprus','CY',0),(62,0,'Czech Republic','CZ',0),(63,0,'Denmark','DK',0),(64,0,'Djibouti','DJ',0),(65,0,'Dominica','DM',0),(66,0,'Dominican Republic','DO',0),(67,0,'Ecuador','EC',0),(68,0,'Egypt','EG',0),(69,0,'El Salvador','SV',0),(70,0,'Equatorial Guinea','GQ',0),(71,0,'Eritrea','ER',0),(72,0,'Estonia','EE',0),(73,0,'Ethiopia','ET',0),(74,0,'Falkland Islands (Malvinas)','FK',0),(75,0,'Faroe Islands','FO',0),(76,0,'Finland','FI',0),(77,0,'Fiji','FJ',0),(78,1,'France','FR',0),(79,0,'French Guiana','GF',0),(80,0,'French Polynesia','PF',0),(81,0,'French Southern Territories','TF',0),(82,0,'Gabon','GA',0),(83,0,'Gambia','GM',0),(84,0,'Georgia','GE',0),(85,0,'Germany','DE',0),(86,0,'Ghana','GH',0),(87,0,'Gibraltar','GI',0),(88,0,'Greece','GR',0),(89,0,'Greenland','GL',0),(90,0,'Grenada','GD',0),(91,0,'Guadeloupe','GP',0),(92,0,'Guam','GU',0),(93,0,'Guatemala','GT',0),(94,0,'Guernsey','GG',0),(95,0,'Guinea','GN',0),(96,0,'Guinea-Bissau','GW',0),(97,0,'Guyana','GY',0),(98,0,'Haiti','HT',0),(99,0,'Heard Island and McDonald Islands','HM',0),(100,0,'Holy See (Vatican City State)','VA',0),(101,0,'Honduras','HN',0),(102,0,'Hong Kong','HK',0),(103,1,'Hungary','HU',0),(104,0,'Iceland','IS',0),(105,1,'India','IN',0),(106,0,'Indonesia','ID',0),(107,0,'Iran, Islamic Republic of','IR',0),(108,0,'Iraq','IQ',0),(109,1,'Ireland','IE',0),(110,0,'Isle of Man','IM',0),(111,0,'Israel','IL',0),(112,0,'Italy','IT',0),(113,0,'Jamaica','JM',0),(114,0,'Japan','JP',0),(115,0,'Jersey','JE',0),(116,0,'Jordan','JO',0),(117,0,'Kazakhstan','KZ',0),(118,0,'Kenya','KE',0),(119,0,'Kiribati','KI',0),(120,0,'Korea, Democratic People\'s Republic of','KP',0),(121,0,'Korea, Republic of','KR',0),(122,0,'Kuwait','KW',0),(123,0,'Kyrgyzstan','KG',0),(124,0,'Lao People\'s Democratic Republic','LA',0),(125,0,'Latvia','LV',0),(126,0,'Lebanon','LB',0),(127,0,'Lesotho','LS',0),(128,0,'Liberia','LR',0),(129,0,'Libyan Arab Jamahiriya','LY',0),(130,0,'Liechtenstein','LI',0),(131,0,'Lithuania','LT',0),(132,0,'Luxembourg','LU',0),(133,0,'Macao','MO',0),(134,0,'Macedonia','MK',0),(135,0,'Madagascar','MG',0),(136,0,'Malawi','MW',0),(137,0,'Malaysia','MY',0),(138,0,'Maldives','MV',0),(139,0,'Mali','ML',0),(140,0,'Malta','MT',0),(141,0,'Marshall Islands','MH',0),(142,0,'Martinique','MQ',0),(143,0,'Mauritania','MR',0),(144,0,'Mauritius','MU',0),(145,0,'Mayotte','YT',0),(146,0,'Mexico','MX',0),(147,0,'Micronesia, Federated States of','FM',0),(148,0,'Moldova, Republic of','MD',0),(149,0,'Monaco','MC',0),(150,0,'Mongolia','MN',0),(151,0,'Montenegro','ME',0),(152,0,'Montserrat','MS',0),(153,0,'Morocco','MA',0),(154,0,'Mozambique','MZ',0),(155,0,'Myanmar','MM',0),(156,0,'Namibia','NA',0),(157,0,'Nauru','NR',0),(158,0,'Nepal','NP',0),(159,1,'Netherlands','NL',0),(160,0,'New Caledonia','NC',0),(161,1,'New Zealand','NZ',0),(162,0,'Nicaragua','NI',0),(163,0,'Niger','NE',0),(164,0,'Nigeria','NG',0),(165,0,'Niue','NU',0),(166,0,'Norfolk Island','NF',0),(167,0,'Northern Mariana Islands','MP',0),(168,0,'Norway','NO',0),(169,0,'Oman','OM',0),(170,0,'Pakistan','PK',0),(171,0,'Palau','PW',0),(172,0,'Palestine','PS',0),(173,0,'Panama','PA',0),(174,0,'Papua New Guinea','PG',0),(175,0,'Paraguay','PY',0),(176,0,'Peru','PE',0),(177,0,'Philippines','PH',0),(178,0,'Pitcairn','PN',0),(179,0,'Poland','PL',0),(180,0,'Portugal','PT',0),(181,0,'Puerto Rico','PR',0),(182,0,'Qatar','QA',0),(183,0,'Reunion','RE',0),(184,1,'Romania','RO',0),(185,0,'Russian Federation','RU',0),(186,0,'Rwanda','RW',0),(187,0,'Saint Barthélemy','BL',0),(188,0,'Saint Helena','SH',0),(189,0,'Saint Kitts and Nevis','KN',0),(190,0,'Saint Lucia','LC',0),(191,0,'Saint Martin (French part)','MF',0),(192,0,'Saint Pierre and Miquelon','PM',0),(193,0,'Saint Vincent and the Grenadines','VC',0),(194,0,'Samoa','WS',0),(195,0,'San Marino','SM',0),(196,0,'Sao Tome and Principe','ST',0),(197,0,'Saudi Arabia','SA',0),(198,0,'Senegal','SN',0),(199,0,'Serbia','RS',0),(200,0,'Seychelles','SC',0),(201,0,'Sierra Leone','SL',0),(202,0,'Singapore','SG',0),(203,0,'Sint Maarten (Dutch part)','SX',0),(204,0,'Slovakia','SK',0),(205,0,'Slovenia','SI',0),(206,0,'Solomon Islands','SB',0),(207,0,'Somalia','SO',0),(208,0,'South Africa','ZA',0),(209,0,'South Georgia and the South Sandwich Islands','GS',0),(210,1,'Spain','ES',0),(211,0,'Sri Lanka','LK',0),(212,0,'Sudan','SD',0),(213,0,'Suriname','SR',0),(214,0,'Svalbard and Jan Mayen','SJ',0),(215,0,'Swaziland','SZ',0),(216,0,'Sweden','SE',0),(217,0,'Switzerland','CH',0),(218,0,'Syrian Arab Republic','SY',0),(219,0,'Taiwan, Province of China','TW',0),(220,0,'Tajikistan','TJ',0),(221,0,'Tanzania, United Republic of','TZ',0),(222,0,'Thailand','TH',0),(223,0,'Timor-Leste','TL',0),(224,0,'Togo','TG',0),(225,0,'Tokelau','TK',0),(226,0,'Tonga','TO',0),(227,0,'Trinidad and Tobago','TT',0),(228,0,'Tunisia','TN',0),(229,0,'Turkey','TR',0),(230,0,'Turkmenistan','TM',0),(231,0,'Turks and Caicos Islands','TC',0),(232,0,'Tuvalu','TV',0),(233,0,'Uganda','UG',0),(234,0,'Ukraine','UA',0),(235,0,'United Arab Emirates','AE',0),(236,0,'United States Minor Outlying Islands','UM',0),(237,0,'Uruguay','UY',0),(238,0,'Uzbekistan','UZ',0),(239,0,'Vanuatu','VU',0),(240,0,'Venezuela, Bolivarian Republic of','VE',0),(241,0,'Viet Nam','VN',0),(242,0,'Virgin Islands, British','VG',0),(243,0,'Virgin Islands, U.S.','VI',0),(244,0,'Wallis and Futuna','WF',0),(245,0,'Western Sahara','EH',0),(246,0,'Yemen','YE',0),(247,0,'Zambia','ZM',0),(248,0,'Zimbabwe','ZW',0);
/*!40000 ALTER TABLE `rainlab_location_countries` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:29:27
