/*
SQLyog Community Edition- MySQL GUI v6.15
MySQL - 5.5.5-10.1.21-MariaDB : Database - project100
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `project100`;

USE `project100`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `ce_category` */

DROP TABLE IF EXISTS `ce_category`;

CREATE TABLE `ce_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ce_category` */

/*Table structure for table `ce_cities` */

DROP TABLE IF EXISTS `ce_cities`;

CREATE TABLE `ce_cities` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(200) DEFAULT NULL,
  `state_name` varchar(50) DEFAULT NULL,
  `country_name` varchar(50) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `city_lat` double DEFAULT NULL,
  `city_lng` double DEFAULT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ce_cities` */

/*Table structure for table `ce_product_categories` */

DROP TABLE IF EXISTS `ce_product_categories`;

CREATE TABLE `ce_product_categories` (
  `product_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ce_product_categories` */

/*Table structure for table `ce_products` */

DROP TABLE IF EXISTS `ce_products`;

CREATE TABLE `ce_products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` text,
  `product_description` text,
  `product_images` text,
  `product_videos` text,
  `product_pdfs` text,
  `product_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `product_manufacture` int(11) DEFAULT NULL,
  `product_number` varchar(255) DEFAULT NULL,
  `product_xtras` text,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ce_products` */

/*Table structure for table `ce_store_products` */

DROP TABLE IF EXISTS `ce_store_products`;

CREATE TABLE `ce_store_products` (
  `store_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price_regular` double DEFAULT NULL,
  `price_discounted` double DEFAULT NULL,
  `shipping` double DEFAULT NULL,
  `stock` double DEFAULT NULL,
  `product_status` int(1) NOT NULL DEFAULT '1',
  `city_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`store_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ce_store_products` */

/*Table structure for table `dating_profiles` */

DROP TABLE IF EXISTS `dating_profiles`;

