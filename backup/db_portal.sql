/*
 Navicat Premium Data Transfer

 Source Server         : BL88_Portal
 Source Server Type    : MySQL
 Source Server Version : 50565 (5.5.65-MariaDB)
 Source Host           : 119.8.165.218:3306
 Source Schema         : db_portal

 Target Server Type    : MySQL
 Target Server Version : 50565 (5.5.65-MariaDB)
 File Encoding         : 65001

 Date: 03/12/2023 21:30:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_agent
-- ----------------------------
DROP TABLE IF EXISTS `tb_agent`;
CREATE TABLE `tb_agent`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `secret` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `web` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `line_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `line_link` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  `add_date` datetime NULL DEFAULT NULL,
  `add_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `edit_date` datetime NULL DEFAULT NULL,
  `edit_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 0 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_agent
-- ----------------------------
INSERT INTO `tb_agent` VALUES (1, 'AG059', 'aghejee8tzh74', 'bl789', 'ag1', 'BL88123456', 'https://bl88bet.com/', 'bl88 best casino online.', 'https://portal.bl88b.com/images/ag1logo_653ca2f450964.png', '@637wbkqa', 'https://line.me/R/ti/p/@637wbkqa', 1, NULL, NULL, '2023-11-18 11:15:00', 'master');
INSERT INTO `tb_agent` VALUES (2, 'ENJUFA', '2a8a96960a2e922825ea5471251b4159', 'ENJUFA', 'ag2', 'UFA Master', NULL, NULL, 'https://portal.bl88b.com/images/ag2logo_656ad3d7c0a31.png', NULL, 'https://lin.ee/jB1LkQ7', 1, NULL, NULL, '2023-12-02 13:51:03', 'master');
INSERT INTO `tb_agent` VALUES (3, 'OFFUFA', 'cf36445e3237983317ee7a9def6a98ef', 'OFFUFA', 'ag3', 'UFA Odin', NULL, NULL, 'https://member.ufaodin.com/assets/images/ufa_odin_1.png', NULL, 'https://lin.ee/zWj44TZ', 1, NULL, NULL, '2023-10-30 15:21:22', 'ag3agent');
INSERT INTO `tb_agent` VALUES (4, 'ASIUFA', '4493fec6e119f864d078dd9fd66954c4', 'ASIUFA', 'ag4', 'GOD UFA', NULL, NULL, 'https://member.godufa.com/assets/images/god_ufa.png', NULL, 'https://lin.ee/B7l5eJk', 1, NULL, NULL, '2023-10-30 15:05:10', 'ag4agent');
INSERT INTO `tb_agent` VALUES (5, 'DEMOUFA', '0546ddc00f6c4378c2fdef66b5e199f0', 'DEMOUFA', 'ag5', 'ufa 123456', 'https://ufa.bl88b.com/', 'test ufa 654123', 'https://portal.bl88b.com/images/ag5logo_653ca4abc2d79.png', '@testufa', 'https://www.bilibili.tv/', 1, '2023-10-26 16:28:35', NULL, '2023-10-29 21:10:44', 'ag5agent');
INSERT INTO `tb_agent` VALUES (6, '789UFA', '3cc5b194f43c48b093e11998658ab299', '789UFA', 'ag6', 'UFA Peenoi', NULL, NULL, NULL, NULL, NULL, 0, '2023-10-31 13:53:26', 'master', '2023-11-13 00:17:30', 'master');
INSERT INTO `tb_agent` VALUES (7, 'asdasd1123', 'eq4312eqwdasd1123', 'asdasd1123', 'ag7', 'test agent 6', NULL, NULL, NULL, NULL, NULL, 0, '2023-10-31 13:53:57', 'master', '2023-11-10 19:12:02', 'master');

-- ----------------------------
-- Table structure for tb_banner
-- ----------------------------
DROP TABLE IF EXISTS `tb_banner`;
CREATE TABLE `tb_banner`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `detail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `agent` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  `add_date` datetime NULL DEFAULT NULL,
  `add_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `edit_date` datetime NULL DEFAULT NULL,
  `edit_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 0 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_banner
-- ----------------------------
INSERT INTO `tb_banner` VALUES (2, 'asd', 'asd', 'https://portal.bl88b.com/images/ag5banner_653a381b33723.png', 'ag5', 0, '2023-10-26 16:57:47', 'ag5agent', '2023-10-29 21:11:12', 'ag5agent');
INSERT INTO `tb_banner` VALUES (3, '', '', 'https://portal.bl88b.com/images/ag5banner_653a382105b28.png', 'ag5', 1, '2023-10-26 16:57:53', 'ag5agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (4, '', '', 'https://portal.bl88b.com/images/ag5banner_653a382abb289.png', 'ag5', 1, '2023-10-26 16:58:02', 'ag5agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (5, '', '', 'https://portal.bl88b.com/images/ag5banner_653a383276e83.png', 'ag5', 1, '2023-10-26 16:58:10', 'ag5agent', '2023-10-28 14:12:14', NULL);
INSERT INTO `tb_banner` VALUES (6, '', '', 'https://member.ufaodin.com/assets/images/promotions/01.png', 'ag3', 1, '2023-10-26 19:09:41', 'ag3agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (7, '', '', 'https://member.ufaodin.com/assets/images/promotions/02.png', 'ag3', 1, '2023-10-26 19:09:46', 'ag3agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (8, '', '', 'https://member.ufaodin.com/assets/images/promotions/03.png', 'ag3', 1, '2023-10-26 19:09:51', 'ag3agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (9, '', '', 'https://member.ufaodin.com/assets/images/promotions/04.png', 'ag3', 1, '2023-10-26 19:09:58', 'ag3agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (10, 'ฟรีเครดิต 500', 'ฟรีเครดิต 500', 'https://portal.bl88b.com/images/ag5banner_653caa6f0eaad.png', 'ag5', 1, '2023-10-28 13:30:07', 'ag5agent', '2023-10-29 21:12:45', NULL);
INSERT INTO `tb_banner` VALUES (11, '', '', 'https://portal.bl88b.com/images/ag2banner_653f1bbec8000.jpeg', 'ag2', 1, '2023-10-30 09:58:06', 'ag2agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (12, '', '', 'https://portal.bl88b.com/images/ag2banner_653f1bc46080c.jpeg', 'ag2', 1, '2023-10-30 09:58:12', 'ag2agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (13, '', '', 'https://portal.bl88b.com/images/ag2banner_653f1bcb12795.jpeg', 'ag2', 1, '2023-10-30 09:58:19', 'ag2agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (14, '', '', 'https://portal.bl88b.com/images/ag4banner_653f1c2383766.jpeg', 'ag4', 1, '2023-10-30 09:59:47', 'ag4agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (15, '', '', 'https://portal.bl88b.com/images/ag4banner_653f1c2bde9c7.jpeg', 'ag4', 1, '2023-10-30 09:59:56', 'ag4agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (16, '', '', 'https://portal.bl88b.com/images/ag4banner_653f1c3184296.jpeg', 'ag4', 1, '2023-10-30 10:00:01', 'ag4agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (17, '', '', 'https://portal.bl88b.com/images/ag4banner_653f1c366bf52.jpeg', 'ag4', 1, '2023-10-30 10:00:06', 'ag4agent', NULL, NULL);
INSERT INTO `tb_banner` VALUES (18, NULL, NULL, 'https://member.ufaodin.com/assets/images/promotions/05.png', 'ag3', 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_banner` VALUES (19, NULL, NULL, 'https://member.ufaodin.com/assets/images/promotions/06.png', 'ag3', 0, NULL, NULL, '2023-11-29 21:55:32', NULL);

-- ----------------------------
-- Table structure for tb_role
-- ----------------------------
DROP TABLE IF EXISTS `tb_role`;
CREATE TABLE `tb_role`  (
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  `add_date` datetime NULL DEFAULT NULL,
  `add_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `edit_date` datetime NULL DEFAULT NULL,
  `edit_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`code`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_role
-- ----------------------------
INSERT INTO `tb_role` VALUES ('admin', 'Admin', 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_role` VALUES ('agent', 'Agent', 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_role` VALUES ('master', 'Master', 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_segment
-- ----------------------------
DROP TABLE IF EXISTS `tb_segment`;
CREATE TABLE `tb_segment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `wheel` int(11) NULL DEFAULT NULL,
  `index` int(11) NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `value` decimal(18, 2) NULL DEFAULT NULL,
  `rate` int(11) NOT NULL DEFAULT 0,
  `hex` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  `add_date` datetime NULL DEFAULT NULL,
  `add_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `edit_date` datetime NULL DEFAULT NULL,
  `edit_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 0 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_segment
-- ----------------------------
INSERT INTO `tb_segment` VALUES (1, 'ag3', 1, 2, 'เครดิต 5', 'CREDIT', 5.00, 1000, '#f56b6b', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (2, 'ag3', 1, 7, 'เครดิต 10', 'CREDIT', 10.00, 100, '#a9affe', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (3, 'ag3', 1, 8, 'เครดิต 20', 'CREDIT', 20.00, 50, '#ffb066', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (4, 'ag3', 1, 6, 'เครดิต 50', 'CREDIT', 50.00, 35, '#a366ff', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (5, 'ag3', 1, 1, 'เครดิต 100', 'CREDIT', 100.00, 15, '#ff8ac8', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (6, 'ag3', 1, 3, 'เครดิต 300', 'CREDIT', 300.00, 10, '#ffa3a3', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (7, 'ag3', 1, 5, 'เครดิต 500', 'CREDIT', 500.00, 5, '#9ff8fe', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (8, 'ag3', 1, 4, 'เครดิต 1000', 'CREDIT', 1000.00, 1, '#71fe9b', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (9, 'ag1', 4, 7, 'Credit 5', 'CREDIT', 5.00, 1000, '#67ac74', NULL, 1, '2023-12-02 12:56:38', 'master', '2023-12-02 13:03:31', 'master');
INSERT INTO `tb_segment` VALUES (10, 'ag1', 4, 3, 'Credit 10', 'CREDIT', 10.00, 500, '#6dacad', NULL, 1, '2023-12-02 12:56:39', 'master', '2023-12-02 13:03:40', 'master');
INSERT INTO `tb_segment` VALUES (11, 'ag1', 4, 0, 'Credit 20', 'CREDIT', 20.00, 100, '#752ba5', NULL, 1, '2023-12-02 12:56:39', 'master', '2023-12-02 13:03:52', 'master');
INSERT INTO `tb_segment` VALUES (12, 'ag1', 4, 1, 'Credit 50', 'CREDIT', 50.00, 50, '#7b540e', NULL, 1, '2023-12-02 12:56:40', 'master', '2023-12-02 13:04:05', 'master');
INSERT INTO `tb_segment` VALUES (13, 'ag1', 4, 4, 'Credit 100', 'CREDIT', 100.00, 25, '#821f1d', NULL, 1, '2023-12-02 12:56:40', 'master', '2023-12-02 13:04:18', 'master');
INSERT INTO `tb_segment` VALUES (14, 'ag1', 4, 6, 'Credit 300', 'CREDIT', 300.00, 10, '#8890dd', NULL, 1, '2023-12-02 12:56:40', 'master', '2023-12-02 13:04:42', 'master');
INSERT INTO `tb_segment` VALUES (15, 'ag1', 4, 5, 'Credit 500', 'CREDIT', 500.00, 5, '#9002b5', NULL, 1, '2023-12-02 12:56:41', 'master', '2023-12-02 13:05:08', 'master');
INSERT INTO `tb_segment` VALUES (16, 'ag1', 4, 2, 'Credit 1000', 'CREDIT', 1000.00, 1, '#960110', NULL, 1, '2023-12-02 12:56:41', 'master', '2023-12-02 13:05:02', 'master');
INSERT INTO `tb_segment` VALUES (17, 'ag5', 2, 4, 'เครดิต 5', 'CREDIT', 5.00, 1000, '#f56b6b', NULL, 1, '2023-12-02 13:37:14', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (18, 'ag5', 2, 5, 'เครดิต 10', 'CREDIT', 10.00, 100, '#a9affe', NULL, 1, '2023-12-02 13:37:14', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (19, 'ag5', 2, 2, 'เครดิต 20', 'CREDIT', 20.00, 50, '#ffb066', NULL, 1, '2023-12-02 13:37:15', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (20, 'ag5', 2, 1, 'เครดิต 50', 'CREDIT', 50.00, 35, '#a366ff', NULL, 1, '2023-12-02 13:37:15', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (21, 'ag5', 2, 3, 'เครดิต 100', 'CREDIT', 100.00, 15, '#ff8ac8', NULL, 1, '2023-12-02 13:37:16', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (22, 'ag5', 2, 7, 'เครดิต 300', 'CREDIT', 300.00, 10, '#ffa3a3', NULL, 1, '2023-12-02 13:37:16', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (23, 'ag5', 2, 0, 'เครดิต 500', 'CREDIT', 500.00, 5, '#9ff8fe', NULL, 1, '2023-12-02 13:37:16', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (24, 'ag5', 2, 6, 'เครดิต 1000', 'CREDIT', 1000.00, 1, '#71fe9b', NULL, 1, '2023-12-02 13:37:17', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (25, 'ag7', 5, 6, 'เครดิต 5', 'CREDIT', 5.00, 1000, '#f56b6b', NULL, 1, '2023-12-02 13:38:54', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (26, 'ag7', 5, 4, 'เครดิต 10', 'CREDIT', 10.00, 100, '#a9affe', NULL, 1, '2023-12-02 13:38:55', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (27, 'ag7', 5, 3, 'เครดิต 20', 'CREDIT', 20.00, 50, '#ffb066', NULL, 1, '2023-12-02 13:38:55', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (28, 'ag7', 5, 2, 'เครดิต 50', 'CREDIT', 50.00, 35, '#a366ff', NULL, 1, '2023-12-02 13:38:56', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (29, 'ag7', 5, 1, 'เครดิต 100', 'CREDIT', 100.00, 15, '#ff8ac8', NULL, 1, '2023-12-02 13:38:56', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (30, 'ag7', 5, 0, 'เครดิต 300', 'CREDIT', 300.00, 10, '#ffa3a3', NULL, 1, '2023-12-02 13:38:56', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (31, 'ag7', 5, 5, 'เครดิต 500', 'CREDIT', 500.00, 5, '#9ff8fe', NULL, 1, '2023-12-02 13:38:57', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (32, 'ag7', 5, 7, 'เครดิต 1000', 'CREDIT', 1000.00, 1, '#71fe9b', NULL, 1, '2023-12-02 13:38:57', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (33, 'ag2', 6, 1, 'เครดิต 5', 'CREDIT', 5.00, 1000, '#f56b6b', NULL, 1, '2023-12-02 13:48:05', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (34, 'ag2', 6, 2, 'เครดิต 10', 'CREDIT', 10.00, 100, '#a9affe', NULL, 1, '2023-12-02 13:48:05', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (35, 'ag2', 6, 3, 'เครดิต 20', 'CREDIT', 20.00, 50, '#ffb066', NULL, 1, '2023-12-02 13:48:05', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (36, 'ag2', 6, 4, 'เครดิต 50', 'CREDIT', 50.00, 35, '#a366ff', NULL, 1, '2023-12-02 13:48:05', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (37, 'ag2', 6, 5, 'เครดิต 100', 'CREDIT', 100.00, 15, '#ff8ac8', NULL, 1, '2023-12-02 13:48:06', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (38, 'ag2', 6, 6, 'เครดิต 300', 'CREDIT', 300.00, 10, '#ffa3a3', NULL, 1, '2023-12-02 13:48:06', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (39, 'ag2', 6, 7, 'เครดิต 500', 'CREDIT', 500.00, 5, '#9ff8fe', NULL, 1, '2023-12-02 13:48:06', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (40, 'ag2', 6, 8, 'เครดิต 1000', 'CREDIT', 1000.00, 1, '#71fe9b', NULL, 1, '2023-12-02 13:48:06', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (41, 'ag4', 7, 1, 'เครดิต 5', 'CREDIT', 5.00, 1000, '#f56b6b', NULL, 1, '2023-12-02 13:48:38', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (42, 'ag4', 7, 2, 'เครดิต 10', 'CREDIT', 10.00, 100, '#a9affe', NULL, 1, '2023-12-02 13:48:38', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (43, 'ag4', 7, 3, 'เครดิต 20', 'CREDIT', 20.00, 50, '#ffb066', NULL, 1, '2023-12-02 13:48:38', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (44, 'ag4', 7, 4, 'เครดิต 50', 'CREDIT', 50.00, 35, '#a366ff', NULL, 1, '2023-12-02 13:48:39', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (45, 'ag4', 7, 5, 'เครดิต 100', 'CREDIT', 100.00, 15, '#ff8ac8', NULL, 1, '2023-12-02 13:48:39', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (46, 'ag4', 7, 6, 'เครดิต 300', 'CREDIT', 300.00, 10, '#ffa3a3', NULL, 1, '2023-12-02 13:48:39', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (47, 'ag4', 7, 7, 'เครดิต 500', 'CREDIT', 500.00, 5, '#9ff8fe', NULL, 1, '2023-12-02 13:48:39', 'master', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment` VALUES (48, 'ag4', 7, 8, 'เครดิต 1000', 'CREDIT', 1000.00, 1, '#71fe9b', NULL, 1, '2023-12-02 13:48:39', 'master', '2023-06-16 16:07:40', 'admin_imi');

-- ----------------------------
-- Table structure for tb_segment_master
-- ----------------------------
DROP TABLE IF EXISTS `tb_segment_master`;
CREATE TABLE `tb_segment_master`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `wheel` int(11) NULL DEFAULT NULL,
  `index` int(11) NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `value` decimal(18, 2) NULL DEFAULT NULL,
  `rate` int(11) NOT NULL DEFAULT 0,
  `hex` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  `add_date` datetime NULL DEFAULT NULL,
  `add_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `edit_date` datetime NULL DEFAULT NULL,
  `edit_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 0 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_segment_master
-- ----------------------------
INSERT INTO `tb_segment_master` VALUES (1, NULL, NULL, 1, 'เครดิต 5', 'CREDIT', 5.00, 1000, '#f56b6b', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment_master` VALUES (2, NULL, NULL, 2, 'เครดิต 10', 'CREDIT', 10.00, 100, '#a9affe', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment_master` VALUES (3, NULL, NULL, 3, 'เครดิต 20', 'CREDIT', 20.00, 50, '#ffb066', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment_master` VALUES (4, NULL, NULL, 4, 'เครดิต 50', 'CREDIT', 50.00, 35, '#a366ff', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment_master` VALUES (5, NULL, NULL, 5, 'เครดิต 100', 'CREDIT', 100.00, 15, '#ff8ac8', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment_master` VALUES (6, NULL, NULL, 6, 'เครดิต 300', 'CREDIT', 300.00, 10, '#ffa3a3', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment_master` VALUES (7, NULL, NULL, 7, 'เครดิต 500', 'CREDIT', 500.00, 5, '#9ff8fe', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');
INSERT INTO `tb_segment_master` VALUES (8, NULL, NULL, 8, 'เครดิต 1000', 'CREDIT', 1000.00, 1, '#71fe9b', NULL, 1, '2023-06-16 16:06:19', 'admin_imi', '2023-06-16 16:07:40', 'admin_imi');

-- ----------------------------
-- Table structure for tb_statement
-- ----------------------------
DROP TABLE IF EXISTS `tb_statement`;
CREATE TABLE `tb_statement`  (
  `id` int(11) NOT NULL,
  `agent` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `date` datetime NULL DEFAULT NULL,
  `web` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `bank` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `amount` decimal(10, 2) NULL DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `statement_status` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  `add_date` datetime NULL DEFAULT NULL,
  `add_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `edit_date` datetime NULL DEFAULT NULL,
  `edit_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_statement
-- ----------------------------

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tel` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `agent` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  `add_date` datetime NULL DEFAULT NULL,
  `add_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `edit_date` datetime NULL DEFAULT NULL,
  `edit_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 0 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` VALUES (1, 'master', 'master', 'P@ssw0rd', 'asdds', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_user` VALUES (2, 'agent', 'ag1agent', 'P@ssw0rd', 'uytyu', NULL, 'ag1', 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_user` VALUES (3, 'agent', 'ag2agent', 'P@ssw0rd', 'UFA Master', NULL, 'ag2', 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_user` VALUES (4, 'agent', 'ag3agent', 'P@ssw0rd', 'UFA Odin', NULL, 'ag3', 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_user` VALUES (5, 'agent', 'ag4agent', 'P@ssw0rd', 'GOD UFA', NULL, 'ag4', 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_user` VALUES (6, 'agent', 'ag5agent', 'P@ssw0rd', NULL, NULL, 'ag5', 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_user` VALUES (7, 'agent', 'ag6agent', 'P@ssw0rd', 'UFA Peenoi', NULL, 'ag6', 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_wheel
-- ----------------------------
DROP TABLE IF EXISTS `tb_wheel`;
CREATE TABLE `tb_wheel`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `detail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deposit_rule` decimal(10, 2) NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  `add_date` datetime NULL DEFAULT NULL,
  `add_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `edit_date` datetime NULL DEFAULT NULL,
  `edit_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 0 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_wheel
-- ----------------------------
INSERT INTO `tb_wheel` VALUES (1, 'ag3', 'wheel1', 'test wheel', 100.00, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_wheel` VALUES (2, 'ag5', 'Lucky Wheel', 'Lucky Wheel', 100.00, 1, '2023-12-02 09:33:23', NULL, '2023-12-02 13:42:50', 'ag5agent');
INSERT INTO `tb_wheel` VALUES (3, 'ag5', 'asdasd', 'weqwe', 50.00, 1, NULL, NULL, '2023-12-02 09:40:01', 'master');
INSERT INTO `tb_wheel` VALUES (4, 'ag1', NULL, NULL, 100.00, 1, '2023-12-02 09:45:59', NULL, '2023-12-02 13:48:24', 'master');
INSERT INTO `tb_wheel` VALUES (5, 'ag7', NULL, NULL, NULL, 1, '2023-12-02 13:38:53', NULL, NULL, NULL);
INSERT INTO `tb_wheel` VALUES (6, 'ag2', NULL, NULL, 100.00, 1, '2023-12-02 13:48:05', NULL, '2023-12-02 13:48:14', 'master');
INSERT INTO `tb_wheel` VALUES (7, 'ag4', NULL, NULL, 100.00, 1, '2023-12-02 13:48:38', NULL, '2023-12-02 13:48:41', 'master');

-- ----------------------------
-- Table structure for tb_wheel_daily
-- ----------------------------
DROP TABLE IF EXISTS `tb_wheel_daily`;
CREATE TABLE `tb_wheel_daily`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `date` date NULL DEFAULT NULL,
  `wheel` int(11) NULL DEFAULT NULL,
  `date_use` datetime NULL DEFAULT NULL,
  `segment` int(11) NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `value` decimal(18, 2) NULL DEFAULT NULL,
  `rate` int(11) NULL DEFAULT NULL,
  `rate_min` int(11) NULL DEFAULT NULL,
  `rate_max` int(11) NULL DEFAULT NULL,
  `lucky_number` int(11) NULL DEFAULT NULL,
  `date_claim` datetime NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT 1,
  `add_date` datetime NULL DEFAULT NULL,
  `add_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `edit_date` datetime NULL DEFAULT NULL,
  `edit_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 0 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_wheel_daily
-- ----------------------------
INSERT INTO `tb_wheel_daily` VALUES (1, 'ag3', 'UFTWA980120', '2023-11-18', 1, '2023-11-22 21:04:55', 1, 'เครดิต 5', 'CREDIT', 5.00, 1000, 66, 1065, 977, NULL, 1, '2023-11-18 17:52:17', 'postman', '2023-11-22 21:04:55', 'UFTWA980120');
INSERT INTO `tb_wheel_daily` VALUES (2, 'ag3', 'UFTWA980120', '2023-11-19', 1, '2023-11-20 21:51:36', 6, 'เครดิต 300', 'CREDIT', 300.00, 10, 1022, 1031, 1031, NULL, 1, NULL, NULL, '2023-11-20 21:51:36', 'UFTWA980120');

SET FOREIGN_KEY_CHECKS = 1;
