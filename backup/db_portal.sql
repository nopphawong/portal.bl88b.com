/*
Navicat MySQL Data Transfer

Source Server         : portal
Source Server Version : 50565
Source Host           : 119.8.165.218:3306
Source Database       : db_portal

Target Server Type    : MYSQL
Target Server Version : 50565
File Encoding         : 65001

Date: 2023-10-26 16:09:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_agent
-- ----------------------------
DROP TABLE IF EXISTS `tb_agent`;
CREATE TABLE `tb_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(10) DEFAULT NULL,
  `secret` varchar(50) DEFAULT NULL,
  `code` varchar(10) DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` text,
  `logo` varchar(255) DEFAULT NULL,
  `line_id` varchar(50) DEFAULT NULL,
  `line_link` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `add_date` datetime DEFAULT NULL,
  `add_by` varchar(50) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_agent
-- ----------------------------
INSERT INTO `tb_agent` VALUES ('1', 'AG059', 'aghejee8tzh74', 'ag1', 'BL88', 'https://bl88bet.com/', 'bl88 best casino online.', 'https://portal.bl88b.com/images/AG059logo_6538cd990758c.png', '@637wbkqa', 'https://line.me/R/ti/p/@637wbkqa', '1', null, null, '2023-10-25 15:11:05', 'AG059admin1');
INSERT INTO `tb_agent` VALUES ('2', 'ENJUFA', '2a8a96960a2e922825ea5471251b4159', 'ag2', 'ufamaster', null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `tb_agent` VALUES ('3', 'OFFUFA', 'cf36445e3237983317ee7a9def6a98ef', 'ag3', 'ufaodin', null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `tb_agent` VALUES ('4', 'ASIUFA', '4493fec6e119f864d078dd9fd66954c4', 'ag4', 'godufa', null, null, null, null, null, '1', null, null, null, null);

-- ----------------------------
-- Table structure for tb_banner
-- ----------------------------
DROP TABLE IF EXISTS `tb_banner`;
CREATE TABLE `tb_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `agent` varchar(10) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `add_date` datetime DEFAULT NULL,
  `add_by` varchar(50) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_banner
-- ----------------------------

-- ----------------------------
-- Table structure for tb_role
-- ----------------------------
DROP TABLE IF EXISTS `tb_role`;
CREATE TABLE `tb_role` (
  `code` varchar(50) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
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
INSERT INTO `tb_role` VALUES ('master', 'Master', '1', null, null, null, null);

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) DEFAULT '',
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `tel` varchar(10) DEFAULT NULL,
  `agent` varchar(50) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `add_date` datetime DEFAULT NULL,
  `add_by` varchar(50) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` VALUES ('1', 'master', 'master', 'P@ssw0rd', 'asdds', null, null, '1', null, null, null, null);
INSERT INTO `tb_user` VALUES ('2', 'agent', 'ag1agent', 'P@ssw0rd', 'uytyu', null, 'AG059', '1', null, null, null, null);
INSERT INTO `tb_user` VALUES ('3', 'agent', 'ag2agent', 'P@ssw0rd', null, null, 'ENJUFA', '1', null, null, null, null);
INSERT INTO `tb_user` VALUES ('4', 'agent', 'ag3agent', 'P@ssw0rd', null, null, 'OFFUFA', '1', null, null, null, null);
INSERT INTO `tb_user` VALUES ('5', 'agent', 'ag4agent', 'P@ssw0rd', null, null, 'ASIUFA', '1', null, null, null, null);
