-- MariaDB dump 10.19  Distrib 10.5.19-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: token
-- ------------------------------------------------------
-- Server version	10.5.19-MariaDB-0+deb11u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `meter`
--

DROP TABLE IF EXISTS `meter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meter_id` varchar(50) NOT NULL,
  `meter_type` varchar(10) NOT NULL DEFAULT 'pre-paid',
  `meter_number` varchar(20) NOT NULL,
  `current_token` int(11) NOT NULL DEFAULT 0,
  `last_token` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `meter_id` (`meter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meter`
--

LOCK TABLES `meter` WRITE;
/*!40000 ALTER TABLE `meter` DISABLE KEYS */;
INSERT INTO `meter` VALUES (2,'4d9c29c6-fad50d43-a642a8bc-9a85ab03','pre-paid','14235220192',0,'2023-03-13 17:46:12','2023-03-13 17:46:12'),(3,'30b08cd8-e8d49e5f-cbd2ea82-aae4d553','pre-paid','14235220193',0,'2023-03-14 11:29:07','2023-03-14 11:29:07'),(4,'5cea3031-1341561a-82f00c65-42cfc3fe','post-paid','14235220194',0,'2023-03-14 11:37:03','2023-03-14 11:37:03'),(6,'3280692e-4756a939-764f8fb1-cd67038c','pre-paid','123456788823791',0,'2023-03-22 19:08:28','2023-03-22 19:08:28'),(7,'9320e329-496cfcf7-c5f9722b-49a6f6b4','post-paid','1234567889347923',0,'2023-03-22 19:08:45','2023-03-22 19:08:45'),(8,'a164f3e1-3b5f29c7-b2f6325c-b10408a1','post-paid','8976543453',0,'2023-03-22 19:11:30','2023-03-22 19:11:30');
/*!40000 ALTER TABLE `meter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_channel`
--

DROP TABLE IF EXISTS `payment_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `account_number` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_number` (`account_number`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_channel`
--

LOCK TABLES `payment_channel` WRITE;
/*!40000 ALTER TABLE `payment_channel` DISABLE KEYS */;
INSERT INTO `payment_channel` VALUES (1,'pre-paid','888880','2023-03-13 17:39:21'),(3,'post-paid','888888','2023-03-13 17:39:36');
/*!40000 ALTER TABLE `payment_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `meter_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_id` (`transaction_id`),
  KEY `fk_transaction_user` (`user_id`),
  KEY `fk_transaction_meter` (`meter_id`),
  CONSTRAINT `fk_transaction_meter` FOREIGN KEY (`meter_id`) REFERENCES `meter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_transaction_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (1,'68672bfb-0de41b33-888e51ab-b5e5bac9',100,2,2,'2023-03-28 09:32:36'),(2,'2v9E6TMb9qZ0fKLBnzrM',1,3,8,'2023-03-29 15:29:38'),(3,'WrgmHimAKnB4jFME60mU',1,3,2,'2023-03-29 15:33:02');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_request_id` varchar(255) NOT NULL,
  `checkout_request_id` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `result_code` varchar(10) DEFAULT NULL,
  `result_description` text DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions_records`
--

DROP TABLE IF EXISTS `transactions_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_request_id` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `result_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions_records`
--

LOCK TABLES `transactions_records` WRITE;
/*!40000 ALTER TABLE `transactions_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'68672bfb-0de41b33-888e51ab-b5e5bac9','WANDABI GIDEON','wandabi@gmail.com','712881672','$2y$10$YlYk07NkHt/QwQdZyGVFyuxq55qjOWibhQH0beG4DdIjx4WsN00Nq','2023-03-13 17:48:00','2023-03-13 17:48:25'),(2,'94201df4-930302a0-7d368d49-1d1707ef','LLOYD TONY','lloyd@gmail.com','712345678','$2y$10$vgFtjgWYr/8RTX9bdGIYCuYpbv/vjhD3kN5z5s2VjBSwasXuWIGZW','2023-03-14 12:02:29','2023-03-14 12:02:29'),(3,'7df273f2-b32293c4-4056c65c-593e1fdd','ANIDA','kirui@gmail.com','07712121212','$2y$10$2nq73ez1m9Tm0wIYMUCdDeI9yBERWonhyNuYpYSFBO5bzFz/GKwka','2023-03-28 10:32:39','2023-03-28 10:32:39');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_meter`
--

DROP TABLE IF EXISTS `user_meter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_meter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `meter_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_user_meter_user` (`user_id`),
  KEY `fk_user_meter_meter` (`meter_id`),
  CONSTRAINT `fk_user_meter_meter` FOREIGN KEY (`meter_id`) REFERENCES `meter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_meter_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_meter`
--

LOCK TABLES `user_meter` WRITE;
/*!40000 ALTER TABLE `user_meter` DISABLE KEYS */;
INSERT INTO `user_meter` VALUES (1,1,2,'2023-03-13 17:46:12'),(2,1,3,'2023-03-14 11:29:07'),(3,1,4,'2023-03-14 11:37:03'),(4,2,2,'2023-03-14 12:06:03'),(6,2,6,'2023-03-22 19:08:29'),(7,2,7,'2023-03-22 19:08:46'),(8,2,8,'2023-03-22 19:11:31');
/*!40000 ALTER TABLE `user_meter` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-29 22:05:37
