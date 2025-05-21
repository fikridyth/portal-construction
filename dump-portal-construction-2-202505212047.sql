-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: portal-construction-2
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bahans`
--

DROP TABLE IF EXISTS `bahans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bahans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `volume` decimal(16,2) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `harga_modal_material` decimal(16,2) DEFAULT NULL,
  `harga_modal_upah` decimal(16,2) DEFAULT NULL,
  `harga_jual` decimal(16,2) DEFAULT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bahans_nama_unique` (`nama`),
  KEY `bahans_created_by_foreign` (`created_by`),
  KEY `bahans_updated_by_foreign` (`updated_by`),
  CONSTRAINT `bahans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `bahans_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bahans`
--

LOCK TABLES `bahans` WRITE;
/*!40000 ALTER TABLE `bahans` DISABLE KEYS */;
INSERT INTO `bahans` VALUES (1,'Terpal',NULL,'M2',NULL,9000.00,NULL,2,2,'2025-04-15 07:29:18','2025-04-15 07:30:57'),(2,'Pasir Urug',NULL,'M3',200150.00,NULL,NULL,2,2,'2025-04-15 07:30:16','2025-04-15 07:41:14'),(3,'Reng',NULL,'Btg',NULL,65000.00,NULL,2,2,'2025-04-15 07:43:13','2025-04-15 07:43:13'),(4,'Bambu 4 Meter',NULL,'Bh',30000.00,NULL,NULL,2,2,'2025-04-16 10:14:31','2025-04-16 10:14:56');
/*!40000 ALTER TABLE `bahans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccos`
--

DROP TABLE IF EXISTS `ccos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ccos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_proyek` bigint(20) unsigned NOT NULL,
  `nama` varchar(255) NOT NULL,
  `volume` decimal(16,2) DEFAULT NULL,
  `harga` decimal(16,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ccos_id_proyek_foreign` (`id_proyek`),
  CONSTRAINT `ccos_id_proyek_foreign` FOREIGN KEY (`id_proyek`) REFERENCES `proyeks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccos`
--

LOCK TABLES `ccos` WRITE;
/*!40000 ALTER TABLE `ccos` DISABLE KEYS */;
INSERT INTO `ccos` VALUES (1,1,'Partisipasi Proyek (Pak Anang & Pak Yui)',1.00,2000000.00,'2025-04-28 08:36:50','2025-04-28 08:36:50'),(2,1,'Sewa Excavator PC 2001',30.00,750000.00,'2025-04-28 08:39:39','2025-04-28 08:44:18');
/*!40000 ALTER TABLE `ccos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuaca_mingguans`
--

DROP TABLE IF EXISTS `cuaca_mingguans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cuaca_mingguans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_proyek` bigint(20) unsigned NOT NULL,
  `id_laporan_mingguan` bigint(20) unsigned NOT NULL,
  `minggu_ke` bigint(20) NOT NULL,
  `list_cuaca` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_cuaca`)),
  `dari` date NOT NULL,
  `sampai` date NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bobot_total` decimal(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cuaca_mingguans_id_proyek_foreign` (`id_proyek`),
  KEY `cuaca_mingguans_id_laporan_mingguan_foreign` (`id_laporan_mingguan`),
  KEY `cuaca_mingguans_created_by_foreign` (`created_by`),
  KEY `cuaca_mingguans_updated_by_foreign` (`updated_by`),
  CONSTRAINT `cuaca_mingguans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `cuaca_mingguans_id_laporan_mingguan_foreign` FOREIGN KEY (`id_laporan_mingguan`) REFERENCES `laporan_mingguans` (`id`),
  CONSTRAINT `cuaca_mingguans_id_proyek_foreign` FOREIGN KEY (`id_proyek`) REFERENCES `proyeks` (`id`),
  CONSTRAINT `cuaca_mingguans_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuaca_mingguans`
--

LOCK TABLES `cuaca_mingguans` WRITE;
/*!40000 ALTER TABLE `cuaca_mingguans` DISABLE KEYS */;
INSERT INTO `cuaca_mingguans` VALUES (1,1,1,1,'{\"Senin\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Selasa\":{\"6\":\"Hujan\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Rabu\":{\"6\":\"Berawan\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Kamis\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Jumat\":{\"6\":\"Hujan\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Sabtu\":{\"6\":\"Berawan\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Minggu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"}}','2025-03-24','2025-03-30',2,2,'2025-04-25 08:03:20','2025-04-25 08:03:20',20.00),(2,1,2,2,'{\"Senin\":{\"6\":\"Berawan\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Selasa\":{\"6\":\"Hujan\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Rabu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Kamis\":{\"6\":\"Berawan\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Jumat\":{\"6\":\"Hujan\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Sabtu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Minggu\":{\"6\":\"Berawan\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"}}','2025-03-31','2025-04-06',2,2,'2025-04-25 08:03:48','2025-04-25 08:03:48',48.02),(3,1,5,3,'{\"Senin\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Selasa\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Hujan\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Rabu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Berawan\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Kamis\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Hujan\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Jumat\":{\"6\":\"Berawan\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Sabtu\":{\"6\":\"Hujan\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Minggu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"}}','2025-04-07','2025-04-13',2,2,'2025-04-25 08:06:20','2025-04-25 08:06:20',64.05),(4,1,6,4,'{\"Senin\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Selasa\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Rabu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Kamis\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Jumat\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Sabtu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Minggu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"}}','2025-04-14','2025-04-20',2,2,'2025-04-25 08:06:46','2025-04-25 08:06:46',84.06),(6,1,7,5,'{\"Senin\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Selasa\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Rabu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Kamis\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Jumat\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Sabtu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Minggu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"}}','2025-04-21','2025-04-27',2,2,'2025-04-25 08:12:29','2025-04-25 08:12:29',100.00),(7,4,8,1,'{\"Senin\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Hujan\",\"9\":\"Hujan\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Selasa\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Rabu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Kamis\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Jumat\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Sabtu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"},\"Minggu\":{\"6\":\"Baik\",\"7\":\"Baik\",\"8\":\"Baik\",\"9\":\"Baik\",\"10\":\"Baik\",\"11\":\"Baik\",\"12\":\"Baik\",\"13\":\"Baik\",\"14\":\"Baik\",\"15\":\"Baik\",\"16\":\"Baik\",\"17\":\"Baik\",\"18\":\"Baik\",\"19\":\"Baik\",\"20\":\"Baik\"}}','2025-04-14','2025-04-20',3,3,'2025-05-12 12:04:34','2025-05-12 12:04:34',30.00);
/*!40000 ALTER TABLE `cuaca_mingguans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_pekerjaans`
--

DROP TABLE IF EXISTS `detail_pekerjaans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_pekerjaans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_proyek` bigint(20) unsigned NOT NULL,
  `id_pekerjaan` bigint(20) unsigned NOT NULL,
  `nama` varchar(255) NOT NULL,
  `volume` decimal(16,2) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `harga_modal_material` decimal(16,2) DEFAULT NULL,
  `harga_modal_upah` decimal(16,2) DEFAULT NULL,
  `harga_jual_satuan` decimal(16,2) DEFAULT NULL,
  `harga_jual_total` decimal(16,2) DEFAULT NULL,
  `is_bahan` tinyint(1) NOT NULL,
  `list_bahan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_bahan`)),
  `vol_pemakaian` decimal(16,2) DEFAULT NULL,
  `harga_pemakaian` decimal(16,2) DEFAULT NULL,
  `vol_sisa` decimal(16,2) DEFAULT NULL,
  `harga_sisa` decimal(16,2) DEFAULT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bobot` decimal(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_pekerjaans_id_proyek_foreign` (`id_proyek`),
  KEY `detail_pekerjaans_id_pekerjaan_foreign` (`id_pekerjaan`),
  KEY `detail_pekerjaans_created_by_foreign` (`created_by`),
  KEY `detail_pekerjaans_updated_by_foreign` (`updated_by`),
  CONSTRAINT `detail_pekerjaans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `detail_pekerjaans_id_pekerjaan_foreign` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaans` (`id`),
  CONSTRAINT `detail_pekerjaans_id_proyek_foreign` FOREIGN KEY (`id_proyek`) REFERENCES `proyeks` (`id`),
  CONSTRAINT `detail_pekerjaans_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_pekerjaans`
--

LOCK TABLES `detail_pekerjaans` WRITE;
/*!40000 ALTER TABLE `detail_pekerjaans` DISABLE KEYS */;
INSERT INTO `detail_pekerjaans` VALUES (1,1,1,'Pengukuran/Bouwplank',69.00,'m2',NULL,2208000.00,68373.19,4717750.11,0,'[]',NULL,NULL,NULL,NULL,2,2,'2025-04-14 08:09:47','2025-04-20 03:56:30',15.00),(2,1,2,'Air Kerja',1.00,'Ls',NULL,1500000.00,3000000.00,3000000.00,0,'[]',NULL,NULL,NULL,NULL,2,2,'2025-04-14 08:10:18','2025-04-20 04:00:32',20.00),(4,1,2,'Jasa',1.00,'Ml',NULL,2000000.00,4000000.00,4000000.00,0,'[]',NULL,NULL,NULL,NULL,2,2,'2025-04-14 09:02:47','2025-04-20 04:00:52',20.08),(5,1,1,'Pagar Pengaman Proyek',55.00,'M',NULL,NULL,402551.75,22140346.25,1,'[{\"id_bahan\":1,\"nama_bahan\":\"Terpal\",\"volume\":\"99\",\"satuan\":\"M2\",\"harga_modal_material\":null,\"harga_modal_upah\":\"9000.00\",\"total\":891000},{\"id_bahan\":3,\"nama_bahan\":\"Reng\",\"volume\":\"28\",\"satuan\":\"Btg\",\"harga_modal_material\":null,\"harga_modal_upah\":\"65000.00\",\"total\":1820000}]',NULL,NULL,NULL,NULL,2,2,'2025-04-15 08:54:20','2025-04-20 04:00:21',25.00),(6,1,3,'Cerucuk dolken P 4 M',220.00,'Bh',NULL,NULL,72537.91,15958340.20,1,'[{\"id_bahan\":4,\"nama_bahan\":\"Bambu 4 Meter\",\"volume\":\"220\",\"satuan\":\"Bh\",\"harga_modal_material\":\"30000.00\",\"harga_modal_upah\":null,\"total\":6600000}]',NULL,NULL,NULL,NULL,2,2,'2025-04-16 10:15:57','2025-04-20 04:01:11',19.92),(7,4,1,'Pagar Pengaman Proyek',55.00,'m2',68373.19,NULL,402551.75,22140346.25,0,'[]',NULL,NULL,NULL,NULL,2,2,'2025-04-22 04:16:49','2025-04-22 04:16:49',20.08),(8,4,2,'Pengukuran/Bouwplank',55.00,'m2',68373.19,NULL,402551.75,22140346.25,0,'[]',NULL,NULL,NULL,NULL,2,2,'2025-04-22 04:17:37','2025-04-22 07:58:01',79.92);
/*!40000 ALTER TABLE `detail_pekerjaans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dokumentasi_mingguans`
--

DROP TABLE IF EXISTS `dokumentasi_mingguans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dokumentasi_mingguans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_proyek` bigint(20) unsigned NOT NULL,
  `id_laporan_mingguan` bigint(20) unsigned NOT NULL,
  `minggu_ke` bigint(20) NOT NULL,
  `list_gambar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_gambar`)),
  `dari` date NOT NULL,
  `sampai` date NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bobot_total` decimal(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dokumentasi_mingguans_id_proyek_foreign` (`id_proyek`),
  KEY `dokumentasi_mingguans_id_laporan_mingguan_foreign` (`id_laporan_mingguan`),
  KEY `dokumentasi_mingguans_created_by_foreign` (`created_by`),
  KEY `dokumentasi_mingguans_updated_by_foreign` (`updated_by`),
  CONSTRAINT `dokumentasi_mingguans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `dokumentasi_mingguans_id_laporan_mingguan_foreign` FOREIGN KEY (`id_laporan_mingguan`) REFERENCES `laporan_mingguans` (`id`),
  CONSTRAINT `dokumentasi_mingguans_id_proyek_foreign` FOREIGN KEY (`id_proyek`) REFERENCES `proyeks` (`id`),
  CONSTRAINT `dokumentasi_mingguans_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dokumentasi_mingguans`
--

LOCK TABLES `dokumentasi_mingguans` WRITE;
/*!40000 ALTER TABLE `dokumentasi_mingguans` DISABLE KEYS */;
INSERT INTO `dokumentasi_mingguans` VALUES (1,1,1,1,'[{\"file\":\"dokumentasi\\/kEFGne76RfFsG5FXTkLF.JPG\",\"keterangan\":\"12\"}]','2025-03-24','2025-03-30',2,2,'2025-04-25 08:13:39','2025-04-25 08:13:39',20.00),(2,1,2,2,'[{\"file\":\"dokumentasi\\/6QwSOW65nZoJAfqInzaj.JPG\",\"keterangan\":\"2121\"}]','2025-03-31','2025-04-06',2,2,'2025-04-25 08:13:50','2025-04-25 08:13:50',48.02),(4,4,8,1,'[{\"file\":\"dokumentasi\\/4jJA9c5s3n1A06o73pGO.JPG\",\"keterangan\":\"3\"}]','2025-04-14','2025-04-20',2,2,'2025-04-25 08:16:30','2025-04-25 08:16:30',30.00),(5,1,5,3,'[{\"file\":\"dokumentasi\\/i5Z284CfRIU1q2MOPRce.JPG\",\"keterangan\":\"3\"}]','2025-04-07','2025-04-13',2,2,'2025-04-25 08:16:55','2025-04-25 08:16:55',64.05),(6,1,6,4,'[{\"file\":\"dokumentasi\\/dbxZUfcvR4jjatcNwlDR.JPG\",\"keterangan\":\"4\"}]','2025-04-14','2025-04-20',2,2,'2025-04-25 08:17:05','2025-04-25 08:17:05',84.06),(7,1,7,5,'[{\"file\":\"dokumentasi\\/carHCET4E3kT5ZuhwpFb.JPG\",\"keterangan\":\"TAMPAK DEPAN\"},{\"file\":\"dokumentasi\\/n378obYruITAWxlOOGJF.JPG\",\"keterangan\":\"TAMPAK SAMPING KANAN\"},{\"file\":\"dokumentasi\\/VQlNPLrVmntCuHzdu9Pq.JPG\",\"keterangan\":\"TAMPAK SAMPING KIRI\"},{\"file\":\"dokumentasi\\/etJL6WXZBOLsgjmGRdcF.JPG\",\"keterangan\":\"TAMPAK BELAKANG\"},{\"file\":\"dokumentasi\\/rPIiY8hx4ckAEfkMtfND.JPG\",\"keterangan\":\"TAMPAK ATAS\"},{\"file\":\"dokumentasi\\/VBXwHL7srIWFoov9zmVL.JPG\",\"keterangan\":\"TAMPAK JAUH\"}]','2025-04-21','2025-04-27',2,2,'2025-04-25 08:19:33','2025-04-25 08:19:33',100.00),(8,4,9,2,'[{\"file\":\"dokumentasi\\/zD8k672dIisosNwfwWPb.jpeg\",\"keterangan\":\"TAMPAK DEPAN\"},{\"file\":\"dokumentasi\\/TOVphJECsbweS2xofgwy.JPG\",\"keterangan\":\"TAMPAK BELAKANG\"},{\"file\":\"dokumentasi\\/fu45YOZPLyoXabgH0toj.JPG\",\"keterangan\":\"TAMPAK SAMPING\"}]','2025-04-21','2025-04-27',3,3,'2025-05-12 12:03:02','2025-05-12 12:03:02',50.00);
/*!40000 ALTER TABLE `dokumentasi_mingguans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
-- Table structure for table `laporan_harians`
--

DROP TABLE IF EXISTS `laporan_harians`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan_harians` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_proyek` bigint(20) unsigned NOT NULL,
  `list_tenaga` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_tenaga`)),
  `list_bahan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_bahan`)),
  `minggu_ke` bigint(20) NOT NULL,
  `hari` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_harians_id_proyek_foreign` (`id_proyek`),
  CONSTRAINT `laporan_harians_id_proyek_foreign` FOREIGN KEY (`id_proyek`) REFERENCES `proyeks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan_harians`
--

LOCK TABLES `laporan_harians` WRITE;
/*!40000 ALTER TABLE `laporan_harians` DISABLE KEYS */;
INSERT INTO `laporan_harians` VALUES (1,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Bambu 4 Meter\",\"jumlah\":\"2\"}]',1,'Senin','2025-03-24','2025-04-26 23:05:55','2025-04-26 23:05:55'),(2,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Bambu 4 Meter\",\"jumlah\":\"2\"}]',1,'Selasa','2025-03-25','2025-04-26 23:16:40','2025-04-26 23:16:40'),(3,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Bambu 4 Meter\",\"jumlah\":\"2\"}]',1,'Rabu','2025-03-26','2025-04-26 23:16:46','2025-04-26 23:16:46'),(4,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Bambu 4 Meter\",\"jumlah\":\"2\"}]',1,'Kamis','2025-03-27','2025-04-26 23:16:53','2025-04-26 23:16:53'),(5,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Bambu 4 Meter\",\"jumlah\":\"2\"}]',1,'Jumat','2025-03-28','2025-04-26 23:16:58','2025-04-26 23:16:58'),(6,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Bambu 4 Meter\",\"jumlah\":\"2\"}]',1,'Sabtu','2025-03-29','2025-04-26 23:17:05','2025-04-26 23:17:05'),(7,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Bambu 4 Meter\",\"jumlah\":\"2\"}]',1,'Minggu','2025-03-30','2025-04-26 23:17:11','2025-04-26 23:17:11'),(8,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Bambu 4 Meter\",\"jumlah\":\"2\"}]',2,'Senin','2025-03-31','2025-04-26 23:17:18','2025-04-26 23:17:18'),(9,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Bambu 4 Meter\",\"jumlah\":\"2\"}]',2,'Selasa','2025-04-01','2025-04-26 23:17:24','2025-04-26 23:17:24'),(10,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Bambu 4 Meter\",\"jumlah\":\"2\"}]',2,'Rabu','2025-04-02','2025-04-27 03:33:32','2025-04-27 03:33:32'),(11,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Bambu 4 Meter\",\"jumlah\":\"2\"}]',2,'Kamis','2025-04-03','2025-04-27 04:42:11','2025-04-27 04:42:11'),(12,1,'[{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"3\",\"nama\":\"Reng\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Pasir Urug\",\"jumlah\":\"6\"}]',2,'Jumat','2025-04-04','2025-04-27 04:46:17','2025-04-27 04:46:17'),(13,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"3\",\"nama\":\"Mandor\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"5\"},{\"id\":\"2\",\"nama\":\"Pasir Urug\",\"jumlah\":\"7\"}]',2,'Sabtu','2025-04-05','2025-05-12 11:47:05','2025-05-12 11:47:05'),(14,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Pasir Urug\",\"jumlah\":\"6\"}]',2,'Minggu','2025-04-06','2025-05-12 11:53:48','2025-05-12 11:53:48'),(15,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Pasir Urug\",\"jumlah\":\"5\"}]',3,'Senin','2025-04-07','2025-05-12 11:57:43','2025-05-12 11:57:43'),(16,1,'[{\"id\":\"1\",\"nama\":\"Project Manager\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Site Manager\\/SPV\",\"jumlah\":\"1\"},{\"id\":\"4\",\"nama\":\"Tukang\",\"jumlah\":\"5\"}]','[{\"id\":\"1\",\"nama\":\"Terpal\",\"jumlah\":\"1\"},{\"id\":\"2\",\"nama\":\"Pasir Urug\",\"jumlah\":\"5\"}]',3,'Selasa','2025-04-08','2025-05-12 11:59:22','2025-05-12 11:59:22');
/*!40000 ALTER TABLE `laporan_harians` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan_mingguans`
--

DROP TABLE IF EXISTS `laporan_mingguans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan_mingguans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_proyek` bigint(20) unsigned NOT NULL,
  `list_pekerjaan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_pekerjaan`)),
  `minggu_ke` bigint(20) NOT NULL,
  `bobot_minggu_lalu` decimal(16,2) DEFAULT NULL,
  `bobot_minggu_ini` decimal(16,2) DEFAULT NULL,
  `bobot_rencana` decimal(16,2) DEFAULT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bobot_total` decimal(16,2) DEFAULT NULL,
  `dari` date DEFAULT NULL,
  `sampai` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_mingguans_id_proyek_foreign` (`id_proyek`),
  KEY `laporan_mingguans_created_by_foreign` (`created_by`),
  KEY `laporan_mingguans_updated_by_foreign` (`updated_by`),
  CONSTRAINT `laporan_mingguans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `laporan_mingguans_id_proyek_foreign` FOREIGN KEY (`id_proyek`) REFERENCES `proyeks` (`id`),
  CONSTRAINT `laporan_mingguans_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan_mingguans`
--

LOCK TABLES `laporan_mingguans` WRITE;
/*!40000 ALTER TABLE `laporan_mingguans` DISABLE KEYS */;
INSERT INTO `laporan_mingguans` VALUES (1,1,'[{\"id_proyek\":\"1\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"1\",\"nama_pekerjaan\":\"Pengukuran\\/Bouwplank\",\"volume\":\"69.00\",\"satuan\":\"m2\",\"bobot\":\"15.00\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":50,\"bobot_minggu_ini\":\"7.50\",\"progress_total\":\"50\",\"bobot_total\":\"7.50\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"5\",\"nama_pekerjaan\":\"Pagar Pengaman Proyek\",\"volume\":\"55.00\",\"satuan\":\"M\",\"bobot\":\"25.00\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":50,\"bobot_minggu_ini\":\"12.50\",\"progress_total\":\"50\",\"bobot_total\":\"12.50\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"2\",\"nama_pekerjaan\":\"Air Kerja\",\"volume\":\"1.00\",\"satuan\":\"Ls\",\"bobot\":\"20.00\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"0\",\"bobot_total\":\"0.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"4\",\"nama_pekerjaan\":\"Jasa\",\"volume\":\"1.00\",\"satuan\":\"Ml\",\"bobot\":\"20.08\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"0\",\"bobot_total\":\"0.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"3\",\"id_detail_pekerjaan\":\"6\",\"nama_pekerjaan\":\"Cerucuk dolken P 4 M\",\"volume\":\"220.00\",\"satuan\":\"Bh\",\"bobot\":\"19.92\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"0\",\"bobot_total\":\"0.00\"}]',1,0.00,20.00,20.00,2,2,'2025-04-21 07:52:46','2025-04-21 07:52:46',20.00,'2025-03-24','2025-03-30'),(2,1,'[{\"id_proyek\":\"1\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"1\",\"nama_pekerjaan\":\"Pengukuran\\/Bouwplank\",\"volume\":\"69.00\",\"satuan\":\"m2\",\"bobot\":\"15.00\",\"progress_minggu_lalu\":50,\"bobot_minggu_lalu\":\"7.50\",\"progress_minggu_ini\":50,\"bobot_minggu_ini\":\"7.50\",\"progress_total\":\"100\",\"bobot_total\":\"15.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"5\",\"nama_pekerjaan\":\"Pagar Pengaman Proyek\",\"volume\":\"55.00\",\"satuan\":\"M\",\"bobot\":\"25.00\",\"progress_minggu_lalu\":50,\"bobot_minggu_lalu\":\"12.50\",\"progress_minggu_ini\":50,\"bobot_minggu_ini\":\"12.50\",\"progress_total\":\"100\",\"bobot_total\":\"25.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"2\",\"nama_pekerjaan\":\"Air Kerja\",\"volume\":\"1.00\",\"satuan\":\"Ls\",\"bobot\":\"20.00\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":20,\"bobot_minggu_ini\":\"4.00\",\"progress_total\":\"20\",\"bobot_total\":\"4.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"4\",\"nama_pekerjaan\":\"Jasa\",\"volume\":\"1.00\",\"satuan\":\"Ml\",\"bobot\":\"20.08\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":20,\"bobot_minggu_ini\":\"4.02\",\"progress_total\":\"20\",\"bobot_total\":\"4.02\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"3\",\"id_detail_pekerjaan\":\"6\",\"nama_pekerjaan\":\"Cerucuk dolken P 4 M\",\"volume\":\"220.00\",\"satuan\":\"Bh\",\"bobot\":\"19.92\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"0\",\"bobot_total\":\"0.00\"}]',2,20.00,28.02,40.00,2,2,'2025-04-21 07:53:55','2025-04-21 07:53:55',48.02,'2025-03-31','2025-04-06'),(5,1,'[{\"id_proyek\":\"1\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"1\",\"nama_pekerjaan\":\"Pengukuran\\/Bouwplank\",\"volume\":\"69.00\",\"satuan\":\"m2\",\"bobot\":\"15.00\",\"progress_minggu_lalu\":100,\"bobot_minggu_lalu\":\"15.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"100\",\"bobot_total\":\"15.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"5\",\"nama_pekerjaan\":\"Pagar Pengaman Proyek\",\"volume\":\"55.00\",\"satuan\":\"M\",\"bobot\":\"25.00\",\"progress_minggu_lalu\":100,\"bobot_minggu_lalu\":\"25.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"100\",\"bobot_total\":\"25.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"2\",\"nama_pekerjaan\":\"Air Kerja\",\"volume\":\"1.00\",\"satuan\":\"Ls\",\"bobot\":\"20.00\",\"progress_minggu_lalu\":20,\"bobot_minggu_lalu\":\"4.00\",\"progress_minggu_ini\":40,\"bobot_minggu_ini\":\"8.00\",\"progress_total\":\"60\",\"bobot_total\":\"12.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"4\",\"nama_pekerjaan\":\"Jasa\",\"volume\":\"1.00\",\"satuan\":\"Ml\",\"bobot\":\"20.08\",\"progress_minggu_lalu\":20,\"bobot_minggu_lalu\":\"4.02\",\"progress_minggu_ini\":40,\"bobot_minggu_ini\":\"8.03\",\"progress_total\":\"60\",\"bobot_total\":\"12.05\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"3\",\"id_detail_pekerjaan\":\"6\",\"nama_pekerjaan\":\"Cerucuk dolken P 4 M\",\"volume\":\"220.00\",\"satuan\":\"Bh\",\"bobot\":\"19.92\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"0\",\"bobot_total\":\"0.00\"}]',3,48.02,16.03,60.00,2,2,'2025-04-21 07:55:09','2025-04-21 07:55:09',64.05,'2025-04-07','2025-04-13'),(6,1,'[{\"id_proyek\":\"1\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"1\",\"nama_pekerjaan\":\"Pengukuran\\/Bouwplank\",\"volume\":\"69.00\",\"satuan\":\"m2\",\"bobot\":\"15.00\",\"progress_minggu_lalu\":100,\"bobot_minggu_lalu\":\"15.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"100\",\"bobot_total\":\"15.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"5\",\"nama_pekerjaan\":\"Pagar Pengaman Proyek\",\"volume\":\"55.00\",\"satuan\":\"M\",\"bobot\":\"25.00\",\"progress_minggu_lalu\":100,\"bobot_minggu_lalu\":\"25.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"100\",\"bobot_total\":\"25.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"2\",\"nama_pekerjaan\":\"Air Kerja\",\"volume\":\"1.00\",\"satuan\":\"Ls\",\"bobot\":\"20.00\",\"progress_minggu_lalu\":60,\"bobot_minggu_lalu\":\"12.00\",\"progress_minggu_ini\":40,\"bobot_minggu_ini\":\"8.00\",\"progress_total\":\"100\",\"bobot_total\":\"20.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"4\",\"nama_pekerjaan\":\"Jasa\",\"volume\":\"1.00\",\"satuan\":\"Ml\",\"bobot\":\"20.08\",\"progress_minggu_lalu\":60,\"bobot_minggu_lalu\":\"12.05\",\"progress_minggu_ini\":40,\"bobot_minggu_ini\":\"8.03\",\"progress_total\":\"100\",\"bobot_total\":\"20.08\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"3\",\"id_detail_pekerjaan\":\"6\",\"nama_pekerjaan\":\"Cerucuk dolken P 4 M\",\"volume\":\"220.00\",\"satuan\":\"Bh\",\"bobot\":\"19.92\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":20,\"bobot_minggu_ini\":\"3.98\",\"progress_total\":\"20\",\"bobot_total\":\"3.98\"}]',4,64.05,20.01,80.00,2,2,'2025-04-21 07:55:31','2025-04-21 07:55:31',84.06,'2025-04-14','2025-04-20'),(7,1,'[{\"id_proyek\":\"1\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"1\",\"nama_pekerjaan\":\"Pengukuran\\/Bouwplank\",\"volume\":\"69.00\",\"satuan\":\"m2\",\"bobot\":\"15.00\",\"progress_minggu_lalu\":100,\"bobot_minggu_lalu\":\"15.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"100\",\"bobot_total\":\"15.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"5\",\"nama_pekerjaan\":\"Pagar Pengaman Proyek\",\"volume\":\"55.00\",\"satuan\":\"M\",\"bobot\":\"25.00\",\"progress_minggu_lalu\":100,\"bobot_minggu_lalu\":\"25.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"100\",\"bobot_total\":\"25.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"2\",\"nama_pekerjaan\":\"Air Kerja\",\"volume\":\"1.00\",\"satuan\":\"Ls\",\"bobot\":\"20.00\",\"progress_minggu_lalu\":100,\"bobot_minggu_lalu\":\"20.00\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"100\",\"bobot_total\":\"20.00\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"4\",\"nama_pekerjaan\":\"Jasa\",\"volume\":\"1.00\",\"satuan\":\"Ml\",\"bobot\":\"20.08\",\"progress_minggu_lalu\":100,\"bobot_minggu_lalu\":\"20.08\",\"progress_minggu_ini\":0,\"bobot_minggu_ini\":\"0.00\",\"progress_total\":\"100\",\"bobot_total\":\"20.08\"},{\"id_proyek\":\"1\",\"id_pekerjaan\":\"3\",\"id_detail_pekerjaan\":\"6\",\"nama_pekerjaan\":\"Cerucuk dolken P 4 M\",\"volume\":\"220.00\",\"satuan\":\"Bh\",\"bobot\":\"19.92\",\"progress_minggu_lalu\":20,\"bobot_minggu_lalu\":\"3.98\",\"progress_minggu_ini\":80,\"bobot_minggu_ini\":\"15.94\",\"progress_total\":\"100\",\"bobot_total\":\"19.92\"}]',5,84.06,15.94,100.00,2,2,'2025-04-22 05:55:00','2025-04-22 05:55:00',100.00,'2025-04-21','2025-04-27'),(8,4,'[{\"id_proyek\":\"4\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"7\",\"nama_pekerjaan\":\"Pagar Pengaman Proyek\",\"volume\":\"55.00\",\"satuan\":\"m2\",\"bobot\":\"20.08\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":30,\"bobot_minggu_ini\":\"6.02\",\"progress_total\":\"30\",\"bobot_total\":\"6.02\"},{\"id_proyek\":\"4\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"8\",\"nama_pekerjaan\":\"Pengukuran\\/Bouwplank\",\"volume\":\"55.00\",\"satuan\":\"m2\",\"bobot\":\"79.92\",\"progress_minggu_lalu\":0,\"bobot_minggu_lalu\":\"0.00\",\"progress_minggu_ini\":30,\"bobot_minggu_ini\":\"23.98\",\"progress_total\":\"30\",\"bobot_total\":\"23.98\"}]',1,0.00,30.00,20.00,2,2,'2025-04-22 07:58:57','2025-04-22 07:58:57',30.00,'2025-04-14','2025-04-20'),(9,4,'[{\"id_proyek\":\"4\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"7\",\"nama_pekerjaan\":\"Pagar Pengaman Proyek\",\"volume\":\"55.00\",\"satuan\":\"m2\",\"bobot\":\"20.08\",\"progress_minggu_lalu\":30,\"bobot_minggu_lalu\":\"6.02\",\"progress_minggu_ini\":20,\"bobot_minggu_ini\":\"4.02\",\"progress_total\":\"50\",\"bobot_total\":\"10.04\"},{\"id_proyek\":\"4\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"8\",\"nama_pekerjaan\":\"Pengukuran\\/Bouwplank\",\"volume\":\"55.00\",\"satuan\":\"m2\",\"bobot\":\"79.92\",\"progress_minggu_lalu\":30,\"bobot_minggu_lalu\":\"23.98\",\"progress_minggu_ini\":20,\"bobot_minggu_ini\":\"15.98\",\"progress_total\":\"50\",\"bobot_total\":\"39.96\"}]',2,30.00,20.00,40.00,2,2,'2025-04-22 08:01:14','2025-04-22 08:01:14',50.00,'2025-04-21','2025-04-27'),(10,4,'[{\"id_proyek\":\"4\",\"id_pekerjaan\":\"1\",\"id_detail_pekerjaan\":\"7\",\"nama_pekerjaan\":\"Pagar Pengaman Proyek\",\"volume\":\"55.00\",\"satuan\":\"m2\",\"bobot\":\"20.08\",\"progress_minggu_lalu\":50,\"bobot_minggu_lalu\":\"10.04\",\"progress_minggu_ini\":25,\"bobot_minggu_ini\":\"5.02\",\"progress_total\":\"75\",\"bobot_total\":\"15.06\"},{\"id_proyek\":\"4\",\"id_pekerjaan\":\"2\",\"id_detail_pekerjaan\":\"8\",\"nama_pekerjaan\":\"Pengukuran\\/Bouwplank\",\"volume\":\"55.00\",\"satuan\":\"m2\",\"bobot\":\"79.92\",\"progress_minggu_lalu\":50,\"bobot_minggu_lalu\":\"39.96\",\"progress_minggu_ini\":25,\"bobot_minggu_ini\":\"19.98\",\"progress_total\":\"75\",\"bobot_total\":\"59.94\"}]',3,50.00,25.00,70.00,3,3,'2025-05-12 12:01:10','2025-05-12 12:01:10',75.00,'2025-05-12','2025-05-18');
/*!40000 ALTER TABLE `laporan_mingguans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL,
  `conversions_disk` varchar(255) DEFAULT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2021_11_09_064224_create_user_profiles_table',1),(5,'2021_11_11_110731_create_permission_tables',1),(6,'2021_11_16_114009_create_media_table',1),(7,'2025_04_13_044056_create_proyeks_table',2),(9,'2025_04_13_083322_create_bahans_table',2),(10,'2025_04_13_083406_create_pekerjaans_table',2),(11,'2025_04_13_083407_create_detail_pekerjaans_table',3),(12,'2025_04_17_161533_create_laporan_mingguans_table',4),(16,'2025_04_22_134915_create_dokumentasi_mingguans_table',5),(17,'2025_04_24_161132_create_cuaca_mingguans_table',5),(18,'2025_04_25_170228_create_laporan_harians_table',6),(19,'2025_04_27_091951_create_tenaga_kerjas_table',7),(20,'2025_04_28_151053_create_ccos_table',8),(22,'2025_04_30_143955_create_preorders_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
-- Table structure for table `pekerjaans`
--

DROP TABLE IF EXISTS `pekerjaans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pekerjaans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pekerjaans_nama_unique` (`nama`),
  KEY `pekerjaans_created_by_foreign` (`created_by`),
  KEY `pekerjaans_updated_by_foreign` (`updated_by`),
  CONSTRAINT `pekerjaans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `pekerjaans_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pekerjaans`
--

LOCK TABLES `pekerjaans` WRITE;
/*!40000 ALTER TABLE `pekerjaans` DISABLE KEYS */;
INSERT INTO `pekerjaans` VALUES (1,'Pekerjaan Persiapan',2,2,'2025-04-13 10:09:40','2025-04-13 10:12:00'),(2,'Pekerjaan Galian dan Urugan',2,2,'2025-04-13 10:12:35','2025-04-13 10:12:35'),(3,'Pekerjaan Pondasi',2,2,'2025-04-16 10:13:10','2025-04-16 10:13:10');
/*!40000 ALTER TABLE `pekerjaans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'role','Role','web',NULL,'2025-04-08 07:18:06','2025-04-08 07:18:06'),(2,'role-add','Role Add','web',1,'2025-04-08 07:18:06','2025-04-08 07:18:06'),(3,'role-list','Role List','web',1,'2025-04-08 07:18:06','2025-04-08 07:18:06'),(4,'permission','Permission','web',NULL,'2025-04-08 07:18:06','2025-04-08 07:18:06'),(5,'permission-add','Permission Add','web',4,'2025-04-08 07:18:06','2025-04-08 07:18:06'),(6,'permission-list','Permission List','web',4,'2025-04-08 07:18:06','2025-04-08 07:18:06');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preorders`
--

DROP TABLE IF EXISTS `preorders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preorders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_proyek` bigint(20) unsigned NOT NULL,
  `id_laporan_mingguan` bigint(20) unsigned NOT NULL,
  `no_po` varchar(255) NOT NULL,
  `minggu_ke` bigint(20) NOT NULL,
  `list_pesanan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_pesanan`)),
  `dari` date NOT NULL,
  `sampai` date NOT NULL,
  `total` decimal(16,2) DEFAULT NULL,
  `bobot_total` decimal(16,2) DEFAULT NULL,
  `status` bigint(20) NOT NULL,
  `kode_bayar` varchar(255) NOT NULL,
  `approved_manager_by` bigint(20) unsigned DEFAULT NULL,
  `approved_manager_at` timestamp NULL DEFAULT NULL,
  `approved_owner_by` bigint(20) unsigned DEFAULT NULL,
  `approved_owner_at` timestamp NULL DEFAULT NULL,
  `approved_finance_by` bigint(20) unsigned DEFAULT NULL,
  `approved_finance_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `preorders_id_proyek_foreign` (`id_proyek`),
  KEY `preorders_id_laporan_mingguan_foreign` (`id_laporan_mingguan`),
  KEY `preorders_approved_manager_by_foreign` (`approved_manager_by`),
  KEY `preorders_approved_owner_by_foreign` (`approved_owner_by`),
  KEY `preorders_approved_finance_by_foreign` (`approved_finance_by`),
  KEY `preorders_created_by_foreign` (`created_by`),
  KEY `preorders_updated_by_foreign` (`updated_by`),
  CONSTRAINT `preorders_approved_finance_by_foreign` FOREIGN KEY (`approved_finance_by`) REFERENCES `users` (`id`),
  CONSTRAINT `preorders_approved_manager_by_foreign` FOREIGN KEY (`approved_manager_by`) REFERENCES `users` (`id`),
  CONSTRAINT `preorders_approved_owner_by_foreign` FOREIGN KEY (`approved_owner_by`) REFERENCES `users` (`id`),
  CONSTRAINT `preorders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `preorders_id_laporan_mingguan_foreign` FOREIGN KEY (`id_laporan_mingguan`) REFERENCES `laporan_mingguans` (`id`),
  CONSTRAINT `preorders_id_proyek_foreign` FOREIGN KEY (`id_proyek`) REFERENCES `proyeks` (`id`),
  CONSTRAINT `preorders_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preorders`
--

LOCK TABLES `preorders` WRITE;
/*!40000 ALTER TABLE `preorders` DISABLE KEYS */;
INSERT INTO `preorders` VALUES (1,1,1,'PO-2505-0001',1,'[{\"nama\":\"Perekat Hebel\",\"volume\":\"20\",\"satuan\":\"Zak\",\"harga\":\"77500\",\"total\":1550000}]','2025-03-24','2025-03-30',1550000.00,20.00,4,'xUHjUBLWv8',4,'2025-05-03 00:14:10',5,'2025-05-03 00:24:17',6,'2025-05-03 07:26:40',3,6,'2025-05-01 00:10:26','2025-05-03 07:26:40'),(3,1,2,'PO-2505-0002',2,'[{\"nama\":\"Perekat Hebel\",\"volume\":\"20\",\"satuan\":\"Zak\",\"harga\":\"77500\",\"total\":1550000},{\"nama\":\"Kawat Beton 25 Kg\",\"volume\":\"1\",\"satuan\":\"Roll\",\"harga\":\"415000\",\"total\":415000},{\"nama\":\"Tdus\",\"volume\":\"150\",\"satuan\":\"Bh\",\"harga\":\"3000\",\"total\":450000},{\"nama\":\"Paku 7\",\"volume\":\"5\",\"satuan\":\"Kg\",\"harga\":\"18500\",\"total\":92500}]','2025-03-31','2025-04-06',2507500.00,48.02,4,'6TBqBPLrTh',4,'2025-05-04 09:17:09',5,'2025-05-04 09:17:42',6,'2025-05-04 12:00:21',3,6,'2025-05-03 09:10:41','2025-05-04 12:00:21'),(4,1,5,'PO-2505-0003',3,'[{\"nama\":\"Test\",\"volume\":\"1\",\"satuan\":\"Zak\",\"harga\":\"10000\",\"total\":10000}]','2025-04-07','2025-04-13',10000.00,64.05,5,'oTWFw2cCDt',4,'2025-05-04 12:04:03',NULL,NULL,NULL,NULL,3,4,'2025-05-04 12:03:44','2025-05-04 12:04:03'),(5,1,5,'PO-2505-0004',3,'[{\"nama\":\"Perekat Hebel\",\"volume\":\"20\",\"satuan\":\"Zak\",\"harga\":\"77500\",\"total\":1550000,\"type\":\"Material\"},{\"nama\":\"Kawat Beton 25 Kg\",\"volume\":\"1\",\"satuan\":\"Roll\",\"harga\":\"415000\",\"total\":415000,\"type\":\"Material\"},{\"nama\":\"Tdus\",\"volume\":\"150\",\"satuan\":\"Bh\",\"harga\":\"3000\",\"total\":450000,\"type\":\"Material\"},{\"nama\":\"DP Ke 5 Pak Sarpras\",\"volume\":\"1\",\"satuan\":\"ls\",\"harga\":\"20000000\",\"total\":20000000,\"type\":\"Upah Borong Non Bangunan\"},{\"nama\":\"Uang Makan + Lembur\",\"volume\":\"1\",\"satuan\":\"Org\",\"harga\":\"2101000\",\"total\":2101000,\"type\":\"Uang Makan Supervisor\"},{\"nama\":\"Passring\",\"volume\":\"14\",\"satuan\":\"Org\",\"harga\":\"1400000\",\"total\":19600000,\"type\":\"Operasional Proyek\"},{\"nama\":\"Biaya Adm Trf\",\"volume\":\"1\",\"satuan\":\"Org\",\"harga\":\"2500\",\"total\":2500,\"type\":\"Adm\"}]','2025-04-07','2025-04-13',44118500.00,64.05,4,'0NGUmzZuwW',4,'2025-05-04 14:10:24',5,'2025-05-04 14:10:44',6,'2025-05-04 14:12:00',3,6,'2025-05-04 13:51:47','2025-05-04 14:12:00'),(7,4,8,'PO-2505-0006',1,'[{\"nama\":\"Perekat Hebel\",\"volume\":\"30\",\"satuan\":\"Zak\",\"harga\":\"77500\",\"total\":2325000,\"type\":\"Material\"}]','2025-04-14','2025-04-20',2325000.00,30.00,1,'ZvPCBBssKo',NULL,NULL,NULL,NULL,NULL,NULL,3,4,'2025-05-05 13:36:00','2025-05-05 15:43:20'),(10,1,6,'PO-2505-0007',4,'[{\"nama\":\"Perekat Hebel\",\"volume\":\"20\",\"satuan\":\"Zak\",\"harga\":\"77500\",\"total\":1550000,\"type\":\"Material\"},{\"nama\":\"Kawat Beton 25 Kg\",\"volume\":\"1\",\"satuan\":\"Roll\",\"harga\":\"41500\",\"total\":41500,\"type\":\"Material\"},{\"nama\":\"Tdus\",\"volume\":\"50\",\"satuan\":\"Bh\",\"harga\":\"3000\",\"total\":150000,\"type\":\"Material\"},{\"nama\":\"DP Ke 5 Pak Sarpras\",\"volume\":\"1\",\"satuan\":\"ls\",\"harga\":\"2000000\",\"total\":2000000,\"type\":\"Upah Borong Bangunan\"}]','2025-04-14','2025-04-20',3741500.00,84.06,4,'PHW2u1AHDG',4,'2025-05-12 11:40:43',5,'2025-05-12 11:41:30',6,'2025-05-12 11:42:33',3,6,'2025-05-12 11:39:20','2025-05-12 11:42:33');
/*!40000 ALTER TABLE `preorders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyeks`
--

DROP TABLE IF EXISTS `proyeks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proyeks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `kontrak` varchar(255) NOT NULL,
  `pelaksana` varchar(255) NOT NULL,
  `direktur` varchar(255) NOT NULL,
  `dari` date DEFAULT NULL,
  `sampai` date DEFAULT NULL,
  `waktu_pelaksanaan` bigint(20) NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tahun_anggaran` varchar(255) NOT NULL,
  `total_meter` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `proyeks_nama_unique` (`nama`),
  KEY `proyeks_created_by_foreign` (`created_by`),
  KEY `proyeks_updated_by_foreign` (`updated_by`),
  CONSTRAINT `proyeks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `proyeks_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyeks`
--

LOCK TABLES `proyeks` WRITE;
/*!40000 ALTER TABLE `proyeks` DISABLE KEYS */;
INSERT INTO `proyeks` VALUES (1,'Proyek Pekerjaan Pembangunan Kantor','Lanud Sultan Iskandar','SPERJ/01/III/2024/LANUD2','CV. Tri Cipta Gemilang','Ananto Pratama Z','2025-03-24','2025-04-27',35,2,2,'2025-04-13 07:40:13','2025-04-27 05:29:44','DIPA 2025',300),(4,'Proyek Pekerjaan Pembangunan Rumah','Lanud Sultan Iskandar','SPERJ/01/III/2024/RUMAH','CV. Tri Cipta Gemilang','Ananto Pratama Z','2025-04-28','2025-10-31',186,2,2,'2025-04-22 04:16:02','2025-04-27 05:30:23','DIPA 2025',250);
/*!40000 ALTER TABLE `proyeks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'system_admin','System Administrator','web',1,'2025-04-08 07:18:06','2025-04-08 07:18:06'),(2,'admin_purchasing','Admin Purchasing','web',1,'2025-04-08 07:18:06','2025-04-08 07:18:06'),(3,'project_manager','Project Manager','web',1,'2025-04-08 07:18:06','2025-04-08 07:18:06'),(4,'owner','Owner','web',1,'2025-04-08 07:18:06','2025-04-08 07:18:06'),(5,'finance','Finance','web',1,'2025-04-08 07:18:06','2025-04-08 07:18:06');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenaga_kerjas`
--

DROP TABLE IF EXISTS `tenaga_kerjas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenaga_kerjas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenaga_kerjas_nama_unique` (`nama`),
  KEY `tenaga_kerjas_created_by_foreign` (`created_by`),
  KEY `tenaga_kerjas_updated_by_foreign` (`updated_by`),
  CONSTRAINT `tenaga_kerjas_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `tenaga_kerjas_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenaga_kerjas`
--

LOCK TABLES `tenaga_kerjas` WRITE;
/*!40000 ALTER TABLE `tenaga_kerjas` DISABLE KEYS */;
INSERT INTO `tenaga_kerjas` VALUES (1,'Project Manager',2,2,'2025-04-27 02:37:58','2025-04-27 02:37:58'),(2,'Site Manager/SPV',2,2,'2025-04-27 02:38:08','2025-04-27 02:38:08'),(3,'Mandor',2,2,'2025-04-27 02:38:15','2025-04-27 02:38:15'),(4,'Tukang',2,2,'2025-04-27 02:38:23','2025-04-27 02:38:23');
/*!40000 ALTER TABLE `tenaga_kerjas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_profiles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `street_addr_1` varchar(255) DEFAULT NULL,
  `street_addr_2` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `alt_phone_number` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pin_code` bigint(20) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `linkdin_url` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
INSERT INTO `user_profiles` VALUES (1,'DigiBiz','Cibitung','Metland','08977361519',NULL,'Indonesia',NULL,'Bekasi',17133,NULL,NULL,NULL,NULL,2,'2025-04-08 07:31:05','2025-04-08 07:31:05');
/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `user_type` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'fikri','Fikri','Hidayat','fikroyz@gmail.com',NULL,NULL,'1','$2y$10$lpn.iOVwh4OO1kxJUxkFluWQ8ALVVj5KFwSnMSfeln1B539HwpoJe','active',NULL,'2025-04-08 07:31:05','2025-04-08 07:31:05'),(3,'admin596','Test','Admin','admin@gmail.com',NULL,NULL,'2','$2y$10$/.XLJw3MX/XqIuWsM9E3Juia7K8Loa0aonHdlRVzum1heWGIysh9a','active',NULL,'2025-04-30 07:28:09','2025-04-30 07:28:09'),(4,'manager205','Test','Manager','manager@gmail.com',NULL,NULL,'3','$2y$10$hGRlroqxlz2voyiatcjAIOcCqF6gEZpA.LOSLynlLxUGT7RsuuQwS','active',NULL,'2025-04-30 07:32:21','2025-04-30 07:32:21'),(5,'owner907','Test','Owner','owner@gmail.com',NULL,NULL,'4','$2y$10$THQswlD94n.PeFiv6Jrm1ONLMpUJPY5oXLwpcHZsqk3H1YXG0dknS','active',NULL,'2025-04-30 07:35:37','2025-04-30 07:35:37'),(6,'finance744','Test','Finance','finance@gmail.com',NULL,NULL,'5','$2y$10$iQL491pDVfLDkEFO0bbpM.sEku2JieXFEqdLwkGMzVdQAYnl6JxBu','active',NULL,'2025-04-30 07:35:55','2025-04-30 07:35:55');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'portal-construction-2'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-21 20:47:20
