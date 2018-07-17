/*
SQLyog Community v12.5.0 (64 bit)
MySQL - 5.6.38 : Database - booking_calendar
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `nelsonc_carshare`;

/*Table structure for table `phpc_announcementdates` */

DROP TABLE IF EXISTS `phpc_announcementdates`;

CREATE TABLE `phpc_announcementdates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `announcement_id` int(11) NOT NULL DEFAULT '0',
  `startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `announcement_id` (`announcement_id`),
  KEY `startdate` (`startdate`),
  KEY `enddate` (`enddate`)
) ENGINE=MyISAM AUTO_INCREMENT=514 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_announcementdates` */

/*Table structure for table `phpc_announcements` */

DROP TABLE IF EXISTS `phpc_announcements`;

CREATE TABLE `phpc_announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` longblob NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `display_on_day` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=521 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_announcements` */

/*Table structure for table `phpc_announcements_bookables` */

DROP TABLE IF EXISTS `phpc_announcements_bookables`;

CREATE TABLE `phpc_announcements_bookables` (
  `announcement_id` int(11) NOT NULL DEFAULT '0',
  `bookable_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`announcement_id`,`bookable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `phpc_announcements_bookables` */

/*Table structure for table `phpc_announcements_calendars` */

DROP TABLE IF EXISTS `phpc_announcements_calendars`;

CREATE TABLE `phpc_announcements_calendars` (
  `announcement_id` int(11) NOT NULL DEFAULT '0',
  `calendar_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`announcement_id`,`calendar_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `phpc_announcements_calendars` */

/*Table structure for table `phpc_billings` */

DROP TABLE IF EXISTS `phpc_billings`;

CREATE TABLE `phpc_billings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(10) unsigned NOT NULL DEFAULT '0',
  `month` int(10) unsigned NOT NULL DEFAULT '0',
  `gas_surcharge_per_km_rate` float NOT NULL DEFAULT '0',
  `member_plan_low_rate` float NOT NULL DEFAULT '0',
  `member_plan_med_rate` float NOT NULL DEFAULT '0',
  `member_plan_high_rate` float NOT NULL DEFAULT '0',
  `member_plan_organization_rate` float DEFAULT NULL,
  `member_plan_low_cutoff` int(11) NOT NULL DEFAULT '0',
  `member_plan_med_cutoff` int(11) NOT NULL DEFAULT '0',
  `carbon_offset_per_km_rate` float NOT NULL DEFAULT '0',
  `self_insurance_per_km_rate` float NOT NULL DEFAULT '0',
  `pst` float NOT NULL DEFAULT '0',
  `gst` float NOT NULL DEFAULT '0',
  `rental_tax_per_day` float DEFAULT NULL,
  `dont_charge_interest_below` float NOT NULL DEFAULT '0',
  `late_payment_interest` float NOT NULL DEFAULT '0',
  `long_time_member_discount_percent` float NOT NULL DEFAULT '0',
  `long_time_member_discount_max` float NOT NULL DEFAULT '0',
  `invoice_num_to_start_at` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_due_date` date DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `long_term_discount_year` int(11) NOT NULL DEFAULT '0',
  `acnt_new_code_pst` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_code_gst` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_rental_tax` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_gas_surcharge` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_self_insurance` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_carbon_offset` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_member_plan_low` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_member_plan_med` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_member_plan_high` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_member_plan_organization` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_accounts_receivable` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_long_term_member_discount` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_interest_charged` int(11) unsigned NOT NULL DEFAULT '0',
  `day_rate_start_hour` int(11) NOT NULL DEFAULT '0',
  `day_rate_end_hour` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `year` (`year`,`month`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_billings` */

/*Table structure for table `phpc_bookables` */

DROP TABLE IF EXISTS `phpc_bookables`;

CREATE TABLE `phpc_bookables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `vehicle_id` int(10) unsigned NOT NULL DEFAULT '0',
  `location_id` int(11) DEFAULT NULL,
  `color` varchar(50) NOT NULL DEFAULT '',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `hourly_rate_low` float DEFAULT '0.55',
  `hourly_rate_high` float DEFAULT '1.5',
  `rate_cutoff` float DEFAULT '8',
  `is_flat_daily_rate` tinyint(1) DEFAULT NULL,
  `daily_rate_low` float DEFAULT '0',
  `daily_rate` float DEFAULT NULL,
  `km_rate_low` float DEFAULT NULL,
  `km_rate_med` float DEFAULT NULL,
  `km_rate_high` float DEFAULT NULL,
  `charge_bc_rental_tax` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`,`vehicle_id`),
  KEY `vehicle_id` (`vehicle_id`),
  KEY `location_id` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_bookables` */

/*Table structure for table `phpc_bookables_calendars` */

DROP TABLE IF EXISTS `phpc_bookables_calendars`;

CREATE TABLE `phpc_bookables_calendars` (
  `bookable_id` int(10) unsigned NOT NULL DEFAULT '0',
  `calendar_id` int(11) NOT NULL DEFAULT '0',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `bookableid` (`bookable_id`,`id`,`calendar_id`),
  KEY `calendar_id` (`calendar_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1628 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_bookables_calendars` */

/*Table structure for table `phpc_calendars` */

DROP TABLE IF EXISTS `phpc_calendars`;

CREATE TABLE `phpc_calendars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar` varchar(32) NOT NULL DEFAULT '',
  `hours_24` tinyint(4) NOT NULL DEFAULT '0',
  `start_monday` tinyint(4) NOT NULL DEFAULT '0',
  `translate` tinyint(4) NOT NULL DEFAULT '0',
  `anon_permission` tinyint(4) NOT NULL DEFAULT '0',
  `subject_max` smallint(6) NOT NULL DEFAULT '32',
  `contact_name` varchar(255) NOT NULL DEFAULT '',
  `contact_email` varchar(255) NOT NULL DEFAULT '',
  `calendar_title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `calendar_file_name` varchar(255) NOT NULL DEFAULT '',
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `calendar` (`calendar`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_calendars` */

insert  into `phpc_calendars`(`id`,`calendar`,`hours_24`,`start_monday`,`translate`,`anon_permission`,`subject_max`,`contact_name`,`contact_email`,`calendar_title`,`url`,`calendar_file_name`,`latitude`,`longitude`) values 
(1,'0',0,0,1,1,32,'','','Nelson','','nelson.php',49.4958,-117.2952);

/*Table structure for table `phpc_chartofaccounts` */

DROP TABLE IF EXISTS `phpc_chartofaccounts`;

CREATE TABLE `phpc_chartofaccounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(255) NOT NULL DEFAULT '',
  `type` int(4) unsigned NOT NULL DEFAULT '1',
  `refnum` int(32) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `show_in_lists` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1086 DEFAULT CHARSET=latin1;

INSERT INTO `phpc_chartofaccounts` (`id`, `account`, `type`, `refnum`, `show_in_lists`) VALUES (3,'UNDEFINED',0,0,1);

/*Data for the table `phpc_chartofaccounts` */

/*Table structure for table `phpc_checkpoints` */

DROP TABLE IF EXISTS `phpc_checkpoints`;

CREATE TABLE `phpc_checkpoints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkpoint` varchar(24) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_checkpoints` */

insert  into `phpc_checkpoints`(`id`,`checkpoint`) values 
(1,'EVENT_FORM'),
(2,'EVENT_DELETE'),
(3,'EVENT_FORM.SET_PAST_TIME'),
(4,'DISPLAY'),
(5,'LIST_USERS'),
(6,'VIEW_ALL_INVOICES'),
(7,'ADMINISTRATION'),
(8,'DISPLAY_ADMIN_LINK'),
(9,'ADMINISTER_BOOKINGS'),
(10,'DISPLAY_ADMIN_BOOKINGS_L');

/*Table structure for table `phpc_couldnt_book_vehicle` */

DROP TABLE IF EXISTS `phpc_couldnt_book_vehicle`;

CREATE TABLE `phpc_couldnt_book_vehicle` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `bookable` int(12) NOT NULL DEFAULT '0',
  `comment` longblob,
  `creationtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=317 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_couldnt_book_vehicle` */

/*Table structure for table `phpc_event_log` */

DROP TABLE IF EXISTS `phpc_event_log`;

CREATE TABLE `phpc_event_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) DEFAULT NULL,
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `note` blob,
  `bookableobject` int(11) DEFAULT NULL,
  `canceled` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modifiedByUid` int(11) DEFAULT NULL,
  `bookingIsForUid` int(11) DEFAULT NULL,
  `amntTagged` varchar(100) DEFAULT NULL,
  `operation` int(11) DEFAULT NULL COMMENT '1=create,2=mod,3=cancel,4=cancel in window',
  PRIMARY KEY (`id`),
  KEY `eventid` (`eventid`),
  KEY `created` (`created`)
) ENGINE=MyISAM AUTO_INCREMENT=190711 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_event_log` */

insert  into `phpc_event_log`(`id`,`eventid`,`starttime`,`endtime`,`subject`,`note`,`bookableobject`,`canceled`,`created`,`modifiedByUid`,`bookingIsForUid`,`amntTagged`,`operation`) values 
(190708,-1,'2018-01-14 11:44:33','2018-01-14 11:44:33','','',-1,0,'2018-01-14 11:44:33',65,-1,'',8),
(190709,-1,'2018-01-14 11:46:11','2018-01-14 11:46:11','','',-1,0,'2018-01-14 11:46:11',65,-1,'',8),
(190710,-1,'2018-01-14 11:54:04','2018-01-14 11:54:04','','',-1,0,'2018-01-14 11:54:04',65,-1,'',8);

/*Table structure for table `phpc_events` */

DROP TABLE IF EXISTS `phpc_events`;

CREATE TABLE `phpc_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `eventtype` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `description` longblob,
  `bookableobject` int(10) unsigned NOT NULL DEFAULT '0',
  `vehicle_used_id` int(11) NOT NULL DEFAULT '0' COMMENT 'vehicle that user used, may be different from what was booked',
  `canceled` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0=NORMAL,1=CANCELED,2=CANCELED_WITHIN_TWO_DAYS',
  `startkm` int(11) unsigned DEFAULT NULL,
  `endkm` int(11) unsigned DEFAULT NULL,
  `expense_gas` float DEFAULT '0',
  `expense_admin` float DEFAULT '0',
  `expense_repair` float DEFAULT '0',
  `expense_insurance` float DEFAULT '0',
  `expense_misc_1` float DEFAULT '0',
  `expense_misc_2` float DEFAULT '0',
  `expense_misc_3` float DEFAULT '0',
  `expense_misc_4` float DEFAULT '0',
  `admin_ignore_this_booking` tinyint(1) DEFAULT '0',
  `admin_ignore_km_hours` tinyint(1) DEFAULT '0',
  `admin_comment` varchar(30) DEFAULT NULL,
  `canceledtime` datetime DEFAULT NULL,
  `creationtime` timestamp NULL DEFAULT NULL,
  `modifytime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookableobject` (`bookableobject`),
  KEY `starttime` (`starttime`),
  KEY `endtime` (`endtime`),
  KEY `vehicle_used_id` (`vehicle_used_id`),
  KEY `canceled` (`canceled`),
  KEY `eventtype` (`eventtype`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=64597 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_events` */

/*Table structure for table `phpc_groups` */

DROP TABLE IF EXISTS `phpc_groups`;

CREATE TABLE `phpc_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0',
  `grp_displayname` varchar(100) NOT NULL DEFAULT '',
  `grp_accountingname` varchar(41) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(100) NOT NULL DEFAULT '',
  `address1` varchar(200) NOT NULL DEFAULT '',
  `address2` varchar(200) NOT NULL DEFAULT '',
  `city` varchar(100) NOT NULL DEFAULT '',
  `province` varchar(100) NOT NULL DEFAULT '',
  `postalcode` varchar(15) NOT NULL DEFAULT '',
  `disabled` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `activated` datetime DEFAULT NULL,
  `acnt_code_group_customer` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Quickbooks account code',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_groups` */

insert  into `phpc_groups`(`id`,`type`,`grp_displayname`,`grp_accountingname`,`email`,`phone`,`address1`,`address2`,`city`,`province`,`postalcode`,`disabled`,`created`,`modified`,`activated`,`acnt_code_group_customer`) values 
(1,1,'INDIVIDUAL_DO_NOT_DELETE','','','','','','','','',0,NULL,NULL,NULL,0);

/*Table structure for table `phpc_grouptypes` */

DROP TABLE IF EXISTS `phpc_grouptypes`;

CREATE TABLE `phpc_grouptypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_grouptypes` */

insert  into `phpc_grouptypes`(`id`,`type`) values 
(1,'INDIVIDUAL'),
(2,'ORGANIZATION');

/*Table structure for table `phpc_invoicables` */

DROP TABLE IF EXISTS `phpc_invoicables`;

CREATE TABLE `phpc_invoicables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `force_user_member_plan` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`user_id`),
  UNIQUE KEY `group_id` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=605 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_invoicables` */

/*Table structure for table `phpc_invoiceextraitems` */

DROP TABLE IF EXISTS `phpc_invoiceextraitems`;

CREATE TABLE `phpc_invoiceextraitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `billing_id` int(11) NOT NULL DEFAULT '0',
  `user_id_depricated` int(11) unsigned DEFAULT NULL,
  `item` varchar(30) NOT NULL DEFAULT '',
  `taxcode` int(11) NOT NULL DEFAULT '0' COMMENT '0=PST,1=GST,2=PST/GST,3=EXEMPT',
  `ammount` float NOT NULL DEFAULT '0',
  `comment` varchar(30) DEFAULT NULL,
  `cost_per_unit` float DEFAULT NULL,
  `number_of_units` float DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `invoicable_id` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_code_new` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1907 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_invoiceextraitems` */

/*Table structure for table `phpc_invoices` */

DROP TABLE IF EXISTS `phpc_invoices`;

CREATE TABLE `phpc_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `billing_id` int(11) NOT NULL DEFAULT '0',
  `invoice_num` int(11) NOT NULL DEFAULT '-1',
  `previous_owing` float NOT NULL DEFAULT '0',
  `payment_made` float NOT NULL DEFAULT '0',
  `inv_total` float NOT NULL DEFAULT '0',
  `amt_owing` float NOT NULL DEFAULT '0',
  `user_id_depricated` int(11) unsigned DEFAULT NULL,
  `file_stem` varchar(255) NOT NULL DEFAULT '',
  `invoicable_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21728 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_invoices` */

/*Table structure for table `phpc_locations` */

DROP TABLE IF EXISTS `phpc_locations`;

CREATE TABLE `phpc_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `address1` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `comment` blob,
  `URL` varchar(255) DEFAULT NULL,
  `GPS_coord_x` varchar(20) DEFAULT NULL,
  `GPS_coord_y` varchar(20) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_locations` */

/*Table structure for table `phpc_permissions` */

DROP TABLE IF EXISTS `phpc_permissions`;

CREATE TABLE `phpc_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission` varchar(24) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_permissions` */

insert  into `phpc_permissions`(`id`,`permission`) values 
(1,'WORLD'),
(2,'NAMED_USER'),
(3,'ADMIN_USER'),
(4,'BOOK_KEEPER');

/*Table structure for table `phpc_permissions_checkpoints` */

DROP TABLE IF EXISTS `phpc_permissions_checkpoints`;

CREATE TABLE `phpc_permissions_checkpoints` (
  `permission_id` int(11) NOT NULL DEFAULT '0',
  `checkpoint_id` int(11) NOT NULL DEFAULT '0',
  `perm` varchar(6) NOT NULL DEFAULT 'ALLOW',
  PRIMARY KEY (`permission_id`,`checkpoint_id`),
  KEY `permission_id` (`permission_id`),
  KEY `checkpoint_id` (`checkpoint_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `phpc_permissions_checkpoints` */

insert  into `phpc_permissions_checkpoints`(`permission_id`,`checkpoint_id`,`perm`) values 
(1,1,'ALLOW'),
(1,2,'ALLOW'),
(3,3,'ALLOW'),
(1,4,'ALLOW'),
(1,5,'ALLOW'),
(3,6,'ALLOW'),
(3,7,'ALLOW'),
(3,8,'ALLOW'),
(3,9,'ALLOW'),
(4,9,'ALLOW'),
(4,10,'ALLOW'),
(4,3,'ALLOW');

/*Table structure for table `phpc_tagged_event_slots` */

DROP TABLE IF EXISTS `phpc_tagged_event_slots`;

CREATE TABLE `phpc_tagged_event_slots` (
  `eventid` int(11) DEFAULT '0',
  `slot` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bookableid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`slot`,`bookableid`),
  KEY `slot` (`slot`),
  KEY `bookableid` (`bookableid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `phpc_tagged_event_slots` */

/*Table structure for table `phpc_users` */

DROP TABLE IF EXISTS `phpc_users`;

CREATE TABLE `phpc_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `displayname` varchar(100) NOT NULL DEFAULT '',
  `username` varchar(100) NOT NULL DEFAULT '',
  `accountingname` varchar(41) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `permission` int(11) NOT NULL DEFAULT '0' COMMENT '0=normal, 1=admin',
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address1` varchar(200) DEFAULT NULL,
  `address2` varchar(200) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `postalcode` varchar(15) DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `activated` datetime DEFAULT NULL,
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastNoticeSentOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licenseExpiresOn` date NOT NULL DEFAULT '2000-01-01',
  `acnt_code_customer` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `displayname` (`displayname`),
  UNIQUE KEY `username` (`username`),
  KEY `group_id` (`group_id`),
  KEY `permission` (`permission`),
  KEY `disabled` (`disabled`)
) ENGINE=MyISAM AUTO_INCREMENT=737 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_users` */

insert  into `phpc_users`(`id`,`displayname`,`username`,`accountingname`,`password`,`permission`,`email`,`phone`,`address1`,`address2`,`city`,`province`,`postalcode`,`disabled`,`created`,`modified`,`activated`,`group_id`,`lastNoticeSentOn`,`licenseExpiresOn`,`acnt_code_customer`) values 
(65,'admin','admin','admin','14a7039cd84090598af6206db95be0d7',1,'myemail@gmail.com','','','','Nelson','BC','',0,'2008-01-12 11:20:33','2016-09-19 09:36:22','2001-08-01 00:00:00',1,'2010-07-04 00:04:00','2000-01-01',0);

/*Table structure for table `phpc_users_permissions` */

DROP TABLE IF EXISTS `phpc_users_permissions`;

CREATE TABLE `phpc_users_permissions` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `permission_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `user_id` (`user_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `phpc_users_permissions` */

insert  into `phpc_users_permissions`(`user_id`,`permission_id`) values 
(65,3);

/*Table structure for table `phpc_vehicles` */

DROP TABLE IF EXISTS `phpc_vehicles`;

CREATE TABLE `phpc_vehicles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `vehicle_number` varchar(50) DEFAULT NULL,
  `vehicle_type` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `acnt_new_code_gas` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_code_admin` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_code_repair` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_code_insurance` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_code_fines` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_code_misc_2` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_code_misc_3` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_code_misc_4` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_code_hours` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_code_blocked_time` int(11) unsigned NOT NULL DEFAULT '0',
  `acnt_new_code_km` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_vehicles` */

/*Table structure for table `phpc_vehicletypes` */

DROP TABLE IF EXISTS `phpc_vehicletypes`;

CREATE TABLE `phpc_vehicletypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL DEFAULT '',
  `imagefile` varchar(100) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `phpc_vehicletypes` */

insert  into `phpc_vehicletypes`(`id`,`type`,`imagefile`,`modified`,`created`) values 
(1,'van midsize','media/car-icons/van-mid.gif',NULL,NULL),
(2,'car midsize','media/car-icons/car-mid.gif',NULL,NULL),
(3,'truck midsize','media/car-icons/truck-mid.gif',NULL,NULL),
(4,'trailer','media/car-icons/trailer.gif',NULL,NULL),
(5,'accessory','media/car-icons/accessory.gif',NULL,NULL),
(6,'van economy','media/car-icons/van-eco.gif',NULL,NULL),
(7,'car economy','media/car-icons/car-eco.gif',NULL,NULL),
(8,'truck eco','media/car-icons/truck-eco.gif',NULL,NULL),
(9,'van large','media/car-icons/van-lrg.gif',NULL,NULL),
(10,'car large','media/car-icons/car-lrg.gif',NULL,NULL),
(11,'truck large','media/car-icons/truck-lrg.gif',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
