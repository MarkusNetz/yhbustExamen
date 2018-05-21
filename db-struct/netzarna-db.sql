-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema pjdqirfm_netz
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `netzarna` ;

-- -----------------------------------------------------
-- Schema pjdqirfm_netz
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `pjdqirfm_netz` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci ;
USE `pjdqirfm_netz` ;

-- -----------------------------------------------------
-- Table `t_cv_work_experience`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_cv_work_experience` ;

CREATE TABLE IF NOT EXISTS `t_cv_work_experience` (
  `id_work_experience` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cv` SMALLINT UNSIGNED NOT NULL,
  `start_date` DATE NULL,
  `end_date` DATE NULL DEFAULT '9999-12-31',
  `employer` VARCHAR(45) NULL,
  `work_title` VARCHAR(50) NOT NULL,
  `work_description` VARCHAR(1000) NOT NULL,
  `added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_work_experience`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_users` ;

CREATE TABLE IF NOT EXISTS `t_users` (
  `id_user` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_first` VARCHAR(45) NOT NULL,
  `name_last` VARCHAR(45) NOT NULL,
  `personal_number` VARCHAR(15) NOT NULL,
  `registered` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  `unique_hash` VARCHAR(45) NULL,
  `t_userscol` CHAR(32) NULL,
  UNIQUE INDEX `personal_number_UNIQUE` (`personal_number` ASC),
  PRIMARY KEY (`id_user`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_user_has_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_user_has_address` ;

CREATE TABLE IF NOT EXISTS `t_user_has_address` (
  `id_user_address` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` SMALLINT UNSIGNED NOT NULL,
  `id_street` SMALLINT UNSIGNED NOT NULL,
  `street_number` VARCHAR(45) NOT NULL,
  `street_letter` CHAR(1) NULL,
  `id_zip_code` SMALLINT NOT NULL,
  `id_postal_area` SMALLINT NOT NULL,
  `id_city` VARCHAR(45) NOT NULL,
  `added` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_cv_educations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_cv_educations` ;

CREATE TABLE IF NOT EXISTS `t_cv_educations` (
  `id_education` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cv` SMALLINT UNSIGNED NOT NULL,
  `start_date` DATE NULL,
  `end_date` DATE NULL DEFAULT '9999-12-31',
  `school` VARCHAR(45) NULL,
  `education_title` VARCHAR(50) NOT NULL,
  `education_description` VARCHAR(1000) NOT NULL,
  `added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_education`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_cv_skills`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_cv_skills` ;

CREATE TABLE IF NOT EXISTS `t_cv_skills` (
  `id_skill` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cv` SMALLINT UNSIGNED NOT NULL,
  `skill` VARCHAR(75) NOT NULL,
  `skill_level` TINYINT UNSIGNED NOT NULL,
  `added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_skill`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_user_has_cv`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_user_has_cv` ;

CREATE TABLE IF NOT EXISTS `t_user_has_cv` (
  `id_cv` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` SMALLINT UNSIGNED NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(45) NULL,
  `created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `edited` VARCHAR(45) NULL DEFAULT 'ON UPDATE CURRENT_TIMESTAMP',
  PRIMARY KEY (`id_cv`),
  INDEX `id_user` (`id_user` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_loc_streets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_loc_streets` ;

CREATE TABLE IF NOT EXISTS `t_loc_streets` (
  `id_street` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id_street`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_user_has_contact_info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_user_has_contact_info` ;

CREATE TABLE IF NOT EXISTS `t_user_has_contact_info` (
  `id_user_info` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` SMALLINT UNSIGNED NOT NULL,
  `id_contact_type` TINYINT UNSIGNED NOT NULL,
  `contact` VARCHAR(45) NULL,
  `acquired` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user_info`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_contact_types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_contact_types` ;

CREATE TABLE IF NOT EXISTS `t_contact_types` (
  `id_contact_type` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  `description` VARCHAR(100) NULL,
  PRIMARY KEY (`id_contact_type`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_loc_zip_codes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_loc_zip_codes` ;

CREATE TABLE IF NOT EXISTS `t_loc_zip_codes` (
  `id_zip_codes` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `zip_code` CHAR(6) NULL,
  PRIMARY KEY (`id_zip_codes`),
  UNIQUE INDEX `zip_code_UNIQUE` (`zip_code` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_loc_cities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_loc_cities` ;

CREATE TABLE IF NOT EXISTS `t_loc_cities` (
  `id_city` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `city` VARCHAR(50) NULL,
  PRIMARY KEY (`id_city`),
  UNIQUE INDEX `zip_code_UNIQUE` (`city` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_loc_postal_areas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_loc_postal_areas` ;

CREATE TABLE IF NOT EXISTS `t_loc_postal_areas` (
  `id_postal_area` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `postal_area` VARCHAR(50) NULL,
  PRIMARY KEY (`id_postal_area`),
  UNIQUE INDEX `zip_code_UNIQUE` (`postal_area` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_user_has_login`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_user_has_login` ;

CREATE TABLE IF NOT EXISTS `t_user_has_login` (
  `idt_user_login` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(100) NULL COMMENT 'value to be used as an identifier for a user to login. Could be a name, or email.',
  `passphrase` VARCHAR(255) NULL,
  `last_login` TIMESTAMP NULL COMMENT 'Updated on each successful login.',
  `latest_activity` TIMESTAMP NULL,
  `pass_updated` TIMESTAMP NULL,
  PRIMARY KEY (`idt_user_login`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `t_logins`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `t_logins` ;

CREATE TABLE IF NOT EXISTS `t_logins` (
  `id_login` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` VARBINARY(16) NULL COMMENT 'VARBINARY to store both ipv6 and ipv4 IP-addresses.',
  `host` VARCHAR(255) NULL,
  `login_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `login_code` VARCHAR(45) NULL,
  PRIMARY KEY (`id_login`))
ENGINE = InnoDB;

-- begin attached script 'INSERT-t_users'
INSERT INTO `t_users`
(`id_user`,
`name_first`,
`name_last`,
`personal_number`)
VALUES
(1,
'Markus',
'Netz',
'19890127-2412');

-- end attached script 'INSERT-t_users'
-- begin attached script 'INSERT-t_contact_types'
INSERT INTO `t_contact_types`
(`id_contact_type`,
`name`,
`description`)
VALUES
(1, 'email', 'Represents a valid e-mailaddress for a user.'),
(2,'phone number','Represents a phone number to a user'),
(3, 'linkedIn', 'URL to a users LinkedIn space.');
-- end attached script 'INSERT-t_contact_types'
-- begin attached script 'INSERT-t_logins'
INSERT INTO `t_logins`
(`ip`, `host`, `login_code`)
VALUES
(IF (is_ipv4('fdfe::5a55:caff:fefa:9089'), inet_aton('fdfe::5a55:caff:fefa:9089'), IF (is_ipv6('fdfe::5a55:caff:fefa:9089'),inet6_aton('fdfe::5a55:caff:fefa:9089'), null)),
'Testar',
'logged in'),
(IF (is_ipv4('123.32.123.32'), inet_aton('123.32.123.32'), IF (is_ipv6('123.32.123.32'),inet6_aton('123.32.123.32'), null)),
'Testar',
'logged in');

-- end attached script 'INSERT-t_logins'