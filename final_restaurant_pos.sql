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

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ 'b528e4a2-1f52-11f0-a3de-7a318818dd0e:1-526';

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
  PRIMARY KEY (`PersonelID`),
  UNIQUE KEY `Telefon` (`Telefon`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PERSONEL`
--

LOCK TABLES `PERSONEL` WRITE;
/*!40000 ALTER TABLE `PERSONEL` DISABLE KEYS */;
INSERT INTO `PERSONEL` VALUES (1,'Ahmad','Pratama','05311111111','Yönetici','E'),(2,'Siti','Lestari','05322222222','Kasiyer','E');
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SATIS`
--

LOCK TABLES `SATIS` WRITE;
/*!40000 ALTER TABLE `SATIS` DISABLE KEYS */;
INSERT INTO `SATIS` VALUES (1,'2026-05-20 21:25:54','Salon',5,450.00,0.00,450.00,'Nakit','Aktif',2),(2,'2026-05-20 21:25:54','Paket',NULL,310.00,20.00,290.00,'Kart','Aktif',2),(3,'2026-05-20 21:58:04','Paket',1,660.00,200.00,460.00,'Nakit','Aktif',2),(4,'2026-05-20 21:59:09','Salon',1,525.00,0.00,525.00,'Nakit','Aktif',2),(5,'2026-05-20 22:14:09','Salon',1,950.00,0.00,950.00,'Nakit','Aktif',2),(6,'2026-05-20 22:18:10','Salon',1,220.00,0.00,220.00,'Nakit','Aktif',2),(7,'2026-05-20 22:18:43','Salon',1,880.00,0.00,880.00,'Nakit','Aktif',2),(8,'2026-05-20 22:19:01','Salon',1,515.00,0.00,515.00,'Nakit','Aktif',2),(9,'2026-05-20 22:21:39','Salon',1,220.00,0.00,220.00,'Nakit','Aktif',2),(10,'2026-05-20 22:21:44','Salon',1,880.00,0.00,880.00,'Nakit','Aktif',2),(11,'2026-05-20 22:29:45','Salon',1,220.00,0.00,220.00,'Nakit','Aktif',2),(12,'2026-05-20 22:34:44','Salon',1,620.00,0.00,620.00,'Nakit','Aktif',2);
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SATIS_DETAY`
--

LOCK TABLES `SATIS_DETAY` WRITE;
/*!40000 ALTER TABLE `SATIS_DETAY` DISABLE KEYS */;
INSERT INTO `SATIS_DETAY` VALUES (1,1,1,2,180.00,360.00),(2,1,6,2,45.00,90.00),(3,2,3,1,220.00,220.00),(4,2,5,1,90.00,90.00),(5,3,2,1,170.00,170.00),(6,3,1,1,180.00,180.00),(7,3,3,1,220.00,220.00),(8,3,5,1,90.00,90.00),(9,4,5,1,90.00,90.00),(10,4,6,1,45.00,45.00),(11,4,3,1,220.00,220.00),(12,4,2,1,170.00,170.00),(13,5,3,1,220.00,220.00),(14,5,2,1,170.00,170.00),(15,5,1,1,180.00,180.00),(16,5,4,1,160.00,160.00),(17,5,3,1,220.00,220.00),(18,6,3,1,220.00,220.00),(19,7,3,4,220.00,880.00),(20,8,3,1,220.00,220.00),(21,8,5,1,90.00,90.00),(22,8,6,1,45.00,45.00),(23,8,4,1,160.00,160.00),(24,9,3,1,220.00,220.00),(25,10,3,4,220.00,880.00),(26,11,3,1,220.00,220.00),(27,12,3,2,220.00,440.00),(28,12,5,2,90.00,180.00);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `URUN`
--

LOCK TABLES `URUN` WRITE;
/*!40000 ALTER TABLE `URUN` DISABLE KEYS */;
INSERT INTO `URUN` VALUES (1,'Nasi Goreng',180.00,'E',1),(2,'Mie Goreng',170.00,'E',1),(3,'Satay Ayam',220.00,'E',1),(4,'Soto Ayam',160.00,'E',2),(5,'Pisang Goreng',90.00,'E',3),(6,'Es Teh Manis',45.00,'E',4);
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

-- Dump completed on 2026-05-20 22:39:06
