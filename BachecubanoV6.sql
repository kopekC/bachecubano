/*
Navicat MySQL Data Transfer
Source Server         : Bachecubano
Target Server Type    : MYSQL
File Encoding         : 65001
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for oc_t_admin
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_admin`;
CREATE TABLE `oc_t_admin` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_name` varchar(100) NOT NULL,
  `s_username` varchar(40) NOT NULL,
  `s_password` char(60) NOT NULL,
  `s_email` varchar(100) DEFAULT NULL,
  `s_secret` varchar(40) DEFAULT NULL,
  `b_moderator` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`pk_i_id`),
  UNIQUE KEY `s_username` (`s_username`),
  UNIQUE KEY `s_email` (`s_email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_alerts
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_alerts`;
CREATE TABLE `oc_t_alerts` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_email` varchar(100) DEFAULT NULL,
  `fk_i_user_id` int(10) unsigned DEFAULT NULL,
  `s_search` longtext DEFAULT NULL,
  `s_secret` varchar(40) DEFAULT NULL,
  `b_active` tinyint(1) NOT NULL DEFAULT 0,
  `e_type` enum('INSTANT','HOURLY','DAILY','WEEKLY','CUSTOM') NOT NULL,
  `dt_date` datetime DEFAULT NULL,
  `dt_unsub_date` datetime DEFAULT NULL,
  PRIMARY KEY (`pk_i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_alerts_sent
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_alerts_sent`;
CREATE TABLE `oc_t_alerts_sent` (
  `d_date` date NOT NULL,
  `i_num_alerts_sent` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`d_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_ban_rule
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_ban_rule`;
CREATE TABLE `oc_t_ban_rule` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_name` varchar(250) NOT NULL DEFAULT '',
  `s_ip` varchar(50) NOT NULL DEFAULT '',
  `s_email` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_category
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_category`;
CREATE TABLE `oc_t_category` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_i_parent_id` int(10) unsigned DEFAULT NULL,
  `i_expiration_days` int(3) unsigned NOT NULL DEFAULT 0,
  `i_position` int(2) unsigned NOT NULL DEFAULT 0,
  `b_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `b_price_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `s_icon` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`pk_i_id`),
  KEY `fk_i_parent_id` (`fk_i_parent_id`),
  KEY `i_position` (`i_position`),
  CONSTRAINT `oc_t_category_ibfk_1` FOREIGN KEY (`fk_i_parent_id`) REFERENCES `oc_t_category` (`pk_i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_category_description
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_category_description`;
CREATE TABLE `oc_t_category_description` (
  `fk_i_category_id` int(10) unsigned NOT NULL,
  `fk_c_locale_code` char(5) NOT NULL,
  `s_name` varchar(100) DEFAULT NULL,
  `s_description` text DEFAULT NULL,
  `s_slug` varchar(255) NOT NULL,
  PRIMARY KEY (`fk_i_category_id`,`fk_c_locale_code`),
  KEY `idx_s_slug` (`s_slug`),
  KEY `fk_c_locale_code` (`fk_c_locale_code`),
  CONSTRAINT `oc_t_category_description_ibfk_1` FOREIGN KEY (`fk_i_category_id`) REFERENCES `oc_t_category` (`pk_i_id`),
  CONSTRAINT `oc_t_category_description_ibfk_2` FOREIGN KEY (`fk_c_locale_code`) REFERENCES `oc_t_locale` (`pk_c_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_category_stats
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_category_stats`;
CREATE TABLE `oc_t_category_stats` (
  `fk_i_category_id` int(10) unsigned NOT NULL,
  `i_num_items` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`fk_i_category_id`),
  CONSTRAINT `oc_t_category_stats_ibfk_1` FOREIGN KEY (`fk_i_category_id`) REFERENCES `oc_t_category` (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_category_stela
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_category_stela`;
CREATE TABLE `oc_t_category_stela` (
  `fk_i_category_id` int(11) unsigned NOT NULL,
  `s_color` varchar(100) DEFAULT NULL,
  `s_icon` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`fk_i_category_id`),
  UNIQUE KEY `fk_i_category_id` (`fk_i_category_id`),
  CONSTRAINT `oc_t_category_stela_ibfk_1` FOREIGN KEY (`fk_i_category_id`) REFERENCES `oc_t_category` (`pk_i_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_city
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_city`;
CREATE TABLE `oc_t_city` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_i_region_id` int(10) unsigned NOT NULL,
  `s_name` varchar(60) NOT NULL,
  `s_slug` varchar(60) NOT NULL DEFAULT '',
  `fk_c_country_code` char(2) DEFAULT NULL,
  `b_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`pk_i_id`),
  KEY `fk_i_region_id` (`fk_i_region_id`),
  KEY `idx_s_name` (`s_name`),
  KEY `idx_s_slug` (`s_slug`),
  KEY `fk_c_country_code` (`fk_c_country_code`),
  CONSTRAINT `oc_t_city_ibfk_1` FOREIGN KEY (`fk_i_region_id`) REFERENCES `oc_t_region` (`pk_i_id`),
  CONSTRAINT `oc_t_city_ibfk_2` FOREIGN KEY (`fk_c_country_code`) REFERENCES `oc_t_country` (`pk_c_code`)
) ENGINE=InnoDB AUTO_INCREMENT=427757 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_city_area
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_city_area`;
CREATE TABLE `oc_t_city_area` (
  `pk_i_id` int(10) unsigned NOT NULL,
  `fk_i_city_id` int(10) unsigned NOT NULL,
  `s_name` varchar(255) NOT NULL,
  PRIMARY KEY (`pk_i_id`),
  KEY `fk_i_city_id` (`fk_i_city_id`),
  KEY `idx_s_name` (`s_name`),
  CONSTRAINT `oc_t_city_area_ibfk_1` FOREIGN KEY (`fk_i_city_id`) REFERENCES `oc_t_city` (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_city_stats
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_city_stats`;
CREATE TABLE `oc_t_city_stats` (
  `fk_i_city_id` int(10) unsigned NOT NULL,
  `i_num_items` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`fk_i_city_id`),
  KEY `idx_num_items` (`i_num_items`),
  CONSTRAINT `oc_t_city_stats_ibfk_1` FOREIGN KEY (`fk_i_city_id`) REFERENCES `oc_t_city` (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_country
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_country`;
CREATE TABLE `oc_t_country` (
  `pk_c_code` char(2) NOT NULL,
  `s_name` varchar(80) NOT NULL,
  `s_slug` varchar(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`pk_c_code`),
  KEY `idx_s_slug` (`s_slug`),
  KEY `idx_s_name` (`s_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_country_stats
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_country_stats`;
CREATE TABLE `oc_t_country_stats` (
  `fk_c_country_code` char(2) NOT NULL,
  `i_num_items` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`fk_c_country_code`),
  KEY `idx_num_items` (`i_num_items`),
  CONSTRAINT `oc_t_country_stats_ibfk_1` FOREIGN KEY (`fk_c_country_code`) REFERENCES `oc_t_country` (`pk_c_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_cron
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_cron`;
CREATE TABLE `oc_t_cron` (
  `e_type` enum('INSTANT','HOURLY','DAILY','WEEKLY','CUSTOM') NOT NULL,
  `d_last_exec` datetime NOT NULL,
  `d_next_exec` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_currency
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_currency`;
CREATE TABLE `oc_t_currency` (
  `pk_c_code` char(3) NOT NULL,
  `s_name` varchar(40) NOT NULL,
  `s_description` varchar(80) DEFAULT NULL,
  `b_enabled` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`pk_c_code`),
  UNIQUE KEY `s_name` (`s_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_item
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_item`;
CREATE TABLE `oc_t_item` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_i_user_id` int(10) unsigned DEFAULT NULL,
  `fk_i_category_id` int(10) unsigned NOT NULL,
  `dt_pub_date` datetime NOT NULL,
  `dt_mod_date` datetime DEFAULT NULL,
  `f_price` float DEFAULT NULL,
  `i_price` bigint(20) DEFAULT NULL,
  `fk_c_currency_code` char(3) DEFAULT NULL,
  `s_contact_name` varchar(100) DEFAULT NULL,
  `s_contact_email` varchar(140) NOT NULL,
  `s_ip` varchar(64) NOT NULL DEFAULT '',
  `b_premium` tinyint(1) NOT NULL DEFAULT 0,
  `b_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `b_active` tinyint(1) NOT NULL DEFAULT 0,
  `b_spam` tinyint(1) NOT NULL DEFAULT 0,
  `s_secret` varchar(40) DEFAULT NULL,
  `b_show_email` tinyint(1) DEFAULT NULL,
  `dt_expiration` datetime NOT NULL DEFAULT '9999-12-31 23:59:59',
  PRIMARY KEY (`pk_i_id`),
  KEY `fk_i_user_id` (`fk_i_user_id`),
  KEY `idx_b_premium` (`b_premium`),
  KEY `idx_s_contact_email` (`s_contact_email`(10)),
  KEY `fk_i_category_id` (`fk_i_category_id`),
  KEY `fk_c_currency_code` (`fk_c_currency_code`),
  KEY `idx_pub_date` (`dt_pub_date`),
  KEY `idx_price` (`i_price`),
  CONSTRAINT `oc_t_item_ibfk_1` FOREIGN KEY (`fk_i_user_id`) REFERENCES `oc_t_user` (`pk_i_id`),
  CONSTRAINT `oc_t_item_ibfk_2` FOREIGN KEY (`fk_i_category_id`) REFERENCES `oc_t_category` (`pk_i_id`),
  CONSTRAINT `oc_t_item_ibfk_3` FOREIGN KEY (`fk_c_currency_code`) REFERENCES `oc_t_currency` (`pk_c_code`)
) ENGINE=InnoDB AUTO_INCREMENT=118198 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_item_comment
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_item_comment`;
CREATE TABLE `oc_t_item_comment` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_i_item_id` int(10) unsigned NOT NULL,
  `dt_pub_date` datetime NOT NULL,
  `s_title` varchar(200) NOT NULL,
  `s_author_name` varchar(100) NOT NULL,
  `s_author_email` varchar(100) NOT NULL,
  `s_body` text NOT NULL,
  `b_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `b_active` tinyint(1) NOT NULL DEFAULT 0,
  `b_spam` tinyint(1) NOT NULL DEFAULT 0,
  `fk_i_user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`pk_i_id`),
  KEY `fk_i_item_id` (`fk_i_item_id`),
  KEY `fk_i_user_id` (`fk_i_user_id`),
  CONSTRAINT `oc_t_item_comment_ibfk_1` FOREIGN KEY (`fk_i_item_id`) REFERENCES `oc_t_item` (`pk_i_id`),
  CONSTRAINT `oc_t_item_comment_ibfk_2` FOREIGN KEY (`fk_i_user_id`) REFERENCES `oc_t_user` (`pk_i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=312 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_item_description
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_item_description`;
CREATE TABLE `oc_t_item_description` (
  `fk_i_item_id` int(10) unsigned NOT NULL,
  `fk_c_locale_code` char(5) NOT NULL,
  `s_title` varchar(100) NOT NULL,
  `s_description` mediumtext NOT NULL,
  PRIMARY KEY (`fk_i_item_id`,`fk_c_locale_code`),
  FULLTEXT KEY `s_description` (`s_description`,`s_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_item_location
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_item_location`;
CREATE TABLE `oc_t_item_location` (
  `fk_i_item_id` int(10) unsigned NOT NULL,
  `fk_c_country_code` char(2) DEFAULT NULL,
  `s_country` varchar(40) DEFAULT NULL,
  `s_address` varchar(100) DEFAULT NULL,
  `s_zip` varchar(15) DEFAULT NULL,
  `fk_i_region_id` int(10) unsigned DEFAULT NULL,
  `s_region` varchar(100) DEFAULT NULL,
  `fk_i_city_id` int(10) unsigned DEFAULT NULL,
  `s_city` varchar(100) DEFAULT NULL,
  `fk_i_city_area_id` int(10) unsigned DEFAULT NULL,
  `s_city_area` varchar(200) DEFAULT NULL,
  `d_coord_lat` decimal(10,6) DEFAULT NULL,
  `d_coord_long` decimal(10,6) DEFAULT NULL,
  PRIMARY KEY (`fk_i_item_id`),
  KEY `fk_c_country_code` (`fk_c_country_code`),
  KEY `fk_i_region_id` (`fk_i_region_id`),
  KEY `fk_i_city_id` (`fk_i_city_id`),
  KEY `fk_i_city_area_id` (`fk_i_city_area_id`),
  CONSTRAINT `oc_t_item_location_ibfk_1` FOREIGN KEY (`fk_i_item_id`) REFERENCES `oc_t_item` (`pk_i_id`),
  CONSTRAINT `oc_t_item_location_ibfk_2` FOREIGN KEY (`fk_c_country_code`) REFERENCES `oc_t_country` (`pk_c_code`),
  CONSTRAINT `oc_t_item_location_ibfk_3` FOREIGN KEY (`fk_i_region_id`) REFERENCES `oc_t_region` (`pk_i_id`),
  CONSTRAINT `oc_t_item_location_ibfk_4` FOREIGN KEY (`fk_i_city_id`) REFERENCES `oc_t_city` (`pk_i_id`),
  CONSTRAINT `oc_t_item_location_ibfk_5` FOREIGN KEY (`fk_i_city_area_id`) REFERENCES `oc_t_city_area` (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_item_meta
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_item_meta`;
CREATE TABLE `oc_t_item_meta` (
  `fk_i_item_id` int(10) unsigned NOT NULL,
  `fk_i_field_id` int(10) unsigned NOT NULL,
  `s_value` text DEFAULT NULL,
  `s_multi` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`fk_i_item_id`,`fk_i_field_id`,`s_multi`),
  KEY `s_value` (`s_value`(255)),
  KEY `fk_i_field_id` (`fk_i_field_id`),
  CONSTRAINT `oc_t_item_meta_ibfk_1` FOREIGN KEY (`fk_i_item_id`) REFERENCES `oc_t_item` (`pk_i_id`),
  CONSTRAINT `oc_t_item_meta_ibfk_2` FOREIGN KEY (`fk_i_field_id`) REFERENCES `oc_t_meta_fields` (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_item_promotion
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_item_promotion`;
CREATE TABLE `oc_t_item_promotion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) DEFAULT NULL,
  `promotype` tinyint(1) DEFAULT NULL,
  `end_promo` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6746 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_item_resource
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_item_resource`;
CREATE TABLE `oc_t_item_resource` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_i_item_id` int(10) unsigned NOT NULL,
  `s_name` varchar(60) DEFAULT NULL,
  `s_extension` varchar(10) DEFAULT NULL,
  `s_content_type` varchar(40) DEFAULT NULL,
  `s_path` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`pk_i_id`),
  KEY `fk_i_item_id` (`fk_i_item_id`),
  KEY `idx_s_content_type` (`pk_i_id`,`s_content_type`(10)),
  CONSTRAINT `oc_t_item_resource_ibfk_1` FOREIGN KEY (`fk_i_item_id`) REFERENCES `oc_t_item` (`pk_i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=140794 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_item_stats
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_item_stats`;
CREATE TABLE `oc_t_item_stats` (
  `fk_i_item_id` int(10) unsigned NOT NULL,
  `i_num_views` int(10) unsigned NOT NULL DEFAULT 0,
  `i_num_spam` int(10) unsigned NOT NULL DEFAULT 0,
  `i_num_repeated` int(10) unsigned NOT NULL DEFAULT 0,
  `i_num_bad_classified` int(10) unsigned NOT NULL DEFAULT 0,
  `i_num_offensive` int(10) unsigned NOT NULL DEFAULT 0,
  `i_num_expired` int(10) unsigned NOT NULL DEFAULT 0,
  `i_num_premium_views` int(10) unsigned NOT NULL DEFAULT 0,
  `dt_date` date NOT NULL,
  PRIMARY KEY (`fk_i_item_id`,`dt_date`),
  KEY `dt_date_fk_i_item_id` (`dt_date`,`fk_i_item_id`),
  CONSTRAINT `oc_t_item_stats_ibfk_1` FOREIGN KEY (`fk_i_item_id`) REFERENCES `oc_t_item` (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_item_stats_stela
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_item_stats_stela`;
CREATE TABLE `oc_t_item_stats_stela` (
  `fk_i_item_id` int(11) unsigned NOT NULL,
  `i_num_phone_clicks` int(10) DEFAULT 0,
  `dt_date` date NOT NULL,
  PRIMARY KEY (`fk_i_item_id`,`dt_date`),
  CONSTRAINT `oc_t_item_stats_stela_ibfk_1` FOREIGN KEY (`fk_i_item_id`) REFERENCES `oc_t_item` (`pk_i_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_item_stela
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_item_stela`;
CREATE TABLE `oc_t_item_stela` (
  `fk_i_item_id` int(11) unsigned NOT NULL,
  `s_phone` varchar(100) DEFAULT NULL,
  `i_condition` varchar(100) DEFAULT NULL,
  `i_transaction` varchar(100) DEFAULT NULL,
  `i_sold` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`fk_i_item_id`),
  UNIQUE KEY `fk_i_item_id` (`fk_i_item_id`),
  CONSTRAINT `oc_t_item_stela_ibfk_1` FOREIGN KEY (`fk_i_item_id`) REFERENCES `oc_t_item` (`pk_i_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_item_watchlist
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_item_watchlist`;
CREATE TABLE `oc_t_item_watchlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_i_item_id` int(10) unsigned DEFAULT NULL,
  `fk_i_user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_keywords
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_keywords`;
CREATE TABLE `oc_t_keywords` (
  `s_md5` varchar(32) NOT NULL,
  `fk_c_locale_code` char(5) NOT NULL,
  `s_original_text` varchar(255) NOT NULL,
  `s_anchor_text` varchar(255) NOT NULL,
  `s_normalized_text` varchar(255) NOT NULL,
  `fk_i_category_id` int(10) unsigned DEFAULT NULL,
  `fk_i_city_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`s_md5`,`fk_c_locale_code`),
  KEY `fk_i_category_id` (`fk_i_category_id`),
  KEY `fk_i_city_id` (`fk_i_city_id`),
  KEY `fk_c_locale_code` (`fk_c_locale_code`),
  CONSTRAINT `oc_t_keywords_ibfk_1` FOREIGN KEY (`fk_i_category_id`) REFERENCES `oc_t_category` (`pk_i_id`),
  CONSTRAINT `oc_t_keywords_ibfk_2` FOREIGN KEY (`fk_i_city_id`) REFERENCES `oc_t_city` (`pk_i_id`),
  CONSTRAINT `oc_t_keywords_ibfk_3` FOREIGN KEY (`fk_c_locale_code`) REFERENCES `oc_t_locale` (`pk_c_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_latest_searches
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_latest_searches`;
CREATE TABLE `oc_t_latest_searches` (
  `d_date` datetime NOT NULL,
  `s_search` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_locale
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_locale`;
CREATE TABLE `oc_t_locale` (
  `pk_c_code` char(5) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_short_name` varchar(40) NOT NULL,
  `s_description` varchar(100) NOT NULL,
  `s_version` varchar(20) NOT NULL,
  `s_author_name` varchar(100) NOT NULL,
  `s_author_url` varchar(100) NOT NULL,
  `s_currency_format` varchar(50) NOT NULL,
  `s_dec_point` varchar(2) DEFAULT '.',
  `s_thousands_sep` varchar(2) DEFAULT '',
  `i_num_dec` tinyint(4) DEFAULT 2,
  `s_date_format` varchar(20) NOT NULL,
  `s_stop_words` text DEFAULT NULL,
  `b_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `b_enabled_bo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`pk_c_code`),
  UNIQUE KEY `s_short_name` (`s_short_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_locations_tmp
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_locations_tmp`;
CREATE TABLE `oc_t_locations_tmp` (
  `id_location` varchar(10) NOT NULL,
  `e_type` enum('COUNTRY','REGION','CITY') NOT NULL,
  PRIMARY KEY (`id_location`,`e_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_log
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_log`;
CREATE TABLE `oc_t_log` (
  `dt_date` datetime NOT NULL,
  `s_section` varchar(50) NOT NULL,
  `s_action` varchar(50) NOT NULL,
  `fk_i_id` int(10) unsigned NOT NULL,
  `s_data` varchar(250) NOT NULL,
  `s_ip` varchar(50) NOT NULL,
  `s_who` varchar(50) NOT NULL,
  `fk_i_who_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_massive_email
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_massive_email`;
CREATE TABLE `oc_t_massive_email` (
  `pk_i_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_subject` varchar(255) DEFAULT NULL,
  `s_body` text DEFAULT NULL,
  PRIMARY KEY (`pk_i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_massive_email_duty
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_massive_email_duty`;
CREATE TABLE `oc_t_massive_email_duty` (
  `pk_i_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_i_user_id` int(11) NOT NULL,
  `i_sent` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`pk_i_id`),
  KEY `sent` (`i_sent`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=243728 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_meta_categories
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_meta_categories`;
CREATE TABLE `oc_t_meta_categories` (
  `fk_i_category_id` int(10) unsigned NOT NULL,
  `fk_i_field_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`fk_i_category_id`,`fk_i_field_id`),
  KEY `fk_i_field_id` (`fk_i_field_id`),
  CONSTRAINT `oc_t_meta_categories_ibfk_1` FOREIGN KEY (`fk_i_category_id`) REFERENCES `oc_t_category` (`pk_i_id`),
  CONSTRAINT `oc_t_meta_categories_ibfk_2` FOREIGN KEY (`fk_i_field_id`) REFERENCES `oc_t_meta_fields` (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_meta_fields
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_meta_fields`;
CREATE TABLE `oc_t_meta_fields` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_name` varchar(255) NOT NULL,
  `s_slug` varchar(255) NOT NULL,
  `e_type` enum('TEXT','TEXTAREA','DROPDOWN','RADIO','CHECKBOX','URL','DATE','DATEINTERVAL') NOT NULL DEFAULT 'TEXT',
  `s_options` varchar(2048) DEFAULT NULL,
  `b_required` tinyint(1) NOT NULL DEFAULT 0,
  `b_searchable` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`pk_i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_pages
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_pages`;
CREATE TABLE `oc_t_pages` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_internal_name` varchar(50) DEFAULT NULL,
  `b_indelible` tinyint(1) NOT NULL DEFAULT 0,
  `b_link` tinyint(1) NOT NULL DEFAULT 1,
  `dt_pub_date` datetime NOT NULL,
  `dt_mod_date` datetime DEFAULT NULL,
  `i_order` int(3) NOT NULL DEFAULT 0,
  `s_meta` text DEFAULT NULL,
  PRIMARY KEY (`pk_i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_pages_description
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_pages_description`;
CREATE TABLE `oc_t_pages_description` (
  `fk_i_pages_id` int(10) unsigned NOT NULL,
  `fk_c_locale_code` char(5) NOT NULL,
  `s_title` varchar(255) NOT NULL,
  `s_text` text DEFAULT NULL,
  PRIMARY KEY (`fk_i_pages_id`,`fk_c_locale_code`),
  KEY `fk_c_locale_code` (`fk_c_locale_code`),
  CONSTRAINT `oc_t_pages_description_ibfk_1` FOREIGN KEY (`fk_i_pages_id`) REFERENCES `oc_t_pages` (`pk_i_id`),
  CONSTRAINT `oc_t_pages_description_ibfk_2` FOREIGN KEY (`fk_c_locale_code`) REFERENCES `oc_t_locale` (`pk_c_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_plugin_category
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_plugin_category`;
CREATE TABLE `oc_t_plugin_category` (
  `s_plugin_name` varchar(40) NOT NULL,
  `fk_i_category_id` int(10) unsigned NOT NULL,
  KEY `fk_i_category_id` (`fk_i_category_id`),
  CONSTRAINT `oc_t_plugin_category_ibfk_1` FOREIGN KEY (`fk_i_category_id`) REFERENCES `oc_t_category` (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_preference
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_preference`;
CREATE TABLE `oc_t_preference` (
  `s_section` varchar(128) NOT NULL,
  `s_name` varchar(128) NOT NULL,
  `s_value` longtext NOT NULL,
  `e_type` enum('STRING','INTEGER','BOOLEAN') NOT NULL,
  UNIQUE KEY `s_section` (`s_section`,`s_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_profile_picture
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_profile_picture`;
CREATE TABLE `oc_t_profile_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `pic_ext` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_profile_wallet
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_profile_wallet`;
CREATE TABLE `oc_t_profile_wallet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `credits` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19125 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_region
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_region`;
CREATE TABLE `oc_t_region` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_c_country_code` char(2) NOT NULL,
  `s_name` varchar(60) NOT NULL,
  `s_slug` varchar(60) NOT NULL DEFAULT '',
  `b_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`pk_i_id`),
  KEY `fk_c_country_code` (`fk_c_country_code`),
  KEY `idx_s_name` (`s_name`),
  KEY `idx_s_slug` (`s_slug`),
  CONSTRAINT `oc_t_region_ibfk_1` FOREIGN KEY (`fk_c_country_code`) REFERENCES `oc_t_country` (`pk_c_code`)
) ENGINE=InnoDB AUTO_INCREMENT=782053 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_region_stats
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_region_stats`;
CREATE TABLE `oc_t_region_stats` (
  `fk_i_region_id` int(10) unsigned NOT NULL,
  `i_num_items` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`fk_i_region_id`),
  KEY `idx_num_items` (`i_num_items`),
  CONSTRAINT `oc_t_region_stats_ibfk_1` FOREIGN KEY (`fk_i_region_id`) REFERENCES `oc_t_region` (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_sms_massive
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_sms_massive`;
CREATE TABLE `oc_t_sms_massive` (
  `pk_i_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_i_user_id` int(11) DEFAULT NULL,
  `s_number` varchar(255) DEFAULT NULL,
  `s_message` varchar(255) DEFAULT NULL,
  `i_sent` bit(6) DEFAULT b'0',
  PRIMARY KEY (`pk_i_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for oc_t_sms_sent
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_sms_sent`;
CREATE TABLE `oc_t_sms_sent` (
  `pk_i_id` int(7) NOT NULL AUTO_INCREMENT,
  `fk_i_user_id` int(7) NOT NULL,
  `s_number` varchar(16) NOT NULL,
  `s_message` varchar(160) NOT NULL,
  `dt_sent` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pk_i_id`),
  KEY `fk_i_user_id` (`fk_i_user_id`),
  KEY `s_number` (`s_number`)
) ENGINE=MyISAM AUTO_INCREMENT=2481 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for oc_t_user
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_user`;
CREATE TABLE `oc_t_user` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dt_reg_date` datetime NOT NULL,
  `dt_mod_date` datetime DEFAULT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_username` varchar(100) NOT NULL,
  `s_password` char(60) NOT NULL,
  `s_secret` varchar(40) DEFAULT NULL,
  `s_email` varchar(100) NOT NULL,
  `s_website` varchar(100) DEFAULT NULL,
  `s_phone_land` varchar(45) DEFAULT NULL,
  `s_phone_mobile` varchar(45) DEFAULT NULL,
  `b_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `b_active` tinyint(1) NOT NULL DEFAULT 0,
  `s_pass_code` varchar(100) DEFAULT NULL,
  `s_pass_date` datetime DEFAULT NULL,
  `s_pass_ip` varchar(15) DEFAULT NULL,
  `fk_c_country_code` char(2) DEFAULT NULL,
  `s_country` varchar(40) DEFAULT NULL,
  `s_address` varchar(100) DEFAULT NULL,
  `s_zip` varchar(15) DEFAULT NULL,
  `fk_i_region_id` int(10) unsigned DEFAULT NULL,
  `s_region` varchar(100) DEFAULT NULL,
  `fk_i_city_id` int(10) unsigned DEFAULT NULL,
  `s_city` varchar(100) DEFAULT NULL,
  `fk_i_city_area_id` int(10) unsigned DEFAULT NULL,
  `s_city_area` varchar(200) DEFAULT NULL,
  `d_coord_lat` decimal(10,6) DEFAULT NULL,
  `d_coord_long` decimal(10,6) DEFAULT NULL,
  `b_company` tinyint(1) NOT NULL DEFAULT 0,
  `i_items` int(10) unsigned DEFAULT 0,
  `i_comments` int(10) unsigned DEFAULT 0,
  `dt_access_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `s_access_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`pk_i_id`),
  UNIQUE KEY `s_email` (`s_email`),
  KEY `idx_s_name` (`s_name`(6)),
  KEY `idx_s_username` (`s_username`),
  KEY `fk_c_country_code` (`fk_c_country_code`),
  KEY `fk_i_region_id` (`fk_i_region_id`),
  KEY `fk_i_city_id` (`fk_i_city_id`),
  KEY `fk_i_city_area_id` (`fk_i_city_area_id`),
  CONSTRAINT `oc_t_user_ibfk_1` FOREIGN KEY (`fk_c_country_code`) REFERENCES `oc_t_country` (`pk_c_code`),
  CONSTRAINT `oc_t_user_ibfk_2` FOREIGN KEY (`fk_i_region_id`) REFERENCES `oc_t_region` (`pk_i_id`),
  CONSTRAINT `oc_t_user_ibfk_3` FOREIGN KEY (`fk_i_city_id`) REFERENCES `oc_t_city` (`pk_i_id`),
  CONSTRAINT `oc_t_user_ibfk_4` FOREIGN KEY (`fk_i_city_area_id`) REFERENCES `oc_t_city_area` (`pk_i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19162 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_user_description
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_user_description`;
CREATE TABLE `oc_t_user_description` (
  `fk_i_user_id` int(10) unsigned NOT NULL,
  `fk_c_locale_code` char(5) NOT NULL,
  `s_info` text DEFAULT NULL,
  PRIMARY KEY (`fk_i_user_id`,`fk_c_locale_code`),
  KEY `fk_c_locale_code` (`fk_c_locale_code`),
  CONSTRAINT `oc_t_user_description_ibfk_1` FOREIGN KEY (`fk_i_user_id`) REFERENCES `oc_t_user` (`pk_i_id`),
  CONSTRAINT `oc_t_user_description_ibfk_2` FOREIGN KEY (`fk_c_locale_code`) REFERENCES `oc_t_locale` (`pk_c_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_user_email_tmp
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_user_email_tmp`;
CREATE TABLE `oc_t_user_email_tmp` (
  `fk_i_user_id` int(10) unsigned NOT NULL,
  `s_new_email` varchar(100) NOT NULL,
  `dt_date` datetime NOT NULL,
  PRIMARY KEY (`fk_i_user_id`),
  CONSTRAINT `oc_t_user_email_tmp_ibfk_1` FOREIGN KEY (`fk_i_user_id`) REFERENCES `oc_t_user` (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oc_t_widget
-- ----------------------------
DROP TABLE IF EXISTS `oc_t_widget`;
CREATE TABLE `oc_t_widget` (
  `pk_i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_description` varchar(40) NOT NULL,
  `s_location` varchar(40) NOT NULL,
  `e_kind` enum('TEXT','HTML') NOT NULL,
  `s_content` mediumtext NOT NULL,
  PRIMARY KEY (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET FOREIGN_KEY_CHECKS=1;
