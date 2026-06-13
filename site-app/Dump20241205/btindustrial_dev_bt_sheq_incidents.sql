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
-- Table structure for table `bt_sheq_incidents`
--

DROP TABLE IF EXISTS `bt_sheq_incidents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bt_sheq_incidents` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `incident_no` text COLLATE utf8mb4_unicode_ci,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `incident_date` datetime NOT NULL,
  `invest_date` datetime DEFAULT NULL,
  `team_id` int DEFAULT NULL,
  `root` text COLLATE utf8mb4_unicode_ci,
  `control` text COLLATE utf8mb4_unicode_ci,
  `close_date` datetime DEFAULT NULL,
  `recall_date` datetime DEFAULT NULL,
  `teams` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bt_sheq_incidents_team_id_index` (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bt_sheq_incidents`
--

LOCK TABLES `bt_sheq_incidents` WRITE;
/*!40000 ALTER TABLE `bt_sheq_incidents` DISABLE KEYS */;
INSERT INTO `bt_sheq_incidents` VALUES (1,'BT-LOGISTICS-001','Velile Sathula - was conducting his duty as a forklift driver.\r\nHe then accidentally hit the fence with the pipe.\r\nElectricity wires was then loose, damaged and no longer armed.','2021-05-03 10:00:00','2021-06-04 08:30:00',NULL,'Accident due to lack of space around to store pipes around the yard.','To store the pipes in less risky place away from the fence. To avoid damaging electricity fence  since the company become vulnerable to criminals and robbery. \r\nThe fence is now fixed and is restored to working condition.','2021-06-04 13:00:00',NULL,NULL,'2021-06-04 11:27:42','2022-04-06 09:58:35'),(2,'BT-HDPE-002','Bennet Moyikwa was on duty for night shift on the 28 July 2021. He was conducting his duty as an operator offloading big pipe from the machine while the forklift driver was picking the pipe. It happened that the pipe fell and hit the operator at the back. He fell down and became unconscious for about 5 - 10 minutes. He sustained injury at his right hand side of his chest. According to him he had a popping sound from his chest. He was released telephonically by his manager to go home if he is not feeling well. He then drive himself home and the following morning he went to see the doctor for examination since he was still feeling pains.','2021-07-28 19:00:00','2021-08-04 10:00:00',NULL,'Accident','',NULL,NULL,'[]','2021-08-24 08:35:57','2021-08-24 08:40:05'),(3,'BT-HDPE-003','Thabo Victor Tsekela - He is a line operator and he was conducting his normal duty on the 02/August/2021. He was removing pipe from the rolling stand. Rolling stand is consist of arms that open and close. On that day one of the arm in the rolling stand was not fully open. When he pull the pipe, he was then hit by the arm on the left side of his head. He then started bleeding and he was offered first aid treatment by Veli Sathola. He was having slightly head \r\nache.','2021-08-02 11:30:00','2021-08-04 10:00:00',NULL,'','',NULL,NULL,'[]','2021-08-24 08:42:50','2021-08-24 08:51:24'),(4,'BT-HDPE-004','Daizy Malatji ID number 8402095531083 was on duty on the 27 of August 2021 working night shift. There was a starter pipe 400mm at Bailly 2 that needed to be removed.  Two forklift are normally used to move the pipe out, Daizy was alone as forklift operator that night and he operated two forklift. He pulled the pipe with one forklift while another one was balancing the pipe outside. He suddenly had a huge sound outside and when he checked the forklift has rolled on the ground and it was seriously damaged. He then called his Supervisor to report the incidence.','2021-08-27 21:30:00','2021-08-31 16:30:00',NULL,'','',NULL,NULL,'[]','2021-09-01 07:58:55','2021-09-01 07:58:55'),(5,'BT-HDPE-005','Daizy Malatji ID number 8402095531083 was on duty on the 24 September 2021. He was busy with his daily duty of driving forklift, while he was taking pipes from the machine, the pipe slips and hit an office window and now the window is broken.','2021-09-24 17:30:00','2021-09-29 11:00:00',NULL,'Not using pipe grabber when moving pipes from the machine.','To ensure that pipe grabber is used at all time when moving pipes and to also protect Office windows with bugler proofs from outside.',NULL,NULL,'','2021-09-29 07:40:10','2022-03-18 12:04:17'),(6,'BT-HDPE-006','Veli Sathula ID No 7210095764088 - Was loading pipes on Barona Van. It was raining and when He was busy loading, the pipes rolled back and hit the floor and the door of the car and damaged the  door. Only a minor dent was caused at the side of the door.','2022-02-11 11:30:00','2022-02-11 15:30:00',NULL,'Loading on top of the van while is raining - pipes was wet and slippery.','Avoid loading and stacking when is raining.','2022-02-11 16:00:00',NULL,NULL,'2022-03-22 11:55:28','2022-03-22 12:04:28'),(7,'BT-Meltblown-007','Thabiso Simon Ngwenya was on duty on the 24 February 2022. He was purging to start meltblown next to the screen changer and the cables. He was trying to remove the cables so that they don\'t catch the melted pp material. the material ended up falling on top of his hands and he was burnt with hot material. First aider assisted him.','2022-02-24 11:15:00','2022-02-25 10:15:00',NULL,'Operating machine without wearing gloves.','Gloves to be provided to Meltblown operator.','2022-02-25 15:30:00',NULL,NULL,'2022-03-22 12:19:04','2022-03-22 12:19:04'),(8,'BT-HDPE-008','Veli Sathula ID No 7210095764088 - He was on duty on the 17 March 2022 going to deliver pipes to the customer using a van and a trailer. While he was driving on the free way at a speed of 60-70km/hr . He suddenly realised that the trailer was going side by side. He tried to control the vehicle till it was stable. The bolt went out and caused the trailer to be out of alignment. The pipes was all over the road and the traffic officer helped him to move the pipes out of the road.\r\n*6 Coils (50mm x 200m x PN25) weighing 186kg each was loaded on the trailer.\r\n*The trailer was reported to the Seniors/Maintenance that it was not in good state to be used but it was never fixed.\r\n*It was unfortunate for Veli that he never knew about the condition of the trailer before he used it.','2022-03-17 10:00:00','2022-03-17 16:00:00',NULL,'*Inspection was not done for the trailer before loading the pipes.\r\n*Maintenance never reported back to Logistics if the trailer was fixed or not since it was reported to them.\r\n*Everything was done in the absence of Logistic Supervisor.','Inspection to be done for all vehicles and tailor before loading pipes.\r\nMaintenance to give feedback on issues reported to them.','2022-03-22 11:00:00',NULL,NULL,'2022-03-22 12:45:02','2022-03-22 12:45:02'),(9,'BT-Medical - 009','Tshilidzi Mushamula  ID No 9602155597085 was on duty offloading HDPE Raw material packing inside the cage. He was stacking pallets in two, the pallet fall on top of medical boxes and damaged some boxes.','2022-04-08 11:00:00','2022-04-08 11:00:00',NULL,'Black Plastic pallet not strong or balanced enough to hold pallet of raw material especially stacking them in two. \r\nThere is a serious challenge of space inside the cage.','To put pallet one by one on the floor rather than stacking in two pallets.','2022-04-08 12:00:00',NULL,NULL,'2022-04-12 13:47:06','2022-04-12 13:47:06');
/*!40000 ALTER TABLE `bt_sheq_incidents` ENABLE KEYS */;
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

-- Dump completed on 2024-12-05 17:33:14
