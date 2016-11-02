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
-- 创建时间： 2016-11-02 08:49:09
-- 最后更新： 2016-11-02 08:49:09
--

DROP TABLE IF EXISTS `fmt_node`;
CREATE TABLE `fmt_node` (
  `node_id` bigint(20) NOT NULL,
  `parent_id` bigint(20) NOT NULL,
  `node_path` text COLLATE utf8_unicode_ci NOT NULL COMMENT '节点ID用半角逗号隔开',
  `node_level` int(11) NOT NULL COMMENT '层级，根部为1',
  `file_id` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `fmt_tree`
--
-- 创建时间： 2016-11-02 08:38:47
--

DROP TABLE IF EXISTS `fmt_tree`;
CREATE TABLE `fmt_tree` (
  `tree_id` bigint(20) NOT NULL,
  `root_node` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `fmt_tree`
--

INSERT INTO `fmt_tree` (`tree_id`, `root_node`, `uid`) VALUES
(1, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fmt_node`
--
ALTER TABLE `fmt_node`
  ADD PRIMARY KEY (`node_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `fmt_tree`
--
ALTER TABLE `fmt_tree`
  ADD PRIMARY KEY (`tree_id`),
  ADD KEY `uid` (`uid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `fmt_node`
--
ALTER TABLE `fmt_node`
  MODIFY `node_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `fmt_tree`
--
ALTER TABLE `fmt_tree`
  MODIFY `tree_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
