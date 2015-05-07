/*
Source Database       : kdesk

Target Server Type    : MYSQL
Target Server Version : 50541
File Encoding         : 65001

Date: 2015-05-08 02:43:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ch_last_projects`
-- ----------------------------
DROP TABLE IF EXISTS `ch_last_projects`;
CREATE TABLE `ch_last_projects` (
  `id_dk_project` int(10) unsigned NOT NULL,
  `id_sys_users_author` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description_short` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('open','inwork','closed','deleted') NOT NULL DEFAULT 'open',
  `cost` bigint(19) unsigned NOT NULL DEFAULT '0',
  `tax` bigint(20) NOT NULL DEFAULT '0',
  `time_created` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_dk_project`),
  KEY `fk_dk_projects_sys_users1_idx` (`id_sys_users_author`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `ch_search_text_projects`
-- ----------------------------
DROP TABLE IF EXISTS `ch_search_text_projects`;
CREATE TABLE `ch_search_text_projects` (
  `id_dk_project` int(10) unsigned NOT NULL,
  `id_sys_users_performer` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description_short` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `keywords` text,
  `status` enum('open','inwork','closed','deleted') NOT NULL,
  `cost` bigint(19) unsigned NOT NULL,
  `time_created` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_dk_project`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `dk_projects`
-- ----------------------------
DROP TABLE IF EXISTS `dk_projects`;
CREATE TABLE `dk_projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_sys_users_author` int(10) unsigned NOT NULL,
  `id_sys_users_performer` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description_short` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `status` enum('open','inwork','closed','deleted') NOT NULL DEFAULT 'open',
  `cost` bigint(19) unsigned NOT NULL DEFAULT '0',
  `tax` bigint(20) NOT NULL DEFAULT '0',
  `time_created` int(10) unsigned NOT NULL,
  `time_modify` int(10) unsigned DEFAULT NULL,
  `time_closed` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dk_projects_sys_users1_idx` (`id_sys_users_author`),
  KEY `fk_dk_projects_sys_users2_idx` (`id_sys_users_performer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `dk_projects_comments`
-- ----------------------------
DROP TABLE IF EXISTS `dk_projects_comments`;
CREATE TABLE `dk_projects_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_dk_projects` int(10) unsigned NOT NULL,
  `id_sys_users` int(10) unsigned NOT NULL,
  `comment` text NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dk_projects_comments_dk_projects1_idx` (`id_dk_projects`),
  KEY `fk_dk_projects_comments_sys_users1_idx` (`id_sys_users`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `dk_projects_has_dk_tags`
-- ----------------------------
DROP TABLE IF EXISTS `dk_projects_has_dk_tags`;
CREATE TABLE `dk_projects_has_dk_tags` (
  `id_dk_projects` int(11) NOT NULL,
  `id_dk_tags` int(11) NOT NULL,
  PRIMARY KEY (`id_dk_projects`,`id_dk_tags`),
  KEY `fk_dk_projects_has_dk_tags_dk_tags1_idx` (`id_dk_tags`),
  KEY `fk_dk_projects_has_dk_tags_dk_projects_idx` (`id_dk_projects`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `dk_tags`
-- ----------------------------
DROP TABLE IF EXISTS `dk_tags`;
CREATE TABLE `dk_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(155) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `fn_logs`
-- ----------------------------
DROP TABLE IF EXISTS `fn_logs`;
CREATE TABLE `fn_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_sys_users` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-debit,1-credit,2-inreseve,3-outreserve',
  `sum` bigint(20) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fn_logs_sys_users1_idx` (`id_sys_users`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `sys_settings`
-- ----------------------------
DROP TABLE IF EXISTS `sys_settings`;
CREATE TABLE `sys_settings` (
  `key` char(50) NOT NULL,
  `value` text NOT NULL,
  `type` enum('string','byte','int','percent','bool') NOT NULL DEFAULT 'bool',
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_settings
-- ----------------------------
INSERT INTO `sys_settings` VALUES ('tax', '8', 'percent');
INSERT INTO `sys_settings` VALUES ('project_money', '0', 'int');
INSERT INTO `sys_settings` VALUES ('count_open_projects', '0', 'int');
INSERT INTO `sys_settings` VALUES ('max_ch_last_projects', '10', 'int');
INSERT INTO `sys_settings` VALUES ('sh_last_project_id', '0', 'int');

-- ----------------------------
-- Table structure for `sys_users`
-- ----------------------------
DROP TABLE IF EXISTS `sys_users`;
CREATE TABLE `sys_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(155) NOT NULL,
  `email` varchar(155) NOT NULL,
  `password` char(60) NOT NULL,
  `surname` varchar(155) DEFAULT NULL,
  `name` varchar(155) NOT NULL,
  `middlename` varchar(155) DEFAULT NULL,
  `sex` tinyint(1) NOT NULL,
  `time_reg` int(11) NOT NULL,
  `time_last_login` int(11) DEFAULT NULL,
  `time_last_activity` int(11) DEFAULT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `money` bigint(20) NOT NULL DEFAULT '0',
  `money_reserve` bigint(20) NOT NULL DEFAULT '0',
  `auth_key` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
