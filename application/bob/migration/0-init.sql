CREATE TABLE `puja_acl_privilege` (
  `id_acl_privilege` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(128) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` DATETIME NULL  COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_acl_privilege`),
  UNIQUE KEY `acl_privilege_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_acl_resource` (
  `id_acl_resource` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(128) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` DATETIME NULL  COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_acl_resource`),
  UNIQUE KEY `acl_resource_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_acl_role` (
  `id_acl_role` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(128) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` TEXT NULL,
  `fk_acl_role` int(10) unsigned DEFAULT NULL,
  `created_at` DATETIME NULL  COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_acl_role`),
  UNIQUE KEY `acl_role_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;


CREATE TABLE `puja_acl_user` (
  `id_acl_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT '' ,
  `password` varchar(128) NOT NULL COMMENT 'hashed password',
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  `fk_acl_role` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_acl_user`),
  UNIQUE KEY `acl_user_unique` (`username`),
  KEY `fk_acl_user_acl_role1` (`fk_acl_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_acl_roleset` (
  `id_acl_roleset` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_acl_role` int(10) unsigned DEFAULT NULL,
  `fk_acl_privilege` int(11) unsigned DEFAULT NULL,
  `fk_acl_resource` int(11) unsigned DEFAULT NULL,
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_acl_roleset`),
  UNIQUE KEY `acl_rule_unique` (`fk_acl_role`,`fk_acl_privilege`,`fk_acl_resource`),
  KEY `fk_acl_privilege` (`fk_acl_privilege`),
  KEY `fk_acl_resource` (`fk_acl_resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

insert into puja_acl_privilege(`key`, `name`) values ('read', 'Read'), ('create', 'Create'), ('update', 'Update'), ('delete', 'Delete');
insert into puja_acl_role(`key`, `name`) values ('admin', 'Admin'), ('guest', 'Guest'),('user', 'User');
insert into puja_acl_user(`username`, `email`, `password`, `fk_acl_role`) values ('admin','admin@pujacms', md5('admin'), 1), ('guest','guest@pujacms', md5('admin'), 2), ('user','user@pujacms', md5('user'), 3);

