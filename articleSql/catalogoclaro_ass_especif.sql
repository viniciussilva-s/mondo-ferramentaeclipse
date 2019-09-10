-- MySQL dump 10.13  Distrib 8.0.17, for Win64 (x86_64)
--
-- Host: catalogoclaro.mysql.dbaas.com.br    Database: catalogoclaro
-- ------------------------------------------------------
-- Server version	5.6.40-84.0-log

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
-- Table structure for table `ass_especif`
--

DROP TABLE IF EXISTS `ass_especif`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ass_especif` (
  `prefix` char(1) NOT NULL DEFAULT 'E',
  `id_especif` int(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `nome_especif` varchar(45) NOT NULL,
  PRIMARY KEY (`id_especif`),
  UNIQUE KEY `nome_especif` (`nome_especif`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ass_especif`
--

LOCK TABLES `ass_especif` WRITE;
/*!40000 ALTER TABLE `ass_especif` DISABLE KEYS */;
INSERT INTO `ass_especif` VALUES ('E',01,''),('E',02,'Alteração Cadastral'),('E',03,'Mudança De Pacote'),('E',04,'Mudança De Endereço'),('E',05,'Suspensão Temporária'),('E',06,'Transferência De Titularidade'),('E',07,'Portabilidade'),('E',08,'Fatura'),('E',09,'Ordem De Serviços Técnicos'),('E',10,'Pops'),('E',11,'Pagamentos'),('E',12,'Inadimplência');
/*!40000 ALTER TABLE `ass_especif` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-10 14:07:04
