/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_portal

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-10-21 13:21:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_agent
-- ----------------------------
DROP TABLE IF EXISTS `tb_agent`;
CREATE TABLE `tb_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT '',
  `key` varchar(10) DEFAULT NULL,
  `secret` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `line` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_by` varchar(50) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_agent
-- ----------------------------
INSERT INTO `tb_agent` VALUES ('1', 'BL88', 'AG059', 'aghejee8tzh74', 'BL88', 'https://bl88bet.com/', 'bl88 best casino online.', 'https://bl88bet.com/images/logo/logo.png', '', '1', null, null, '2023-10-21 13:08:25', 'admin1');

-- ----------------------------
-- Table structure for tb_role
-- ----------------------------
DROP TABLE IF EXISTS `tb_role`;
CREATE TABLE `tb_role` (
  `code` varchar(50) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_by` varchar(50) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_role
-- ----------------------------
INSERT INTO `tb_role` VALUES ('admin', 'Admin', '1', null, null, null, null);
INSERT INTO `tb_role` VALUES ('agent', 'Agent', '1', null, null, null, null);

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) DEFAULT '',
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `agent` varchar(50) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_by` varchar(50) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` VALUES ('1', 'admin', 'BL88admin1', 'P@ssw0rd', 'BL88', '1', null, null, null, null);
