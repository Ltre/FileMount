-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-11-02 09:09:58
-- 服务器版本： 5.7.11
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filemount`
--
CREATE DATABASE IF NOT EXISTS `filemount` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `filemount`;

-- --------------------------------------------------------

--
-- 表的结构 `fmt_node`
--

DROP TABLE IF EXISTS `fmt_node`;
CREATE TABLE `fmt_node` (
  `node_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '节点ID',
  `parent_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '父节点ID',
  `node_path` text COLLATE utf8_unicode_ci NOT NULL COMMENT '节点ID用半角逗号隔开',
  `node_level` int(11) NOT NULL DEFAULT '1' COMMENT '层级，根部为1',
  `file_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '文件ID',
  PRIMARY KEY (`node_id`),
  KEY `idx_parent_id` (`parent_id`),
  KEY `idx_file_id` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='文件节点';


-- --------------------------------------------------------

--
-- 表的结构 `fmt_tree`
--

DROP TABLE IF EXISTS `fmt_tree`;
CREATE TABLE `fmt_tree` (
  `tree_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `root_node` bigint(20) NOT NULL COMMENT '指定为根部的节点ID',
  `uid` bigint(20) NOT NULL COMMENT '所属用户ID',
  PRIMARY KEY (`tree_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='文件节点树';


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