CREATE TABLE `puja_configure` (
  `id_configure` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_configure_group` INT(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `field_type` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `cfg_data` TEXT,
  `init_data` TEXT,
  `is_system` TINYINT(1) NOT NULL,
  `order_id` INT(5) NOT NULL,
  `note` varchar(255) NOT NULL,
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_configure`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_configure_cmsmenu` (
  `id_configure_cmsmenu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL ,
  `status` TINYINT(1) NOT NULL,
  `order_id` INT(5) NOT NULL,
  `child` TEXT NOT NULL,
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_configure_cmsmenu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_configure_module` (
  `id_configure_module` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `fk_module_type` INT(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alice_module` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` TEXT NULL,
  `core_data` TEXT NOT NULL,
  `cfg_data` TEXT NOT NULL,
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_configure_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `puja_configure_module_type` (
  `id_configure_module_type` int(3) NOT NULL,
  `module_type` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `order_id` int(3) NOT NULL,
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_configure_module_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `puja_configure_module_type` (`id_configure_module_type`, `module_type`, `name`, `order_id`) VALUES
(1, 'entity', 'Entity', 0),
(2, 'customize', 'Customize', 0),
(3, 'html', 'Html', 0),
(4, 'system', 'System', 0);

CREATE TABLE `puja_configure_cmstheme` (
  `id_configure_cmstheme` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `order_id` int(3) DEFAULT 0,
  `theme_data` TEXT NOT NULL,
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_configure_cmstheme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_configure_group` (
  `id_configure_group` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `order_id` int(3) NOT NULL,
  `status` int(3) NOT NULL,
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_configure_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_configure_language` (
  `id_configure_language` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `locale` varchar(10) NOT NULL,
  `is_default` int(3) NOT NULL,
  `order_id` int(3) NOT NULL,
  `status` int(3) NOT NULL,
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_configure_language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

INSERT INTO `puja_configure_language` (`name`, `locale`, `is_default`, `order_id`, `status`)
VALUES ('Vietnamese', 'vi', '1', '0', '1'), ('English', 'en', '0', '1', '1');

CREATE TABLE `puja_content` (
  `id_content` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'system',
  `fk_configure_module` int(3) NOT NULL COMMENT 'system',
  `fk_category` int(10) NOT NULL COMMENT 'system',
  `order_id` int(10) NOT NULL COMMENT 'system',
  `status` tinyint(1) DEFAULT NULL COMMENT 'system',
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_content_ln` (
  `fk_content` int(10) unsigned NOT NULL COMMENT 'system',
  `fk_configure_language` int(10) unsigned NOT NULL COMMENT 'system',
  `name` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`fk_content`,`fk_configure_language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_category` (
  `id_category` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'system',
  `fk_configure_module` int(3) NOT NULL COMMENT 'system',
  `parent_fk_category` int(10) NOT NULL COMMENT 'system',
  `order_id` int(10) NOT NULL COMMENT 'system',
  `status` tinyint(1) DEFAULT NULL COMMENT 'system',
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_category_ln` (
  `fk_category` int(10) unsigned NOT NULL COMMENT 'system',
  `fk_configure_language` INT(10) NOT NULL COMMENT 'system',
  `name` VARCHAR(255) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`fk_category`,`fk_configure_language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_link_content_category` (
  `fk_content` int(10) unsigned NOT NULL COMMENT 'system',
  `fk_category` int(10) unsigned NOT NULL COMMENT 'system',
  PRIMARY KEY (`fk_content`,`fk_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_link_content_content` (
  `fk_configure_module` int(10) unsigned NOT NULL COMMENT 'system',
  `field_name` VARCHAR(255) NOT NULL,
  `src_fk_content` int(10) unsigned NOT NULL COMMENT 'system',
  `target_fk_content` int(10) unsigned NOT NULL COMMENT 'system'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_link_entity_media` (
  `record_type` VARCHAR(255) NOT NULL DEFAULT "content",
  `fk_entity` int(11) NOT NULL,
  `fk_media` int(11) NOT NULL,
  PRIMARY KEY (`record_type`,`fk_entity`,`fk_media`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `puja_html` (
  `id_html` int(10) unsigned NOT NULL COMMENT 'system',
  `order_id` int(10) NOT NULL COMMENT 'system',
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_html`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_html_ln` (
  `fk_html` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'system',
  `fk_configure_language` varchar(10) NOT NULL COMMENT 'system',
  `name` text,
  `description` text,
  PRIMARY KEY (`fk_html`,`fk_configure_language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_html_link_entity_media` (
  `record_type` VARCHAR(255) NOT NULL DEFAULT "content",
  `fk_html` int(11) NOT NULL,
  `fk_media` int(11) NOT NULL,
  PRIMARY KEY (`record_type`,`fk_html`,`fk_media`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_media` (
  `id_media` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_used` INT(1) DEFAULT "0",
  `name` VARCHAR(255),
  `description` TEXT NULL,
  `src` VARCHAR(255),
  `filesize` INT(10),
  `image_size` VARCHAR(255),
  `thumb_size` VARCHAR(255),
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_media`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_configure_pagemeta` (
  `id_configure_pagemeta` int(5) NOT NULL AUTO_INCREMENT,
  `fk_configure_module` int(5) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alice_module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `metadata` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_configure_pagemeta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_configure_webtranslate` (
  `id_configure_webtranslate` int(5) NOT NULL AUTO_INCREMENT,
  `translate_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` DATETIME NULL COMMENT 'system',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT 'system',
  PRIMARY KEY (`id_configure_webtranslate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `puja_configure_webtranslate_ln` (
  `fk_configure_webtranslate` int(10) unsigned NOT NULL COMMENT 'system',
  `fk_configure_language` int(10) unsigned NOT NULL COMMENT 'system',
  `translate_value` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`fk_configure_webtranslate`, `fk_configure_language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--- Alice table (maybe use sqlite for Alice)
-- puja_alice_content_search ( store some basic content field, it just for search)
-- puja_alice_content_object ( store object data content)
-- puja_alice_category_search ( store some basic content field, it just for search)
-- puja_alice_category_object ( store object data content)
-- puja_alice_html_object
-- puja_alice_configure_object