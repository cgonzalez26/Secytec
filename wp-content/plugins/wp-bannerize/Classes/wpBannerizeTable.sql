-- --------------------------------------------------------
-- WP Bannerize Table SQL Dump
--
-- @author       =undo= <g.fazioli@undolog.com>, <g.fazioli@wpxtre.me>
-- @copyright    Copyright (C) 2008-2013
-- @version      3.0
--
-- --------------------------------------------------------

CREATE TABLE `%s` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sorter` bigint(20) NOT NULL DEFAULT '0',
  `clickcount` bigint(20) NOT NULL DEFAULT '0',
  `impressions` bigint(20) NOT NULL DEFAULT '0',
  `maximpressions` bigint(20) NOT NULL DEFAULT '0',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `group` varchar(128) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `use_description` char(1) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT '',
  `target` varchar(32) NOT NULL DEFAULT '',
  `nofollow` char(1) NOT NULL DEFAULT '0',
  `trash` char(1) NOT NULL DEFAULT '0',
  `mime` varchar(255) NOT NULL DEFAULT '',
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `realpath` varchar(255) NOT NULL DEFAULT '',
  `banner_type` char(1) NOT NULL DEFAULT '1',
  `free_html` text NOT NULL,
  `enabled` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `group` (`group`),
  KEY `enabled` (`enabled`),
  KEY `trash` (`trash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;