-- MySQL dump 10.13  Distrib 5.7.24, for Linux (i686)
--
-- Host: localhost    Database: clubman
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cm_auditrecords`
--

DROP TABLE IF EXISTS `cm_auditrecords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_auditrecords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userrole` varchar(100) DEFAULT NULL,
  `action` varchar(32) DEFAULT NULL,
  `model` varchar(32) DEFAULT NULL,
  `modelid` int(11) unsigned NOT NULL,
  `userip` varchar(64) DEFAULT NULL,
  `useragent` varchar(256) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=183 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_contactaddresses`
--

DROP TABLE IF EXISTS `cm_contactaddresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_contactaddresses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(64) DEFAULT NULL,
  `postcode` varchar(16) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `countrycode` char(2) DEFAULT NULL,
  `landline` varchar(40) DEFAULT NULL,
  `metadata` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_efforts`
--

DROP TABLE IF EXISTS `cm_efforts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_efforts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) unsigned DEFAULT NULL,
  `team_id` int(11) unsigned DEFAULT NULL,
  `season` char(10) DEFAULT NULL,
  `taskname` varchar(50) NOT NULL,
  `taskdate` date NOT NULL,
  `tasktime` time DEFAULT NULL,
  `taskduration` int(5) unsigned DEFAULT NULL,
  `status` char(15) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18000053 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_enquetes`
--

