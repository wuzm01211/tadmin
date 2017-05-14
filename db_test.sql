-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-05-15 00:16:58
-- 服务器版本： 5.7.15
-- PHP Version: 7.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_test`
--

-- --------------------------------------------------------

--
-- 表的结构 `sys_action`
--

CREATE TABLE `sys_action` (
  `id` smallint(3) NOT NULL COMMENT '自增主键',
  `title` varchar(16) NOT NULL COMMENT '动作名',
  `code` varchar(16) NOT NULL COMMENT '动作编码',
  `action` varchar(32) NOT NULL COMMENT '动作 redirect confirm',
  `type` varchar(32) NOT NULL COMMENT '类型 default primary success info warning danger'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作表';

--
-- 转存表中的数据 `sys_action`
--

INSERT INTO `sys_action` (`id`, `title`, `code`, `action`, `type`) VALUES
(1, '可见', 'have', 'redirect', 'default');

-- --------------------------------------------------------

--
-- 表的结构 `sys_admin`
--

CREATE TABLE `sys_admin` (
  `id` smallint(5) NOT NULL COMMENT '自增主键',
  `role_id` smallint(5) NOT NULL COMMENT '角色id',
  `account` varchar(64) NOT NULL COMMENT '账号',
  `pwd` char(32) NOT NULL COMMENT '密码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0禁用 1正常',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `last_time` int(11) NOT NULL COMMENT '最后登录',
  `last_ip` varchar(64) NOT NULL COMMENT '最后ip'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- --------------------------------------------------------

--
-- 表的结构 `sys_log`
--

CREATE TABLE `sys_log` (
  `id` int(12) NOT NULL COMMENT '自增主键',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `admin_id` int(11) NOT NULL COMMENT '操作人id',
  `create_time` int(11) NOT NULL COMMENT '操作时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日志表';

-- --------------------------------------------------------

--
-- 表的结构 `sys_operate`
--

CREATE TABLE `sys_operate` (
  `id` smallint(5) NOT NULL COMMENT '自增主键',
  `pid` smallint(5) NOT NULL DEFAULT '0' COMMENT '上级id',
  `title` varchar(16) NOT NULL COMMENT '操作名称',
  `url` varchar(64) DEFAULT NULL COMMENT 'url路径',
  `last_time` int(11) NOT NULL COMMENT '修改时间',
  `sort` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单表';

--
-- 转存表中的数据 `sys_operate`
--

INSERT INTO `sys_operate` (`id`, `pid`, `title`, `url`, `last_time`, `sort`) VALUES
(1, 0, '系统设置', 'admin/sys/index', 1494770998, 1),
(2, 1, '操作管理', 'admin/action/index', 1494773470, 1);

-- --------------------------------------------------------

--
-- 表的结构 `sys_permission`
--

CREATE TABLE `sys_permission` (
  `id` int(11) NOT NULL COMMENT '自增主键',
  `role_id` smallint(5) NOT NULL COMMENT '角色id',
  `op_id` smallint(5) NOT NULL COMMENT '操作id',
  `ac_id` smallint(5) NOT NULL COMMENT '动作id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限表';

-- --------------------------------------------------------

--
-- 表的结构 `sys_role`
--

CREATE TABLE `sys_role` (
  `id` smallint(5) NOT NULL COMMENT '自增主键',
  `role_name` varchar(64) NOT NULL COMMENT '角色名',
  `status` tinyint(1) NOT NULL COMMENT '状态 0禁用 1正常',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `last_time` int(11) NOT NULL COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';

--
-- 转存表中的数据 `sys_role`
--

INSERT INTO `sys_role` (`id`, `role_name`, `status`, `create_time`, `last_time`) VALUES
(1, '超级管理员', 1, 1494729551, 1494729551);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sys_action`
--
ALTER TABLE `sys_action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_admin`
--
ALTER TABLE `sys_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_log`
--
ALTER TABLE `sys_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_operate`
--
ALTER TABLE `sys_operate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_permission`
--
ALTER TABLE `sys_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_role`
--
ALTER TABLE `sys_role`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `sys_action`
--
ALTER TABLE `sys_action`
  MODIFY `id` smallint(3) NOT NULL AUTO_INCREMENT COMMENT '自增主键', AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `sys_admin`
--
ALTER TABLE `sys_admin`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '自增主键';
--
-- 使用表AUTO_INCREMENT `sys_log`
--
ALTER TABLE `sys_log`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '自增主键';
--
-- 使用表AUTO_INCREMENT `sys_operate`
--
ALTER TABLE `sys_operate`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '自增主键', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `sys_permission`
--
ALTER TABLE `sys_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键';
--
-- 使用表AUTO_INCREMENT `sys_role`
--
ALTER TABLE `sys_role`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '自增主键', AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
