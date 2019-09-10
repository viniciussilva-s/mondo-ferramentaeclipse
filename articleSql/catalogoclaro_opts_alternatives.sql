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
-- Table structure for table `opts_alternatives`
--

DROP TABLE IF EXISTS `opts_alternatives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opts_alternatives` (
  `id_alt` int(11) NOT NULL AUTO_INCREMENT,
  `id_option` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_alternatives` smallint(11) DEFAULT '1',
  PRIMARY KEY (`id_alt`),
  UNIQUE KEY `id_option` (`id_option`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opts_alternatives`
--

LOCK TABLES `opts_alternatives` WRITE;
/*!40000 ALTER TABLE `opts_alternatives` DISABLE KEYS */;
INSERT INTO `opts_alternatives` VALUES (18,1,'Claro','2019-08-22 14:04:50',0),(22,2,'TV','2019-08-22 14:05:25',1),(24,3,'Produto','2019-08-22 14:06:02',0),(30,5,'Segmento','2019-08-22 14:06:57',0),(32,6,'Assunto Especifico','2019-08-22 14:07:21',0),(80,4,'Assunto Geral','2019-08-29 17:19:24',0),(81,1,'Claro tv','2019-09-02 10:30:34',1),(82,1,'Claro net','2019-09-02 10:30:34',1),(83,1,'Embratel','2019-09-02 10:30:34',1),(84,2,'Internet','2019-09-02 10:31:59',1),(85,2,'Fone','2019-09-02 10:34:56',1),(86,3,'Claro net fone','2019-09-02 10:38:38',1),(87,3,'Claro net fone empresas','2019-09-02 10:38:38',1),(88,3,'Claro net virtua empresas','2019-09-02 10:38:38',1),(89,3,'Claro net virtua','2019-09-02 10:38:38',1),(90,3,'Claro net tv empresas','2019-09-02 10:38:38',1),(91,3,'Claro net tv','2019-09-02 10:38:38',1),(92,4,'Planos','2019-09-02 10:40:03',1),(94,4,'Recursos digitais','2019-09-02 10:40:03',1),(95,4,'Serviços','2019-09-02 10:40:03',0),(96,6,'POPs','2019-09-02 10:40:34',1),(97,4,'Banco de dados','2019-09-02 10:50:35',1),(102,2,'Serviços','2019-09-02 11:29:39',1),(103,2,'Operações','2019-09-02 11:29:39',0),(104,4,'Atendimento especializado','2019-09-02 11:44:40',1),(105,5,'Alto propensos','2019-09-02 11:45:11',0),(106,5,' ','2019-09-02 13:13:33',1),(107,6,' ','2019-09-02 13:13:53',1),(108,1,' ','2019-09-02 13:15:04',1),(109,2,' ','2019-09-02 13:15:16',1),(110,3,' ','2019-09-02 13:15:35',1),(111,6,'Ocorrências','2019-09-02 13:16:03',1),(115,4,'Pacotes','2019-09-02 15:49:22',1),(116,4,'Serviços adicionais','2019-09-02 15:49:22',1),(122,4,' ','2019-09-02 18:02:54',1),(126,1,'Nextel','2019-09-05 14:54:08',1);
/*!40000 ALTER TABLE `opts_alternatives` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-10 14:06:54
