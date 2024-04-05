-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: timetablev2j
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buildings` (
  `building_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buildings`
--

LOCK TABLES `buildings` WRITE;
/*!40000 ALTER TABLE `buildings` DISABLE KEYS */;
INSERT INTO `buildings` VALUES (1,'SMHS','2023-10-10 00:26:00','2023-10-10 00:26:00');
/*!40000 ALTER TABLE `buildings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cohorts`
--

DROP TABLE IF EXISTS `cohorts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cohorts` (
  `cohort_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `program_id` int(10) unsigned NOT NULL,
  `student_count` int(11) NOT NULL DEFAULT 0,
  `status` enum('INSESSION','NOTINSESSION') NOT NULL DEFAULT 'NOTINSESSION',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cohort_id`),
  UNIQUE KEY `cohorts_program_id_code_unique` (`program_id`,`code`),
  CONSTRAINT `cohorts_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cohorts`
--

LOCK TABLES `cohorts` WRITE;
/*!40000 ALTER TABLE `cohorts` DISABLE KEYS */;
INSERT INTO `cohorts` VALUES (1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,105,'INSESSION','2023-10-09 23:42:28','2023-10-10 01:24:28'),(2,'PHAM Year 1 Semester 2','PHAM-Y1-S2',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(3,'PHAM Year 1 Semester 3','PHAM-Y1-S3',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(4,'PHAM Year 2 Semester 1','PHAM-Y2-S1',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(5,'PHAM Year 2 Semester 2','PHAM-Y2-S2',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(6,'PHAM Year 2 Semester 3','PHAM-Y2-S3',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(7,'PHAM Year 3 Semester 1','PHAM-Y3-S1',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(8,'PHAM Year 3 Semester 2','PHAM-Y3-S2',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(9,'PHAM Year 3 Semester 3','PHAM-Y3-S3',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(10,'PHAM Year 4 Semester 1','PHAM-Y4-S1',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(11,'PHAM Year 4 Semester 2','PHAM-Y4-S2',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(12,'PHAM Year 4 Semester 3','PHAM-Y4-S3',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(13,'PHAM Year 5 Semester 1','PHAM-Y5-S1',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(14,'PHAM Year 5 Semester 2','PHAM-Y5-S2',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28'),(15,'PHAM Year 5 Semester 3','PHAM-Y5-S3',1,0,'NOTINSESSION','2023-10-09 23:42:28','2023-10-09 23:42:28');
/*!40000 ALTER TABLE `cohorts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `department_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `school_id` int(10) unsigned NOT NULL,
  `hod_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`department_id`),
  KEY `departments_school_id_foreign` (`school_id`),
  KEY `departments_hod_id_foreign` (`hod_id`),
  CONSTRAINT `departments_hod_id_foreign` FOREIGN KEY (`hod_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `departments_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`school_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'Pharmacology & Pharmacognosy',1,6,'2023-10-09 23:45:12','2023-10-09 23:45:12'),(2,'Preclinicals',1,7,'2023-10-09 23:45:38','2023-10-09 23:45:38'),(4,'Pharmaceutical Chemistry & Pharmaceutics',1,8,'2023-10-09 23:46:00','2023-10-09 23:46:00'),(5,'Biomedical Sciences',1,26,'2023-10-09 23:46:36','2023-10-09 23:46:36'),(6,'SSET',1,27,'2023-10-09 23:46:58','2023-10-09 23:46:58');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `student_count` int(10) unsigned NOT NULL DEFAULT 0,
  `cohort_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `groups_cohort_id_name_unique` (`cohort_id`,`name`),
  CONSTRAINT `groups_cohort_id_foreign` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`cohort_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'A',53,1,'2023-10-10 01:24:28','2023-10-10 01:24:28'),(2,'B',53,1,'2023-10-10 01:24:28','2023-10-10 01:24:28');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `groups_view`
--

DROP TABLE IF EXISTS `groups_view`;
/*!50001 DROP VIEW IF EXISTS `groups_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `groups_view` AS SELECT
 1 AS `group_id`,
  1 AS `group_name`,
  1 AS `student_count`,
  1 AS `cohort_id`,
  1 AS `cohort_name`,
  1 AS `program_id`,
  1 AS `school_id` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `labs`
--

DROP TABLE IF EXISTS `labs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `labs` (
  `lab_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lab_name` varchar(255) NOT NULL,
  `lab_type` int(10) unsigned NOT NULL,
  `building_id` int(10) unsigned NOT NULL,
  `lab_capacity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`lab_id`),
  KEY `labs_lab_type_foreign` (`lab_type`),
  KEY `labs_building_id_foreign` (`building_id`),
  CONSTRAINT `labs_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`) ON DELETE CASCADE,
  CONSTRAINT `labs_lab_type_foreign` FOREIGN KEY (`lab_type`) REFERENCES `labtypes` (`labtype_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `labs`
--

LOCK TABLES `labs` WRITE;
/*!40000 ALTER TABLE `labs` DISABLE KEYS */;
INSERT INTO `labs` VALUES (1,'Chemistry Lab 1',5,1,65,'2023-10-10 00:26:20','2023-10-10 00:26:20'),(2,'Chemistry Lab 2',5,1,65,'2023-10-10 00:26:35','2023-10-10 00:26:35'),(3,'Anatomy Lab',2,1,65,'2023-10-10 00:26:52','2023-10-10 00:26:52'),(4,'Physiology Lab',1,1,65,'2023-10-10 00:27:16','2023-10-10 00:27:16'),(5,'Pharmacology Lab',3,1,65,'2023-10-10 00:27:50','2023-10-10 00:27:50'),(6,'Biochemistry Lab',4,1,65,'2023-10-10 00:28:25','2023-10-10 00:28:25'),(7,'Microbiology Lab',6,1,65,'2023-10-10 00:28:48','2023-10-10 00:28:48'),(8,'Pathology Lab',7,1,65,'2023-10-10 00:29:18','2023-10-10 00:29:18'),(9,'Pharmaceutical Chemistry Lab',8,1,65,'2023-10-10 00:29:53','2023-10-10 00:29:53'),(10,'Pharmaceutics Lab',9,1,65,'2023-10-10 00:30:46','2023-10-10 00:30:46'),(11,'Pharmacognosy Lab',10,1,65,'2023-10-10 00:31:38','2023-10-10 00:31:38');
/*!40000 ALTER TABLE `labs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `labs_view`
--

DROP TABLE IF EXISTS `labs_view`;
/*!50001 DROP VIEW IF EXISTS `labs_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `labs_view` AS SELECT
 1 AS `lab_id`,
  1 AS `lab_name`,
  1 AS `lab_capacity`,
  1 AS `lab_type`,
  1 AS `name`,
  1 AS `school_id`,
  1 AS `created_at` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `labtypes`
--

DROP TABLE IF EXISTS `labtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `labtypes` (
  `labtype_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`labtype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `labtypes`
--

LOCK TABLES `labtypes` WRITE;
/*!40000 ALTER TABLE `labtypes` DISABLE KEYS */;
INSERT INTO `labtypes` VALUES (1,'Physiology Labs','2023-10-10 00:16:58','2023-10-10 00:16:58'),(2,'Anatomy Labs','2023-10-10 00:22:46','2023-10-10 00:22:46'),(3,'Pharmacology Labs','2023-10-10 00:22:54','2023-10-10 00:22:54'),(4,'Biochemistry Labs','2023-10-10 00:23:00','2023-10-10 00:23:00'),(5,'Chemistry Labs','2023-10-10 00:23:07','2023-10-10 00:23:07'),(6,'Microbiology Labs','2023-10-10 00:23:13','2023-10-10 00:23:13'),(7,'Pathology Labs','2023-10-10 00:23:45','2023-10-10 00:23:45'),(8,'Pharmaceutical Chemistry Labs','2023-10-10 00:24:01','2023-10-10 00:24:01'),(9,'Pharmaceutics Labs','2023-10-10 00:24:11','2023-10-10 00:24:11'),(10,'Pharmacognosy Labs','2023-10-10 00:24:45','2023-10-10 00:24:45');
/*!40000 ALTER TABLE `labtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecture_rooms`
--

DROP TABLE IF EXISTS `lecture_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecture_rooms` (
  `lecture_room_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lecture_room_name` varchar(255) NOT NULL,
  `building_id` int(10) unsigned NOT NULL,
  `lecture_room_capacity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`lecture_room_id`),
  KEY `lecture_rooms_building_id_foreign` (`building_id`),
  CONSTRAINT `lecture_rooms_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecture_rooms`
--

LOCK TABLES `lecture_rooms` WRITE;
/*!40000 ALTER TABLE `lecture_rooms` DISABLE KEYS */;
INSERT INTO `lecture_rooms` VALUES (1,'GF L5',1,70,'2023-10-10 00:34:54','2023-10-10 00:34:54'),(2,'GF L9',1,70,'2023-10-10 00:35:11','2023-10-10 00:35:11'),(3,'GF L8',1,70,'2023-10-10 00:35:31','2023-10-10 00:35:31'),(4,'GF L4',1,70,'2023-10-10 00:35:57','2023-10-10 00:35:57'),(5,'GF L11',1,70,'2023-10-10 00:36:30','2023-10-10 00:36:30'),(6,'GF L6',1,70,'2023-10-10 00:36:52','2023-10-10 00:36:52'),(7,'GF L7',1,70,'2023-10-10 00:37:41','2023-10-10 00:37:41'),(8,'GF L10',1,70,'2023-10-10 00:38:07','2023-10-10 00:38:07');
/*!40000 ALTER TABLE `lecture_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturer_preferred_times`
--

DROP TABLE IF EXISTS `lecturer_preferred_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecturer_preferred_times` (
  `lecturer_preferred_time_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(10) unsigned NOT NULL,
  `day` int(10) unsigned NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`lecturer_preferred_time_id`),
  KEY `lecturer_preferred_times_lecturer_id_foreign` (`lecturer_id`),
  CONSTRAINT `lecturer_preferred_times_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturer_preferred_times`
--

LOCK TABLES `lecturer_preferred_times` WRITE;
/*!40000 ALTER TABLE `lecturer_preferred_times` DISABLE KEYS */;
INSERT INTO `lecturer_preferred_times` VALUES (1,4,2,'07:00:00','10:00:00','2023-10-09 23:47:57','2023-10-09 23:47:57'),(2,4,2,'10:00:00','13:00:00','2023-10-09 23:47:57','2023-10-09 23:47:57'),(3,4,2,'13:00:00','16:00:00','2023-10-09 23:47:58','2023-10-09 23:47:58'),(4,4,2,'16:00:00','19:00:00','2023-10-09 23:47:58','2023-10-09 23:47:58'),(5,5,1,'07:00:00','10:00:00','2023-10-09 23:48:24','2023-10-09 23:48:24'),(6,5,2,'07:00:00','10:00:00','2023-10-09 23:48:24','2023-10-09 23:48:24'),(7,5,3,'07:00:00','10:00:00','2023-10-09 23:48:24','2023-10-09 23:48:24'),(8,5,4,'07:00:00','10:00:00','2023-10-09 23:48:24','2023-10-09 23:48:24'),(9,5,5,'07:00:00','10:00:00','2023-10-09 23:48:24','2023-10-09 23:48:24'),(17,6,1,'07:00:00','10:00:00','2023-10-09 23:49:50','2023-10-09 23:49:50'),(18,6,1,'10:00:00','13:00:00','2023-10-09 23:49:50','2023-10-09 23:49:50'),(19,6,1,'13:00:00','16:00:00','2023-10-09 23:49:50','2023-10-09 23:49:50'),(20,6,1,'16:00:00','19:00:00','2023-10-09 23:49:50','2023-10-09 23:49:50'),(21,6,2,'07:00:00','10:00:00','2023-10-09 23:49:50','2023-10-09 23:49:50'),(22,6,2,'10:00:00','13:00:00','2023-10-09 23:49:50','2023-10-09 23:49:50'),(23,6,2,'13:00:00','16:00:00','2023-10-09 23:49:50','2023-10-09 23:49:50'),(24,6,2,'16:00:00','19:00:00','2023-10-09 23:49:50','2023-10-09 23:49:50'),(25,7,2,'07:00:00','10:00:00','2023-10-09 23:50:12','2023-10-09 23:50:12'),(26,7,2,'10:00:00','13:00:00','2023-10-09 23:50:12','2023-10-09 23:50:12'),(27,7,2,'13:00:00','16:00:00','2023-10-09 23:50:12','2023-10-09 23:50:12'),(28,7,2,'16:00:00','19:00:00','2023-10-09 23:50:12','2023-10-09 23:50:12'),(29,7,3,'07:00:00','10:00:00','2023-10-09 23:50:12','2023-10-09 23:50:12'),(30,7,3,'13:00:00','16:00:00','2023-10-09 23:50:12','2023-10-09 23:50:12'),(31,7,3,'16:00:00','19:00:00','2023-10-09 23:50:12','2023-10-09 23:50:12'),(32,8,2,'07:00:00','10:00:00','2023-10-09 23:50:39','2023-10-09 23:50:39'),(33,8,2,'10:00:00','13:00:00','2023-10-09 23:50:39','2023-10-09 23:50:39'),(34,8,2,'13:00:00','16:00:00','2023-10-09 23:50:39','2023-10-09 23:50:39'),(35,8,2,'16:00:00','19:00:00','2023-10-09 23:50:39','2023-10-09 23:50:39'),(36,8,3,'07:00:00','10:00:00','2023-10-09 23:50:39','2023-10-09 23:50:39'),(37,8,3,'13:00:00','16:00:00','2023-10-09 23:50:39','2023-10-09 23:50:39'),(38,8,3,'16:00:00','19:00:00','2023-10-09 23:50:39','2023-10-09 23:50:39'),(39,9,1,'07:00:00','10:00:00','2023-10-09 23:50:59','2023-10-09 23:50:59'),(40,9,1,'10:00:00','13:00:00','2023-10-09 23:50:59','2023-10-09 23:50:59'),(41,9,1,'13:00:00','16:00:00','2023-10-09 23:50:59','2023-10-09 23:50:59'),(42,9,1,'16:00:00','19:00:00','2023-10-09 23:50:59','2023-10-09 23:50:59'),(43,9,2,'07:00:00','10:00:00','2023-10-09 23:50:59','2023-10-09 23:50:59'),(44,9,2,'10:00:00','13:00:00','2023-10-09 23:50:59','2023-10-09 23:50:59'),(45,9,2,'13:00:00','16:00:00','2023-10-09 23:50:59','2023-10-09 23:50:59'),(46,9,2,'16:00:00','19:00:00','2023-10-09 23:50:59','2023-10-09 23:50:59'),(47,10,1,'07:00:00','10:00:00','2023-10-09 23:51:22','2023-10-09 23:51:22'),(48,10,1,'10:00:00','13:00:00','2023-10-09 23:51:22','2023-10-09 23:51:22'),(49,10,1,'13:00:00','16:00:00','2023-10-09 23:51:22','2023-10-09 23:51:22'),(50,10,1,'16:00:00','19:00:00','2023-10-09 23:51:22','2023-10-09 23:51:22'),(51,10,2,'07:00:00','10:00:00','2023-10-09 23:51:22','2023-10-09 23:51:22'),(52,10,2,'10:00:00','13:00:00','2023-10-09 23:51:22','2023-10-09 23:51:22'),(53,10,2,'13:00:00','16:00:00','2023-10-09 23:51:22','2023-10-09 23:51:22'),(54,10,2,'16:00:00','19:00:00','2023-10-09 23:51:22','2023-10-09 23:51:22'),(55,11,3,'07:00:00','10:00:00','2023-10-09 23:51:45','2023-10-09 23:51:45'),(56,11,3,'13:00:00','16:00:00','2023-10-09 23:51:45','2023-10-09 23:51:45'),(57,11,3,'16:00:00','19:00:00','2023-10-09 23:51:45','2023-10-09 23:51:45'),(58,11,4,'07:00:00','10:00:00','2023-10-09 23:51:45','2023-10-09 23:51:45'),(59,11,4,'10:00:00','13:00:00','2023-10-09 23:51:45','2023-10-09 23:51:45'),(60,11,4,'13:00:00','16:00:00','2023-10-09 23:51:45','2023-10-09 23:51:45'),(61,11,4,'16:00:00','19:00:00','2023-10-09 23:51:45','2023-10-09 23:51:45'),(62,12,3,'07:00:00','10:00:00','2023-10-09 23:52:22','2023-10-09 23:52:22'),(63,12,3,'13:00:00','16:00:00','2023-10-09 23:52:22','2023-10-09 23:52:22'),(64,12,3,'16:00:00','19:00:00','2023-10-09 23:52:22','2023-10-09 23:52:22'),(65,12,5,'07:00:00','10:00:00','2023-10-09 23:52:22','2023-10-09 23:52:22'),(66,12,5,'10:00:00','13:00:00','2023-10-09 23:52:22','2023-10-09 23:52:22'),(67,12,5,'13:00:00','16:00:00','2023-10-09 23:52:22','2023-10-09 23:52:22'),(68,12,5,'16:00:00','19:00:00','2023-10-09 23:52:22','2023-10-09 23:52:22'),(69,13,4,'07:00:00','10:00:00','2023-10-09 23:52:46','2023-10-09 23:52:46'),(70,13,4,'10:00:00','13:00:00','2023-10-09 23:52:46','2023-10-09 23:52:46'),(71,13,4,'13:00:00','16:00:00','2023-10-09 23:52:46','2023-10-09 23:52:46'),(72,13,4,'16:00:00','19:00:00','2023-10-09 23:52:46','2023-10-09 23:52:46'),(73,13,5,'07:00:00','10:00:00','2023-10-09 23:52:46','2023-10-09 23:52:46'),(74,13,5,'10:00:00','13:00:00','2023-10-09 23:52:46','2023-10-09 23:52:46'),(75,13,5,'13:00:00','16:00:00','2023-10-09 23:52:46','2023-10-09 23:52:46'),(76,13,5,'16:00:00','19:00:00','2023-10-09 23:52:46','2023-10-09 23:52:46'),(77,14,1,'07:00:00','10:00:00','2023-10-09 23:53:18','2023-10-09 23:53:18'),(78,14,1,'10:00:00','13:00:00','2023-10-09 23:53:18','2023-10-09 23:53:18'),(79,14,1,'13:00:00','16:00:00','2023-10-09 23:53:18','2023-10-09 23:53:18'),(80,14,1,'16:00:00','19:00:00','2023-10-09 23:53:18','2023-10-09 23:53:18'),(81,14,2,'07:00:00','10:00:00','2023-10-09 23:53:18','2023-10-09 23:53:18'),(82,14,2,'10:00:00','13:00:00','2023-10-09 23:53:18','2023-10-09 23:53:18'),(83,14,2,'13:00:00','16:00:00','2023-10-09 23:53:18','2023-10-09 23:53:18'),(84,14,2,'16:00:00','19:00:00','2023-10-09 23:53:18','2023-10-09 23:53:18'),(85,14,3,'07:00:00','10:00:00','2023-10-09 23:53:18','2023-10-09 23:53:18'),(86,14,3,'13:00:00','16:00:00','2023-10-09 23:53:18','2023-10-09 23:53:18'),(87,14,3,'16:00:00','19:00:00','2023-10-09 23:53:18','2023-10-09 23:53:18'),(88,15,1,'07:00:00','10:00:00','2023-10-09 23:53:38','2023-10-09 23:53:38'),(89,15,1,'10:00:00','13:00:00','2023-10-09 23:53:38','2023-10-09 23:53:38'),(90,15,1,'13:00:00','16:00:00','2023-10-09 23:53:38','2023-10-09 23:53:38'),(91,15,1,'16:00:00','19:00:00','2023-10-09 23:53:38','2023-10-09 23:53:38'),(92,15,4,'07:00:00','10:00:00','2023-10-09 23:53:38','2023-10-09 23:53:38'),(93,15,4,'10:00:00','13:00:00','2023-10-09 23:53:38','2023-10-09 23:53:38'),(94,15,4,'13:00:00','16:00:00','2023-10-09 23:53:38','2023-10-09 23:53:38'),(95,15,4,'16:00:00','19:00:00','2023-10-09 23:53:38','2023-10-09 23:53:38'),(96,16,1,'07:00:00','10:00:00','2023-10-09 23:54:14','2023-10-09 23:54:14'),(97,16,1,'10:00:00','13:00:00','2023-10-09 23:54:14','2023-10-09 23:54:14'),(98,16,1,'13:00:00','16:00:00','2023-10-09 23:54:14','2023-10-09 23:54:14'),(99,16,1,'16:00:00','19:00:00','2023-10-09 23:54:14','2023-10-09 23:54:14'),(100,16,2,'07:00:00','10:00:00','2023-10-09 23:54:14','2023-10-09 23:54:14'),(101,16,2,'10:00:00','13:00:00','2023-10-09 23:54:14','2023-10-09 23:54:14'),(102,16,2,'13:00:00','16:00:00','2023-10-09 23:54:14','2023-10-09 23:54:14'),(103,16,2,'16:00:00','19:00:00','2023-10-09 23:54:14','2023-10-09 23:54:14'),(104,16,3,'07:00:00','10:00:00','2023-10-09 23:54:14','2023-10-09 23:54:14'),(105,17,4,'07:00:00','10:00:00','2023-10-09 23:54:35','2023-10-09 23:54:35'),(106,17,4,'10:00:00','13:00:00','2023-10-09 23:54:35','2023-10-09 23:54:35'),(107,17,4,'13:00:00','16:00:00','2023-10-09 23:54:35','2023-10-09 23:54:35'),(108,17,4,'16:00:00','19:00:00','2023-10-09 23:54:35','2023-10-09 23:54:35'),(109,17,5,'07:00:00','10:00:00','2023-10-09 23:54:35','2023-10-09 23:54:35'),(110,17,5,'10:00:00','13:00:00','2023-10-09 23:54:35','2023-10-09 23:54:35'),(111,17,5,'13:00:00','16:00:00','2023-10-09 23:54:35','2023-10-09 23:54:35'),(112,17,5,'16:00:00','19:00:00','2023-10-09 23:54:35','2023-10-09 23:54:35'),(113,18,2,'07:00:00','10:00:00','2023-10-09 23:54:52','2023-10-09 23:54:52'),(114,18,2,'10:00:00','13:00:00','2023-10-09 23:54:52','2023-10-09 23:54:52'),(115,18,2,'13:00:00','16:00:00','2023-10-09 23:54:52','2023-10-09 23:54:52'),(116,18,2,'16:00:00','19:00:00','2023-10-09 23:54:52','2023-10-09 23:54:52'),(117,22,4,'07:00:00','10:00:00','2023-10-09 23:55:27','2023-10-09 23:55:27'),(118,22,4,'10:00:00','13:00:00','2023-10-09 23:55:27','2023-10-09 23:55:27'),(119,22,4,'13:00:00','16:00:00','2023-10-09 23:55:27','2023-10-09 23:55:27'),(120,22,4,'16:00:00','19:00:00','2023-10-09 23:55:27','2023-10-09 23:55:27'),(121,22,5,'07:00:00','10:00:00','2023-10-09 23:55:27','2023-10-09 23:55:27'),(122,22,5,'10:00:00','13:00:00','2023-10-09 23:55:27','2023-10-09 23:55:27'),(123,22,5,'13:00:00','16:00:00','2023-10-09 23:55:27','2023-10-09 23:55:27'),(124,22,5,'16:00:00','19:00:00','2023-10-09 23:55:27','2023-10-09 23:55:27'),(125,23,1,'07:00:00','10:00:00','2023-10-09 23:55:44','2023-10-09 23:55:44'),(126,23,1,'10:00:00','13:00:00','2023-10-09 23:55:44','2023-10-09 23:55:44'),(127,23,1,'13:00:00','16:00:00','2023-10-09 23:55:44','2023-10-09 23:55:44'),(128,23,1,'16:00:00','19:00:00','2023-10-09 23:55:44','2023-10-09 23:55:44'),(129,24,2,'07:00:00','10:00:00','2023-10-09 23:56:29','2023-10-09 23:56:29'),(130,24,2,'10:00:00','13:00:00','2023-10-09 23:56:29','2023-10-09 23:56:29'),(131,24,2,'13:00:00','16:00:00','2023-10-09 23:56:29','2023-10-09 23:56:29'),(132,24,2,'16:00:00','19:00:00','2023-10-09 23:56:29','2023-10-09 23:56:29'),(133,25,3,'07:00:00','10:00:00','2023-10-09 23:57:23','2023-10-09 23:57:23'),(134,25,3,'13:00:00','16:00:00','2023-10-09 23:57:23','2023-10-09 23:57:23'),(135,25,3,'16:00:00','19:00:00','2023-10-09 23:57:23','2023-10-09 23:57:23'),(136,20,1,'07:00:00','10:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(137,20,1,'10:00:00','13:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(138,20,1,'13:00:00','16:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(139,20,1,'16:00:00','19:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(140,20,2,'07:00:00','10:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(141,20,2,'10:00:00','13:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(142,20,2,'13:00:00','16:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(143,20,2,'16:00:00','19:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(144,20,3,'07:00:00','10:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(145,20,3,'13:00:00','16:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(146,20,3,'16:00:00','19:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(147,20,4,'07:00:00','10:00:00','2023-10-10 00:00:27','2023-10-10 00:00:27'),(148,29,1,'07:00:00','10:00:00','2023-10-10 00:01:29','2023-10-10 00:01:29'),(149,29,1,'10:00:00','13:00:00','2023-10-10 00:01:29','2023-10-10 00:01:29'),(150,29,1,'13:00:00','16:00:00','2023-10-10 00:01:29','2023-10-10 00:01:29'),(151,29,1,'16:00:00','19:00:00','2023-10-10 00:01:29','2023-10-10 00:01:29'),(152,34,5,'07:00:00','10:00:00','2023-10-10 00:01:48','2023-10-10 00:01:48'),(153,34,5,'10:00:00','13:00:00','2023-10-10 00:01:48','2023-10-10 00:01:48'),(154,34,5,'13:00:00','16:00:00','2023-10-10 00:01:48','2023-10-10 00:01:48'),(155,34,5,'16:00:00','19:00:00','2023-10-10 00:01:48','2023-10-10 00:01:48'),(156,35,5,'07:00:00','10:00:00','2023-10-10 00:02:22','2023-10-10 00:02:22'),(157,35,5,'10:00:00','13:00:00','2023-10-10 00:02:23','2023-10-10 00:02:23'),(158,35,5,'13:00:00','16:00:00','2023-10-10 00:02:23','2023-10-10 00:02:23'),(159,35,5,'16:00:00','19:00:00','2023-10-10 00:02:23','2023-10-10 00:02:23'),(160,36,4,'07:00:00','10:00:00','2023-10-10 00:02:58','2023-10-10 00:02:58'),(161,36,4,'10:00:00','13:00:00','2023-10-10 00:02:58','2023-10-10 00:02:58'),(162,36,4,'13:00:00','16:00:00','2023-10-10 00:02:58','2023-10-10 00:02:58'),(163,36,4,'16:00:00','19:00:00','2023-10-10 00:02:58','2023-10-10 00:02:58'),(164,37,3,'13:00:00','16:00:00','2023-10-10 00:03:16','2023-10-10 00:03:16'),(165,37,3,'16:00:00','19:00:00','2023-10-10 00:03:16','2023-10-10 00:03:16'),(166,38,1,'07:00:00','10:00:00','2023-10-10 00:03:34','2023-10-10 00:03:34'),(167,38,1,'10:00:00','13:00:00','2023-10-10 00:03:34','2023-10-10 00:03:34'),(168,38,1,'13:00:00','16:00:00','2023-10-10 00:03:34','2023-10-10 00:03:34'),(169,38,1,'16:00:00','19:00:00','2023-10-10 00:03:34','2023-10-10 00:03:34'),(170,39,4,'07:00:00','10:00:00','2023-10-10 00:03:57','2023-10-10 00:03:57'),(171,39,4,'10:00:00','13:00:00','2023-10-10 00:03:57','2023-10-10 00:03:57'),(172,39,4,'13:00:00','16:00:00','2023-10-10 00:03:57','2023-10-10 00:03:57'),(173,39,4,'16:00:00','19:00:00','2023-10-10 00:03:57','2023-10-10 00:03:57'),(174,40,5,'07:00:00','10:00:00','2023-10-10 00:04:16','2023-10-10 00:04:16'),(175,40,5,'10:00:00','13:00:00','2023-10-10 00:04:16','2023-10-10 00:04:16'),(176,40,5,'13:00:00','16:00:00','2023-10-10 00:04:16','2023-10-10 00:04:16'),(177,40,5,'16:00:00','19:00:00','2023-10-10 00:04:16','2023-10-10 00:04:16'),(178,41,5,'07:00:00','10:00:00','2023-10-10 00:04:30','2023-10-10 00:04:30'),(179,41,5,'10:00:00','13:00:00','2023-10-10 00:04:31','2023-10-10 00:04:31'),(180,41,5,'13:00:00','16:00:00','2023-10-10 00:04:31','2023-10-10 00:04:31'),(181,41,5,'16:00:00','19:00:00','2023-10-10 00:04:31','2023-10-10 00:04:31'),(182,43,2,'07:00:00','10:00:00','2023-10-10 00:04:55','2023-10-10 00:04:55'),(183,43,2,'10:00:00','13:00:00','2023-10-10 00:04:55','2023-10-10 00:04:55'),(184,43,2,'13:00:00','16:00:00','2023-10-10 00:04:55','2023-10-10 00:04:55'),(185,43,2,'16:00:00','19:00:00','2023-10-10 00:04:55','2023-10-10 00:04:55'),(186,44,5,'07:00:00','10:00:00','2023-10-10 00:05:22','2023-10-10 00:05:22'),(187,44,5,'10:00:00','13:00:00','2023-10-10 00:05:22','2023-10-10 00:05:22'),(188,44,5,'13:00:00','16:00:00','2023-10-10 00:05:22','2023-10-10 00:05:22'),(189,44,5,'16:00:00','19:00:00','2023-10-10 00:05:22','2023-10-10 00:05:22'),(190,45,4,'07:00:00','10:00:00','2023-10-10 00:05:57','2023-10-10 00:05:57'),(191,45,4,'10:00:00','13:00:00','2023-10-10 00:05:57','2023-10-10 00:05:57'),(192,45,4,'13:00:00','16:00:00','2023-10-10 00:05:57','2023-10-10 00:05:57'),(193,45,4,'16:00:00','19:00:00','2023-10-10 00:05:57','2023-10-10 00:05:57');
/*!40000 ALTER TABLE `lecturer_preferred_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `lecturerooms_view`
--

DROP TABLE IF EXISTS `lecturerooms_view`;
/*!50001 DROP VIEW IF EXISTS `lecturerooms_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `lecturerooms_view` AS SELECT
 1 AS `lecture_room_id`,
  1 AS `lecture_room_name`,
  1 AS `lecture_room_capacity`,
  1 AS `name`,
  1 AS `school_id`,
  1 AS `created_at` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `lecturers_view`
--

DROP TABLE IF EXISTS `lecturers_view`;
/*!50001 DROP VIEW IF EXISTS `lecturers_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `lecturers_view` AS SELECT
 1 AS `user_id`,
  1 AS `title`,
  1 AS `lecturer_name`,
  1 AS `email`,
  1 AS `created_at` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_08_18_105004_add_roles_to_users_table',1),(6,'2023_08_23_002450_create_schools_table',1),(7,'2023_08_23_103133_create_departments_table',1),(8,'2023_08_23_120318_create_buildings_table',1),(9,'2023_08_23_130357_create_labtypes_table',1),(10,'2023_08_23_134259_create_labs_table',1),(11,'2023_08_23_140322_create_lecture_rooms_table',1),(12,'2023_08_23_175918_create_school_buildings_table',1),(13,'2023_08_25_003620_create_programs_table',1),(14,'2023_08_25_062735_create_school_periods_table',1),(15,'2023_08_26_082518_create_school_lecturers_table',1),(16,'2023_09_04_162752_create_cohorts_table',1),(17,'2023_09_06_050415_create_units_table',1),(18,'2023_09_06_051019_create_unit_lecturers_table',1),(19,'2023_09_06_053043_create_lecturer_preferred_times_table',1),(20,'2023_09_09_222537_create_unit_preferences_table',1),(21,'2023_09_09_223027_create_unit_preferred_rooms_table',1),(22,'2023_09_09_223038_create_unit_preferred_periods_table',1),(23,'2023_09_10_020108_create_unit_preferred_labs_table',1),(24,'2023_09_10_105610_create_unit_assingments_table',1),(25,'2023_09_12_004906_create_groups_table',1),(26,'2023_09_13_163025_create_timetable_instances_table',1),(27,'2023_09_14_002412_create_labs_view',1),(28,'2023_09_14_002433_create_lecturerooms_view',1),(29,'2023_09_14_010237_create_sessions_view',1),(30,'2023_09_14_014752_create_programs_view',1),(31,'2023_09_14_020040_create_schools_view',1),(32,'2023_09_14_020315_create_lecturers_view',1),(33,'2023_09_16_210203_create_groups_view',1),(34,'2023_09_17_025717_create_jobs_table',1),(35,'2023_09_24_045442_create_unit_preferred_times_view',1),(36,'2023_09_24_045450_create_unit_preferred_rooms_view',1),(37,'2023_09_24_050207_create_unit_preferred_labs_view',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programs` (
  `program_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `academic_years` int(11) NOT NULL,
  `semesters` int(11) NOT NULL,
  `max_group_size` int(11) NOT NULL,
  `school_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`program_id`),
  KEY `programs_school_id_foreign` (`school_id`),
  CONSTRAINT `programs_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`school_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programs`
--

LOCK TABLES `programs` WRITE;
/*!40000 ALTER TABLE `programs` DISABLE KEYS */;
INSERT INTO `programs` VALUES (1,'Bachelor of Pharmacy','PHAM',5,3,60,1,'2023-10-09 23:42:27','2023-10-09 23:42:27');
/*!40000 ALTER TABLE `programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `programs_view`
--

DROP TABLE IF EXISTS `programs_view`;
/*!50001 DROP VIEW IF EXISTS `programs_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `programs_view` AS SELECT
 1 AS `program_id`,
  1 AS `program_name`,
  1 AS `program_code`,
  1 AS `school_id`,
  1 AS `created_at` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `school_buildings`
--

DROP TABLE IF EXISTS `school_buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_buildings` (
  `school_building_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(10) unsigned NOT NULL,
  `building_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`school_building_id`),
  KEY `school_buildings_school_id_foreign` (`school_id`),
  KEY `school_buildings_building_id_foreign` (`building_id`),
  CONSTRAINT `school_buildings_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`) ON DELETE CASCADE,
  CONSTRAINT `school_buildings_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`school_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_buildings`
--

LOCK TABLES `school_buildings` WRITE;
/*!40000 ALTER TABLE `school_buildings` DISABLE KEYS */;
INSERT INTO `school_buildings` VALUES (1,1,1,'2023-10-10 00:27:58','2023-10-10 00:27:58');
/*!40000 ALTER TABLE `school_buildings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_lecturers`
--

DROP TABLE IF EXISTS `school_lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_lecturers` (
  `school_lecturer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(10) unsigned NOT NULL,
  `lecturer_id` int(10) unsigned NOT NULL,
  `department_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`school_lecturer_id`),
  KEY `school_lecturers_school_id_foreign` (`school_id`),
  KEY `school_lecturers_lecturer_id_foreign` (`lecturer_id`),
  KEY `school_lecturers_department_id_foreign` (`department_id`),
  CONSTRAINT `school_lecturers_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE SET NULL,
  CONSTRAINT `school_lecturers_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `school_lecturers_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`school_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_lecturers`
--

LOCK TABLES `school_lecturers` WRITE;
/*!40000 ALTER TABLE `school_lecturers` DISABLE KEYS */;
INSERT INTO `school_lecturers` VALUES (1,1,4,NULL,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(2,1,40,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(3,1,43,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(4,1,35,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(5,1,31,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(6,1,17,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(7,1,27,6,'2023-10-09 23:43:41','2023-10-09 23:46:58'),(8,1,5,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(9,1,15,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(10,1,39,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(11,1,44,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(12,1,32,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(13,1,42,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(14,1,20,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(15,1,41,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(16,1,9,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(17,1,38,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(18,1,28,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(19,1,30,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(20,1,8,4,'2023-10-09 23:43:41','2023-10-09 23:46:00'),(21,1,23,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(22,1,12,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(23,1,37,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(24,1,18,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(25,1,7,NULL,'2023-10-09 23:43:41','2023-10-09 23:45:39'),(26,1,19,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(27,1,26,5,'2023-10-09 23:43:41','2023-10-09 23:46:36'),(28,1,14,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(29,1,24,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(30,1,25,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(31,1,6,1,'2023-10-09 23:43:41','2023-10-09 23:45:12'),(32,1,36,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(33,1,21,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(35,1,10,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(36,1,16,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(37,1,29,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(38,1,45,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(39,1,11,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(40,1,13,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(41,1,34,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(42,1,33,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41'),(43,1,22,NULL,'2023-10-09 23:43:41','2023-10-09 23:43:41');
/*!40000 ALTER TABLE `school_lecturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_periods`
--

DROP TABLE IF EXISTS `school_periods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_periods` (
  `school_period_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `school_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`school_period_id`),
  KEY `school_periods_school_id_foreign` (`school_id`),
  CONSTRAINT `school_periods_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`school_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_periods`
--

LOCK TABLES `school_periods` WRITE;
/*!40000 ALTER TABLE `school_periods` DISABLE KEYS */;
INSERT INTO `school_periods` VALUES (1,'Monday','07:00:00','09:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(2,'Monday','09:00:00','11:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(3,'Monday','11:00:00','13:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(4,'Monday','14:00:00','16:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(5,'Monday','16:00:00','18:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(6,'Tuesday','07:00:00','09:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(7,'Tuesday','09:00:00','11:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(8,'Tuesday','11:00:00','13:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(9,'Tuesday','14:00:00','16:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(10,'Tuesday','16:00:00','18:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(11,'Wednesday','07:00:00','09:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(12,'Wednesday','09:00:00','11:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(13,'Wednesday','14:00:00','16:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(14,'Wednesday','16:00:00','18:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(15,'Thursday','07:00:00','09:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(16,'Thursday','09:00:00','11:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(17,'Thursday','11:00:00','13:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(18,'Thursday','14:00:00','16:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(19,'Thursday','16:00:00','18:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(20,'Friday','07:00:00','09:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(21,'Friday','09:00:00','11:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(22,'Friday','11:00:00','13:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(23,'Friday','14:00:00','16:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50'),(24,'Friday','16:00:00','18:00:00',1,'2023-10-09 23:41:50','2023-10-09 23:41:50');
/*!40000 ALTER TABLE `school_periods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schools` (
  `school_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `dean_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`school_id`),
  UNIQUE KEY `schools_slug_unique` (`slug`),
  KEY `schools_dean_id_foreign` (`dean_id`),
  CONSTRAINT `schools_dean_id_foreign` FOREIGN KEY (`dean_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schools`
--

LOCK TABLES `schools` WRITE;
/*!40000 ALTER TABLE `schools` DISABLE KEYS */;
INSERT INTO `schools` VALUES (1,'School Of Pharmacy','SOP',4,'2023-10-09 23:41:50','2023-10-09 23:41:50');
/*!40000 ALTER TABLE `schools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `schools_view`
--

DROP TABLE IF EXISTS `schools_view`;
/*!50001 DROP VIEW IF EXISTS `schools_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `schools_view` AS SELECT
 1 AS `school_id`,
  1 AS `school_name`,
  1 AS `school_slug`,
  1 AS `created_at` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `sessions_view`
--

DROP TABLE IF EXISTS `sessions_view`;
/*!50001 DROP VIEW IF EXISTS `sessions_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `sessions_view` AS SELECT
 1 AS `unit_assingment_id`,
  1 AS `unit_id`,
  1 AS `unit_name`,
  1 AS `unit_code`,
  1 AS `department_id`,
  1 AS `has_lab`,
  1 AS `labtype_id`,
  1 AS `lab_alternative`,
  1 AS `lecturer_hours`,
  1 AS `lab_hours`,
  1 AS `is_full_day`,
  1 AS `lecturer_id`,
  1 AS `cohort_id`,
  1 AS `cohort_name`,
  1 AS `cohort_code`,
  1 AS `program_id`,
  1 AS `group_id`,
  1 AS `group_name`,
  1 AS `student_count`,
  1 AS `created_at` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `timetable_instances`
--

DROP TABLE IF EXISTS `timetable_instances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timetable_instances` (
  `timetable_instance_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'queued' COMMENT 'Generating, Done, queued',
  `table_prefix` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`timetable_instance_id`),
  UNIQUE KEY `timetable_instances_table_prefix_unique` (`table_prefix`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timetable_instances`
--

LOCK TABLES `timetable_instances` WRITE;
/*!40000 ALTER TABLE `timetable_instances` DISABLE KEYS */;
INSERT INTO `timetable_instances` VALUES (1,'Current Year 1 sem 1','Done','tt_instance_1','2023-10-11 09:31:19','2023-10-11 09:32:00');
/*!40000 ALTER TABLE `timetable_instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_group_schema`
--

DROP TABLE IF EXISTS `tt_instance_1_group_schema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_group_schema` (
  `schema_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `lecturer_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `lectureroom_id` int(11) DEFAULT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`schema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_group_schema`
--

LOCK TABLES `tt_instance_1_group_schema` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_group_schema` DISABLE KEYS */;
INSERT INTO `tt_instance_1_group_schema` VALUES (1,1,NULL,NULL,NULL,NULL,'Monday','07:00:00','08:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(2,1,NULL,NULL,NULL,NULL,'Monday','08:00:00','09:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(3,1,NULL,NULL,NULL,NULL,'Monday','09:00:00','10:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(4,1,NULL,NULL,NULL,NULL,'Monday','10:00:00','11:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(5,1,NULL,NULL,NULL,NULL,'Monday','11:00:00','12:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(6,1,NULL,NULL,NULL,NULL,'Monday','12:00:00','13:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(7,1,NULL,NULL,NULL,NULL,'Monday','14:00:00','15:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(8,1,NULL,NULL,NULL,NULL,'Monday','15:00:00','16:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(9,1,NULL,NULL,NULL,NULL,'Monday','16:00:00','17:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(10,1,NULL,NULL,NULL,NULL,'Monday','17:00:00','18:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(11,1,14,3,2,NULL,'Tuesday','07:00:00','08:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(12,1,14,3,2,NULL,'Tuesday','08:00:00','09:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(13,1,NULL,NULL,NULL,NULL,'Tuesday','09:00:00','10:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(14,1,NULL,NULL,NULL,NULL,'Tuesday','10:00:00','11:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(15,1,7,7,1,NULL,'Tuesday','11:00:00','12:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(16,1,7,7,1,NULL,'Tuesday','12:00:00','13:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(17,1,NULL,NULL,NULL,NULL,'Tuesday','14:00:00','15:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(18,1,7,8,NULL,6,'Tuesday','15:00:00','16:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(19,1,7,8,NULL,6,'Tuesday','16:00:00','17:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(20,1,NULL,NULL,NULL,NULL,'Tuesday','17:00:00','18:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(21,1,5,11,1,NULL,'Wednesday','07:00:00','08:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(22,1,5,11,1,NULL,'Wednesday','08:00:00','09:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(23,1,NULL,NULL,NULL,NULL,'Wednesday','09:00:00','10:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(24,1,NULL,NULL,NULL,NULL,'Wednesday','10:00:00','11:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(25,1,NULL,NULL,NULL,NULL,'Wednesday','14:00:00','15:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(26,1,NULL,NULL,NULL,NULL,'Wednesday','15:00:00','16:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(27,1,NULL,NULL,NULL,NULL,'Wednesday','16:00:00','17:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(28,1,NULL,NULL,NULL,NULL,'Wednesday','17:00:00','18:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(29,1,NULL,NULL,NULL,NULL,'Thursday','07:00:00','08:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(30,1,NULL,NULL,NULL,NULL,'Thursday','08:00:00','09:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(31,1,NULL,NULL,NULL,NULL,'Thursday','09:00:00','10:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(32,1,NULL,NULL,NULL,NULL,'Thursday','10:00:00','11:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(33,1,17,19,1,NULL,'Thursday','11:00:00','12:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(34,1,17,19,1,NULL,'Thursday','12:00:00','13:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(35,1,NULL,NULL,NULL,NULL,'Thursday','14:00:00','15:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(36,1,NULL,NULL,NULL,NULL,'Thursday','15:00:00','16:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(37,1,NULL,NULL,NULL,NULL,'Thursday','16:00:00','17:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(38,1,NULL,NULL,NULL,NULL,'Thursday','17:00:00','18:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(39,1,NULL,NULL,NULL,NULL,'Friday','07:00:00','08:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(40,1,NULL,NULL,NULL,NULL,'Friday','08:00:00','09:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(41,1,NULL,NULL,NULL,NULL,'Friday','09:00:00','10:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(42,1,NULL,NULL,NULL,NULL,'Friday','10:00:00','11:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(43,1,NULL,NULL,NULL,NULL,'Friday','11:00:00','12:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(44,1,NULL,NULL,NULL,NULL,'Friday','12:00:00','13:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(45,1,NULL,NULL,NULL,NULL,'Friday','14:00:00','15:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(46,1,34,15,2,NULL,'Friday','15:00:00','16:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(47,1,34,15,2,NULL,'Friday','16:00:00','17:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(48,1,NULL,NULL,NULL,NULL,'Friday','17:00:00','18:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(49,2,NULL,NULL,NULL,NULL,'Monday','07:00:00','08:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(50,2,NULL,NULL,NULL,NULL,'Monday','08:00:00','09:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(51,2,NULL,NULL,NULL,NULL,'Monday','09:00:00','10:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(52,2,NULL,NULL,NULL,NULL,'Monday','10:00:00','11:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(53,2,NULL,NULL,NULL,NULL,'Monday','11:00:00','12:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(54,2,NULL,NULL,NULL,NULL,'Monday','12:00:00','13:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(55,2,NULL,NULL,NULL,NULL,'Monday','14:00:00','15:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(56,2,NULL,NULL,NULL,NULL,'Monday','15:00:00','16:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(57,2,NULL,NULL,NULL,NULL,'Monday','16:00:00','17:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(58,2,NULL,NULL,NULL,NULL,'Monday','17:00:00','18:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(59,2,5,13,1,NULL,'Tuesday','07:00:00','08:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(60,2,5,13,1,NULL,'Tuesday','08:00:00','09:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(61,2,7,9,1,NULL,'Tuesday','09:00:00','10:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(62,2,7,9,1,NULL,'Tuesday','10:00:00','11:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(63,2,NULL,NULL,NULL,NULL,'Tuesday','11:00:00','12:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(64,2,NULL,NULL,NULL,NULL,'Tuesday','12:00:00','13:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(65,2,NULL,NULL,NULL,NULL,'Tuesday','14:00:00','15:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(66,2,NULL,NULL,NULL,NULL,'Tuesday','15:00:00','16:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(67,2,14,5,1,NULL,'Tuesday','16:00:00','17:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(68,2,14,5,1,NULL,'Tuesday','17:00:00','18:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(69,2,NULL,NULL,NULL,NULL,'Wednesday','07:00:00','08:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(70,2,NULL,NULL,NULL,NULL,'Wednesday','08:00:00','09:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(71,2,NULL,NULL,NULL,NULL,'Wednesday','09:00:00','10:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(72,2,NULL,NULL,NULL,NULL,'Wednesday','10:00:00','11:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(73,2,7,10,NULL,6,'Wednesday','14:00:00','15:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(74,2,7,10,NULL,6,'Wednesday','15:00:00','16:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(75,2,NULL,NULL,NULL,NULL,'Wednesday','16:00:00','17:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(76,2,NULL,NULL,NULL,NULL,'Wednesday','17:00:00','18:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(77,2,NULL,NULL,NULL,NULL,'Thursday','07:00:00','08:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(78,2,NULL,NULL,NULL,NULL,'Thursday','08:00:00','09:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(79,2,NULL,NULL,NULL,NULL,'Thursday','09:00:00','10:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(80,2,NULL,NULL,NULL,NULL,'Thursday','10:00:00','11:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(81,2,NULL,NULL,NULL,NULL,'Thursday','11:00:00','12:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(82,2,NULL,NULL,NULL,NULL,'Thursday','12:00:00','13:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(83,2,NULL,NULL,NULL,NULL,'Thursday','14:00:00','15:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(84,2,NULL,NULL,NULL,NULL,'Thursday','15:00:00','16:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(85,2,NULL,NULL,NULL,NULL,'Thursday','16:00:00','17:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(86,2,NULL,NULL,NULL,NULL,'Thursday','17:00:00','18:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(87,2,34,17,1,NULL,'Friday','07:00:00','08:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(88,2,34,17,1,NULL,'Friday','08:00:00','09:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(89,2,NULL,NULL,NULL,NULL,'Friday','09:00:00','10:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(90,2,NULL,NULL,NULL,NULL,'Friday','10:00:00','11:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(91,2,NULL,NULL,NULL,NULL,'Friday','11:00:00','12:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(92,2,NULL,NULL,NULL,NULL,'Friday','12:00:00','13:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(93,2,NULL,NULL,NULL,NULL,'Friday','14:00:00','15:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(94,2,17,21,1,NULL,'Friday','15:00:00','16:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(95,2,17,21,1,NULL,'Friday','16:00:00','17:00:00',1,'2023-10-11 09:31:59','2023-10-11 09:31:59'),(96,2,NULL,NULL,NULL,NULL,'Friday','17:00:00','18:00:00',0,'2023-10-11 09:31:59','2023-10-11 09:31:59');
/*!40000 ALTER TABLE `tt_instance_1_group_schema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_groups`
--

DROP TABLE IF EXISTS `tt_instance_1_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `student_count` int(11) NOT NULL,
  `cohort_id` int(11) NOT NULL,
  `cohort_name` varchar(255) NOT NULL,
  `program_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_groups`
--

LOCK TABLES `tt_instance_1_groups` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_groups` DISABLE KEYS */;
INSERT INTO `tt_instance_1_groups` VALUES (1,1,'A',53,1,'PHAM Year 1 Semester 1',1,1,'2023-10-11 09:31:21','2023-10-11 09:31:21'),(2,2,'B',53,1,'PHAM Year 1 Semester 1',1,1,'2023-10-11 09:31:21','2023-10-11 09:31:21');
/*!40000 ALTER TABLE `tt_instance_1_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_labs`
--

DROP TABLE IF EXISTS `tt_instance_1_labs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_labs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lab_id` int(11) NOT NULL,
  `lab_name` varchar(255) NOT NULL,
  `lab_capacity` int(11) NOT NULL,
  `lab_type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `school_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_labs`
--

LOCK TABLES `tt_instance_1_labs` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_labs` DISABLE KEYS */;
INSERT INTO `tt_instance_1_labs` VALUES (1,1,'Chemistry Lab 1',65,5,'SMHS',1,'2023-10-11 09:31:21','2023-10-11 09:31:21'),(2,2,'Chemistry Lab 2',65,5,'SMHS',1,'2023-10-11 09:31:21','2023-10-11 09:31:21'),(3,3,'Anatomy Lab',65,2,'SMHS',1,'2023-10-11 09:31:21','2023-10-11 09:31:21'),(4,4,'Physiology Lab',65,1,'SMHS',1,'2023-10-11 09:31:21','2023-10-11 09:31:21'),(5,5,'Pharmacology Lab',65,3,'SMHS',1,'2023-10-11 09:31:21','2023-10-11 09:31:21'),(6,6,'Biochemistry Lab',65,4,'SMHS',1,'2023-10-11 09:31:21','2023-10-11 09:31:21'),(7,7,'Microbiology Lab',65,6,'SMHS',1,'2023-10-11 09:31:21','2023-10-11 09:31:21'),(8,8,'Pathology Lab',65,7,'SMHS',1,'2023-10-11 09:31:21','2023-10-11 09:31:21'),(9,9,'Pharmaceutical Chemistry Lab',65,8,'SMHS',1,'2023-10-11 09:31:21','2023-10-11 09:31:21'),(10,10,'Pharmaceutics Lab',65,9,'SMHS',1,'2023-10-11 09:31:21','2023-10-11 09:31:21'),(11,11,'Pharmacognosy Lab',65,10,'SMHS',1,'2023-10-11 09:31:21','2023-10-11 09:31:21');
/*!40000 ALTER TABLE `tt_instance_1_labs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_lecturer_preferred_times`
--

DROP TABLE IF EXISTS `tt_instance_1_lecturer_preferred_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_lecturer_preferred_times` (
  `lecturer_preferred_time_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) NOT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`lecturer_preferred_time_id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_lecturer_preferred_times`
--

LOCK TABLES `tt_instance_1_lecturer_preferred_times` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_lecturer_preferred_times` DISABLE KEYS */;
INSERT INTO `tt_instance_1_lecturer_preferred_times` VALUES (1,4,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(2,4,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(3,4,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(4,4,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(5,5,'Monday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(6,5,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(7,5,'Wednesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(8,5,'Thursday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(9,5,'Friday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(10,6,'Monday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(11,6,'Monday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(12,6,'Monday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(13,6,'Monday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(14,6,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(15,6,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(16,6,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(17,6,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(18,7,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(19,7,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(20,7,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(21,7,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(22,7,'Wednesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(23,7,'Wednesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(24,7,'Wednesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(25,8,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(26,8,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(27,8,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(28,8,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(29,8,'Wednesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(30,8,'Wednesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(31,8,'Wednesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(32,9,'Monday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(33,9,'Monday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(34,9,'Monday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(35,9,'Monday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(36,9,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(37,9,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(38,9,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(39,9,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(40,10,'Monday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(41,10,'Monday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(42,10,'Monday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(43,10,'Monday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(44,10,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(45,10,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(46,10,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(47,10,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(48,11,'Wednesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(49,11,'Wednesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(50,11,'Wednesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(51,11,'Thursday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(52,11,'Thursday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(53,11,'Thursday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(54,11,'Thursday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(55,12,'Wednesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(56,12,'Wednesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(57,12,'Wednesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(58,12,'Friday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(59,12,'Friday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(60,12,'Friday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(61,12,'Friday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(62,13,'Thursday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(63,13,'Thursday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(64,13,'Thursday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(65,13,'Thursday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(66,13,'Friday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(67,13,'Friday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(68,13,'Friday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(69,13,'Friday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(70,14,'Monday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(71,14,'Monday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(72,14,'Monday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(73,14,'Monday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(74,14,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(75,14,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(76,14,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(77,14,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(78,14,'Wednesday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(79,14,'Wednesday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(80,14,'Wednesday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(81,15,'Monday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(82,15,'Monday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(83,15,'Monday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(84,15,'Monday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(85,15,'Thursday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(86,15,'Thursday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(87,15,'Thursday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(88,15,'Thursday','16:00:00','19:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(89,16,'Monday','07:00:00','10:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(90,16,'Monday','10:00:00','13:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(91,16,'Monday','13:00:00','16:00:00','2023-10-11 09:31:21','2023-10-11 09:31:21'),(92,16,'Monday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(93,16,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(94,16,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(95,16,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(96,16,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(97,16,'Wednesday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(98,17,'Thursday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(99,17,'Thursday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(100,17,'Thursday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(101,17,'Thursday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(102,17,'Friday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(103,17,'Friday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(104,17,'Friday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(105,17,'Friday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(106,18,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(107,18,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(108,18,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(109,18,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(110,22,'Thursday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(111,22,'Thursday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(112,22,'Thursday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(113,22,'Thursday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(114,22,'Friday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(115,22,'Friday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(116,22,'Friday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(117,22,'Friday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(118,23,'Monday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(119,23,'Monday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(120,23,'Monday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(121,23,'Monday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(122,24,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(123,24,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(124,24,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(125,24,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(126,25,'Wednesday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(127,25,'Wednesday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(128,25,'Wednesday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(129,20,'Monday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(130,20,'Monday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(131,20,'Monday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(132,20,'Monday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(133,20,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(134,20,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(135,20,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(136,20,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(137,20,'Wednesday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(138,20,'Wednesday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(139,20,'Wednesday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(140,20,'Thursday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(141,29,'Monday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(142,29,'Monday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(143,29,'Monday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(144,29,'Monday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(145,34,'Friday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(146,34,'Friday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(147,34,'Friday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(148,34,'Friday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(149,35,'Friday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(150,35,'Friday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(151,35,'Friday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(152,35,'Friday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(153,36,'Thursday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(154,36,'Thursday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(155,36,'Thursday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(156,36,'Thursday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(157,37,'Wednesday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(158,37,'Wednesday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(159,38,'Monday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(160,38,'Monday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(161,38,'Monday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(162,38,'Monday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(163,39,'Thursday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(164,39,'Thursday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(165,39,'Thursday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(166,39,'Thursday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(167,40,'Friday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(168,40,'Friday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(169,40,'Friday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(170,40,'Friday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(171,41,'Friday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(172,41,'Friday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(173,41,'Friday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(174,41,'Friday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(175,43,'Tuesday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(176,43,'Tuesday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(177,43,'Tuesday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(178,43,'Tuesday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(179,44,'Friday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(180,44,'Friday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(181,44,'Friday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(182,44,'Friday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(183,45,'Thursday','07:00:00','10:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(184,45,'Thursday','10:00:00','13:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(185,45,'Thursday','13:00:00','16:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22'),(186,45,'Thursday','16:00:00','19:00:00','2023-10-11 09:31:22','2023-10-11 09:31:22');
/*!40000 ALTER TABLE `tt_instance_1_lecturer_preferred_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_lecturerooms`
--

DROP TABLE IF EXISTS `tt_instance_1_lecturerooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_lecturerooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lecture_room_id` int(11) NOT NULL,
  `lecture_room_name` varchar(255) NOT NULL,
  `lecture_room_capacity` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `school_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_lecturerooms`
--

LOCK TABLES `tt_instance_1_lecturerooms` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_lecturerooms` DISABLE KEYS */;
INSERT INTO `tt_instance_1_lecturerooms` VALUES (1,1,'GF L5',70,'SMHS',1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(2,2,'GF L9',70,'SMHS',1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(3,3,'GF L8',70,'SMHS',1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(4,4,'GF L4',70,'SMHS',1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(5,5,'GF L11',70,'SMHS',1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(6,6,'GF L6',70,'SMHS',1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(7,7,'GF L7',70,'SMHS',1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(8,8,'GF L10',70,'SMHS',1,'2023-10-11 09:31:23','2023-10-11 09:31:23');
/*!40000 ALTER TABLE `tt_instance_1_lecturerooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_lecturers`
--

DROP TABLE IF EXISTS `tt_instance_1_lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_lecturers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `lecturer_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_lecturers`
--

LOCK TABLES `tt_instance_1_lecturers` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_lecturers` DISABLE KEYS */;
INSERT INTO `tt_instance_1_lecturers` VALUES (1,5,'Dr.','Edwin Akumu','oakumu@kabarak.ac.ke','2023-10-11 09:31:21','2023-10-11 09:31:21'),(2,7,'Ms.','Mary Murithii','mmurithii@kabarak.ac.ke','2023-10-11 09:31:21','2023-10-11 09:31:21'),(3,14,'Dr.','Nahashon Gichana Akunga','nakunga@kabarak.ac.ke','2023-10-11 09:31:21','2023-10-11 09:31:21'),(4,17,'Dr.','Caroline Chepkirui ','chepkiruicaroline@kabarak.ac.ke','2023-10-11 09:31:21','2023-10-11 09:31:21'),(5,28,'Mr.','Jeremiah Bundotich','jbundotich@kabarak.ac.ke','2023-10-11 09:31:21','2023-10-11 09:31:21'),(6,34,'Mr.','Walter Rono','wkrono@kabarak.ac.ke','2023-10-11 09:31:21','2023-10-11 09:31:21');
/*!40000 ALTER TABLE `tt_instance_1_lecturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_programs`
--

DROP TABLE IF EXISTS `tt_instance_1_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_programs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `program_id` int(11) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `program_code` varchar(255) NOT NULL,
  `school_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_programs`
--

LOCK TABLES `tt_instance_1_programs` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_programs` DISABLE KEYS */;
INSERT INTO `tt_instance_1_programs` VALUES (1,1,'Bachelor of Pharmacy','PHAM',1,'2023-10-11 09:31:21','2023-10-11 09:31:21');
/*!40000 ALTER TABLE `tt_instance_1_programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_schools`
--

DROP TABLE IF EXISTS `tt_instance_1_schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_schools` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `school_slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_schools`
--

LOCK TABLES `tt_instance_1_schools` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_schools` DISABLE KEYS */;
INSERT INTO `tt_instance_1_schools` VALUES (1,1,'School Of Pharmacy','SOP','2023-10-11 09:31:21','2023-10-11 09:31:21');
/*!40000 ALTER TABLE `tt_instance_1_schools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_sessions`
--

DROP TABLE IF EXISTS `tt_instance_1_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_assingment_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `unit_code` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `is_lab` tinyint(1) NOT NULL,
  `labtype_id` int(11) DEFAULT NULL,
  `lab_alternative` tinyint(1) DEFAULT NULL,
  `lecturer_hours` int(11) NOT NULL,
  `lab_hours` int(11) DEFAULT NULL,
  `is_full_day` tinyint(1) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `cohort_id` int(11) NOT NULL,
  `cohort_name` varchar(255) NOT NULL,
  `cohort_code` varchar(255) NOT NULL,
  `program_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `student_count` int(11) NOT NULL,
  `is_assigned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_sessions`
--

LOCK TABLES `tt_instance_1_sessions` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_sessions` DISABLE KEYS */;
INSERT INTO `tt_instance_1_sessions` VALUES (1,1,1,'Mathematics for Pharmacy I','SCPH 1111',6,0,NULL,0,3,0,0,28,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,1,'A',53,0,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(2,1,1,'Mathematics for Pharmacy I','SCPH 1111',6,0,NULL,0,3,0,0,28,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,2,'B',53,0,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(3,2,2,'Medical Physiology I','SCPH 1141',5,0,1,0,2,3,0,14,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,1,'A',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(4,2,2,'Medical Physiology I','SCPH 1141',5,1,1,0,0,3,0,14,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,1,'A',53,0,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(5,2,2,'Medical Physiology I','SCPH 1141',5,0,1,0,2,3,0,14,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,2,'B',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(6,2,2,'Medical Physiology I','SCPH 1141',5,1,1,0,0,3,0,14,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,2,'B',53,0,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(7,3,3,'Biochemistry I','SCPH 1131',5,0,4,0,2,2,0,7,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,1,'A',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(8,3,3,'Biochemistry I','SCPH 1131',5,1,4,0,0,2,0,7,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,1,'A',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(9,3,3,'Biochemistry I','SCPH 1131',5,0,4,0,2,2,0,7,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,2,'B',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(10,3,3,'Biochemistry I','SCPH 1131',5,1,4,0,0,2,0,7,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,2,'B',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(11,4,4,'Inorganic Chemistry I','SCPH 1123',5,0,5,0,2,3,0,5,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,1,'A',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(12,4,4,'Inorganic Chemistry I','SCPH 1123',5,1,5,0,0,3,0,5,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,1,'A',53,0,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(13,4,4,'Inorganic Chemistry I','SCPH 1123',5,0,5,0,2,3,0,5,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,2,'B',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(14,4,4,'Inorganic Chemistry I','SCPH 1123',5,1,5,0,0,3,0,5,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,2,'B',53,0,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(15,5,5,'Human Anatomy I (Gross Anatomy)','SCPH 1151',2,0,2,0,2,4,0,34,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,1,'A',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(16,5,5,'Human Anatomy I (Gross Anatomy)','SCPH 1151',2,1,2,0,0,4,0,34,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,1,'A',53,0,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(17,5,5,'Human Anatomy I (Gross Anatomy)','SCPH 1151',2,0,2,0,2,4,0,34,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,2,'B',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(18,5,5,'Human Anatomy I (Gross Anatomy)','SCPH 1151',2,1,2,0,0,4,0,34,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,2,'B',53,0,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(19,6,6,'Physical Chemistry I','SCPH 1122',4,0,5,0,2,3,0,17,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,1,'A',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(20,6,6,'Physical Chemistry I','SCPH 1122',4,1,5,0,0,3,0,17,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,1,'A',53,0,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(21,6,6,'Physical Chemistry I','SCPH 1122',4,0,5,0,2,3,0,17,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,2,'B',53,1,'2023-10-11 09:31:23','2023-10-11 09:31:23'),(22,6,6,'Physical Chemistry I','SCPH 1122',4,1,5,0,0,3,0,17,1,'PHAM Year 1 Semester 1','PHAM-Y1-S1',1,2,'B',53,0,'2023-10-11 09:31:23','2023-10-11 09:31:23');
/*!40000 ALTER TABLE `tt_instance_1_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_unit_preferred_times`
--

DROP TABLE IF EXISTS `tt_instance_1_unit_preferred_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_unit_preferred_times` (
  `unit_preferred_time_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unit_preferred_time_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_unit_preferred_times`
--

LOCK TABLES `tt_instance_1_unit_preferred_times` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_unit_preferred_times` DISABLE KEYS */;
/*!40000 ALTER TABLE `tt_instance_1_unit_preferred_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_unit_preffered_labs`
--

DROP TABLE IF EXISTS `tt_instance_1_unit_preffered_labs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_unit_preffered_labs` (
  `unit_preffered_lab_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unit_preffered_lab_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_unit_preffered_labs`
--

LOCK TABLES `tt_instance_1_unit_preffered_labs` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_unit_preffered_labs` DISABLE KEYS */;
/*!40000 ALTER TABLE `tt_instance_1_unit_preffered_labs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_instance_1_unit_preffered_rooms`
--

DROP TABLE IF EXISTS `tt_instance_1_unit_preffered_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_instance_1_unit_preffered_rooms` (
  `unit_preffered_room_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `lecture_room_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unit_preffered_room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_instance_1_unit_preffered_rooms`
--

LOCK TABLES `tt_instance_1_unit_preffered_rooms` WRITE;
/*!40000 ALTER TABLE `tt_instance_1_unit_preffered_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `tt_instance_1_unit_preffered_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_assingments`
--

DROP TABLE IF EXISTS `unit_assingments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_assingments` (
  `unit_assingment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` int(10) unsigned NOT NULL,
  `lecturer_id` int(10) unsigned NOT NULL,
  `cohort_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unit_assingment_id`),
  KEY `unit_assingments_unit_id_foreign` (`unit_id`),
  KEY `unit_assingments_lecturer_id_foreign` (`lecturer_id`),
  KEY `unit_assingments_cohort_id_foreign` (`cohort_id`),
  CONSTRAINT `unit_assingments_cohort_id_foreign` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`cohort_id`) ON DELETE CASCADE,
  CONSTRAINT `unit_assingments_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `unit_assingments_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_assingments`
--

LOCK TABLES `unit_assingments` WRITE;
/*!40000 ALTER TABLE `unit_assingments` DISABLE KEYS */;
INSERT INTO `unit_assingments` VALUES (1,1,28,1,'2023-10-10 00:45:06','2023-10-10 00:45:06'),(2,2,14,1,'2023-10-10 00:51:02','2023-10-10 00:51:02'),(3,3,7,1,'2023-10-10 00:53:35','2023-10-10 00:53:35'),(4,4,5,1,'2023-10-10 01:23:52','2023-10-10 01:23:52'),(5,5,34,1,'2023-10-10 01:26:23','2023-10-10 01:26:23'),(6,6,17,1,'2023-10-10 02:19:34','2023-10-10 02:19:34');
/*!40000 ALTER TABLE `unit_assingments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_lecturers`
--

DROP TABLE IF EXISTS `unit_lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_lecturers` (
  `unit_lecturer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` int(10) unsigned NOT NULL,
  `lecturer_id` int(10) unsigned DEFAULT NULL,
  `cohort_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unit_lecturer_id`),
  UNIQUE KEY `unit_lecturers_unit_id_lecturer_id_cohort_id_unique` (`unit_id`,`lecturer_id`,`cohort_id`),
  KEY `unit_lecturers_lecturer_id_foreign` (`lecturer_id`),
  KEY `unit_lecturers_cohort_id_foreign` (`cohort_id`),
  CONSTRAINT `unit_lecturers_cohort_id_foreign` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`cohort_id`) ON DELETE CASCADE,
  CONSTRAINT `unit_lecturers_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `unit_lecturers_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_lecturers`
--

LOCK TABLES `unit_lecturers` WRITE;
/*!40000 ALTER TABLE `unit_lecturers` DISABLE KEYS */;
/*!40000 ALTER TABLE `unit_lecturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_preferences`
--

DROP TABLE IF EXISTS `unit_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_preferences` (
  `unit_preference_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unit_preference_id`),
  KEY `unit_preferences_unit_id_foreign` (`unit_id`),
  CONSTRAINT `unit_preferences_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_preferences`
--

LOCK TABLES `unit_preferences` WRITE;
/*!40000 ALTER TABLE `unit_preferences` DISABLE KEYS */;
/*!40000 ALTER TABLE `unit_preferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_preferred_labs`
--

DROP TABLE IF EXISTS `unit_preferred_labs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_preferred_labs` (
  `unit_preferred_lab_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_preference_id` int(10) unsigned NOT NULL,
  `lab_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unit_preferred_lab_id`),
  KEY `unit_preferred_labs_unit_preference_id_foreign` (`unit_preference_id`),
  KEY `unit_preferred_labs_lab_id_foreign` (`lab_id`),
  CONSTRAINT `unit_preferred_labs_lab_id_foreign` FOREIGN KEY (`lab_id`) REFERENCES `labs` (`lab_id`) ON DELETE CASCADE,
  CONSTRAINT `unit_preferred_labs_unit_preference_id_foreign` FOREIGN KEY (`unit_preference_id`) REFERENCES `unit_preferences` (`unit_preference_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_preferred_labs`
--

LOCK TABLES `unit_preferred_labs` WRITE;
/*!40000 ALTER TABLE `unit_preferred_labs` DISABLE KEYS */;
/*!40000 ALTER TABLE `unit_preferred_labs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `unit_preferred_labs_view`
--

DROP TABLE IF EXISTS `unit_preferred_labs_view`;
/*!50001 DROP VIEW IF EXISTS `unit_preferred_labs_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `unit_preferred_labs_view` AS SELECT
 1 AS `unit_id`,
  1 AS `lab_id` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `unit_preferred_periods`
--

DROP TABLE IF EXISTS `unit_preferred_periods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_preferred_periods` (
  `unit_preferred_period_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_preference_id` int(10) unsigned NOT NULL,
  `school_period_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unit_preferred_period_id`),
  KEY `unit_preferred_periods_unit_preference_id_foreign` (`unit_preference_id`),
  KEY `unit_preferred_periods_school_period_id_foreign` (`school_period_id`),
  CONSTRAINT `unit_preferred_periods_school_period_id_foreign` FOREIGN KEY (`school_period_id`) REFERENCES `school_periods` (`school_period_id`) ON DELETE CASCADE,
  CONSTRAINT `unit_preferred_periods_unit_preference_id_foreign` FOREIGN KEY (`unit_preference_id`) REFERENCES `unit_preferences` (`unit_preference_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_preferred_periods`
--

LOCK TABLES `unit_preferred_periods` WRITE;
/*!40000 ALTER TABLE `unit_preferred_periods` DISABLE KEYS */;
/*!40000 ALTER TABLE `unit_preferred_periods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_preferred_rooms`
--

DROP TABLE IF EXISTS `unit_preferred_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_preferred_rooms` (
  `unit_preferred_room_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_preference_id` int(10) unsigned NOT NULL,
  `lecture_room_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unit_preferred_room_id`),
  KEY `unit_preferred_rooms_unit_preference_id_foreign` (`unit_preference_id`),
  KEY `unit_preferred_rooms_lecture_room_id_foreign` (`lecture_room_id`),
  CONSTRAINT `unit_preferred_rooms_lecture_room_id_foreign` FOREIGN KEY (`lecture_room_id`) REFERENCES `lecture_rooms` (`lecture_room_id`) ON DELETE CASCADE,
  CONSTRAINT `unit_preferred_rooms_unit_preference_id_foreign` FOREIGN KEY (`unit_preference_id`) REFERENCES `unit_preferences` (`unit_preference_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_preferred_rooms`
--

LOCK TABLES `unit_preferred_rooms` WRITE;
/*!40000 ALTER TABLE `unit_preferred_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `unit_preferred_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `unit_preferred_rooms_view`
--

DROP TABLE IF EXISTS `unit_preferred_rooms_view`;
/*!50001 DROP VIEW IF EXISTS `unit_preferred_rooms_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `unit_preferred_rooms_view` AS SELECT
 1 AS `unit_id`,
  1 AS `lecture_room_id` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `unit_preferred_times_view`
--

DROP TABLE IF EXISTS `unit_preferred_times_view`;
/*!50001 DROP VIEW IF EXISTS `unit_preferred_times_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `unit_preferred_times_view` AS SELECT
 1 AS `unit_id`,
  1 AS `day_of_week`,
  1 AS `start_time`,
  1 AS `end_time` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `unit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `department_id` int(10) unsigned NOT NULL,
  `has_lab` tinyint(1) NOT NULL DEFAULT 0,
  `labtype_id` int(10) unsigned DEFAULT NULL,
  `lab_alternative` tinyint(1) NOT NULL DEFAULT 0,
  `lecturer_hours` int(10) unsigned NOT NULL DEFAULT 0,
  `lab_hours` int(10) unsigned NOT NULL DEFAULT 0,
  `is_full_day` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unit_id`),
  UNIQUE KEY `units_name_department_id_unique` (`name`,`department_id`),
  UNIQUE KEY `units_code_unique` (`code`),
  KEY `units_department_id_foreign` (`department_id`),
  KEY `units_labtype_id_foreign` (`labtype_id`),
  CONSTRAINT `units_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE,
  CONSTRAINT `units_labtype_id_foreign` FOREIGN KEY (`labtype_id`) REFERENCES `labtypes` (`labtype_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'Mathematics for Pharmacy I','SCPH 1111',6,0,NULL,0,3,0,0,'2023-10-10 00:44:48','2023-10-10 00:44:48'),(2,'Medical Physiology I','SCPH 1141',5,1,1,0,2,3,0,'2023-10-10 00:50:25','2023-10-10 00:50:25'),(3,'Biochemistry I','SCPH 1131',5,1,4,0,2,2,0,'2023-10-10 00:52:17','2023-10-10 00:52:17'),(4,'Inorganic Chemistry I','SCPH 1123',5,1,5,0,2,3,0,'2023-10-10 00:55:22','2023-10-10 00:55:22'),(5,'Human Anatomy I (Gross Anatomy)','SCPH 1151',2,1,2,0,2,4,0,'2023-10-10 01:25:41','2023-10-10 01:25:41'),(6,'Physical Chemistry I','SCPH 1122',4,1,5,0,2,3,0,'2023-10-10 02:19:12','2023-10-10 02:19:12');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'USER' COMMENT 'USER,ADMIN, LECTURER, HEAD OF DEPARTMENT, DEAN',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Eng','Samuel Uzima','samueluzima@kabarak.ac.ke',NULL,'$2y$10$ymKLqrjJ7sEFxcIE8vEzw.jNvxsXIC/k5qfQjva80jEwmPLqKyXii','ADMIN',NULL,'2023-10-09 23:29:58','2023-10-09 23:29:58'),(2,'Eng','Captain David','nsaruni@kabarak.ac.ke',NULL,'$2y$10$epzhUGiRTqLaSyV2B8AUr.rT6YkAyGZaVmOar6np.CP3MOL29JxSm','ADMIN',NULL,'2023-10-09 23:29:58','2023-10-09 23:29:58'),(3,'Eng','Samuel Uzima','uzimasamuel1@gmail.com',NULL,'$2y$10$Vm4NwPPCTPskB247yrWwh.FREkQUK.GYKQhaf2rSWBQjeMrq8BSwe','USER',NULL,'2023-10-09 23:29:58','2023-10-09 23:44:21'),(4,'Dr.','Titus Suge','sugetitus@kabarak.ac.ke',NULL,'$2y$10$o/QvvA01Na6SbOdPCaYIteVt1A2up.pUMzdZZ/1KSUNlEHMK.9oQK','DEAN',NULL,'2023-10-09 23:29:59','2023-10-09 23:41:50'),(5,'Dr.','Edwin Akumu','oakumu@kabarak.ac.ke',NULL,'$2y$10$4gFu5nFZcBRkTY8NPXG7nuARBFWGwqsDJA72dCkbtSha6Av.Gu/g6','LECTURER',NULL,'2023-10-09 23:29:59','2023-10-09 23:29:59'),(6,'Dr.','Richard Kagia','rkagia@kabarak.ac.ke',NULL,'$2y$10$WC2paYcBgxRXmDuqb5kYvuBNkED.6VvTFuBAcc2kQTfX08n86eb4W','HEAD OF DEPARTMENT',NULL,'2023-10-09 23:29:59','2023-10-09 23:45:12'),(7,'Ms.','Mary Murithii','mmurithii@kabarak.ac.ke',NULL,'$2y$10$LNkFtnIJR7WtUWcoMHLQ4On6ccG7oV7K/ZkEuA/8l97pCb90XHbs.','HEAD OF DEPARTMENT',NULL,'2023-10-09 23:29:59','2023-10-09 23:45:38'),(8,'Dr.','Jim Amisi','jamisi@kabarak.ac.ke',NULL,'$2y$10$TuY/.lY8g.QmIDxHmKQ/0ec74/xEWTcewihz9jTxty16lUkxtf1cq','HEAD OF DEPARTMENT',NULL,'2023-10-09 23:29:59','2023-10-09 23:46:00'),(9,'Dr.','James Meroka','jonsinyo@kabarak.ac.ke',NULL,'$2y$10$Jw.nVyFFiNCU5BXHruxuAOuZFRhrfHN3ptVh0GLUHbu6JK/4ihG5q','LECTURER',NULL,'2023-10-09 23:29:59','2023-10-09 23:29:59'),(10,'Dr.','Sarah Vugigi','svugigi@kabarak.ac.ke',NULL,'$2y$10$BylYalfPYogz00W8Yg6YeOK32KZl16RKkssHzVPJaA8zynsFjSghC','LECTURER',NULL,'2023-10-09 23:29:59','2023-10-09 23:29:59'),(11,'Dr.','Vincent Nyandoro','vnyandoro@kabarak.ac.ke',NULL,'$2y$10$BbXLwvOwxqQpQqpno/qvbek/x9OBU/Q1wnZ2GjCotobzgwxFHoOFa','LECTURER',NULL,'2023-10-09 23:29:59','2023-10-09 23:29:59'),(12,'Dr.','Kelvin Manyega','kelvinmanyega@kabarak.ac.ke',NULL,'$2y$10$47mCIIVktVuKRWfRBZVq/OEqUKWbH8i/bdntcz2dCqiMNxSMsn002','LECTURER',NULL,'2023-10-09 23:29:59','2023-10-09 23:29:59'),(13,'Dr.','Wairimu Karaihira','wkaraihira@kabarak.ac.ke',NULL,'$2y$10$NwmIA3reg/fqa.jr.6UBEOMLVxjxP4.CuWNgPwzJihR9djSGzmugi','LECTURER',NULL,'2023-10-09 23:29:59','2023-10-09 23:29:59'),(14,'Dr.','Nahashon Gichana Akunga','nakunga@kabarak.ac.ke',NULL,'$2y$10$FDb/7IyDqgbXK8jYHcD/YOZlOMtuDqjTB6I2nPBPMbHnfOFGV2jC2','LECTURER',NULL,'2023-10-09 23:29:59','2023-10-09 23:29:59'),(15,'Ms.','Elizabeth Odongo','elizabethodongo@kabarak.ac.ke',NULL,'$2y$10$H25V7SOHE.0TEn/LShn90ewXc9iBs9CWQ5QgNFM.UE1VIv6MEn07y','LECTURER',NULL,'2023-10-09 23:30:00','2023-10-09 23:30:00'),(16,'Dr.','Sellah Kebenei ','SKebenei @kabarak.ac.ke',NULL,'$2y$10$FEizlnr9So4gTNuKFt57EuCfpYkpsgz.0QC7WuHCfLwHGUjU0tqfO','LECTURER',NULL,'2023-10-09 23:30:00','2023-10-09 23:30:00'),(17,'Dr.','Caroline Chepkirui ','chepkiruicaroline@kabarak.ac.ke',NULL,'$2y$10$x0eOxQ94gqLhaAo26LDYL.68v2hsUqOlGm2E1Gh6s41MYpx1Oez9i','LECTURER',NULL,'2023-10-09 23:30:00','2023-10-09 23:30:00'),(18,'Dr.','Margaret Wahome','margaretwahome@kabarak.ac.ke',NULL,'$2y$10$4NXIQgvDyj8IImQ/6A.pweXN82pD1Er8q9hCGaFbkYewIgA9QXXMu','LECTURER',NULL,'2023-10-09 23:30:00','2023-10-09 23:30:00'),(19,'Mr.','Micah Lagat','lagatmicah@kabarak.ac.ke',NULL,'$2y$10$/Zbp6jJFLpyaeqDagAeAU.6fKoz3WRWBHJyYV0nAxE6av66uOaWBC','LECTURER',NULL,'2023-10-09 23:30:00','2023-10-09 23:30:00'),(20,'Dr.','Ferdinand Ndubi','flwafula@kabarak.ac.ke',NULL,'$2y$10$yzXSUx1LgHBYM6hM0.zyk.kbaHtRJ2u2v8t4A8XtHp8F7bJluOF4W','LECTURER',NULL,'2023-10-09 23:30:00','2023-10-09 23:30:00'),(21,'Dr.','Rose Obat','roseobat@kabarak.ac.ke',NULL,'$2y$10$TkuACFJse17PTnRD7.J3feYtWDfl43wMFxnd80KgPK/0IeX/CsmCW','LECTURER',NULL,'2023-10-09 23:30:00','2023-10-09 23:30:00'),(22,'Dr.','Zacchaeus Rotich','zrotich@kabarak.ac.ke',NULL,'$2y$10$HGJHJNA1bzQzU1hA3yxGtOofymihdvOaEilVZ7a1gflzvPfcf5ihu','LECTURER',NULL,'2023-10-09 23:30:00','2023-10-09 23:30:00'),(23,'Dr.','Julia Janet Ouma','janetouma@kabarak.ac.ke',NULL,'$2y$10$bGd382FxFK9mpNzuOMr4LOHom7QSatGHufO6aO/evoQRLcUiWGueK','LECTURER',NULL,'2023-10-09 23:30:00','2023-10-09 23:30:00'),(24,'Dr.','Pamela Kimeto','p_kimeto@kabarak.ac.ke',NULL,'$2y$10$kGvoEzUhDeqdx67tH8b44eo0F8b42dE24OEthe0vZvNtHZpP1WMXi','LECTURER',NULL,'2023-10-09 23:30:00','2023-10-09 23:30:00'),(25,'Dr.','Rahab Wakuraya','rmureithi@kabarak.ac.ke',NULL,'$2y$10$6g01QxPox5ID88trV957Iu0effzoNEnVIYbm94N5rgLcMEpRZKNbO','LECTURER',NULL,'2023-10-09 23:30:00','2023-10-09 23:30:00'),(26,'Dr.','Michael Walekhwa','mwalekhwa@kabarak.ac.ke',NULL,'$2y$10$14wRQbmH/iuHB4rnSOUvgejBiOx673gKV4zm1QVEmbBFf7CUpOUy6','HEAD OF DEPARTMENT',NULL,'2023-10-09 23:30:01','2023-10-09 23:46:36'),(27,'Mr.','Charles Wambugu','cwmwangi@kabarak.ac.ke',NULL,'$2y$10$I3.AhYuYiK53oZLzJivcIOdIO536KJUpoqZGVEja5rMbwKTOPpW76','HEAD OF DEPARTMENT',NULL,'2023-10-09 23:30:01','2023-10-09 23:46:58'),(28,'Mr.','Jeremiah Bundotich','jbundotich@kabarak.ac.ke',NULL,'$2y$10$oAaMingvgD/OBrz.m88OTeByHYdsIVniDGPXBWFjv62G089wa72fq','LECTURER',NULL,'2023-10-09 23:30:01','2023-10-09 23:30:01'),(29,'Ms.','Teresa Kerubo','tkerubo@kabarak.ac.ke',NULL,'$2y$10$BbFqg7HoYMdfKnxc28TH4eBkijMU.TzoYjdcWdqOzeI0wEyICDIA2','LECTURER',NULL,'2023-10-09 23:30:01','2023-10-09 23:30:01'),(30,'Mr.','Jeremiah Ongori','jongori@kabarak.ac.ke',NULL,'$2y$10$P6JsemjvsQNQkN1GjFDGfO08WA5IKj2zdKurzQzRQ9TSt19HZnl0e','LECTURER',NULL,'2023-10-09 23:30:01','2023-10-09 23:30:01'),(31,'Mrs.','Ann Somba','SAnne@kabarak.ac.ke',NULL,'$2y$10$yCZWniMmzjOJgHrY2Ez9aO0Pf8EE8NPSE91mZMqAxMBM0p1LzV.wS','LECTURER',NULL,'2023-10-09 23:30:01','2023-10-09 23:30:01'),(32,'Dr.','Emily Tumwet','ETumwet@kabarak.ac.ke',NULL,'$2y$10$DGLQ0xCIc.V5RTEJ7rOsbuS8a/jAInfv08Mv67BHMr8uDhKlsnzwy','LECTURER',NULL,'2023-10-09 23:30:01','2023-10-09 23:30:01'),(33,'Mr.','Wilson Balongo','balongo@kabarak.ac.ke',NULL,'$2y$10$CUuMPFSk8KNQj5nwS72xOuDZXuubcPmkb0LuBz4z7PAApCG.OJwV.','LECTURER',NULL,'2023-10-09 23:30:01','2023-10-09 23:30:01'),(34,'Mr.','Walter Rono','wkrono@kabarak.ac.ke',NULL,'$2y$10$YamNXyN4HaiSjiYqFN6wcuTtoA2ir0tkzF0rwIYjuAsLPnijT8cq2','LECTURER',NULL,'2023-10-09 23:30:01','2023-10-09 23:30:01'),(35,'Mr.','Amos Kandagor','akandagor@kabarak.ac.ke',NULL,'$2y$10$N2KRzY09ky2tCyueSwYChOrmR8t.A8WUuNcLkwsNv1i45sIVR8Gum','LECTURER',NULL,'2023-10-09 23:30:01','2023-10-09 23:30:01'),(36,'Dr.','Rose Keter','rjketer@kabarak.ac.ke',NULL,'$2y$10$yRvT80XjFVE5BgvMSdbkv.kQ9HNPUfFYZUDoloYJCYIpNQHCoVmK2','LECTURER',NULL,'2023-10-09 23:30:01','2023-10-09 23:30:01'),(37,'Dr.','Lydia Momanyi','null@kabarak.ac.ke',NULL,'$2y$10$ea6F2ZaXgz4aKPuqKh.tdOR9IKC2y8aqbg7MLpW0Z0GoVVukTFQ.O','LECTURER',NULL,'2023-10-09 23:30:02','2023-10-09 23:30:02'),(38,'Dr.','Jediel Muriu','jnull@kabarak.ac.ke',NULL,'$2y$10$64O6q5pIOTcwGlOnkoD0de0DMwf0i6wB1siJxsNlFkTtsHlbS.Aou','LECTURER',NULL,'2023-10-09 23:30:02','2023-10-09 23:30:02'),(39,'Dr.','Elizabeth Ogaja','eogaja@kabarak.ac.ke',NULL,'$2y$10$WhjMpKvR5cIDy.ECZpMzd.eYEzBCnmjzDkof5on4C3a/HesnrSmSa','LECTURER',NULL,'2023-10-09 23:30:02','2023-10-09 23:30:02'),(40,'Dr.','Alex Mwangi','mnull@kabarak.ac.ke',NULL,'$2y$10$0LVRxqh5a8ymfpN.9EoCUupK0R64BIf4dR6wvZU2reL1gui5rTHRW','LECTURER',NULL,'2023-10-09 23:30:02','2023-10-09 23:30:02'),(41,'Dr.','Grace Otieno','gnull@kabarak.ac.ke',NULL,'$2y$10$9F7MG0JOl6o2MFA6nVNfpuZWiFZuU96o.hDIF.Js70uCQCAeanL0q','LECTURER',NULL,'2023-10-09 23:30:02','2023-10-09 23:30:02'),(42,'Mr.','Emmanuel Owino','eowino@kabarak.ac.ke',NULL,'$2y$10$YjXwlka0X2ynQa6Hg9JZh.V1xcuceZwDMelbZDCbnQcq8vLK5INlq','LECTURER',NULL,'2023-10-09 23:30:02','2023-10-09 23:30:02'),(43,'Ms.','Alice Murugi','lmurugi@kabarak.ac.ke',NULL,'$2y$10$7rbvUFCpEEw5y6iVocjtPuCMz7o3GiiWfJNdM9f452IDi5A/KqgP.','LECTURER',NULL,'2023-10-09 23:30:02','2023-10-09 23:30:02'),(44,'Ms.','Elsie Salano','snull@kabarak.ac.ke',NULL,'$2y$10$qnS4WCERXQV..Pej655x8e19g86nO3DTQ/WuQJIXq7j7YeAeLpimK','LECTURER',NULL,'2023-10-09 23:30:02','2023-10-09 23:30:02'),(45,'Dr.','Titus Masai Shapaya','tnull@kabarak.ac.ke',NULL,'$2y$10$8sLrzAU8BvvgQzo/aWQn0OJW1vMwNKobvMfFKvVmKzRwQ5Ktq9i1W','LECTURER',NULL,'2023-10-09 23:30:02','2023-10-09 23:30:02');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `groups_view`
--

/*!50001 DROP VIEW IF EXISTS `groups_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `groups_view` AS select `groups`.`group_id` AS `group_id`,`groups`.`name` AS `group_name`,`groups`.`student_count` AS `student_count`,`groups`.`cohort_id` AS `cohort_id`,`cohorts`.`name` AS `cohort_name`,`programs`.`program_id` AS `program_id`,`schools`.`school_id` AS `school_id` from (((`groups` join `cohorts` on(`groups`.`cohort_id` = `cohorts`.`cohort_id`)) join `programs` on(`cohorts`.`program_id` = `programs`.`program_id`)) join `schools` on(`programs`.`school_id` = `schools`.`school_id`)) where `cohorts`.`status` = 'INSESSION' group by `groups`.`group_id`,`groups`.`name`,`groups`.`student_count`,`groups`.`cohort_id`,`cohorts`.`name`,`programs`.`program_id`,`schools`.`school_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `labs_view`
--

/*!50001 DROP VIEW IF EXISTS `labs_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `labs_view` AS select `labs`.`lab_id` AS `lab_id`,`labs`.`lab_name` AS `lab_name`,`labs`.`lab_capacity` AS `lab_capacity`,`labs`.`lab_type` AS `lab_type`,`buildings`.`name` AS `name`,`schools`.`school_id` AS `school_id`,`labs`.`created_at` AS `created_at` from (((`labs` join `buildings` on(`labs`.`building_id` = `buildings`.`building_id`)) join `school_buildings` on(`buildings`.`building_id` = `school_buildings`.`building_id`)) join `schools` on(`school_buildings`.`school_id` = `schools`.`school_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lecturerooms_view`
--

/*!50001 DROP VIEW IF EXISTS `lecturerooms_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `lecturerooms_view` AS select `lecture_rooms`.`lecture_room_id` AS `lecture_room_id`,`lecture_rooms`.`lecture_room_name` AS `lecture_room_name`,`lecture_rooms`.`lecture_room_capacity` AS `lecture_room_capacity`,`buildings`.`name` AS `name`,`schools`.`school_id` AS `school_id`,`lecture_rooms`.`created_at` AS `created_at` from (((`lecture_rooms` join `buildings` on(`lecture_rooms`.`building_id` = `buildings`.`building_id`)) join `school_buildings` on(`buildings`.`building_id` = `school_buildings`.`building_id`)) join `schools` on(`school_buildings`.`school_id` = `schools`.`school_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lecturers_view`
--

/*!50001 DROP VIEW IF EXISTS `lecturers_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `lecturers_view` AS select `users`.`user_id` AS `user_id`,`users`.`title` AS `title`,`users`.`name` AS `lecturer_name`,`users`.`email` AS `email`,`users`.`created_at` AS `created_at` from (`users` join `sessions_view` on(`users`.`user_id` = `sessions_view`.`lecturer_id`)) group by `users`.`user_id`,`users`.`title`,`users`.`name`,`users`.`email`,`users`.`created_at` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `programs_view`
--

/*!50001 DROP VIEW IF EXISTS `programs_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `programs_view` AS select `programs`.`program_id` AS `program_id`,`programs`.`name` AS `program_name`,`programs`.`code` AS `program_code`,`programs`.`school_id` AS `school_id`,`programs`.`created_at` AS `created_at` from (`programs` join `sessions_view` on(`programs`.`program_id` = `sessions_view`.`program_id`)) group by `programs`.`program_id`,`programs`.`name`,`programs`.`code`,`programs`.`school_id`,`programs`.`created_at` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `schools_view`
--

/*!50001 DROP VIEW IF EXISTS `schools_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `schools_view` AS select `schools`.`school_id` AS `school_id`,`schools`.`name` AS `school_name`,`schools`.`slug` AS `school_slug`,`schools`.`created_at` AS `created_at` from (`schools` join `programs_view` on(`schools`.`school_id` = `programs_view`.`school_id`)) group by `schools`.`school_id`,`schools`.`name`,`schools`.`slug`,`schools`.`created_at` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `sessions_view`
--

/*!50001 DROP VIEW IF EXISTS `sessions_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `sessions_view` AS select `unit_assingments`.`unit_assingment_id` AS `unit_assingment_id`,`units`.`unit_id` AS `unit_id`,`units`.`name` AS `unit_name`,`units`.`code` AS `unit_code`,`units`.`department_id` AS `department_id`,`units`.`has_lab` AS `has_lab`,`units`.`labtype_id` AS `labtype_id`,`units`.`lab_alternative` AS `lab_alternative`,`units`.`lecturer_hours` AS `lecturer_hours`,`units`.`lab_hours` AS `lab_hours`,`units`.`is_full_day` AS `is_full_day`,`unit_assingments`.`lecturer_id` AS `lecturer_id`,`cohorts`.`cohort_id` AS `cohort_id`,`cohorts`.`name` AS `cohort_name`,`cohorts`.`code` AS `cohort_code`,`cohorts`.`program_id` AS `program_id`,`groups`.`group_id` AS `group_id`,`groups`.`name` AS `group_name`,`groups`.`student_count` AS `student_count`,`unit_assingments`.`created_at` AS `created_at` from (((`unit_assingments` join `units` on(`unit_assingments`.`unit_id` = `units`.`unit_id`)) join `cohorts` on(`unit_assingments`.`cohort_id` = `cohorts`.`cohort_id`)) join `groups` on(`cohorts`.`cohort_id` = `groups`.`cohort_id`)) where `cohorts`.`status` = 'INSESSION' */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `unit_preferred_labs_view`
--

/*!50001 DROP VIEW IF EXISTS `unit_preferred_labs_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `unit_preferred_labs_view` AS select `unit_preferences`.`unit_id` AS `unit_id`,`unit_preferred_labs`.`lab_id` AS `lab_id` from (`unit_preferences` join `unit_preferred_labs` on(`unit_preferences`.`unit_preference_id` = `unit_preferred_labs`.`unit_preference_id`)) group by `unit_preferences`.`unit_id`,`unit_preferred_labs`.`lab_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `unit_preferred_rooms_view`
--

/*!50001 DROP VIEW IF EXISTS `unit_preferred_rooms_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `unit_preferred_rooms_view` AS select `unit_preferences`.`unit_id` AS `unit_id`,`unit_preferred_rooms`.`lecture_room_id` AS `lecture_room_id` from (`unit_preferences` join `unit_preferred_rooms` on(`unit_preferences`.`unit_preference_id` = `unit_preferred_rooms`.`unit_preference_id`)) group by `unit_preferences`.`unit_id`,`unit_preferred_rooms`.`lecture_room_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `unit_preferred_times_view`
--

/*!50001 DROP VIEW IF EXISTS `unit_preferred_times_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `unit_preferred_times_view` AS select `unit_preferences`.`unit_id` AS `unit_id`,`school_periods`.`day_of_week` AS `day_of_week`,`school_periods`.`start_time` AS `start_time`,`school_periods`.`end_time` AS `end_time` from ((`unit_preferences` join `unit_preferred_periods` on(`unit_preferences`.`unit_preference_id` = `unit_preferred_periods`.`unit_preference_id`)) join `school_periods` on(`unit_preferred_periods`.`school_period_id` = `school_periods`.`school_period_id`)) group by `unit_preferences`.`unit_id`,`school_periods`.`day_of_week`,`school_periods`.`start_time`,`school_periods`.`end_time` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-11 15:58:47
