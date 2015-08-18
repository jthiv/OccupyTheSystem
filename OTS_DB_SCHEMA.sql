USE database_name;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS `bill_stances` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `stance_value` enum('support','oppose') COLLATE latin1_general_ci NOT NULL,
  `stance_text` text COLLATE latin1_general_ci NOT NULL,
  `stance_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=56 ;

CREATE TABLE IF NOT EXISTS `community_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `section_id` int(11) NOT NULL,
  `category_description` varchar(250) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

INSERT INTO `community_categories` (`category_id`, `category_name`, `section_id`, `category_description`) VALUES
(1, 'Site Discussion', 2, 'Anything regarding the site in general can go in this section. Report bugs, get support, and ask questions.'),
(2, 'Legislators', 2, 'Threads about specific politicians should be posted here.'),
(3, 'Legislation', 2, 'Threads about specific legislation should be posted here.'),
(4, 'General', 2, 'Threads that do not fit into the other categories may be posted here.'),
(5, 'News', 2, 'Share news here'),
(6, 'Videos', 2, 'Share videos here');

CREATE TABLE IF NOT EXISTS `community_sections` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `section_name` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

CREATE TABLE IF NOT EXISTS `community_thread_votes` (
  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote_value` enum('up','down') COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=114 ;

CREATE TABLE IF NOT EXISTS `community_threads` (
  `thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_parent_id` int(11) DEFAULT NULL,
  `thread_url` varchar(2083) COLLATE latin1_general_ci DEFAULT NULL,
  `thread_title` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `thread_text` text COLLATE latin1_general_ci,
  `thread_politician_id` varchar(250) COLLATE latin1_general_ci DEFAULT NULL,
  `thread_bill_id` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `thread_author_user_id` int(11) NOT NULL,
  `thread_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=132 ;

CREATE TABLE IF NOT EXISTS `issuesList` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `issueName` varchar(250) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=976 ;

CREATE TABLE IF NOT EXISTS `message` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `parent_ID` int(11) DEFAULT NULL,
  `title` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `body` text COLLATE latin1_general_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `news_threads` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `thread_parent_id` int(11) DEFAULT NULL,
  `title` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `body` text COLLATE latin1_general_ci NOT NULL,
  `politician_IDs` text COLLATE latin1_general_ci NOT NULL,
  `bill_IDs` text COLLATE latin1_general_ci NOT NULL,
  `category` enum('politics','misc') COLLATE latin1_general_ci NOT NULL DEFAULT 'misc',
  `level` enum('district','state','national') COLLATE latin1_general_ci NOT NULL DEFAULT 'district',
  `district` int(11) NOT NULL,
  `state` varchar(3) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `newtable` (
  `thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_parent_id` int(11) DEFAULT NULL,
  `thread_title` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `thread_text` varchar(250) COLLATE latin1_general_ci DEFAULT NULL,
  `thread_politician_id` varchar(250) COLLATE latin1_general_ci DEFAULT NULL,
  `thread_bill_id` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `thread_author_user_id` int(11) NOT NULL,
  `thread_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=130 ;

CREATE TABLE IF NOT EXISTS `notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `note_text` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `pledge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `phone` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `amt` varchar(250) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=13 ;

CREATE TABLE IF NOT EXISTS `user_follow` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `followed_user_ID` int(11) NOT NULL,
  `followed_user_acknowledged` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=33 ;

CREATE TABLE IF NOT EXISTS `user_issues` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `issueID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=316 ;

CREATE TABLE IF NOT EXISTS `user_messages` (
  `senderID` int(11) NOT NULL,
  `recieverID` int(11) NOT NULL,
  `messageID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE IF NOT EXISTS `user_stance_requests` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `sender_userID` int(11) NOT NULL,
  `recipient_userID` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `billID` varchar(250) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=18 ;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `user_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s activation status',
  `user_account_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'user''s account type (basic, premium, etc)',
  `user_level` enum('user','mod','admin') COLLATE utf8_unicode_ci NOT NULL,
  `user_state` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `user_district` int(3) NOT NULL,
  `user_has_avatar` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 if user has a local avatar, 0 if not',
  `user_rememberme_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s remember-me cookie token',
  `user_creation_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the creation of user''s account',
  `user_last_login_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of user''s last login',
  `user_failed_logins` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s failed login attempts',
  `user_last_failed_login` int(10) DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
  `user_activation_hash` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s email verification hash string',
  `user_password_reset_hash` char(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password reset code',
  `user_password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
  `user_provider_type` text COLLATE utf8_unicode_ci,
  `user_facebook_uid` bigint(20) unsigned DEFAULT NULL COMMENT 'optional - facebook UID',
  `user_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`),
  KEY `user_facebook_uid` (`user_facebook_uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=226 ;

