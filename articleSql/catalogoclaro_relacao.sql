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
-- Table structure for table `relacao`
--

DROP TABLE IF EXISTS `relacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `relacao` (
  `id_relac` int(11) NOT NULL AUTO_INCREMENT,
  `id_marca` int(2) unsigned zerofill NOT NULL,
  `id_prod` int(2) unsigned zerofill NOT NULL,
  `id_subprod` int(2) unsigned zerofill DEFAULT NULL,
  `id_geral` int(2) unsigned zerofill DEFAULT NULL,
  `id_segm` int(2) unsigned zerofill DEFAULT NULL,
  `id_especif` int(2) unsigned zerofill DEFAULT NULL,
  `adds` mediumtext,
  PRIMARY KEY (`id_relac`),
  UNIQUE KEY `id_marca` (`id_marca`,`id_prod`,`id_subprod`,`id_geral`,`id_segm`,`id_especif`),
  KEY `fk_RELACAO_MARCA_idx` (`id_marca`),
  KEY `fk_RELACAO_PRODUTO1_idx` (`id_prod`),
  KEY `fk_RELACAO_ASS_ESPECIF1_idx` (`id_especif`),
  KEY `fk_RELACAO_ASS_GERAL1_idx` (`id_geral`),
  KEY `fk_RELACAO_SUBPRODUTO` (`id_subprod`),
  KEY `fk_RELACAO_SEGMENTO` (`id_segm`),
  CONSTRAINT `fk_RELACAO_ASS_ESPECIF1` FOREIGN KEY (`id_especif`) REFERENCES `ass_especif` (`id_especif`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_RELACAO_ASS_GERAL1` FOREIGN KEY (`id_geral`) REFERENCES `ass_geral` (`id_geral`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_RELACAO_MARCA` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id_marca`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_RELACAO_PRODUTO1` FOREIGN KEY (`id_prod`) REFERENCES `produto` (`id_prod`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_RELACAO_SEGMENTO` FOREIGN KEY (`id_segm`) REFERENCES `segmentos` (`id_segm`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_RELACAO_SUBPRODUTO` FOREIGN KEY (`id_subprod`) REFERENCES `sub_produto` (`id_subprod`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relacao`
--

LOCK TABLES `relacao` WRITE;
/*!40000 ALTER TABLE `relacao` DISABLE KEYS */;
INSERT INTO `relacao` VALUES (2,03,01,03,06,01,10,'<agendamento ordem de serviço>\n'),(3,03,03,04,05,01,08,'<endereço de cobrança>'),(4,01,03,09,05,01,08,'<detalhamento de ligações fixo>'),(5,05,03,01,05,01,08,'Detalhamento de ligações fixo'),(6,05,04,01,05,01,08,'Desmembramento de fatura'),(7,03,04,05,05,01,08,'<endereço de cobrança>'),(8,03,04,06,05,01,08,'<endereço de cobrança>'),(9,03,04,07,05,01,08,'<endereço de cobrança>'),(10,01,04,07,05,01,08,'<endereço de cobrança>'),(12,03,02,02,05,01,08,'<endereço de cobrança>'),(13,03,01,03,05,01,08,'<endereço de cobrança>'),(20,01,02,10,05,01,08,'<endereço de cobrança>'),(21,01,02,11,05,01,08,'<endereço de cobrança>'),(22,01,02,12,05,01,08,'<endereço de cobrança>'),(25,04,04,08,09,01,08,''),(26,04,03,08,09,01,08,''),(27,03,01,03,05,01,11,'Pagamentos em atraso');
/*!40000 ALTER TABLE `relacao` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-10 14:06:59
