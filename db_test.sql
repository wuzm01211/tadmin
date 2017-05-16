-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-05-16 10:59:37
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

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
  `type` varchar(32) NOT NULL COMMENT '类型 default primary success info warning danger',
  `pos` varchar(32) DEFAULT NULL COMMENT '按钮位置 top_button和right_button'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作表';

--
-- 转存表中的数据 `sys_action`
--

INSERT INTO `sys_action` (`id`, `title`, `code`, `action`, `type`, `pos`) VALUES
  (1, '可见', 'have', 'redirect', 'default', 'hidden'),
  (2, '列表', 'index', 'redirect', 'default', 'hidden'),
  (3, '添加', 'add', 'redirect', 'primary', 'top_button'),
  (4, '修改', 'edit', 'redirect', 'info', 'right_button'),
  (5, '删除', 'delete', 'confirm', 'danger', 'top_button,right_button'),
  (6, '启用', 'enable', 'confirm', 'success', 'top_button,right_button'),
  (7, '禁用', 'disable', 'confirm', 'warning', 'top_button,right_button');

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

--
-- 转存表中的数据 `sys_admin`
--

INSERT INTO `sys_admin` (`id`, `role_id`, `account`, `pwd`, `status`, `create_time`, `last_time`, `last_ip`) VALUES
  (1, 1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1, 1494913936, 1494926161, '127.0.0.1'),
  (2, 1, 'develop', 'e10adc3949ba59abbe56e057f20f883e', 1, 1494925110, 1494931917, '127.0.0.1');

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
  `code` varchar(32) NOT NULL COMMENT 'code',
  `url` varchar(64) DEFAULT NULL COMMENT 'url路径',
  `last_time` int(11) NOT NULL COMMENT '修改时间',
  `sort` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排序',
  `icon` varchar(32) DEFAULT NULL COMMENT 'fa图标'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单表';

--
-- 转存表中的数据 `sys_operate`
--

INSERT INTO `sys_operate` (`id`, `pid`, `title`, `code`, `url`, `last_time`, `sort`, `icon`) VALUES
  (1, 0, '系统设置', 'sysconfig', 'admin/sysconfig/index', 1494921626, 1, 'fa-gears'),
  (2, 1, '操作管理', 'action', 'admin/action/index', 1494819163, 1, 'fa-file'),
  (3, 1, '菜单管理', 'operate', 'admin/operate/index', 1494819143, 2, 'fa-file'),
  (4, 1, '角色管理', 'role', 'admin/role/index', 1494819132, 3, 'fa-file'),
  (5, 1, '管理员', 'admin', 'admin/admin/index', 1494841449, 4, 'fa-user'),
  (6, 0, '首页', 'sysindex', 'admin/sys/index', 1494921671, 5, 'fa-home'),
  (7, 6, '概要', 'index', 'admin/index/index', 1494921744, 2, 'fa-home');

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

--
-- 转存表中的数据 `sys_permission`
--

INSERT INTO `sys_permission` (`id`, `role_id`, `op_id`, `ac_id`) VALUES
  (1, 5, 5, 1),
  (2, 5, 5, 2),
  (3, 5, 5, 3),
  (4, 5, 5, 4),
  (5, 5, 5, 5),
  (6, 5, 5, 6),
  (7, 5, 5, 7),
  (8, 5, 4, 1),
  (9, 5, 4, 2),
  (10, 5, 4, 3),
  (11, 5, 4, 4),
  (12, 5, 4, 5),
  (13, 5, 4, 6),
  (14, 5, 4, 7),
  (15, 5, 3, 1),
  (16, 5, 3, 2),
  (17, 5, 3, 3),
  (18, 5, 3, 4),
  (19, 5, 3, 5),
  (20, 5, 1, 1),
  (21, 5, 2, 1),
  (22, 5, 2, 2),
  (23, 5, 2, 3),
  (24, 5, 2, 4),
  (25, 5, 2, 5),
  (32, 1, 5, 1),
  (33, 1, 5, 2),
  (34, 1, 5, 3),
  (35, 1, 5, 4),
  (37, 1, 5, 6),
  (38, 1, 5, 7),
  (39, 1, 4, 1),
  (40, 1, 4, 2),
  (41, 1, 4, 3),
  (42, 1, 4, 4),
  (44, 1, 4, 6),
  (45, 1, 4, 7),
  (46, 1, 3, 1),
  (47, 1, 3, 2),
  (48, 1, 3, 3),
  (49, 1, 3, 4),
  (50, 1, 3, 5),
  (51, 1, 1, 1),
  (52, 1, 2, 1),
  (53, 1, 2, 2),
  (54, 1, 2, 3),
  (55, 1, 2, 4),
  (56, 1, 2, 5),
  (64, 1, 6, 2),
  (71, 1, 6, 1),
  (72, 1, 7, 1),
  (73, 1, 7, 2);

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
  (1, '超级管理员', 1, 1494914066, 1494931962);

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
MODIFY `id` smallint(3) NOT NULL AUTO_INCREMENT COMMENT '自增主键', AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `sys_admin`
--
ALTER TABLE `sys_admin`
MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '自增主键', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `sys_log`
--
ALTER TABLE `sys_log`
MODIFY `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '自增主键';
--
-- 使用表AUTO_INCREMENT `sys_operate`
--
ALTER TABLE `sys_operate`
MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '自增主键', AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `sys_permission`
--
ALTER TABLE `sys_permission`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键', AUTO_INCREMENT=74;
--
-- 使用表AUTO_INCREMENT `sys_role`
--
ALTER TABLE `sys_role`
MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '自增主键', AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