DROP TABLE IF EXISTS `cm_enquetes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_enquetes` (
  `id` binary(32) NOT NULL,
  `member_id` int(11) unsigned DEFAULT NULL,
  `teammember_id` int(11) unsigned DEFAULT NULL,
  `team_id` int(11) unsigned DEFAULT NULL,
  `team_prio` int(2) unsigned DEFAULT NULL,
  `season` char(10) DEFAULT NULL,
  `algemeen_seizoen` varchar(10) DEFAULT '',
  `algemeen_naam` varchar(50) DEFAULT '',
  `algemeen_ploeg` varchar(30) DEFAULT '',
  `algemeen_ploeg_tevreden` char(16) DEFAULT '',
  `algemeen_score_huidige_ploegsfeer` char(2) DEFAULT '',
  `algemeen_score_huidige_trainer` char(2) DEFAULT '',
  `algemeen_dubbelploeg` varchar(30) DEFAULT '',
  `algemeen_volgendseizoen` char(10) DEFAULT '',
  `algemeen_volgendseizoenploeg` varchar(30) DEFAULT '',
  `algemeen_volgendseizoendubbelploeg` varchar(30) DEFAULT '',
  `algemeen_positie_keuze_1` char(16) DEFAULT '',
  `algemeen_positie_keuze_2` char(16) DEFAULT '',
  `training_aantal` int(2) unsigned DEFAULT '0',
  `training_ma19002100` char(10) DEFAULT '',
  `training_di20002200` char(10) DEFAULT '',
  `training_wo16001700` char(10) DEFAULT '',
  `training_wo17001830` char(10) DEFAULT '',
  `training_wo18302000` char(10) DEFAULT '',
  `training_do19302130` char(10) DEFAULT '',
  `training_do20002200` char(10) DEFAULT '',
  `training_vr17301900` char(10) DEFAULT '',
  `training_vr17451915` char(10) DEFAULT '',
  `training_vr19002100` char(10) DEFAULT '',
  `training_vr19152100` char(10) DEFAULT '',
  `training_za09001000` char(10) DEFAULT NULL,
  `training_verplaatsing` char(24) DEFAULT '',
  `locatie_elders` char(15) DEFAULT NULL,
  `wedstrijd_aantal` char(10) DEFAULT '',
  `engagement_steun_ouders` char(10) DEFAULT '',
  `engagement_andere_activiteiten` varchar(100) DEFAULT NULL,
  `engagement_prio_volleybal` char(10) DEFAULT '',
  `studies_mindertrainen` tinyint(1) DEFAULT '0',
  `studies_opkot` tinyint(1) DEFAULT '0',
  `studies_geenwedstrijden` tinyint(1) DEFAULT '0',
  `studies_stage` tinyint(1) DEFAULT '0',
  `studies_andere` text,
  `allerjongsten_training` char(10) DEFAULT '',
  `mail_ik` varchar(50) DEFAULT '',
  `mail_ikfrequentie` char(10) DEFAULT '',
  `mail_mama` varchar(50) DEFAULT '',
  `mail_mamafrequentie` char(10) DEFAULT '',
  `mail_papa` varchar(50) DEFAULT '',
  `mail_papafrequentie` char(10) DEFAULT '',
  `begeleiding_pvmama` char(10) DEFAULT '',
  `begeleiding_pvpapa` char(10) DEFAULT '',
  `begeleiding_pvandere` varchar(50) DEFAULT '',
  `organisatie_naam` varchar(50) DEFAULT '',
  `organisatie_taak` varchar(30) DEFAULT '',
  `volley_toekomst` varchar(100) DEFAULT NULL,
  `volley_leuk` text,
  `diversen_lidgeld_hoog` char(10) DEFAULT '',
  `diversen_tekst` text,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_events`
--

DROP TABLE IF EXISTS `cm_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_events` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `season` varchar(10) DEFAULT NULL,
  `name` varchar(60) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `category` varchar(20) NOT NULL,
  `title` varchar(128) NOT NULL,
  `subtitle` varchar(128) NOT NULL,
  `content` mediumtext,
  `image_url` varchar(255) DEFAULT NULL,
  `target_public` varchar(20) NOT NULL,
  `event_date_start` date DEFAULT NULL,
  `event_date_end` date DEFAULT NULL,
  `event_time_start` time DEFAULT NULL,
  `event_time_end` time DEFAULT NULL,
  `event_location` varchar(128) NOT NULL,
  `event_price` char(64) DEFAULT NULL,
  `publish_date_start` date DEFAULT NULL,
  `publish_date_end` date DEFAULT NULL,
  `subscribe_able` tinyint(1) DEFAULT '0',
  `subscribe_date_start` date DEFAULT NULL,
  `subscribe_date_end` date DEFAULT NULL,
  `subscribe_max` int(11) unsigned DEFAULT '0',
  `subscribe_extra` mediumtext,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_games`
--

DROP TABLE IF EXISTS `cm_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_games` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(11) unsigned DEFAULT NULL,
  `opponent_club_id` int(11) unsigned DEFAULT NULL,
  `season` char(10) DEFAULT NULL,
  `team_code` char(10) DEFAULT NULL,
  `game_code` char(10) DEFAULT NULL,
  `home_game` tinyint(1) DEFAULT NULL,
  `period` char(2) DEFAULT NULL,
  `game_number` char(24) DEFAULT NULL,
  `game_date` date DEFAULT NULL,
  `game_time` time DEFAULT NULL,
  `game_home` varchar(40) DEFAULT NULL,
  `game_away` varchar(40) DEFAULT NULL,
  `game_coach_id` int(11) unsigned DEFAULT NULL,
  `game_hall` varchar(100) DEFAULT NULL,
  `game_home_or_away` char(4) DEFAULT NULL,
  `game_referee` varchar(90) DEFAULT NULL,
  `game_marker` varchar(90) DEFAULT NULL,
  `game_scoreboard` varchar(90) DEFAULT NULL,
  `game_change` varchar(30) DEFAULT NULL,
  `game_t123` int(1) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18000211 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_gamesteammembers`
--

DROP TABLE IF EXISTS `cm_gamesteammembers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_gamesteammembers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `teammember_id` int(11) unsigned DEFAULT NULL,
  `game_id` int(11) unsigned DEFAULT NULL,
  `season` char(10) DEFAULT NULL,
  `status` char(32) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18000044 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_mailings`
--

DROP TABLE IF EXISTS `cm_mailings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_mailings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `season` char(10) DEFAULT NULL,
  `category` char(32) NOT NULL DEFAULT '',
  `name` varchar(50) DEFAULT NULL,
  `fromaddress` varchar(64) DEFAULT NULL,
  `body` text,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_mails`
--

DROP TABLE IF EXISTS `cm_mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `season` char(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `mailing_id` int(11) NOT NULL,
  `mailsubject` varchar(150) DEFAULT NULL,
  `mailfrom` varchar(50) DEFAULT NULL,
  `mailto` varchar(64) DEFAULT NULL,
  `mailcc` varchar(128) DEFAULT NULL,
  `mailbcc` varchar(64) DEFAULT NULL,
  `mailbody` text,
  `maillinkurl` varchar(50) DEFAULT NULL,
  `maillinkuid` varchar(48) DEFAULT NULL,
  `mailsent` datetime DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17000229 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_members`
--

DROP TABLE IF EXISTS `cm_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_members` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `picture_id` int(11) unsigned DEFAULT NULL,
  `picturelicense_id` int(11) unsigned DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `licensenumber` varchar(20) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `birthday_public` tinyint(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` varchar(40) DEFAULT NULL,
  `address` varchar(40) DEFAULT NULL,
  `postcode` varchar(6) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `nationalnumber` char(11) DEFAULT NULL,
  `mom_lastname` varchar(50) DEFAULT NULL,
  `mom_firstname` varchar(40) DEFAULT NULL,
  `mom_email` varchar(255) DEFAULT NULL,
  `mom_tel` varchar(40) DEFAULT NULL,
  `mom_address` varchar(40) DEFAULT NULL,
  `mom_postcode` varchar(6) DEFAULT NULL,
  `mom_city` varchar(40) DEFAULT NULL,
  `dad_lastname` varchar(50) DEFAULT NULL,
  `dad_firstname` varchar(40) DEFAULT NULL,
  `dad_email` varchar(255) DEFAULT NULL,
  `dad_tel` varchar(40) DEFAULT NULL,
  `dad_address` varchar(40) DEFAULT NULL,
  `dad_postcode` varchar(6) DEFAULT NULL,
  `dad_city` varchar(40) DEFAULT NULL,
  `membershipfee` int(11) unsigned DEFAULT NULL,
  `membershipfee_discount` int(11) unsigned DEFAULT NULL,
  `membership_advancepaid` date DEFAULT NULL,
  `membership_balancepaid` date DEFAULT NULL,
  `camp` tinyint(1) DEFAULT '0',
  `campfee` int(11) unsigned DEFAULT NULL,
  `camp_advance` date DEFAULT NULL,
  `camp_balance` date DEFAULT NULL,
  `bank_account` varchar(48) DEFAULT '',
  `car_type` varchar(32) DEFAULT '',
  `car_license` varchar(16) DEFAULT '',
  `active` tinyint(1) DEFAULT '1',
  `nickname` varchar(40) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=566 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_memberships`
--

DROP TABLE IF EXISTS `cm_memberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_memberships` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(11) unsigned DEFAULT NULL,
  `picturelicense_id` int(11) unsigned DEFAULT NULL,
  `licensenumber` varchar(20) NOT NULL,
  `membershipfee` int(11) unsigned DEFAULT NULL,
  `membershipfee_discount` int(11) unsigned DEFAULT NULL,
  `membership_advancepaid` date DEFAULT NULL,
  `membership_balancepaid` date DEFAULT NULL,
  `camp` tinyint(1) DEFAULT '0',
  `campfee` int(11) unsigned DEFAULT NULL,
  `camp_advance` date DEFAULT NULL,
  `camp_balance` date DEFAULT NULL,
  `car_type` varchar(32) DEFAULT '',
  `car_license` varchar(16) DEFAULT '',
  `active` tinyint(1) DEFAULT '1',
  `nickname` varchar(40) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_meterings`
--

DROP TABLE IF EXISTS `cm_meterings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_meterings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) unsigned DEFAULT NULL,
  `season` char(10) DEFAULT NULL,
  `metering_date` date DEFAULT NULL,
  `length` int(3) unsigned DEFAULT NULL,
  `weight` int(6) unsigned DEFAULT NULL,
  `attack_height` int(3) unsigned DEFAULT NULL,
  `block_height` int(3) unsigned DEFAULT NULL,
  `suicide` int(3) unsigned DEFAULT NULL,
  `score_presence` int(2) unsigned DEFAULT NULL,
  `score_effort` int(2) unsigned DEFAULT NULL,
  `score_ambition` int(2) unsigned DEFAULT NULL,
  `score_overhand` int(2) unsigned DEFAULT NULL,
  `score_underhand` int(2) unsigned DEFAULT NULL,
  `score_stroke` int(2) unsigned DEFAULT NULL,
  `score_feetwork` int(2) unsigned DEFAULT NULL,
  `score_runup` int(2) unsigned DEFAULT NULL,
  `score_serve` int(2) unsigned DEFAULT NULL,
  `score_pass` int(2) unsigned DEFAULT NULL,
  `score_set` int(2) unsigned DEFAULT NULL,
  `score_attack` int(2) unsigned DEFAULT NULL,
  `score_block` int(2) unsigned DEFAULT NULL,
  `score_defense` int(2) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_migratemembers`
--

DROP TABLE IF EXISTS `cm_migratemembers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_migratemembers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(11) unsigned DEFAULT NULL,
  `picture_id` int(11) unsigned DEFAULT NULL,
  `picturelicense_id` int(11) unsigned DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `licensenumber` varchar(20) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `birthday_public` tinyint(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` varchar(40) DEFAULT NULL,
  `address` varchar(40) DEFAULT NULL,
  `postcode` varchar(6) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `nationalnumber` char(11) DEFAULT NULL,
  `mom_lastname` varchar(50) DEFAULT NULL,
  `mom_firstname` varchar(40) DEFAULT NULL,
  `mom_email` varchar(255) DEFAULT NULL,
  `mom_tel` varchar(40) DEFAULT NULL,
  `mom_address` varchar(40) DEFAULT NULL,
  `mom_postcode` varchar(6) DEFAULT NULL,
  `mom_city` varchar(40) DEFAULT NULL,
  `dad_lastname` varchar(50) DEFAULT NULL,
  `dad_firstname` varchar(40) DEFAULT NULL,
  `dad_email` varchar(255) DEFAULT NULL,
  `dad_tel` varchar(40) DEFAULT NULL,
  `dad_address` varchar(40) DEFAULT NULL,
  `dad_postcode` varchar(6) DEFAULT NULL,
  `dad_city` varchar(40) DEFAULT NULL,
  `membershipfee` int(11) unsigned DEFAULT NULL,
  `membershipfee_discount` int(11) unsigned DEFAULT NULL,
  `membership_advancepaid` date DEFAULT NULL,
  `membership_balancepaid` date DEFAULT NULL,
  `camp` tinyint(1) DEFAULT '0',
  `campfee` int(11) unsigned DEFAULT NULL,
  `camp_advance` date DEFAULT NULL,
  `camp_balance` date DEFAULT NULL,
  `bank_account` varchar(48) DEFAULT '',
  `car_type` varchar(32) DEFAULT '',
  `car_license` varchar(16) DEFAULT '',
  `active` tinyint(1) DEFAULT '1',
  `nickname` varchar(40) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_newsitems`
--

DROP TABLE IF EXISTS `cm_newsitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_newsitems` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `season` varchar(10) DEFAULT NULL,
  `category` varchar(60) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `title` varchar(60) DEFAULT NULL,
  `subtitle` varchar(60) DEFAULT NULL,
  `content` mediumtext,
  `itemdate` datetime DEFAULT NULL,
  `rellink` varchar(128) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `activate` datetime DEFAULT NULL,
  `expire` datetime DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `image_pos` char(10) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_partywallitems`
--

DROP TABLE IF EXISTS `cm_partywallitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_partywallitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `mimetype` varchar(128) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `sourceip` varchar(64) DEFAULT NULL,
  `sourcemanufacturer` varchar(50) DEFAULT NULL,
  `sourceproduct` varchar(50) DEFAULT NULL,
  `sourcename` varchar(50) DEFAULT NULL,
  `sourceagent` varchar(256) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2017000197 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_personparents`
--

DROP TABLE IF EXISTS `cm_personparents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_personparents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(11) unsigned DEFAULT NULL,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `metadata` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_persons`
--

DROP TABLE IF EXISTS `cm_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_persons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `picture_id` int(11) unsigned DEFAULT NULL,
  `contactaddress_id` int(11) unsigned DEFAULT NULL,
  `uniquenumber` char(255) DEFAULT NULL,
  `lastname` varchar(64) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `gender` varchar(16) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthday_public` tinyint(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `bankaccount` varchar(48) DEFAULT NULL,
  `nickname` varchar(64) DEFAULT NULL,
  `metadata` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_pictures`
--

DROP TABLE IF EXISTS `cm_pictures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `season` char(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `category` char(64) DEFAULT NULL,
  `description` mediumtext NOT NULL,
  `location` varchar(255) NOT NULL,
  `stamp` datetime DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `uploader` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18000157 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_subscriptions`
--

DROP TABLE IF EXISTS `cm_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_subscriptions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) unsigned DEFAULT NULL,
  `season` varchar(10) DEFAULT NULL,
  `substitle` varchar(64) DEFAULT NULL,
  `subshash` binary(32) NOT NULL,
  `subsname` varchar(64) DEFAULT NULL,
  `subsemail` varchar(255) DEFAULT NULL,
  `extra` mediumtext,
  `confirmed` tinyint(1) DEFAULT '0',
  `confirmed_stamp` datetime DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=208 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_teammembers`
--

DROP TABLE IF EXISTS `cm_teammembers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_teammembers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(11) unsigned DEFAULT NULL,
  `member_id` int(11) unsigned DEFAULT NULL,
  `season` char(10) DEFAULT NULL,
  `teamfunction` varchar(50) DEFAULT NULL,
  `teampriority` int(2) DEFAULT '1',
  `shirtnumber` int(3) DEFAULT '0',
  `copy_member_name` varchar(80) DEFAULT NULL,
  `copy_member_license` char(10) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18000159 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_teams`
--

DROP TABLE IF EXISTS `cm_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_teams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `club_id` int(11) unsigned DEFAULT NULL,
  `picture_id` int(11) unsigned DEFAULT NULL,
  `season` varchar(10) DEFAULT NULL,
  `period` varchar(2) DEFAULT NULL,
  `teamtype` varchar(20) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `number` int(2) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `shortname` varchar(15) DEFAULT NULL,
  `mininame` varchar(5) DEFAULT NULL,
  `series` varchar(20) DEFAULT NULL,
  `competition` varchar(20) DEFAULT NULL,
  `homegame` varchar(32) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_order` int(3) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18000014 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_trainingmoments`
--

DROP TABLE IF EXISTS `cm_trainingmoments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_trainingmoments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `weekday` tinyint(4) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `location` varchar(64) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_trainingmomentsteammembers`
--

DROP TABLE IF EXISTS `cm_trainingmomentsteammembers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_trainingmomentsteammembers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `trainingmoment_id` int(11) unsigned DEFAULT NULL,
  `teammember_id` int(11) unsigned DEFAULT NULL,
  `season` char(10) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_trainingmomentsteams`
--

DROP TABLE IF EXISTS `cm_trainingmomentsteams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_trainingmomentsteams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `trainingmoment_id` int(11) unsigned DEFAULT NULL,
  `team_id` int(11) unsigned DEFAULT NULL,
  `season` char(10) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16000027 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_trainings`
--

DROP TABLE IF EXISTS `cm_trainings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_trainings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `trainingmoment_id` int(11) unsigned DEFAULT NULL,
  `team_id` int(11) unsigned DEFAULT NULL,
  `season` char(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `location` varchar(64) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_id` (`team_id`,`start_date`,`start_time`)
) ENGINE=MyISAM AUTO_INCREMENT=18001041 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_trainingsteammembers`
--

DROP TABLE IF EXISTS `cm_trainingsteammembers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_trainingsteammembers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `teammember_id` int(11) unsigned DEFAULT NULL,
  `training_id` int(11) unsigned DEFAULT NULL,
  `season` char(10) DEFAULT NULL,
  `status` char(32) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18000402 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_uploads`
--

DROP TABLE IF EXISTS `cm_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `season` char(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `category` char(64) DEFAULT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `stamp` datetime DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `uploader` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18000013 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cm_users`
--

DROP TABLE IF EXISTS `cm_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cm_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  `role` varchar(255) NOT NULL,
  `resetkey` binary(32) DEFAULT NULL,
  `reset` datetime DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-20 20:00:17
