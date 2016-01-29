-- MySQL dump 10.13  Distrib 5.6.27, for Linux (x86_64)
--
-- Host: localhost    Database: myhomedb
-- ------------------------------------------------------
-- Server version	5.6.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `task_cache_lib`
--

DROP TABLE IF EXISTS `task_cache_lib`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_cache_lib` (
  `t_id` int(4) unsigned DEFAULT NULL,
  `t_date` char(12) DEFAULT NULL,
  `t_exp_time` char(12) DEFAULT NULL COMMENT '预计用时,以秒为单位',
  `t_title` char(100) DEFAULT NULL,
  `t_content` text,
  `t_level` tinyint(1) unsigned DEFAULT NULL COMMENT '1-绿色,2-蓝色,3-黄色,4-橙色,5-红色',
  `t_status` tinyint(1) unsigned DEFAULT '1' COMMENT '(不使用0，因为0判断有问题)1-未开始,2-运行,3-暂停,4-等待,5-停止,6-完成,7-放弃',
  `t_process` text,
  `t_templet` tinyint(1) unsigned DEFAULT '0' COMMENT '任务模板(0=不是,1=是)',
  `c_date` char(12) DEFAULT NULL,
  `t_last_date` char(12) DEFAULT NULL COMMENT '最后更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_cache_lib`
--

LOCK TABLES `task_cache_lib` WRITE;
/*!40000 ALTER TABLE `task_cache_lib` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_cache_lib` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-29 13:12:15
