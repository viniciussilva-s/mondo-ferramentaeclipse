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
-- Table structure for table `prev_registers`
--

DROP TABLE IF EXISTS `prev_registers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prev_registers` (
  `id_register` int(11) NOT NULL AUTO_INCREMENT,
  `original_menu` varchar(255) NOT NULL,
  `original_local` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `keep_content` tinyint(4) NOT NULL DEFAULT '1',
  `description` varchar(500) NOT NULL DEFAULT '',
  `id_user` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_register`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prev_registers`
--

LOCK TABLES `prev_registers` WRITE;
/*!40000 ALTER TABLE `prev_registers` DISABLE KEYS */;
INSERT INTO `prev_registers` VALUES (38,'_T menu ñ mantido','_T loca ñ mantido','_T Nome ñ mantido',0,'_T motivo ',1,'2019-09-05 11:49:36'),(39,'_T Menu Mantido','_T Loc Mantido','_T Nome Mantido',1,'',1,'2019-09-05 11:50:18'),(40,'n/c','n/c','_TEdu',1,'',23,'2019-09-05 14:55:49'),(41,'','','Rem',1,'',23,'2019-09-05 15:06:20'),(42,'Financeiro > Pagamentos > ','local_atual','Reembolso',1,'',23,'2019-09-05 15:45:06'),(43,'n/c','n/c','oferta',1,'',23,'2019-09-05 16:15:38'),(44,'n/c','n/c','xxxxx',1,'',23,'2019-09-06 10:31:08');
/*!40000 ALTER TABLE `prev_registers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-10 14:06:57
