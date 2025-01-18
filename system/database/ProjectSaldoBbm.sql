-- MySQL dump 10.13  Distrib 8.0.40, for macos14 (arm64)
--
-- Host: 127.0.0.1    Database: saldo_bbm
-- ------------------------------------------------------
-- Server version	8.0.40

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

--
-- Table structure for table `aktifitas_mobil`
--

DROP TABLE IF EXISTS `aktifitas_mobil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aktifitas_mobil` (
  `aktifitas_id` int NOT NULL AUTO_INCREMENT,
  `mobil_id` int NOT NULL,
  `sopir_id` int NOT NULL,
  `jarak_tempuh_aktifitas` decimal(10,2) NOT NULL,
  `bbm_terpakai` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`aktifitas_id`),
  KEY `mobil_id` (`mobil_id`),
  KEY `sopir_id` (`sopir_id`),
  CONSTRAINT `aktifitas_mobil_ibfk_1` FOREIGN KEY (`mobil_id`) REFERENCES `master_mobil` (`mobil_id`) ON DELETE CASCADE,
  CONSTRAINT `aktifitas_mobil_ibfk_2` FOREIGN KEY (`sopir_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bbm`
--

DROP TABLE IF EXISTS `bbm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bbm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(45) NOT NULL,
  `harga` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_mobil`
--

DROP TABLE IF EXISTS `master_mobil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_mobil` (
  `mobil_id` int NOT NULL AUTO_INCREMENT,
  `nomor_plat` varchar(20) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `saldo_awal` decimal(10,2) NOT NULL,
  `jarak_tempuh_per_liter` decimal(10,2) NOT NULL,
  `gambar_mobil` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mobil_id`),
  UNIQUE KEY `nomor_plat` (`nomor_plat`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$ 
CREATE TRIGGER after_mobil_insert AFTER INSERT ON master_mobil FOR EACH ROW BEGIN INSERT INTO saldo_bbm_log (mobil_id, tipe_aktivitas, jumlah_saldo, keterangan) VALUES (NEW.mobil_id, 'saldo_awal', NEW.saldo_awal, 'Saldo awal saat pembuatan data mobil'); END
$$ DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `merek_mobil`
--

DROP TABLE IF EXISTS `merek_mobil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `merek_mobil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_merek` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `request_pengisian_bbm`
--

DROP TABLE IF EXISTS `request_pengisian_bbm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `request_pengisian_bbm` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `mobil_id` int NOT NULL,
  `sopir_id` int NOT NULL,
  `jenis_bbm` varchar(50) NOT NULL,
  `jumlah_liter` decimal(10,2) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` int DEFAULT NULL,
  PRIMARY KEY (`request_id`),
  KEY `mobil_id` (`mobil_id`),
  KEY `sopir_id` (`sopir_id`),
  KEY `approved_by` (`approved_by`),
  CONSTRAINT `request_pengisian_bbm_ibfk_1` FOREIGN KEY (`mobil_id`) REFERENCES `master_mobil` (`mobil_id`) ON DELETE CASCADE,
  CONSTRAINT `request_pengisian_bbm_ibfk_2` FOREIGN KEY (`sopir_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `request_pengisian_bbm_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saldo_bbm_log`
--

DROP TABLE IF EXISTS `saldo_bbm_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `saldo_bbm_log` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `mobil_id` int NOT NULL,
  `tipe_aktivitas` enum('saldo_awal','pengisian','penggunaan') NOT NULL,
  `jumlah_saldo` decimal(10,2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `mobil_id` (`mobil_id`),
  CONSTRAINT `saldo_bbm_log_ibfk_1` FOREIGN KEY (`mobil_id`) REFERENCES `master_mobil` (`mobil_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipe_mobil`
--

DROP TABLE IF EXISTS `tipe_mobil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipe_mobil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_merek` int NOT NULL,
  `nama_tipe` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_merek` (`id_merek`),
  CONSTRAINT `tipe_mobil_ibfk_1` FOREIGN KEY (`id_merek`) REFERENCES `merek_mobil` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','sopir') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `merek_mobil` (`nama_merek`) VALUES ('Toyota'), ('Honda'), ('Suzuki'); 
INSERT INTO `tipe_mobil` (`id_merek`, `nama_tipe`) VALUES (1, 'Avanza'), (1, 'Fortuner'), (2, 'Civic'), (2, 'CR-V'), (3, 'Ertiga'), (3, 'Baleno');
-- Dump completed on 2025-01-18 11:53:31
