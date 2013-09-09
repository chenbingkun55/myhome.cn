/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50154
Source Host           : localhost:3306
Source Database       : myhome

Target Server Type    : MYSQL
Target Server Version : 50154
File Encoding         : 65001

Date: 2013-09-09 00:08:13
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `task_lib`
-- ----------------------------
DROP TABLE IF EXISTS `task_lib`;
CREATE TABLE `task_lib` (
  `T_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `T_date` char(12) NOT NULL,
  `T_title` char(100) NOT NULL,
  `T_content` text,
  `T_level` tinyint(1) unsigned NOT NULL COMMENT '1-绿色,2-蓝色,3-黄色,4-橙色,5-红色',
  `T_status` tinyint(1) unsigned DEFAULT '1' COMMENT '(不使用0，因为0判断有问题)1-未开始,2-运行,3-暂停,4-等待,5-停止,6-完成,7-放弃',
  `T_process` char(100) DEFAULT NULL,
  `T_templet` tinyint(1) unsigned DEFAULT '0' COMMENT '任务模板(0=不是,1=是)',
  `C_date` char(12) DEFAULT NULL,
  PRIMARY KEY (`T_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100000000 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of task_lib
-- ----------------------------
