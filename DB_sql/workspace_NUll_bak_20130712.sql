/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50154
Source Host           : localhost:3306
Source Database       : workspace

Target Server Type    : MYSQL
Target Server Version : 50154
File Encoding         : 65001

Date: 2013-07-12 00:49:11
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `work_account`
-- ----------------------------
DROP TABLE IF EXISTS `work_account`;
CREATE TABLE `work_account` (
  `U_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `U_name` char(20) DEFAULT NULL,
  `U_passwd` char(50) DEFAULT NULL,
  `U_clan_passwd` char(20) DEFAULT NULL,
  `C_date` char(12) DEFAULT NULL,
  PRIMARY KEY (`U_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_account
-- ----------------------------

-- ----------------------------
-- Table structure for `work_conten`
-- ----------------------------
DROP TABLE IF EXISTS `work_conten`;
CREATE TABLE `work_conten` (
  `C_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `P_id` int(4) DEFAULT NULL,
  `R_id` int(4) DEFAULT NULL,
  `U_id` int(4) DEFAULT NULL,
  `C_text` text,
  `C_date` char(12) DEFAULT NULL,
  PRIMARY KEY (`C_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_conten
-- ----------------------------

-- ----------------------------
-- Table structure for `work_documents`
-- ----------------------------
DROP TABLE IF EXISTS `work_documents`;
CREATE TABLE `work_documents` (
  `D_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `P_id` int(4) unsigned DEFAULT NULL,
  `R_id` int(4) DEFAULT NULL,
  `LF_id` int(4) DEFAULT NULL,
  `U_id` int(4) DEFAULT NULL,
  `D_name` char(50) DEFAULT NULL,
  `D_size` int(20) DEFAULT NULL,
  `D_type` int(1) DEFAULT NULL,
  `D_note` char(100) DEFAULT NULL,
  `D_path` char(100) DEFAULT NULL,
  `C_date` char(12) DEFAULT NULL,
  PRIMARY KEY (`D_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_documents
-- ----------------------------

-- ----------------------------
-- Table structure for `work_fqdn`
-- ----------------------------
DROP TABLE IF EXISTS `work_fqdn`;
CREATE TABLE `work_fqdn` (
  `N_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `P_id` int(4) DEFAULT NULL,
  `R_id` int(4) DEFAULT NULL,
  `LF_id` int(4) DEFAULT NULL,
  `S_id` int(4) unsigned DEFAULT NULL,
  `U_id` int(4) DEFAULT NULL,
  `N_name` char(20) DEFAULT NULL,
  `N_FQDN` char(100) DEFAULT NULL,
  `C_date` char(12) DEFAULT NULL,
  PRIMARY KEY (`N_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_fqdn
-- ----------------------------

-- ----------------------------
-- Table structure for `work_leftbar`
-- ----------------------------
DROP TABLE IF EXISTS `work_leftbar`;
CREATE TABLE `work_leftbar` (
  `LF_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `U_id` int(4) DEFAULT NULL,
  `P_id` int(4) DEFAULT NULL,
  `R_id` int(4) unsigned NOT NULL,
  `LF_name` char(50) DEFAULT NULL,
  `LF_note` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`LF_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_leftbar
-- ----------------------------

-- ----------------------------
-- Table structure for `work_location`
-- ----------------------------
DROP TABLE IF EXISTS `work_location`;
CREATE TABLE `work_location` (
  `L_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `U_id` int(4) NOT NULL,
  `L_name` char(25) NOT NULL,
  `L_note` varchar(120) DEFAULT NULL,
  `C_date` char(12) DEFAULT NULL,
  PRIMARY KEY (`L_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_location
-- ----------------------------

-- ----------------------------
-- Table structure for `work_othe`
-- ----------------------------
DROP TABLE IF EXISTS `work_othe`;
CREATE TABLE `work_othe` (
  `O_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `P_id` int(4) DEFAULT NULL,
  `R_id` int(4) DEFAULT NULL,
  `LF_id` int(4) DEFAULT NULL,
  `U_id` int(4) DEFAULT NULL,
  `O_name` char(50) DEFAULT NULL,
  `O_text` text,
  `C_date` char(12) DEFAULT NULL,
  PRIMARY KEY (`O_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_othe
-- ----------------------------

-- ----------------------------
-- Table structure for `work_password`
-- ----------------------------
DROP TABLE IF EXISTS `work_password`;
CREATE TABLE `work_password` (
  `PA_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `P_id` int(4) unsigned DEFAULT NULL,
  `R_id` int(4) DEFAULT NULL,
  `LF_id` int(4) unsigned DEFAULT NULL,
  `U_id` int(4) DEFAULT NULL,
  `PA_disable` tinyint(1) DEFAULT '0',
  `PA_name` char(50) DEFAULT NULL,
  `PA_type` tinyint(1) DEFAULT NULL,
  `PA_pass` char(50) DEFAULT NULL,
  `PA_note` varchar(100) DEFAULT NULL,
  `PA_C_date` char(12) DEFAULT NULL,
  `PA_E_date` char(12) DEFAULT NULL,
  `C_date` char(12) DEFAULT NULL,
  PRIMARY KEY (`PA_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_password
-- ----------------------------

-- ----------------------------
-- Table structure for `work_project`
-- ----------------------------
DROP TABLE IF EXISTS `work_project`;
CREATE TABLE `work_project` (
  `P_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `L_id` int(4) unsigned NOT NULL,
  `U_id` int(4) NOT NULL,
  `P_name` char(50) DEFAULT NULL,
  `P_note` varchar(300) DEFAULT NULL,
  `C_date` char(12) DEFAULT NULL,
  PRIMARY KEY (`P_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_project
-- ----------------------------

-- ----------------------------
-- Table structure for `work_resource`
-- ----------------------------
DROP TABLE IF EXISTS `work_resource`;
CREATE TABLE `work_resource` (
  `R_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `P_id` int(4) unsigned DEFAULT NULL,
  `U_id` int(4) NOT NULL,
  `R_name` char(20) NOT NULL,
  `R_type` tinyint(1) DEFAULT '0',
  `R_note` char(100) DEFAULT NULL,
  PRIMARY KEY (`R_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_resource
-- ----------------------------

-- ----------------------------
-- Table structure for `work_server`
-- ----------------------------
DROP TABLE IF EXISTS `work_server`;
CREATE TABLE `work_server` (
  `S_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `P_id` int(4) unsigned DEFAULT NULL,
  `R_id` int(4) DEFAULT NULL,
  `LF_id` int(4) DEFAULT NULL,
  `U_id` int(4) DEFAULT NULL,
  `S_name` char(50) DEFAULT NULL,
  `S_env` int(20) DEFAULT NULL,
  `S_type` int(1) DEFAULT NULL,
  `S_note` char(100) DEFAULT NULL,
  `S_ip1` char(16) DEFAULT NULL,
  `S_sub1` char(16) DEFAULT NULL,
  `S_ip2` char(16) DEFAULT NULL,
  `S_sub2` char(16) DEFAULT NULL,
  `C_date` char(12) DEFAULT NULL,
  PRIMARY KEY (`S_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_server
-- ----------------------------

-- ----------------------------
-- Table structure for `work_titlebar`
-- ----------------------------
DROP TABLE IF EXISTS `work_titlebar`;
CREATE TABLE `work_titlebar` (
  `T_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `R_id` int(4) NOT NULL,
  `U_id` int(4) DEFAULT NULL,
  `T_order` smallint(2) DEFAULT NULL,
  `T_name` char(50) DEFAULT NULL,
  PRIMARY KEY (`T_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_titlebar
-- ----------------------------
