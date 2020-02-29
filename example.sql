/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80019
 Source Host           : localhost:3306
 Source Schema         : autospeak

 Target Server Type    : MySQL
 Target Server Version : 80019
 File Encoding         : 65001

 Date: 29/02/2020 20:34:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for actions
-- ----------------------------
DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `date` int(0) NOT NULL,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `text` longtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `instance_id` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1833 CHARACTER SET = utf8 COLLATE = utf8_polish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for clients
-- ----------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients`  (
  `client_dbid` bigint(0) NOT NULL,
  `client_clid` bigint(0) NOT NULL,
  `client_nick` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `last_nicks` varchar(1024) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `client_uid` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `server_groups` longtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `connections` bigint(0) NOT NULL,
  `connected_time` bigint(0) NOT NULL DEFAULT 0,
  `connected_time_record` bigint(0) NOT NULL,
  `idle_time_record` bigint(0) NOT NULL,
  `time_spent` bigint(0) NOT NULL,
  `idle_time_spent` bigint(0) NOT NULL,
  `week_start` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `week_start_time` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `banner_clock` int(0) NOT NULL DEFAULT 1,
  `banner_additional` int(0) NOT NULL DEFAULT 1,
  `banner_online` int(0) NOT NULL DEFAULT 1,
  `banner_admins` int(0) NOT NULL DEFAULT 1,
  `banner_date` int(0) NOT NULL DEFAULT 1,
  `banner_weather` int(0) NOT NULL DEFAULT 1,
  `banner_bg` int(0) NOT NULL DEFAULT 0,
  `connection_client_ip` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '0',
  `client_version` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `client_lastconnected` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`client_dbid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for new_daily_users
-- ----------------------------
DROP TABLE IF EXISTS `new_daily_users`;
CREATE TABLE `new_daily_users`  (
  `client_dbid` int(0) NOT NULL,
  `client_clid` int(0) NOT NULL,
  `client_nick` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `client_uid` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `day` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`client_dbid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_polish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for random_group
-- ----------------------------
DROP TABLE IF EXISTS `random_group`;
CREATE TABLE `random_group`  (
  `client_dbid` int(0) NOT NULL,
  `sgid` int(0) NOT NULL,
  `date` bigint(0) NOT NULL,
  `time` bigint(0) NOT NULL,
  `deleted` int(0) NOT NULL,
  PRIMARY KEY (`date`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_polish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for statistics
-- ----------------------------
DROP TABLE IF EXISTS `statistics`;
CREATE TABLE `statistics`  (
  `dbid` int(0) NOT NULL,
  `groups_day_start` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `groups_day_normal` int(0) NOT NULL DEFAULT 0,
  `groups_day_reg` int(0) NOT NULL DEFAULT 0,
  `groups_week_start` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `groups_week_normal` int(0) NOT NULL DEFAULT 0,
  `groups_week_reg` int(0) NOT NULL DEFAULT 0,
  `groups_month_start` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `groups_month_normal` int(0) NOT NULL DEFAULT 0,
  `groups_month_reg` int(0) NOT NULL DEFAULT 0,
  `groups_total_normal` int(0) NOT NULL DEFAULT 0,
  `groups_total_reg` int(0) NOT NULL DEFAULT 0,
  `time_day_start` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `time_day_time` bigint(0) NOT NULL DEFAULT 0,
  `time_day_offline` bigint(0) NOT NULL DEFAULT 0,
  `time_week_start` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `time_week_time` bigint(0) NOT NULL DEFAULT 0,
  `time_week_offline` bigint(0) NOT NULL DEFAULT 0,
  `time_month_start` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `time_month_time` bigint(0) NOT NULL DEFAULT 0,
  `time_month_offline` bigint(0) NOT NULL DEFAULT 0,
  `time_total_time` bigint(0) NOT NULL DEFAULT 0,
  `time_total_offline` bigint(0) NOT NULL DEFAULT 0,
  `help_day_start` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `help_day_time` int(0) NOT NULL DEFAULT 0,
  `help_day_count` int(0) NOT NULL DEFAULT 0,
  `help_week_start` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `help_week_time` int(0) NOT NULL DEFAULT 0,
  `help_week_count` int(0) NOT NULL DEFAULT 0,
  `help_month_start` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `help_month_time` int(0) NOT NULL DEFAULT 0,
  `help_month_count` int(0) NOT NULL DEFAULT 0,
  `help_total_time` int(0) NOT NULL DEFAULT 0,
  `help_total_count` int(0) NOT NULL DEFAULT 0,
  PRIMARY KEY (`dbid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_polish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for vip_channels
-- ----------------------------
DROP TABLE IF EXISTS `vip_channels`;
CREATE TABLE `vip_channels`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `type_id` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `channel_num` int(0) NOT NULL,
  `channel_cid` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `spacer_cid` int(0) NOT NULL,
  `online_from` int(0) NOT NULL,
  `get_group` int(0) NOT NULL,
  `owner_dbid` int(0) NOT NULL,
  `group_id` int(0) NOT NULL,
  `created` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_polish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for visitors
-- ----------------------------
DROP TABLE IF EXISTS `visitors`;
CREATE TABLE `visitors`  (
  `client_dbid` int(0) NOT NULL,
  `day` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`client_dbid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_polish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yt_channels
-- ----------------------------
DROP TABLE IF EXISTS `yt_channels`;
CREATE TABLE `yt_channels`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `channel_num` int(0) NOT NULL,
  `channel_cid` int(0) NOT NULL,
  `spacer_cid` int(0) NOT NULL,
  `main_info` int(0) NOT NULL,
  `videos_count` int(0) NOT NULL,
  `views_count` int(0) NOT NULL,
  `owner_dbid` int(0) NOT NULL,
  `created` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_polish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
