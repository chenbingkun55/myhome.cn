/*
Navicat MySQL Data Transfer

Source Server         : DEV_DB[127.0.0.1]
Source Server Version : 60004
Source Host           : localhost:3306
Source Database       : myhome

Target Server Type    : MYSQL
Target Server Version : 60004
File Encoding         : 65001

Date: 2013-09-06 19:05:03
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `task_lib`
-- ----------------------------
DROP TABLE IF EXISTS `task_lib`;
CREATE TABLE `task_lib` (
  `T_id` int(4) NOT NULL AUTO_INCREMENT,
  `T_date` char(12) NOT NULL,
  `T_title` char(100) NOT NULL,
  `T_content` text,
  `T_level` tinyint(1) unsigned NOT NULL COMMENT '1-绿色,2-蓝色,3-黄色,4-橙色,5-红色',
  `C_date` char(12) DEFAULT NULL,
  PRIMARY KEY (`T_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1472180243 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of task_lib
-- ----------------------------
