-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 服务器版本: 5.5.40
-- PHP 版本: 5.5.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `grade`
--

-- --------------------------------------------------------

--
-- 表的结构 `class`
--

use grade;

CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `class`
--

INSERT INTO `class` (`id`, `class`, `name`) VALUES
(1, 1, '一班'),
(2, 2, '二班\r\n'),
(3, 3, '三班'),
(4, 4, '四班'),
(5, 5, '五班'),
(6, 6, '六班'),
(7, 7, '七班'),
(8, 8, '八班');

-- --------------------------------------------------------

--
-- 表的结构 `classbel`
--

CREATE TABLE IF NOT EXISTS `classbel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `classbel`
--

INSERT INTO `classbel` (`id`, `user`, `class`) VALUES
(3, 53160000, 1),
(8, 1, 1),
(9, 1, 2),
(10, 1, 3),
(11, 1, 4),
(12, 1, 5),
(14, 53160001, 2),
(15, 53140201, 2),
(16, 53140203, 2),
(17, 53140206, 2);

-- --------------------------------------------------------

--
-- 表的结构 `grade`
--

CREATE TABLE IF NOT EXISTS `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `subject` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `grade`
--

INSERT INTO `grade` (`id`, `user`, `subject`, `score`, `time`) VALUES
(1, 53160000, 1, 100, '2016-11-19 16:20:56'),
(3, 53160000, 2, 60, '2016-11-19 16:21:47');

-- --------------------------------------------------------

--
-- 表的结构 `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `GPA` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `subject`
--

INSERT INTO `subject` (`id`, `name`, `GPA`) VALUES
(1, 'C语言基础', 5),
(2, '数学分析', 5),
(17, '模拟电子电路', 2),
(19, '三国杀基础', 1),
(20, '守卫先锋基础', 1);

-- --------------------------------------------------------

--
-- 表的结构 `subjectbel`
--

CREATE TABLE IF NOT EXISTS `subjectbel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `subject` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `subjectbel`
--

INSERT INTO `subjectbel` (`id`, `user`, `subject`) VALUES
(1, 53160000, 1),
(2, 53160000, 2),
(3, 53160000, 17),
(7, 53160001, 17),
(8, 53160001, 19),
(9, 1, 1),
(10, 1, 2),
(11, 1, 17),
(12, 53160000, 19),
(13, 53160000, 20),
(14, 53140203, 1),
(16, 53140201, 19),
(17, 53140203, 20),
(18, 53140206, 2),
(19, 53140206, 20);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user` int(11) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(4) NOT NULL,
  `cookie` text NOT NULL,
  `name` text NOT NULL,
  `phone` text NOT NULL,
  PRIMARY KEY (`user`),
  UNIQUE KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user`, `password`, `type`, `cookie`, `name`, `phone`) VALUES
(0, 'admin', 3, 'soMvHoNKjQ', 'admin', '123'),
(53140203, '123456', 1, 'NYjv9iLIeS', '韩嘉臻', ''),
(1, 'admin', 2, 'MZidkyZmPk', 'Teacher', '123456789'),
(53140201, '123456', 1, 'HNTF2ozYtX', '洪琦钧', ''),
(53140206, '123456', 1, '?', '吴志伟', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;