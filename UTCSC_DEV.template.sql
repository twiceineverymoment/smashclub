-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: utcsc_dtmp
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.26-MariaDB

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
-- Table structure for table `activity_feed`
--

DROP TABLE IF EXISTS `activity_feed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_feed` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_header_html` varchar(256) DEFAULT NULL,
  `activity_body_html` varchar(1024) DEFAULT NULL,
  `activity_owner_uuid` int(11) DEFAULT NULL,
  `activity_time` datetime DEFAULT NULL,
  `activity_type` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_feed`
--

LOCK TABLES `activity_feed` WRITE;
/*!40000 ALTER TABLE `activity_feed` DISABLE KEYS */;
INSERT INTO `activity_feed` VALUES (1,'Testing 1, 2, 3','This is a test announcement!',1,'2001-01-01 00:00:00',0);
/*!40000 ALTER TABLE `activity_feed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_schedule`
--

DROP TABLE IF EXISTS `event_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_schedule` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(128) NOT NULL DEFAULT 'Untitled Event',
  `event_time` datetime DEFAULT NULL,
  `event_description` varchar(1024) DEFAULT NULL,
  `event_type` int(11) NOT NULL DEFAULT '0' COMMENT '0=tournament, 1=competitive, 2=casual, 3=training, 4=other',
  `event_location` varchar(128) DEFAULT NULL,
  `event_signup_open` tinyint(4) DEFAULT '1' COMMENT '1=open, 0=closed, 2=no signups',
  `event_signup_access` int(11) DEFAULT '1' COMMENT '0=open to all, 1=members only, 2=invitation only',
  `event_owner_uuid` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_schedule`
--

LOCK TABLES `event_schedule` WRITE;
/*!40000 ALTER TABLE `event_schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_user_signup`
--

DROP TABLE IF EXISTS `event_user_signup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_user_signup` (
  `signup_id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` int(11) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `signup_name` varchar(64) DEFAULT NULL,
  `signup_contact` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`signup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_user_signup`
--

LOCK TABLES `event_user_signup` WRITE;
/*!40000 ALTER TABLE `event_user_signup` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_user_signup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_freeplay_queue`
--

DROP TABLE IF EXISTS `match_freeplay_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `match_freeplay_queue` (
  `match_id` int(11) NOT NULL AUTO_INCREMENT,
  `match_p1_uuid` int(11) NOT NULL,
  `match_p2_uuid` int(11) NOT NULL,
  `match_type` int(11) NOT NULL DEFAULT '0' COMMENT '0=matchmaking, 1=requested',
  PRIMARY KEY (`match_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_freeplay_queue`
--

LOCK TABLES `match_freeplay_queue` WRITE;
/*!40000 ALTER TABLE `match_freeplay_queue` DISABLE KEYS */;
INSERT INTO `match_freeplay_queue` VALUES (1,44,18,0);
/*!40000 ALTER TABLE `match_freeplay_queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poll_response`
--

DROP TABLE IF EXISTS `poll_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poll_response` (
  `response_id` int(11) NOT NULL AUTO_INCREMENT,
  `response_uuid` int(11) NOT NULL,
  `response_choice` int(11) DEFAULT NULL,
  `response_text` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`response_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poll_response`
--

LOCK TABLES `poll_response` WRITE;
/*!40000 ALTER TABLE `poll_response` DISABLE KEYS */;
/*!40000 ALTER TABLE `poll_response` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `records_tourney_match`
--

DROP TABLE IF EXISTS `records_tourney_match`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `records_tourney_match` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `match_order` int(11) NOT NULL,
  `match_p1_uuid` int(11) DEFAULT NULL,
  `match_p2_uuid` int(11) DEFAULT NULL,
  `match_p1_ref` varchar(4) DEFAULT NULL,
  `match_p2_ref` varchar(4) DEFAULT NULL,
  `match_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=not ready,\n1=pending,\n2=in progress,\n3=finished',
  `match_p1_score` int(11) NOT NULL DEFAULT '0',
  `match_p2_score` int(11) NOT NULL DEFAULT '0',
  `match_winner_uuid` int(11) DEFAULT NULL,
  `match_round_no` int(11) NOT NULL DEFAULT '0' COMMENT 'Represents the round/column in the bracket. 0 = finals',
  `match_bracket_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=winners, 1=losers',
  `match_is_final` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `records_tourney_match`
--

LOCK TABLES `records_tourney_match` WRITE;
/*!40000 ALTER TABLE `records_tourney_match` DISABLE KEYS */;
/*!40000 ALTER TABLE `records_tourney_match` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `records_tourney_round`
--

DROP TABLE IF EXISTS `records_tourney_round`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `records_tourney_round` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `round_bracket_level` int(11) NOT NULL,
  `round_no` int(11) NOT NULL,
  `round_name` varchar(64) NOT NULL DEFAULT 'Round',
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `records_tourney_round`
--

LOCK TABLES `records_tourney_round` WRITE;
/*!40000 ALTER TABLE `records_tourney_round` DISABLE KEYS */;
/*!40000 ALTER TABLE `records_tourney_round` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `records_user_ranking`
--

DROP TABLE IF EXISTS `records_user_ranking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `records_user_ranking` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_username` varchar(64) DEFAULT NULL,
  `record_rank_final` int(11) DEFAULT NULL,
  `record_rank_high` int(11) DEFAULT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `records_user_ranking`
--

LOCK TABLES `records_user_ranking` WRITE;
/*!40000 ALTER TABLE `records_user_ranking` DISABLE KEYS */;
/*!40000 ALTER TABLE `records_user_ranking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `season_data`
--

DROP TABLE IF EXISTS `season_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `season_data` (
  `season_id` int(11) NOT NULL AUTO_INCREMENT,
  `season_title` varchar(45) NOT NULL,
  `season_start_date` date NOT NULL,
  `season_game` int(11) DEFAULT NULL COMMENT '0=mixed, 1=N64, 2=Melee, 3=Brawl, 4=WiiU/3DS',
  PRIMARY KEY (`season_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `season_data`
--

LOCK TABLES `season_data` WRITE;
/*!40000 ALTER TABLE `season_data` DISABLE KEYS */;
INSERT INTO `season_data` VALUES (0,'Off-Season','0000-00-00',NULL),(1,'First Season','2000-01-01',0);
/*!40000 ALTER TABLE `season_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(64) NOT NULL,
  `setting_value` varchar(64000) DEFAULT NULL,
  `setting_description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (1,'GuestEnableFullMemberList','1','1=guests see all members in the directory, 0=guests only see organizers'),(2,'OrganizationName','SmashClub','The name of your organization'),(3,'CurrentSeasonNumber','1','Sequence number of the current season, MUST BE UNIQUE'),(4,'SpokespersonUUID','1','The spokesperson receives emails from the Contact Us page'),(5,'TourneyStatus','0','0=not active, 1=tournament (last match wins), 2=tournament (high score wins), 3=freeplay'),(6,'EnableContactPage','1','1=show Contact Us page to guests, 0=disable'),(7,'PollQuestion','Your Question Here','Question used in the active poll'),(8,'PollStatus','0','0=not active, 1=multiplechoice, 2=text'),(9,'PollResponses','','Poll response options. Each choice is separated by a vertical line.'),(10,'InitialPlacementMatches','3','The number of placement matches a member must complete before receiving a rating'),(11,'AboutPageSubtitle','Welcome to SmashClub!','Header of your homepage'),(12,'AboutPageBody','SmashClub 2.0 is a full club management site for your Super Smash Bros. club. Schedule events, post announcements and polls, run tournaments, record ranks, and much more.','Body text of your homepage, you can put HTML here to insert formatting or images'),(13,'EnableSelfRegister','1','1=anyone can register, 0=only staff can create new accounts'),(14,'EnableGuestBrowsing','1','1=guests can see directory, activity feed, and events pages'),(15,'EnableGuestProfileView','1','1=guests can view profiles'),(16,'EnableFreePlayScoring','1','1=scorekeepers can enter scores for free play matches'),(17,'ShowAlertMessage','0','1=enable the sitewide alert message below the banner, 0=hide'),(18,'AlertMessageText','Your Alert Message Here','Text of the alert message'),(19,'Version','2.5 PROTOTYPE','Current app version'),(20,'GeneralMailbox','smashclub@sample','Email address used by the site\'s mailer service'),(21,'MatchMakingEvent','','The event ID being used for the matchmaking pool. Set to 0 to pool from the entire roster'),(22,'EventIsRanked','0','0=casual (unranked), 1=competitive (ranked)'),(23,'TourneyBracketStyle','0','0=single elim, 1=double elim, 2=round robin, 3=swiss'),(24,'CompMatchRules','','Rules paragraph for the active tourney'),(25,'EnableDonatePortlet','0','1=show Donate portlet on homepage, 2=hide'),(26,'DonateURL','http://www.paypal.com/','URL of the Donate link on the homepage'),(27,'MatchMakingQueueFreeze','0','1=freeze the queue during an event so that no new matches can be created'),(28,'DefaultRankSortOrder','4','Default sort order for the leaderboard page'),(29,'ShowRankColumn','0','1=show the ordinal rank column on the leaderboard page'),(30,'SlideshowInterval','4000','Homepage slideshow interval in milliseconds');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tourney_grouping`
--

DROP TABLE IF EXISTS `tourney_grouping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tourney_grouping` (
  `pairing` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `uuid` int(11) NOT NULL,
  PRIMARY KEY (`pairing`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tourney_grouping`
--

LOCK TABLES `tourney_grouping` WRITE;
/*!40000 ALTER TABLE `tourney_grouping` DISABLE KEYS */;
/*!40000 ALTER TABLE `tourney_grouping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tourney_match_order`
--

DROP TABLE IF EXISTS `tourney_match_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tourney_match_order` (
  `match_id` int(11) NOT NULL AUTO_INCREMENT,
  `match_order` int(11) NOT NULL,
  `match_p1_uuid` int(11) DEFAULT NULL,
  `match_p2_uuid` int(11) DEFAULT NULL,
  `match_p1_ref` varchar(4) DEFAULT NULL,
  `match_p2_ref` varchar(4) DEFAULT NULL,
  `match_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=not ready,\n1=pending,\n2=in progress,\n3=finished',
  `match_p1_score` int(11) NOT NULL DEFAULT '0',
  `match_p2_score` int(11) NOT NULL DEFAULT '0',
  `match_winner_uuid` int(11) DEFAULT NULL,
  `match_round_no` int(11) NOT NULL DEFAULT '0' COMMENT 'Represents the round/column in the bracket. 0 = finals',
  `match_bracket_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=winners, 1=losers',
  `match_is_final` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`match_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tourney_match_order`
--

LOCK TABLES `tourney_match_order` WRITE;
/*!40000 ALTER TABLE `tourney_match_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `tourney_match_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tourney_round_list`
--

DROP TABLE IF EXISTS `tourney_round_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tourney_round_list` (
  `round_id` int(11) NOT NULL AUTO_INCREMENT,
  `round_bracket_level` int(11) NOT NULL,
  `round_no` int(11) NOT NULL,
  `round_name` varchar(64) NOT NULL DEFAULT 'Round',
  PRIMARY KEY (`round_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tourney_round_list`
--

LOCK TABLES `tourney_round_list` WRITE;
/*!40000 ALTER TABLE `tourney_round_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `tourney_round_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tourney_user_score`
--

DROP TABLE IF EXISTS `tourney_user_score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tourney_user_score` (
  `uuid` int(11) NOT NULL AUTO_INCREMENT,
  `user_score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tourney_user_score`
--

LOCK TABLES `tourney_user_score` WRITE;
/*!40000 ALTER TABLE `tourney_user_score` DISABLE KEYS */;
/*!40000 ALTER TABLE `tourney_user_score` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_authentication`
--

DROP TABLE IF EXISTS `user_authentication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_authentication` (
  `UUID` int(11) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(64) NOT NULL,
  `user_password_hash` varchar(512) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '1=member, 2=referee, 3=officer, 4=admin, 5=super admin',
  `user_locked` int(11) NOT NULL COMMENT '0=active, 1=password expired, 2=disabled, 3=banned',
  PRIMARY KEY (`UUID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_authentication`
--

LOCK TABLES `user_authentication` WRITE;
/*!40000 ALTER TABLE `user_authentication` DISABLE KEYS */;
INSERT INTO `user_authentication` VALUES (1,'SC_Webmaster_D','$2y$10$COecIrSA9VN1vteh14IsYOOozYFsOiNwpZ0J25nZxfIQ/M9ZSsTh6',5,0),(2,'M_Member1_D','$2y$10$iIKHARKygZTCk1tZWR13Je9MAhZZ6wZHBTjmEoFsUFx4Lo9Iax99u',1,0),(3,'S_Scorekeeper_D','$2y$10$r/xTdKDuppwGZylRfXKr9.u9qKlXWEjmduE1Lsj7UQlysoUjcD.GS',2,0),(4,'O_Officer_D','$2y$10$JlTN9VJkjYDTNIkjb/h62.aSeL25wAGh7TrbcbA4xZXWmM4lHuTie',3,0),(5,'A_Admin_D','$2y$10$eeiQ4pCWvm5lEXFJIIoy2OWyOFH94o2R.Y06nEE2K9o9DUf0OAdLC',4,0),(6,'M_Member2_D','$2y$10$KOKp3EIOEix3vQJqvEJtZOs1Mx0g5g7SRWZP8s1HpsDcIUt5PYvbW',1,0),(7,'M_Member3_D','$2y$10$K2lwlxEVH7DGI9atnKIG4uqjVWe33xr3xhGF7DOUIb1ZjeYEqo6Yq',1,0),(8,'M_Member4_D','$2y$10$BQnDb4deuthDOfem8agM4uicvZwfql8yY6A/cA1B5z74g2Kj3/nyG',1,0),(9,'M_Member5_D','$2y$10$EODAAYx3AFXNXAkyY3e9beHSXzbUgiz9LuhzT9jOLDPgoMR18Fyta',1,0),(10,'M_Member6_D','$2y$10$bjjwVbKZnQSuXvu2tZFj0OhEAwbcOtoaAiSvl0EXMHbabpwWICs.2',1,0);
/*!40000 ALTER TABLE `user_authentication` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_profile` (
  `UUID` int(11) NOT NULL AUTO_INCREMENT,
  `prof_first_name` varchar(45) DEFAULT NULL,
  `prof_last_name` varchar(45) DEFAULT NULL,
  `prof_connect_xbox` varchar(45) DEFAULT NULL,
  `prof_connect_psn` varchar(45) DEFAULT NULL,
  `prof_connect_nintendo` varchar(45) DEFAULT NULL,
  `prof_connect_steam` varchar(45) DEFAULT NULL,
  `prof_connect_origin` varchar(45) DEFAULT NULL,
  `prof_connect_other_name` varchar(45) DEFAULT NULL,
  `prof_connect_other_value` varchar(45) DEFAULT NULL,
  `prof_main_character` varchar(45) DEFAULT 'unknown',
  `prof_email_address` varchar(100) DEFAULT NULL,
  `prof_show_email` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'true/false show user''s email address on their public profile',
  `prof_phone_number` varchar(10) DEFAULT NULL,
  `prof_show_phone` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'true/false show user''s phone number on their public profile',
  `prof_catchphrase` varchar(384) DEFAULT NULL,
  `prof_receive_email` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'true/false receive email notifications',
  PRIMARY KEY (`UUID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
INSERT INTO `user_profile` VALUES (1,'Master','Account',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bayonetta','root@dev',0,NULL,0,'',0),(2,'John','Stallings','XboxTest','','','','','','','ike','member1@dev',0,'1234567890',0,'A good soldier never leaves a man behind.',1),(3,'Michael','Wolford',NULL,'PSNTest',NULL,NULL,NULL,NULL,NULL,'bowser','scorekeeper@dev',0,'0000000000',0,'Use A-spam. And if that don\'t work, use more A-spam.',1),(4,'Mariah','Harris',NULL,NULL,'NintendoNetworkTest',NULL,NULL,NULL,NULL,'corrin','officer@dev',0,'0000000000',0,'An apple a day keeps anyone away if thrown hard enough.',1),(5,'Karl','Garrison','Xx420H34D5H0T$xX',NULL,NULL,'SteamTest',NULL,NULL,NULL,'ganondorf','admin@dev',0,'0000000000',0,'AAAHAHAHHAHHHAHAHA',1),(6,'Damion','Blankenship',NULL,NULL,NULL,NULL,'OriginTest',NULL,NULL,'snake','member2@dev',0,'0000000000',0,'I don\'t miss twice.',1),(7,'Lily','Palmer','','','','','','Test','OtherSiteName','toonlink','member3@dev',0,'0000000000',0,'Pain is just pain entering the body.',1),(8,'Antoine','Rogers','Some','Body','Once','Told','Me','The World Is','Gonna Roll Me','shulk','member4@dev',1,'1238675309',1,'I ain\'t the sharpest tool in the shed.',1),(9,'Alan','Cardenas',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'littlemac','member5@dev',0,'0000000000',0,'',1),(10,'Emily','Robinson',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'zelda','member6@dev',0,'0000000000',0,'A day without sunshine is like... night.',1);
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_rank_history`
--

DROP TABLE IF EXISTS `user_rank_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_rank_history` (
  `row_id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` int(11) NOT NULL,
  `season_number` int(11) NOT NULL DEFAULT '0',
  `rank_final` int(11) NOT NULL,
  `rank_high` int(11) NOT NULL,
  PRIMARY KEY (`row_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_rank_history`
--

LOCK TABLES `user_rank_history` WRITE;
/*!40000 ALTER TABLE `user_rank_history` DISABLE KEYS */;
INSERT INTO `user_rank_history` VALUES (1,1,1,2999,2999),(2,13,1,132,205),(3,14,1,505,556),(4,15,1,712,734),(5,16,1,931,995),(6,17,1,1162,1176),(7,18,1,1338,1338),(8,19,1,1554,1592),(9,20,1,1787,1789),(10,21,1,1954,1977),(11,22,1,2148,2156),(12,23,1,2475,2496),(13,24,1,2708,2771),(14,1,2,2999,2999),(15,13,2,422,422),(16,14,2,351,536),(17,15,2,746,746),(18,16,2,748,895),(19,17,2,1122,1156),(20,18,2,1237,1286),(21,19,2,1569,1588),(22,20,2,1738,1829),(23,21,2,1643,1870),(24,22,2,2128,2174),(25,23,2,2158,2356),(26,24,2,2515,2608),(27,25,2,2156,2206),(28,26,2,2492,2523),(29,1,3,2999,2999),(30,13,3,422,422),(31,14,3,351,536),(32,15,3,746,746),(33,16,3,748,895),(34,17,3,1122,1156),(35,18,3,1237,1286),(36,19,3,1569,1588),(37,20,3,1738,1829),(38,21,3,1643,1870),(39,22,3,2128,2174),(40,23,3,2158,2356),(41,24,3,2515,2608),(42,25,3,2156,2206),(43,26,3,2492,2523),(44,1,4,2999,2999),(45,13,4,422,422),(46,14,4,351,536),(47,15,4,746,746),(48,16,4,748,895),(49,17,4,1122,1156),(50,18,4,1237,1286),(51,19,4,1569,1588),(52,20,4,1738,1829),(53,21,4,1643,1870),(54,22,4,2128,2174),(55,23,4,2158,2356),(56,24,4,2515,2608),(57,25,4,2156,2206),(58,26,4,2492,2523),(59,13,5,1123,1123),(60,13,9,203,203),(61,14,9,681,681),(62,1,11,2999,0),(63,13,11,203,0),(64,14,11,681,0),(65,15,11,746,0),(66,16,11,748,0),(67,17,11,1122,0),(68,18,11,1237,0),(69,19,11,1569,0),(70,20,11,1738,0),(71,21,11,1643,0),(72,22,11,2128,0),(73,23,11,2158,0),(74,24,11,2515,0),(75,25,11,2156,0),(76,26,11,2492,0),(77,30,11,1200,0),(78,33,11,1200,0),(79,34,11,1200,0);
/*!40000 ALTER TABLE `user_rank_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_ranking`
--

DROP TABLE IF EXISTS `user_ranking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_ranking` (
  `UUID` int(11) NOT NULL AUTO_INCREMENT,
  `rank_current` int(11) NOT NULL DEFAULT '0',
  `rank_season_high` int(11) NOT NULL DEFAULT '0',
  `rank_career_high` int(11) NOT NULL DEFAULT '0',
  `rank_placements` int(11) NOT NULL DEFAULT '4' COMMENT 'Number of placement matches remaining before the user receives their official rank, 0=placed',
  `date_member_join` date DEFAULT NULL,
  `date_last_active` date DEFAULT NULL,
  `rank_missed_events` int(11) DEFAULT '0',
  `rank_total_events` int(11) DEFAULT '0',
  `rank_season_wins` int(11) DEFAULT '0',
  `rank_season_losses` int(11) DEFAULT '0',
  `rank_career_wins` int(11) DEFAULT '0',
  `rank_career_losses` int(11) DEFAULT '0',
  PRIMARY KEY (`UUID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_ranking`
--

LOCK TABLES `user_ranking` WRITE;
/*!40000 ALTER TABLE `user_ranking` DISABLE KEYS */;
INSERT INTO `user_ranking` VALUES (1,2999,2999,2999,0,NULL,NULL,0,0,0,0,0,0),(2,473,676,1123,0,'2017-04-05','2017-05-22',0,0,0,0,0,0),(3,573,792,792,0,'2017-03-16','2017-05-22',0,0,0,0,0,0),(4,909,909,909,0,'2017-03-16','2017-06-19',0,0,0,0,0,0),(5,540,803,909,0,'2017-04-05','2017-06-19',0,0,0,0,0,0),(6,1065,1122,1276,0,'2017-03-16','2017-05-22',0,0,0,0,0,0),(7,1253,1314,1335,0,'2017-02-28','2017-06-19',0,0,0,0,0,0),(8,1455,1595,1620,0,'2017-02-28','2017-06-19',0,0,0,0,0,0),(9,1663,1758,1931,0,'2017-02-28','2017-06-19',0,0,0,0,0,0),(10,1496,1643,1898,0,'2017-02-28','2017-06-19',0,0,0,0,0,0);
/*!40000 ALTER TABLE `user_ranking` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-07 21:59:47
