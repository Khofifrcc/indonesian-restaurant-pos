-- MySQL dump 10.13  Distrib 9.6.0, for macos26.3 (arm64)
--
-- Host: localhost    Database: indonesian_restaurant_pos
-- ------------------------------------------------------
-- Server version	9.6.0

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ 'b528e4a2-1f52-11f0-a3de-7a318818dd0e:1-683';

--
-- Table structure for table `GIRIS`
--

DROP TABLE IF EXISTS `GIRIS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `GIRIS` (
  `GirisID` int NOT NULL AUTO_INCREMENT,
  `PersonelID` int NOT NULL,
  `KullaniciAdi` varchar(50) NOT NULL,
  `Sifre` varchar(100) NOT NULL,
  `Rol` enum('Kasiyer','Yönetici') NOT NULL,
  PRIMARY KEY (`GirisID`),
  UNIQUE KEY `KullaniciAdi` (`KullaniciAdi`),
  KEY `PersonelID` (`PersonelID`),
  CONSTRAINT `giris_ibfk_1` FOREIGN KEY (`PersonelID`) REFERENCES `PERSONEL` (`PersonelID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GIRIS`
--

LOCK TABLES `GIRIS` WRITE;
/*!40000 ALTER TABLE `GIRIS` DISABLE KEYS */;
INSERT INTO `GIRIS` VALUES (1,1,'admin','1234','Yönetici'),(2,2,'kasiyer','1234','Kasiyer');
/*!40000 ALTER TABLE `GIRIS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `KATEGORI`
--