CREATE TABLE `dating_profiles` (
  `dating_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `display_dating_name` varchar(50) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `birth_year` int(4) DEFAULT NULL,
  `birth_month` int(2) DEFAULT NULL,
  `birth_day` int(2) DEFAULT NULL,
  `birth_hour` int(2) DEFAULT NULL,
  `birth_minute` int(2) DEFAULT NULL,
  `birth_place` varchar(255) DEFAULT NULL,
  `marital_status` enum('single','divorced','separated','widowed','married') DEFAULT NULL,
  `description` text,
  `display_images` text,
  `hobbies` text,
  `dating_city` varchar(25) DEFAULT NULL,
  `dating_state` varchar(25) DEFAULT NULL,
  `dating_country` varchar(25) DEFAULT NULL,
  `dating_lat` double DEFAULT NULL,
  `dating_lng` double DEFAULT NULL,
  `dating_created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `birth_lat` double DEFAULT NULL,
  `birth_lng` double DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`dating_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `dating_profiles` */

/*Table structure for table `jobs_applied` */

DROP TABLE IF EXISTS `jobs_applied`;

CREATE TABLE `jobs_applied` (
  `applied_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `applied_user_id` int(11) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `cover_letter` varchar(255) DEFAULT NULL,
  `applied_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`applied_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jobs_applied` */

/*Table structure for table `jobs_posting` */

DROP TABLE IF EXISTS `jobs_posting`;

CREATE TABLE `jobs_posting` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_user_id` int(11) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `job_description` text,
  `job_type` enum('full_time','part_time','contract') DEFAULT NULL,
  `job_salary` varchar(255) DEFAULT NULL,
  `job_telecommute` int(1) DEFAULT '0',
  `job_posting_id` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `job_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `job_status` int(1) DEFAULT '1',
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jobs_posting` */

/*Table structure for table `jobs_skills` */

DROP TABLE IF EXISTS `jobs_skills`;

CREATE TABLE `jobs_skills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `skills` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jobs_skills` */

/*Table structure for table `med_stats` */

DROP TABLE IF EXISTS `med_stats`;

CREATE TABLE `med_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `display_gender` enum('male','female') DEFAULT NULL,
  `display_age` int(4) DEFAULT NULL,
  `display_date` date DEFAULT NULL,
  `submitted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `display_weight` int(4) DEFAULT NULL,
  `display_height` int(4) DEFAULT NULL,
  `problem_suffered` varchar(255) DEFAULT NULL,
  `description` text,
  `causes` varchar(255) DEFAULT NULL,
  `family_history` text,
  `medical_history` text,
  `disease` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `med_stats` */

/*Table structure for table `medical_daily_readings` */

DROP TABLE IF EXISTS `medical_daily_readings`;

CREATE TABLE `medical_daily_readings` (
  `reading_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `blood_pressure_upper` int(11) DEFAULT NULL,
  `blood_pressure_lower` int(11) DEFAULT NULL,
  `blood_suger_fasting` int(11) DEFAULT NULL,
  `blood_sugar_pp` int(11) DEFAULT NULL,
  `blood_sugar_random` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `reading_date` datetime DEFAULT NULL,
  PRIMARY KEY (`reading_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `medical_daily_readings` */

/*Table structure for table `medical_medicines` */

DROP TABLE IF EXISTS `medical_medicines`;

CREATE TABLE `medical_medicines` (
  `medicine_id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date DEFAULT NULL,
  `medicine` varchar(200) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `information` text,
  PRIMARY KEY (`medicine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `medical_medicines` */

/*Table structure for table `medical_patient_record` */

DROP TABLE IF EXISTS `medical_patient_record`;

CREATE TABLE `medical_patient_record` (
  `patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `family_history` text,
  `past_history` text,
  `gender` enum('male','female') DEFAULT NULL,
  `patient_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `medical_patient_record` */

/*Table structure for table `medical_reports` */

DROP TABLE IF EXISTS `medical_reports`;

CREATE TABLE `medical_reports` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `report_date` date DEFAULT NULL,
  `report_type` varchar(200) DEFAULT NULL,
  `report_result` text,
  `file_path` text,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `medical_reports` */

/*Table structure for table `public_video_categories` */

DROP TABLE IF EXISTS `public_video_categories`;

CREATE TABLE `public_video_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `public_video_categories` */

/*Table structure for table `public_video_linking` */

DROP TABLE IF EXISTS `public_video_linking`;

CREATE TABLE `public_video_linking` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `public_video_linking` */

/*Table structure for table `public_videos` */

DROP TABLE IF EXISTS `public_videos`;

CREATE TABLE `public_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `video_created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `video_year` int(4) DEFAULT NULL,
  `video_cast` text,
  `video_length` varchar(255) DEFAULT NULL,
  `video_language` varchar(255) DEFAULT NULL,
  `video_director` varchar(255) DEFAULT NULL,
  `video_genres` varchar(255) DEFAULT NULL,
  `video_image` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_related` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `public_videos` */

/*Table structure for table `real_estate_properties` */

DROP TABLE IF EXISTS `real_estate_properties`;

CREATE TABLE `real_estate_properties` (
  `re_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `address` varchar(255) DEFAULT NULL,
  `re_lat` double DEFAULT NULL,
  `re_lng` double DEFAULT NULL,
  `property_type` int(11) DEFAULT NULL,
  `county` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `built_year` int(11) DEFAULT NULL,
  `mls_id` varchar(200) DEFAULT NULL,
  `lot_size` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `beds` int(11) DEFAULT NULL,
  `bath` double DEFAULT NULL,
  `sq_feet` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ac` int(1) DEFAULT NULL,
  `washer_dryer` int(1) DEFAULT NULL,
  `pets_allowed` int(1) DEFAULT NULL,
  `buy_rent` int(1) DEFAULT NULL,
  `property_created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pool` int(1) DEFAULT NULL,
  `fitness` int(1) DEFAULT NULL,
  PRIMARY KEY (`re_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `real_estate_properties` */

/*Table structure for table `religions` */

DROP TABLE IF EXISTS `religions`;

CREATE TABLE `religions` (
  `religion_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `religion_name` varchar(255) DEFAULT NULL,
  `religion_description` text,
  `religion_creation_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `religion_status` int(1) NOT NULL DEFAULT '0',
  `religion_type` enum('public','closed') NOT NULL DEFAULT 'closed',
  PRIMARY KEY (`religion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `religions` */

insert  into `religions`(`religion_id`,`user_id`,`religion_name`,`religion_description`,`religion_creation_dt`,`religion_status`,`religion_type`) values (1,1,'Manny\'s Religion','All about my views','2017-08-03 21:41:46',1,'closed'),(2,1,'Hindu Religion','All about hindu religion','2017-08-03 21:41:48',1,'public');

/*Table structure for table `religions_follower` */

DROP TABLE IF EXISTS `religions_follower`;

CREATE TABLE `religions_follower` (
  `follower_id` int(11) NOT NULL AUTO_INCREMENT,
  `religion_id` int(11) DEFAULT NULL,
  `follower_user_id` int(11) DEFAULT NULL,
  `follower_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`follower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `religions_follower` */

/*Table structure for table `religions_like` */

DROP TABLE IF EXISTS `religions_like`;

CREATE TABLE `religions_like` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `view_id` int(11) DEFAULT NULL,
  `like_user_id` int(11) DEFAULT NULL,
  `like_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`like_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `religions_like` */

/*Table structure for table `religions_view` */

DROP TABLE IF EXISTS `religions_view`;

CREATE TABLE `religions_view` (
  `view_id` int(11) NOT NULL AUTO_INCREMENT,
  `view_user_id` int(11) DEFAULT NULL,
  `religion_id` int(11) DEFAULT NULL,
  `view_description` text,
  `category_id` int(2) DEFAULT NULL,
  `view_created_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`view_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `religions_view` */

insert  into `religions_view`(`view_id`,`view_user_id`,`religion_id`,`view_description`,`category_id`,`view_created_dt`) values (1,1,1,'There is only one GOD and it controls all world.',9,'2017-08-03 22:10:46'),(2,1,1,'Every one should eat natural foods',6,'2017-08-03 22:12:55');

/*Table structure for table `rf_comments` */

DROP TABLE IF EXISTS `rf_comments`;

CREATE TABLE `rf_comments` (
  `rf_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `commentor_user_id` int(11) DEFAULT NULL,
  `comment` text,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rf_comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `rf_comments` */

/*Table structure for table `rf_treatments` */

DROP TABLE IF EXISTS `rf_treatments`;

CREATE TABLE `rf_treatments` (
  `rf_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `problem` varchar(255) DEFAULT NULL,
  `treatment` enum('allopathy','surgery','ayurvedic','acupressure','acupuncture','aromatherapy','balneotherapy','biofeedback','chiropractic','homeopathy','naturopathy','reflexology','reiki','magnetotherapy','massagetherapy') DEFAULT NULL,
  `medicines_taken` text,
  `rf_description` text,
  `rf_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rf_age` int(4) DEFAULT NULL,
  `rf_gender` enum('male','female') DEFAULT NULL,
  `rf_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `rf_treatments` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `access_level` enum('member','admin') DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users` */

/*Table structure for table `users_auth` */

DROP TABLE IF EXISTS `users_auth`;

CREATE TABLE `users_auth` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `provider_id` enum('google.com','facebook.com','twitter.com','github.com','email1','email2') DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `access_level` enum('member','admin') NOT NULL DEFAULT 'member',
  `user_created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uid` varchar(255) DEFAULT NULL,
  `logged_in_time` bigint(20) DEFAULT NULL,
  `profile_uid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `users_auth` */

insert  into `users_auth`(`user_id`,`display_name`,`profile_img`,`email`,`provider_id`,`password`,`access_level`,`user_created_dt`,`uid`,`logged_in_time`,`profile_uid`) values (1,'Mango Here','https://scontent-sjc2-1.xx.fbcdn.net/v/t1.0-9/20229418_10155362155310977_5074678007866764600_n.jpg?oh=fde03124293477a1932df553d1384408&oe=5A08A081','manishkk74@gmail.com','email2','password','admin','2017-08-01 21:52:12',NULL,NULL,NULL),(3,'mango','http://google.com','abc1@mkgalaxy.com','email2','password','member','2017-07-25 21:59:27',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