DROP TABLE IF EXISTS `KATEGORI`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `KATEGORI` (
  `KategoriID` int NOT NULL AUTO_INCREMENT,
  `KategoriAdi` varchar(50) NOT NULL,
  `Aciklama` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`KategoriID`),
  UNIQUE KEY `KategoriAdi` (`KategoriAdi`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `KATEGORI`
--

LOCK TABLES `KATEGORI` WRITE;
/*!40000 ALTER TABLE `KATEGORI` DISABLE KEYS */;
INSERT INTO `KATEGORI` VALUES (1,'Ana Yemek','Endonezya ana yemekleri'),(2,'Corba','Sıcak çorba çeşitleri'),(3,'Tatlı','Endonezya tatlıları'),(4,'İçecek','Soğuk ve sıcak içecekler');
/*!40000 ALTER TABLE `KATEGORI` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PERSONEL`
--

DROP TABLE IF EXISTS `PERSONEL`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PERSONEL` (
  `PersonelID` int NOT NULL AUTO_INCREMENT,
  `Ad` varchar(50) NOT NULL,
  `Soyad` varchar(50) NOT NULL,
  `Telefon` varchar(20) DEFAULT NULL,
  `Gorev` enum('Kasiyer','Yönetici') NOT NULL,
  `AktifMi` enum('E','H') DEFAULT 'E',
  `KullaniciAdi` varchar(50) DEFAULT NULL,
  `Sifre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PersonelID`),
  UNIQUE KEY `Telefon` (`Telefon`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PERSONEL`
--

LOCK TABLES `PERSONEL` WRITE;
/*!40000 ALTER TABLE `PERSONEL` DISABLE KEYS */;
INSERT INTO `PERSONEL` VALUES (1,'Ahmad','Pratama','05311111111','Yönetici','E','admin','1234'),(2,'Siti','Lestari','05322222222','Kasiyer','E','kasir1','1111'),(3,'khofif','Cahyani','05012395474','Kasiyer','E','kasir2','2222');
/*!40000 ALTER TABLE `PERSONEL` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SATIS`
--

DROP TABLE IF EXISTS `SATIS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SATIS` (
  `SatisID` int NOT NULL AUTO_INCREMENT,
  `SatisTarihiSaat` datetime DEFAULT CURRENT_TIMESTAMP,
  `SatisTipi` enum('Salon','Paket') NOT NULL,
  `MasaNo` int DEFAULT NULL,
  `AraToplam` decimal(10,2) DEFAULT '0.00',
  `Indirim` decimal(10,2) DEFAULT '0.00',
  `ToplamTutar` decimal(10,2) DEFAULT '0.00',
  `OdemeYontemi` enum('Nakit','Kart') NOT NULL,
  `Durum` enum('Aktif','İptal') DEFAULT 'Aktif',
  `PersonelID` int NOT NULL,
  PRIMARY KEY (`SatisID`),
  KEY `PersonelID` (`PersonelID`),
  CONSTRAINT `satis_ibfk_1` FOREIGN KEY (`PersonelID`) REFERENCES `PERSONEL` (`PersonelID`),
  CONSTRAINT `satis_chk_1` CHECK ((`Indirim` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SATIS`
--

LOCK TABLES `SATIS` WRITE;
/*!40000 ALTER TABLE `SATIS` DISABLE KEYS */;
INSERT INTO `SATIS` VALUES (1,'2026-05-20 21:25:54','Salon',5,450.00,0.00,450.00,'Nakit','Aktif',2),(2,'2026-05-20 21:25:54','Paket',NULL,310.00,20.00,290.00,'Kart','Aktif',2),(3,'2026-05-20 21:58:04','Paket',1,660.00,200.00,460.00,'Nakit','Aktif',2),(4,'2026-05-20 21:59:09','Salon',1,525.00,0.00,525.00,'Nakit','Aktif',2),(5,'2026-05-20 22:14:09','Salon',1,950.00,0.00,950.00,'Nakit','Aktif',2),(6,'2026-05-20 22:18:10','Salon',1,220.00,0.00,220.00,'Nakit','Aktif',2),(7,'2026-05-20 22:18:43','Salon',1,880.00,0.00,880.00,'Nakit','Aktif',2),(8,'2026-05-20 22:19:01','Salon',1,515.00,0.00,515.00,'Nakit','Aktif',2),(9,'2026-05-20 22:21:39','Salon',1,220.00,0.00,220.00,'Nakit','Aktif',2),(10,'2026-05-20 22:21:44','Salon',1,880.00,0.00,880.00,'Nakit','Aktif',2),(11,'2026-05-20 22:29:45','Salon',1,220.00,0.00,220.00,'Nakit','Aktif',2),(12,'2026-05-20 22:34:44','Salon',1,620.00,0.00,620.00,'Nakit','Aktif',2),(13,'2026-05-20 23:24:55','Salon',1,1335.00,0.00,1335.00,'Nakit','Aktif',2),(14,'2026-05-20 23:29:28','Salon',1,265.00,0.00,265.00,'Nakit','Aktif',2),(15,'2026-05-20 23:33:03','Salon',1,265.00,0.00,265.00,'Nakit','Aktif',2),(16,'2026-05-20 23:40:14','Salon',1,595.00,0.00,595.00,'Nakit','Aktif',2),(17,'2026-05-20 23:42:06','Salon',1,595.00,0.00,595.00,'Nakit','Aktif',2),(18,'2026-05-20 23:42:17','Salon',1,425.00,0.00,425.00,'Nakit','Aktif',2),(19,'2026-05-20 23:44:30','Salon',1,595.00,0.00,595.00,'Nakit','Aktif',2),(20,'2026-05-20 23:53:21','Salon',1,435.00,0.00,435.00,'Nakit','Aktif',2),(21,'2026-05-21 11:58:20','Salon',1,425.00,0.00,425.00,'Nakit','Aktif',2),(22,'2026-05-21 12:07:19','Salon',1,550.00,0.00,550.00,'Nakit','Aktif',2),(23,'2026-05-24 00:27:56','Salon',2,570.00,0.00,570.00,'Nakit','Aktif',2),(24,'2026-05-24 00:30:22','Salon',1,435.00,0.00,435.00,'Nakit','Aktif',2),(25,'2026-05-24 00:35:26','Salon',1,640.00,0.00,640.00,'Nakit','Aktif',2),(26,'2026-05-24 01:21:56','Salon',1,560.00,0.00,560.00,'Nakit','Aktif',3),(27,'2026-05-24 01:25:22','Salon',1,440.00,0.00,440.00,'Nakit','Aktif',3),(28,'2026-05-24 01:46:12','Salon',1,360.00,0.00,360.00,'Nakit','Aktif',2),(29,'2026-05-24 02:21:41','Salon',1,390.00,0.00,390.00,'Nakit','Aktif',1),(30,'2026-05-24 02:21:56','Salon',1,390.00,0.00,390.00,'Nakit','Aktif',1),(31,'2026-05-24 02:58:40','Salon',3,220.00,0.00,220.00,'Nakit','Aktif',1),(32,'2026-05-24 02:59:13','Salon',1,170.00,0.00,170.00,'Kart','Aktif',1),(33,'2026-05-24 03:03:35','Salon',1,220.00,0.00,220.00,'Nakit','Aktif',1),(34,'2026-05-24 03:08:44','Salon',1,170.00,0.00,170.00,'Nakit','Aktif',1),(35,'2026-05-24 03:24:27','Paket',NULL,520.00,0.00,520.00,'Kart','Aktif',1),(36,'2026-05-24 10:00:02','Salon',1,1190.00,595.00,595.00,'Kart','Aktif',2),(37,'2026-05-24 10:03:55','Salon',1,440.00,0.00,440.00,'Nakit','Aktif',2),(38,'2026-05-24 10:08:08','Salon',1,950.00,0.00,950.00,'Nakit','Aktif',2),(39,'2026-05-24 10:09:57','Paket',NULL,580.00,0.00,580.00,'Nakit','Aktif',2),(40,'2026-05-24 10:15:42','Paket',NULL,850.00,0.00,850.00,'Nakit','Aktif',2),(41,'2026-05-24 10:17:17','Paket',NULL,160.00,0.00,160.00,'Nakit','Aktif',2),(42,'2026-05-24 10:18:10','Paket',NULL,160.00,0.00,160.00,'Nakit','Aktif',2),(43,'2026-05-24 10:19:27','Paket',NULL,45.00,0.00,45.00,'Nakit','Aktif',2),(44,'2026-05-24 10:20:30','Salon',1,850.00,0.00,850.00,'Nakit','Aktif',2),(45,'2026-05-24 10:20:47','Salon',1,390.00,78.00,312.00,'Nakit','Aktif',2),(46,'2026-05-24 10:22:19','Salon',1,500.00,0.00,500.00,'Nakit','Aktif',2),(47,'2026-05-24 10:22:30','Salon',1,430.00,129.00,301.00,'Nakit','Aktif',2),(48,'2026-05-24 10:24:34','Salon',1,295.00,0.00,295.00,'Nakit','Aktif',2),(49,'2026-05-24 10:24:49','Salon',1,550.00,55.00,495.00,'Nakit','Aktif',2),(50,'2026-05-24 10:31:09','Salon',1,170.00,0.00,170.00,'Nakit','Aktif',2),(51,'2026-05-24 10:31:18','Salon',1,470.00,188.00,282.00,'Nakit','Aktif',2);
/*!40000 ALTER TABLE `SATIS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SATIS_DETAY`
--

DROP TABLE IF EXISTS `SATIS_DETAY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SATIS_DETAY` (
  `DetayID` int NOT NULL AUTO_INCREMENT,
  `SatisID` int NOT NULL,
  `UrunID` int NOT NULL,
  `Adet` int NOT NULL,
  `BirimFiyat` decimal(10,2) NOT NULL,
  `SatirToplam` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`DetayID`),
  KEY `SatisID` (`SatisID`),
  KEY `UrunID` (`UrunID`),
  CONSTRAINT `satis_detay_ibfk_1` FOREIGN KEY (`SatisID`) REFERENCES `SATIS` (`SatisID`),
  CONSTRAINT `satis_detay_ibfk_2` FOREIGN KEY (`UrunID`) REFERENCES `URUN` (`UrunID`),
  CONSTRAINT `satis_detay_chk_1` CHECK ((`Adet` > 0)),
  CONSTRAINT `satis_detay_chk_2` CHECK ((`BirimFiyat` > 0))
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SATIS_DETAY`
--

LOCK TABLES `SATIS_DETAY` WRITE;
/*!40000 ALTER TABLE `SATIS_DETAY` DISABLE KEYS */;
INSERT INTO `SATIS_DETAY` VALUES (1,1,1,2,180.00,360.00),(2,1,6,2,45.00,90.00),(3,2,3,1,220.00,220.00),(4,2,5,1,90.00,90.00),(5,3,2,1,170.00,170.00),(6,3,1,1,180.00,180.00),(7,3,3,1,220.00,220.00),(8,3,5,1,90.00,90.00),(9,4,5,1,90.00,90.00),(10,4,6,1,45.00,45.00),(11,4,3,1,220.00,220.00),(12,4,2,1,170.00,170.00),(13,5,3,1,220.00,220.00),(14,5,2,1,170.00,170.00),(15,5,1,1,180.00,180.00),(16,5,4,1,160.00,160.00),(17,5,3,1,220.00,220.00),(18,6,3,1,220.00,220.00),(19,7,3,4,220.00,880.00),(20,8,3,1,220.00,220.00),(21,8,5,1,90.00,90.00),(22,8,6,1,45.00,45.00),(23,8,4,1,160.00,160.00),(24,9,3,1,220.00,220.00),(25,10,3,4,220.00,880.00),(26,11,3,1,220.00,220.00),(27,12,3,2,220.00,440.00),(28,12,5,2,90.00,180.00),(29,13,3,1,220.00,220.00),(30,13,6,1,45.00,45.00),(31,13,4,1,160.00,160.00),(32,13,2,1,170.00,170.00),(33,13,3,1,220.00,220.00),(34,13,1,1,180.00,180.00),(35,13,7,1,250.00,250.00),(36,13,5,1,90.00,90.00),(37,14,3,1,220.00,220.00),(38,14,6,1,45.00,45.00),(39,15,3,1,220.00,220.00),(40,15,6,1,45.00,45.00),(41,16,3,1,220.00,220.00),(42,16,6,1,45.00,45.00),(43,16,2,1,170.00,170.00),(44,16,4,1,160.00,160.00),(45,17,2,1,170.00,170.00),(46,17,3,1,220.00,220.00),(47,17,6,1,45.00,45.00),(48,17,4,1,160.00,160.00),(49,18,3,1,220.00,220.00),(50,18,4,1,160.00,160.00),(51,18,6,1,45.00,45.00),(52,19,3,1,220.00,220.00),(53,19,2,1,170.00,170.00),(54,19,4,1,160.00,160.00),(55,19,6,1,45.00,45.00),(56,20,2,1,170.00,170.00),(57,20,3,1,220.00,220.00),(58,20,6,1,45.00,45.00),(59,21,3,1,220.00,220.00),(60,21,6,1,45.00,45.00),(61,21,4,1,160.00,160.00),(62,22,3,1,220.00,220.00),(63,22,2,1,170.00,170.00),(64,22,4,1,160.00,160.00),(65,23,3,1,220.00,220.00),(66,23,2,1,170.00,170.00),(67,23,1,1,180.00,180.00),(68,24,3,1,220.00,220.00),(69,24,2,1,170.00,170.00),(70,24,6,1,45.00,45.00),(71,25,2,1,170.00,170.00),(72,25,3,1,220.00,220.00),(73,25,7,1,250.00,250.00),(74,26,2,2,170.00,340.00),(75,26,3,1,220.00,220.00),(76,27,3,2,220.00,440.00),(77,28,1,2,180.00,360.00),(78,29,3,1,220.00,220.00),(79,29,2,1,170.00,170.00),(80,30,3,1,220.00,220.00),(81,30,2,1,170.00,170.00),(82,31,3,1,220.00,220.00),(83,32,2,1,170.00,170.00),(84,33,3,1,220.00,220.00),(85,34,2,1,170.00,170.00),(86,35,9,1,300.00,300.00),(87,35,3,1,220.00,220.00),(88,36,2,1,170.00,170.00),(89,36,3,1,220.00,220.00),(90,36,9,1,300.00,300.00),(91,36,5,1,90.00,90.00),(92,36,4,1,160.00,160.00),(93,36,7,1,250.00,250.00),(94,37,3,2,220.00,440.00),(95,38,3,1,220.00,220.00),(96,38,1,1,180.00,180.00),(97,38,7,1,250.00,250.00),(98,38,8,1,300.00,300.00),(99,39,2,1,170.00,170.00),(100,39,7,1,250.00,250.00),(101,39,4,1,160.00,160.00),(102,40,2,1,170.00,170.00),(103,40,3,1,220.00,220.00),(104,40,8,1,300.00,300.00),(105,40,4,1,160.00,160.00),(106,41,4,1,160.00,160.00),(107,42,4,1,160.00,160.00),(108,43,6,1,45.00,45.00),(109,44,8,2,300.00,600.00),(110,44,7,1,250.00,250.00),(111,45,2,1,170.00,170.00),(112,45,3,1,220.00,220.00),(113,46,7,2,250.00,500.00),(114,47,1,1,180.00,180.00),(115,47,7,1,250.00,250.00),(116,48,7,1,250.00,250.00),(117,48,6,1,45.00,45.00),(118,49,7,1,250.00,250.00),(119,49,8,1,300.00,300.00),(120,50,2,1,170.00,170.00),(121,51,2,1,170.00,170.00),(122,51,8,1,300.00,300.00);
/*!40000 ALTER TABLE `SATIS_DETAY` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_satis_detay_insert` BEFORE INSERT ON `satis_detay` FOR EACH ROW BEGIN
    SET NEW.SatirToplam = NEW.Adet * NEW.BirimFiyat;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_satis_detay_after_insert` AFTER INSERT ON `satis_detay` FOR EACH ROW BEGIN
    UPDATE SATIS
    SET AraToplam = fn_satis_toplam(NEW.SatisID),
        ToplamTutar = fn_satis_toplam(NEW.SatisID) - Indirim
    WHERE SatisID = NEW.SatisID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `URUN`
--

DROP TABLE IF EXISTS `URUN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `URUN` (
  `UrunID` int NOT NULL AUTO_INCREMENT,
  `UrunAdi` varchar(100) NOT NULL,
  `BirimFiyat` decimal(10,2) NOT NULL,
  `AktifMi` enum('E','H') DEFAULT 'E',
  `KategoriID` int NOT NULL,
  PRIMARY KEY (`UrunID`),
  KEY `KategoriID` (`KategoriID`),
  CONSTRAINT `urun_ibfk_1` FOREIGN KEY (`KategoriID`) REFERENCES `KATEGORI` (`KategoriID`),
  CONSTRAINT `urun_chk_1` CHECK ((`BirimFiyat` > 0))
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `URUN`
--

LOCK TABLES `URUN` WRITE;
/*!40000 ALTER TABLE `URUN` DISABLE KEYS */;
INSERT INTO `URUN` VALUES (1,'Nasi Goreng',180.00,'H',1),(2,'Mie Goreng',170.00,'E',1),(3,'Satay Ayam',220.00,'E',1),(4,'Soto Ayam',160.00,'E',2),(5,'Pisang Goreng',90.00,'E',3),(6,'Es Teh Manis',45.00,'E',4),(7,'Kwetiau',250.00,'E',1),(8,'Bakso',300.00,'E',1),(9,'Nasi Padang',300.00,'E',1);
/*!40000 ALTER TABLE `URUN` ENABLE KEYS */;
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

-- Dump completed on 2026-05-24 10:40:01
