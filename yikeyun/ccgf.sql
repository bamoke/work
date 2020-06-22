-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2020-03-15 23:19:07
-- 服务器版本： 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccgf`
--

-- --------------------------------------------------------

--
-- 表的结构 `x_admin_rule`
--

CREATE TABLE `x_admin_rule` (
  `id` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `controller` varchar(20) DEFAULT NULL,
  `action` varchar(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(100) NOT NULL DEFAULT '',
  `short_name` varchar(20) NOT NULL DEFAULT '',
  `url` varchar(50) DEFAULT NULL,
  `icon` varchar(20) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `x_admin_rule`
--

INSERT INTO `x_admin_rule` (`id`, `parent_id`, `controller`, `action`, `type`, `title`, `short_name`, `url`, `icon`, `status`, `sort`) VALUES
(1, 0, 'Sys', '', 1, '系统管理', '系统', NULL, 'icon-cog', 1, 0),
(2, 0, 'Rbac', '', 1, '权限管理', '权限', NULL, 'icon-cog', 0, 0),
(3, 0, 'User', '', 1, '用户管理', '用户', NULL, 'icon-user', 1, 0),
(4, 0, 'Member', '', 1, '会员管理', '会员', NULL, 'icon-list', 1, 0),
(5, 0, 'Orders', '', 1, '订单管理', '订单', NULL, 'icon-bell-alt', 1, 5),
(6, 1, 'Sys', 'index', 1, '系统信息', '', 'Sys/index', '', 1, 0),
(7, 1, 'Sys', 'conf', 1, '系统配置', '', 'Sys/conf', '', 0, 0),
(8, 1, 'Sys', 'menu', 1, '菜单管理', '', 'Sys/menu', '', 0, 0),
(9, 2, 'Rbac', 'index', 1, '角色管理', '', 'Rbac/index', '', 1, 0),
(10, 0, 'Columnist', '', 1, '专栏管理', '专栏', NULL, 'icon-file', 1, 0),
(11, 3, 'User', 'index', 1, '用户列表', '', 'User/index', '', 1, 0),
(12, 3, 'User', 'add', 1, '添加用户', '', 'User/add', '', 1, 2),
(13, 0, 'Finance', '', 1, '财务管理', '财务', '', '', 0, 3),
(14, 13, 'Finance', 'buy', 1, '购买记录', '', 'Finance/buy', '', 1, 1),
(15, 13, 'Finance', 'pay', 1, '充值记录', '', 'Finance/pay', '', 1, 0),
(16, 4, 'Member', 'index', 1, '会员列表', '', 'Member/index', '', 1, 0),
(17, 0, 'Content', '', 1, '文章管理', '文章', NULL, 'icon-video', 1, 20),
(18, 10, 'Columnist', 'index', 1, '专栏列表', '', 'Columnist/index', '', 1, 0),
(19, 10, 'Columnist', 'add', 0, '创建专栏', '', 'Columnist/add', '', 1, 1),
(20, 17, 'Content', 'index', 1, '文章列表', '', 'Content/index', '', 1, 0),
(21, 5, 'Orders', 'index', 1, '订单列表', '', 'Orders/index', '', 1, 0),
(22, 5, 'Orders', 'add', 1, '创建订单', '', 'Orders/add', '', 0, 1),
(23, 1, 'Sys', 'cate', 1, '系统分类', '', 'Sys/cate', '', 1, 2),
(24, 4, 'Member', 'cash', 1, '会员提现', '', 'Member/cash', '', 0, 1),
(25, 4, 'Member', 'recharge', 1, '会员充值', '', 'Member/recharge', '', 0, 1),
(26, 0, 'Teacher', 'index', 1, '教练管理', '教练', NULL, 'icon-list', 1, 0),
(27, 26, 'Teacher', 'index', 1, '教练列表', '', 'Teacher/index', '', 1, 0),
(28, 26, 'Teacher', 'add', 1, '添加教练', '', 'Teacher/add', '', 1, 1),
(29, 10, 'Columnist', 'edit', 0, '修改专栏', '', 'Columnist/edit', '', 1, 1),
(30, 0, 'Course', '', 1, '课程管理', '课程', NULL, 'icon-list', 1, 2),
(32, 30, 'Course', 'index', 1, '课程列表', '', 'Course/index', '', 1, 0),
(34, 0, 'Comment', '', 1, '评论管理', '评论', NULL, 'icon-list', 1, 2),
(35, 34, 'Comment', 'index', 1, '评论列表', '', 'Comment/index', '', 1, 0),
(42, 1, 'Sys', 'banner', 1, 'Banner管理', '', 'Sys/banner', '', 1, 3),
(43, 0, 'Booking', '', 1, '在线预约', '预约', NULL, 'icon-list', 1, 2),
(44, 43, 'Booking', 'index', 1, '预约课程', '', 'Booking/index', '', 1, 3),
(45, 43, 'Booking', 'logs', 1, '预约记录', '', 'Booking/logs', '', 1, 4),
(46, 43, 'Booking', 'calendar', 1, '课程日历', '', 'Booking/calendar', '', 1, 5),
(52, 0, 'Organization', 'index', 1, '机构管理', '机构', NULL, 'icon-list', 1, 0),
(53, 52, 'Organization', 'index', 1, '机构管理', '机构', 'Organization/index', 'icon-list', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `x_balance_log`
--

CREATE TABLE `x_balance_log` (
  `id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(140) NOT NULL DEFAULT '',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='余额变更记录表';

--
-- 转存表中的数据 `x_balance_log`
--

INSERT INTO `x_balance_log` (`id`, `member_id`, `amount`, `description`, `create_time`) VALUES
(11, 1, '-0.01', '商品购买扣除', '2019-01-08 17:15:02');

-- --------------------------------------------------------

--
-- 表的结构 `x_banner`
--

CREATE TABLE `x_banner` (
  `id` int(10) NOT NULL,
  `img` varchar(128) NOT NULL DEFAULT '',
  `title` varchar(120) NOT NULL DEFAULT '',
  `url` varchar(64) DEFAULT NULL,
  `position_key` int(10) NOT NULL COMMENT '识别标识',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `x_banner`
--

INSERT INTO `x_banner` (`id`, `img`, `title`, `url`, `position_key`, `status`) VALUES
(1, 'index-banner.jpg', '首页banner', NULL, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `x_booking`
--

CREATE TABLE `x_booking` (
  `id` int(10) NOT NULL,
  `type` int(10) NOT NULL,
  `org_id` tinyint(3) NOT NULL COMMENT '机构id',
  `title` varchar(120) NOT NULL,
  `thumb` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(500) NOT NULL DEFAULT '',
  `content` text,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `enroll_limit` date DEFAULT NULL,
  `person_limit` int(10) DEFAULT NULL,
  `enroll_person` int(10) DEFAULT '0',
  `yh_limit` date DEFAULT NULL,
  `yh_price` decimal(10,2) DEFAULT NULL,
  `has_yh` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort` tinyint(3) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='在线预约';

--
-- 转存表中的数据 `x_booking`
--

INSERT INTO `x_booking` (`id`, `type`, `org_id`, `title`, `thumb`, `description`, `content`, `price`, `enroll_limit`, `person_limit`, `enroll_person`, `yh_limit`, `yh_price`, `has_yh`, `create_time`, `status`, `sort`) VALUES
(1, 1, 1, '精英特训班一期', '99dbae91b6c479c9a1d0960226c0d351.png', '专门针对功夫频道基础学员或有一定咏春基础的学员 线下培训，无基础的学员不建议报此班。', '<p>专门针对功夫频道基础学员或有一定咏春基础的学员 线下培训，无基础的学员不建议报此班。每期培训5天，上午2小时，下午3小时，晚上2小时。学习内容主要是“三手两脚”的实战组合运用，开班前半天会强化咏春基础(基本功)内容练习。本期学员限12人。</p>', '8.80', '2019-02-18', 12, 2, '2019-02-22', '0.08', 1, '2018-12-25 05:08:26', 1, 1),
(2, 1, 1, '精英特训班二期', '5ad7f6dce8797a62f9754aa2164932ba.png', '专门针对功夫频道基础学员或有一定咏春基础的学员 线下培训，无基础的学员不建议报此班。', '<p>本期咏春散手特训班限招12人，主要对象针对有咏春基础的学员。我们为什么一定要针对有基础的学员，是因为线下特训班的培训内容属实战性比较强的学习课程，基础内容非常少时间练习，同时，我们也不建议交钱来到线下学基础内容。</p>', '9.90', '2019-03-15', 12, 0, '2019-01-10', '0.09', 1, '2018-12-25 05:09:09', 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `x_booking_log`
--

CREATE TABLE `x_booking_log` (
  `id` int(11) NOT NULL,
  `member_id` int(10) NOT NULL,
  `booking_id` int(10) NOT NULL,
  `realname` varchar(12) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL COMMENT '0:女;1:男',
  `phone` varchar(20) DEFAULT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `day` date DEFAULT NULL COMMENT '上课日期',
  `time` varchar(50) DEFAULT NULL COMMENT '上课时段',
  `notes` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未联系;1:已联系;',
  `operator_id` int(10) DEFAULT NULL COMMENT '操作人'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `x_booking_log`
--

INSERT INTO `x_booking_log` (`id`, `member_id`, `booking_id`, `realname`, `gender`, `phone`, `create_time`, `day`, `time`, `notes`, `status`, `operator_id`) VALUES
(1, 1, 1, NULL, NULL, NULL, '2019-01-10 19:35:57', NULL, NULL, '', 0, NULL),
(2, 3, 1, NULL, NULL, NULL, '2019-01-10 19:45:42', NULL, NULL, '', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `x_collection`
--

CREATE TABLE `x_collection` (
  `id` int(10) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1:专栏2:课程',
  `pro_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏夹';

--
-- 转存表中的数据 `x_collection`
--

INSERT INTO `x_collection` (`id`, `type`, `pro_id`, `member_id`, `status`, `create_time`) VALUES
(2, 3, 1, 1, 1, '2019-01-10 16:36:48'),
(3, 2, 5, 1, 0, '2019-01-10 16:40:05'),
(4, 2, 1, 1, 0, '2019-01-10 17:44:23'),
(5, 3, 1, 7, 1, '2019-01-12 23:37:52'),
(6, 3, 1, 9, 0, '2019-01-14 10:19:26'),
(7, 2, 5, 119, 1, '2020-03-15 23:57:35');

-- --------------------------------------------------------

--
-- 表的结构 `x_columnist`
--

CREATE TABLE `x_columnist` (
  `id` int(10) NOT NULL,
  `cate_id` tinyint(3) NOT NULL DEFAULT '0',
  `teacher_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL COMMENT '名称',
  `keywords` varchar(200) NOT NULL DEFAULT '' COMMENT '页面关键词',
  `thumb` varchar(120) NOT NULL DEFAULT '' COMMENT '缩略图',
  `isfree` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1免费0:收费',
  `price` decimal(10,2) DEFAULT '0.00',
  `has_yh` tinyint(1) NOT NULL DEFAULT '0',
  `yh_limit` date DEFAULT NULL,
  `yh_price` decimal(10,2) DEFAULT NULL,
  `description` varchar(200) NOT NULL DEFAULT '' COMMENT '描述',
  `content` text COMMENT '产品详情',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:下架;1:上架中',
  `recommend` tinyint(4) NOT NULL DEFAULT '0',
  `tags` varchar(200) DEFAULT NULL COMMENT '标签',
  `subscribers` int(10) NOT NULL DEFAULT '0' COMMENT '订阅人数',
  `buy_num` int(10) NOT NULL DEFAULT '0' COMMENT '购买数',
  `article_num` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `x_columnist`
--

INSERT INTO `x_columnist` (`id`, `cate_id`, `teacher_id`, `title`, `keywords`, `thumb`, `isfree`, `price`, `has_yh`, `yh_limit`, `yh_price`, `description`, `content`, `create_time`, `status`, `recommend`, `tags`, `subscribers`, `buy_num`, `article_num`) VALUES
(2, 6, 1, '测试专栏', '', 'd11ae0cb597432302e8d80b0ffaba1c6.jpg', 0, '1.00', 0, NULL, NULL, '专栏描述专栏描述专栏描述专栏描述', '<p>威威</p>', '2018-12-24 07:57:14', 1, 1, NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `x_columnist_article`
--

CREATE TABLE `x_columnist_article` (
  `id` int(10) NOT NULL,
  `columnist_id` int(10) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:图文,2:音频:3视频',
  `title` varchar(50) NOT NULL,
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `source` varchar(500) NOT NULL DEFAULT '' COMMENT '资源地址如视频',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort` tinyint(2) NOT NULL DEFAULT '0',
  `description` varchar(200) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `view_num` int(10) NOT NULL DEFAULT '0',
  `comment_num` int(10) NOT NULL DEFAULT '0' COMMENT '评论数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='专栏文章';

--
-- 转存表中的数据 `x_columnist_article`
--

INSERT INTO `x_columnist_article` (`id`, `columnist_id`, `type`, `title`, `thumb`, `source`, `status`, `sort`, `description`, `content`, `create_time`, `view_num`, `comment_num`) VALUES
(3, 2, 3, '测试专栏章节一', '7d7c5af46b832b612d79e6037dc5c1f3.jpg', 'cart_fill.png', 1, 0, '', '<p>二五</p>', '2018-12-24 16:02:17', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `x_columnist_student`
--

CREATE TABLE `x_columnist_student` (
  `id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `column_id` int(10) NOT NULL,
  `deadline` date NOT NULL COMMENT '截至',
  `create_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='专栏学员';

-- --------------------------------------------------------

--
-- 表的结构 `x_comment`
--

CREATE TABLE `x_comment` (
  `id` int(10) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1:专栏文章;2:针对课程',
  `pro_id` int(10) NOT NULL,
  `pro_title` varchar(50) NOT NULL DEFAULT '' COMMENT '被评论的标题',
  `member_id` int(11) NOT NULL,
  `content` varchar(500) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:show,0:hide',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论';

--
-- 转存表中的数据 `x_comment`
--

INSERT INTO `x_comment` (`id`, `type`, `pro_id`, `pro_title`, `member_id`, `content`, `status`, `create_time`) VALUES
(2, 2, 1, '测试课程', 1, 'ces', 1, '2019-01-08 23:53:42'),
(3, 2, 5, '木人桩_完整套路篇', 4, '可以可以', 0, '2019-01-13 11:20:03'),
(4, 2, 1, '木人桩_散桩练习课程', 4, '这个课程很有系统！！', 0, '2019-01-13 18:58:27');

-- --------------------------------------------------------

--
-- 表的结构 `x_content_cate`
--

CREATE TABLE `x_content_cate` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `pid` tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(24) NOT NULL DEFAULT '',
  `page_type` varchar(12) NOT NULL DEFAULT '' COMMENT 'single\\pic\\news\\product\\banner',
  `sort` tinyint(4) UNSIGNED DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容分类';

--
-- 转存表中的数据 `x_content_cate`
--

INSERT INTO `x_content_cate` (`id`, `pid`, `title`, `page_type`, `sort`, `status`) VALUES
(1, 0, '视频赏析', 'news', 1, 1),
(2, 1, '咏春经典', 'news', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `x_coupon`
--

CREATE TABLE `x_coupon` (
  `id` int(10) NOT NULL,
  `title` varchar(128) NOT NULL,
  `value` int(10) NOT NULL,
  `deadline` date NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券';

--
-- 转存表中的数据 `x_coupon`
--

INSERT INTO `x_coupon` (`id`, `title`, `value`, `deadline`, `create_time`) VALUES
(1, '通用优惠券', 5, '2019-01-08', '2019-01-09 22:29:10'),
(2, '功夫频道贺新春', 15, '2019-02-27', '2019-01-09 22:31:26');

-- --------------------------------------------------------

--
-- 表的结构 `x_coupon_log`
--

CREATE TABLE `x_coupon_log` (
  `id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `coupon_id` int(10) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券领取记录';

--
-- 转存表中的数据 `x_coupon_log`
--

INSERT INTO `x_coupon_log` (`id`, `member_id`, `coupon_id`, `create_time`) VALUES
(1, 1, 1, '2019-01-09 22:29:19'),
(2, 1, 2, '2019-01-09 22:31:34');

-- --------------------------------------------------------

--
-- 表的结构 `x_course`
--

CREATE TABLE `x_course` (
  `id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `org_id` int(10) NOT NULL COMMENT '机构id',
  `teacher_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '封面',
  `description` varchar(200) NOT NULL DEFAULT '',
  `main_people` varchar(500) DEFAULT NULL COMMENT '适用人群',
  `study_target` varchar(500) DEFAULT NULL COMMENT '学习目标',
  `content` text,
  `price` decimal(12,2) DEFAULT '0.00',
  `isfree` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:收费1:免费',
  `has_yh` tinyint(1) DEFAULT '0',
  `yh_limit` datetime DEFAULT NULL,
  `yh_price` decimal(10,2) DEFAULT NULL,
  `buy_num` int(10) NOT NULL DEFAULT '0' COMMENT '购买人数',
  `study_num` int(10) NOT NULL DEFAULT '0' COMMENT '学习人数',
  `comment_num` int(10) NOT NULL DEFAULT '0' COMMENT '评论数',
  `period` tinyint(2) NOT NULL DEFAULT '0' COMMENT '总课时',
  `recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:正常1:推荐',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:下架1:上架',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='课程';

--
-- 转存表中的数据 `x_course`
--

INSERT INTO `x_course` (`id`, `cate_id`, `org_id`, `teacher_id`, `title`, `thumb`, `description`, `main_people`, `study_target`, `content`, `price`, `isfree`, `has_yh`, `yh_limit`, `yh_price`, `buy_num`, `study_num`, `comment_num`, `period`, `recommend`, `sort`, `status`, `create_time`) VALUES
(1, 3, 1, 2, '木人桩_散桩练习课程', '95b03a075189896b98950aa6b27f6119.png', '木人桩散桩练习方法，是从木人桩完整套路中提炼出来的经典动作组合。', NULL, NULL, '<p>木人桩散桩练习方法，是从木人桩完整套路中提炼出来的经典动作组合，是木人桩练习的一种方法，也是强化咏春散手动作规范与定型的有效方式，希望大家好好练习。</p>', '8.88', 0, 1, '2019-01-26 00:00:00', '0.01', 4, 4, 2, 4, 1, 0, 1, '2018-12-23 22:04:26'),
(5, 3, 1, 3, '木人桩_完整套路篇', '85d2a3fd0423d2e01348b8383cef77fa.png', '完整套路篇', NULL, NULL, '<p>木人桩是</p>', '8.88', 0, 1, '2019-02-28 00:00:00', '0.01', 5, 10, 1, 2, 1, 0, 1, '2019-01-08 16:40:46');

-- --------------------------------------------------------

--
-- 表的结构 `x_course_section`
--

CREATE TABLE `x_course_section` (
  `id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1:图文,2:音频:3视频',
  `course_id` int(11) NOT NULL,
  `isfree` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `duration` varchar(10) DEFAULT NULL COMMENT '时长',
  `source` varchar(500) NOT NULL COMMENT '资源地址如视频',
  `view_num` int(10) NOT NULL DEFAULT '0',
  `content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='课程章节';

--
-- 转存表中的数据 `x_course_section`
--

INSERT INTO `x_course_section` (`id`, `type`, `course_id`, `isfree`, `title`, `duration`, `source`, `view_num`, `content`) VALUES
(15, 3, 1, 0, '333', '', 'jwxcp-01.mp4', 0, '<p>得瑟得瑟</p>'),
(16, 3, 1, 0, 'test', '', '', 0, '<p>ss</p>'),
(17, 3, 1, 0, '第三节', '', 'jw.mp4', 0, '<p>呃呃呃</p>'),
(18, 3, 1, 0, '第四节', '06:23', '', 0, ''),
(19, 3, 5, 1, '木人桩第一节', '04:58', '木人桩_第一节.mp4', 0, NULL),
(20, 3, 5, 0, '木人桩第二节', '04:26', '木人桩第一节.mp4', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `x_course_student`
--

CREATE TABLE `x_course_student` (
  `id` int(11) NOT NULL,
  `course_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='课程学员';

--
-- 转存表中的数据 `x_course_student`
--

INSERT INTO `x_course_student` (`id`, `course_id`, `member_id`, `create_time`) VALUES
(1, 1, 1, '2019-01-10 10:06:18'),
(2, 1, 2, '2019-01-10 10:23:10'),
(3, 5, 1, '2019-01-10 16:39:54'),
(4, 5, 3, '2019-01-10 19:36:18'),
(5, 5, 4, '2019-01-11 00:11:13'),
(6, 5, 2, '2019-01-11 14:08:54'),
(7, 5, 3, '2019-01-15 15:19:16'),
(8, 1, 4, '2019-01-15 15:19:40'),
(9, 5, 1, '2019-01-15 15:30:23'),
(10, 1, 3, '2019-01-15 19:37:34'),
(11, 5, 4, '2019-01-15 20:11:37'),
(12, 5, 33, '2019-05-13 00:48:35'),
(13, 5, 78, '2019-10-23 11:40:30');

-- --------------------------------------------------------

--
-- 表的结构 `x_feedback`
--

CREATE TABLE `x_feedback` (
  `id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `content` varchar(500) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='建议';

--
-- 转存表中的数据 `x_feedback`
--

INSERT INTO `x_feedback` (`id`, `member_id`, `content`, `contact`, `create_time`) VALUES
(1, 1, '23', '32', '2019-01-09 22:42:32'),
(2, 3, '反馈，建议', '，cade', '2019-01-10 20:47:48'),
(3, 3, '反馈，建议', '，cade', '2019-01-10 20:47:49');

-- --------------------------------------------------------

--
-- 表的结构 `x_main_cate`
--

CREATE TABLE `x_main_cate` (
  `id` int(10) NOT NULL,
  `pid` int(10) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `identification` varchar(50) NOT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类管理';

--
-- 转存表中的数据 `x_main_cate`
--

INSERT INTO `x_main_cate` (`id`, `pid`, `name`, `identification`, `icon`) VALUES
(1, 0, '专栏类别', 'columnist', NULL),
(2, 0, '课程类别', 'course', NULL),
(3, 2, '咏春', 'course', NULL),
(4, 2, '跆拳道', 'course', NULL),
(5, 2, '散打', 'course', NULL),
(6, 1, '咏春', 'columnist', NULL),
(7, 1, '跆拳道', 'columnist', NULL),
(8, 1, '散打', 'columnist', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `x_member`
--

CREATE TABLE `x_member` (
  `id` int(10) NOT NULL,
  `unionid` varchar(64) DEFAULT NULL,
  `openid` varchar(64) NOT NULL,
  `phone` varchar(11) DEFAULT NULL COMMENT '手机号',
  `password` varchar(32) DEFAULT NULL,
  `reg_time` int(10) NOT NULL COMMENT '注册时间',
  `is_lock` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0是正常 1是锁定',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `error_time` int(10) NOT NULL DEFAULT '0',
  `error_limit` int(10) DEFAULT NULL,
  `is_real_name` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未实名认证,1:已认证',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户余额',
  `study_duration` int(10) NOT NULL DEFAULT '0' COMMENT '秒'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `x_member`
--

INSERT INTO `x_member` (`id`, `unionid`, `openid`, `phone`, `password`, `reg_time`, `is_lock`, `status`, `error_time`, `error_limit`, `is_real_name`, `balance`, `study_duration`) VALUES
(1, NULL, 'oF0I34xKGNNE5p1pTUG8wtVuBUKI', NULL, NULL, 1547086867, 0, 1, 0, NULL, 0, '0.00', 0),
(2, NULL, 'oF0I345xcE3BEyaJ3UUpsIJbbl8k', NULL, NULL, 1547086979, 0, 1, 0, NULL, 0, '0.00', 0),
(3, NULL, 'oF0I34-YYbO-rxVdZIK15pM-81U4', NULL, NULL, 1547087041, 0, 1, 0, NULL, 0, '0.00', 0),
(4, NULL, 'oF0I34729FScrSJM9AAG7yR86Nvw', NULL, NULL, 1547106238, 0, 1, 0, NULL, 0, '0.00', 0),
(5, NULL, 'oF0I343oAx8XdExh2JgEaMoPBbaI', NULL, NULL, 1547275128, 0, 1, 0, NULL, 0, '0.00', 0),
(6, NULL, 'oF0I347QPIOwzvICK7eva5N1bocs', NULL, NULL, 1547285962, 0, 1, 0, NULL, 0, '0.00', 0),
(7, NULL, 'oF0I340Ih7Wn_TMUs8EWVIsaF0vM', NULL, NULL, 1547307440, 0, 1, 0, NULL, 0, '0.00', 0),
(8, NULL, 'oF0I348Rg6CxCnCQhpCYuF5FuqT0', NULL, NULL, 1547361569, 0, 1, 0, NULL, 0, '0.00', 0),
(9, NULL, 'oF0I34_gGNEjOiXdORLcBinK8tJg', NULL, NULL, 1547432315, 0, 1, 0, NULL, 0, '0.00', 0),
(10, NULL, 'oF0I347Bmtw3g2zbxefi7-EicmnQ', NULL, NULL, 1547442215, 0, 1, 0, NULL, 0, '0.00', 0),
(11, NULL, 'oF0I340mAP6_EchaSsV3HhXTwFJ4', NULL, NULL, 1547454932, 0, 1, 0, NULL, 0, '0.00', 0),
(12, NULL, 'oF0I341pbkgo4-TFVErj-0yMeN0o', NULL, NULL, 1547526200, 0, 1, 0, NULL, 0, '0.00', 0),
(13, NULL, 'oF0I34whtJT3B6-S4Ews-65FMLkk', NULL, NULL, 1547536767, 0, 1, 0, NULL, 0, '0.00', 0),
(14, NULL, 'oF0I342u9umGeBCVDAAU-adeswUA', NULL, NULL, 1547548602, 0, 1, 0, NULL, 0, '0.00', 0),
(15, NULL, 'oF0I345j1DrZRGt06PI907ug0ktg', NULL, NULL, 1547548965, 0, 1, 0, NULL, 0, '0.00', 0),
(16, NULL, 'oF0I34xtmWkrJt3SJXeW_dejK-Uc', NULL, NULL, 1547643326, 0, 1, 0, NULL, 0, '0.00', 0),
(17, NULL, 'oF0I347cBCZg6YHqJMLYgxIqeU2c', NULL, NULL, 1549107875, 0, 1, 0, NULL, 0, '0.00', 0),
(18, NULL, 'oF0I345fz4pIRH-KQIj1Lq6SiEVQ', NULL, NULL, 1549824649, 0, 1, 0, NULL, 0, '0.00', 0),
(19, NULL, 'oF0I34y7QISbQI3B_UrZb4syWh7s', NULL, NULL, 1549938228, 0, 1, 0, NULL, 0, '0.00', 0),
(20, NULL, 'oF0I34-02YNGdmrp9vuB62jJ-wt4', NULL, NULL, 1550149535, 0, 1, 0, NULL, 0, '0.00', 0),
(21, NULL, 'oF0I342bhGlmJznZKRIugwSdF35s', NULL, NULL, 1552249726, 0, 1, 0, NULL, 0, '0.00', 0),
(22, NULL, 'oF0I34wr3bwdHuwRm8VdKVXOYJac', NULL, NULL, 1552627631, 0, 1, 0, NULL, 0, '0.00', 0),
(23, NULL, 'oF0I34wS5-3B6tpSKtT9yhWBA9_o', NULL, NULL, 1552873116, 0, 1, 0, NULL, 0, '0.00', 0),
(24, NULL, 'oF0I346yNXY051Eh99N1UtbDj0sY', NULL, NULL, 1553464479, 0, 1, 0, NULL, 0, '0.00', 0),
(25, NULL, 'oF0I344NlH7Zp7SSt7-GVxb1QcHI', NULL, NULL, 1554065806, 0, 1, 0, NULL, 0, '0.00', 0),
(26, NULL, 'oF0I34zTs7FHf9nngbhtZALlF4Hc', NULL, NULL, 1554665103, 0, 1, 0, NULL, 0, '0.00', 0),
(27, NULL, 'oF0I34woMLWRUepvqGb0AB2Kz0-I', NULL, NULL, 1555271923, 0, 1, 0, NULL, 0, '0.00', 0),
(28, NULL, 'oF0I341IPpRjtYfpr2_sTEHl32iE', NULL, NULL, 1555748589, 0, 1, 0, NULL, 0, '0.00', 0),
(29, NULL, 'oF0I34zs2g06720sswZ_a_143lnc', NULL, NULL, 1555841995, 0, 1, 0, NULL, 0, '0.00', 0),
(30, NULL, 'oF0I34wD_qnt0kuTUMpk4t9QkC1A', NULL, NULL, 1555880174, 0, 1, 0, NULL, 0, '0.00', 0),
(31, NULL, 'oF0I346-ywfd3y5e5-z-5dSfVj44', NULL, NULL, 1556520653, 0, 1, 0, NULL, 0, '0.00', 0),
(32, NULL, 'oF0I34-V4LBu3K7lqqpgyqR6394M', NULL, NULL, 1557085805, 0, 1, 0, NULL, 0, '0.00', 0),
(33, NULL, 'oF0I34y209BLj997XBqENvUV1EGY', NULL, NULL, 1557679476, 0, 1, 0, NULL, 0, '0.00', 0),
(34, NULL, 'oF0I340pi3-Vpcxb_KAIfnASe0DM', NULL, NULL, 1557694487, 0, 1, 0, NULL, 0, '0.00', 0),
(35, NULL, 'oF0I343Ok2aFapkR13POfZZsPYUw', NULL, NULL, 1558297868, 0, 1, 0, NULL, 0, '0.00', 0),
(36, NULL, 'oF0I34yubdu59F5rWwhw4C7uNCIE', NULL, NULL, 1558931557, 0, 1, 0, NULL, 0, '0.00', 0),
(37, NULL, 'oF0I349EtVHXn5BJglHCNFa8eb8M', NULL, NULL, 1559384332, 0, 1, 0, NULL, 0, '0.00', 0),
(38, NULL, 'oF0I340Ys4R2geCQU2RZg43uYyOI', NULL, NULL, 1559497955, 0, 1, 0, NULL, 0, '0.00', 0),
(39, NULL, 'oF0I34yJ2HC9LrAx_EoPqvAzMtYs', NULL, NULL, 1559521864, 0, 1, 0, NULL, 0, '0.00', 0),
(40, NULL, 'oF0I34xHMQrsw7wVixkSqrkTw_iM', NULL, NULL, 1560114564, 0, 1, 0, NULL, 0, '0.00', 0),
(41, NULL, 'oF0I34y8TTL52wbphyKolZpOJR5Y', NULL, NULL, 1560718622, 0, 1, 0, NULL, 0, '0.00', 0),
(42, NULL, 'oF0I34xIchlLQzgL02tUp5okXZxw', NULL, NULL, 1560740334, 0, 1, 0, NULL, 0, '0.00', 0),
(43, NULL, 'oF0I345lhHviZFQ6nfXEew5owusw', NULL, NULL, 1561001804, 0, 1, 0, NULL, 0, '0.00', 0),
(44, NULL, 'oF0I3433PiAM8Gu49BOm9eH_M1aA', NULL, NULL, 1561313994, 0, 1, 0, NULL, 0, '0.00', 0),
(45, NULL, 'oF0I342LCtp38UWZTajeaLxUNZ38', NULL, NULL, 1561933784, 0, 1, 0, NULL, 0, '0.00', 0),
(46, NULL, 'oF0I343aO6rrmzWE3R1RJzw89JFU', NULL, NULL, 1562529634, 0, 1, 0, NULL, 0, '0.00', 0),
(47, NULL, 'oF0I34wTtwPbvc9bMP-HUWT9C3gI', NULL, NULL, 1563128714, 0, 1, 0, NULL, 0, '0.00', 0),
(48, NULL, 'oF0I34xrDln1ZLlnNMn52OCT7uKE', NULL, NULL, 1563741728, 0, 1, 0, NULL, 0, '0.00', 0),
(49, NULL, 'oF0I341OZOnJRt3D7s-ov2KloM4g', NULL, NULL, 1564116444, 0, 1, 0, NULL, 0, '0.00', 0),
(50, NULL, 'oF0I34wfTqWZaP98fYGDKDgq8gnE', NULL, NULL, 1564303176, 0, 1, 0, NULL, 0, '0.00', 0),
(51, NULL, 'oF0I34zUGjugiHHAbFXm1LDeQVxI', NULL, NULL, 1564348735, 0, 1, 0, NULL, 0, '0.00', 0),
(52, NULL, 'oF0I34zRjQuMO_5OIVwpNaUSrgsc', NULL, NULL, 1564389876, 0, 1, 0, NULL, 0, '0.00', 0),
(53, NULL, 'oF0I343gZwb6omEvnu875AUWSH-M', NULL, NULL, 1564493379, 0, 1, 0, NULL, 0, '0.00', 0),
(54, NULL, 'oF0I3443Xz3YEJuxWutLQmtkG8To', NULL, NULL, 1564938858, 0, 1, 0, NULL, 0, '0.00', 0),
(55, NULL, 'oF0I342acPMyhbNhw6-n8b8nJ3tU', NULL, NULL, 1565522678, 0, 1, 0, NULL, 0, '0.00', 0),
(56, NULL, 'oF0I3494aiylDMfly581tSxUhVPU', NULL, NULL, 1565563748, 0, 1, 0, NULL, 0, '0.00', 0),
(57, NULL, 'oF0I349hyoYiNrXHoeU1tPMPkUVM', NULL, NULL, 1565612862, 0, 1, 0, NULL, 0, '0.00', 0),
(58, NULL, 'oF0I345Xk2mpCTuKzuNCZbOcDot0', NULL, NULL, 1566183908, 0, 1, 0, NULL, 0, '0.00', 0),
(59, NULL, 'oF0I34-cKbbw5BeN43ab8sELfMUQ', NULL, NULL, 1566530405, 0, 1, 0, NULL, 0, '0.00', 0),
(60, NULL, 'oF0I349qU8Jh9Ij2XiHa_gsjBv48', NULL, NULL, 1566777384, 0, 1, 0, NULL, 0, '0.00', 0),
(61, NULL, 'oF0I3451YEVknW7wY4r5QQ_Enbg8', NULL, NULL, 1566825040, 0, 1, 0, NULL, 0, '0.00', 0),
(62, NULL, 'oF0I34xDTSJR3ImBcdM-aAz_nx9c', NULL, NULL, 1566943170, 0, 1, 0, NULL, 0, '0.00', 0),
(63, NULL, 'oF0I346a_OpzjICmohqNvxmXMV1A', NULL, NULL, 1567220178, 0, 1, 0, NULL, 0, '0.00', 0),
(64, NULL, 'oF0I34_R6zRX3Bh_UA_QqiwvhP34', NULL, NULL, 1567384566, 0, 1, 0, NULL, 0, '0.00', 0),
(65, NULL, 'oF0I343jEwKgdyFcICViTIN7GlWs', NULL, NULL, 1567527022, 0, 1, 0, NULL, 0, '0.00', 0),
(66, NULL, 'oF0I34_5iwraLFNUwzeDytfWpH_g', NULL, NULL, 1567967219, 0, 1, 0, NULL, 0, '0.00', 0),
(67, NULL, 'oF0I34xs6tPbCFnEudwBZ63-atYA', NULL, NULL, 1568117876, 0, 1, 0, NULL, 0, '0.00', 0),
(68, NULL, 'oF0I3436CtdzX3B1mY0NCRgAGndA', NULL, NULL, 1568577692, 0, 1, 0, NULL, 0, '0.00', 0),
(69, NULL, 'oF0I34wDWeydo-OprPsUK1U6hFJY', NULL, NULL, 1568618729, 0, 1, 0, NULL, 0, '0.00', 0),
(70, NULL, 'oF0I34-alU6NEFXxm18vB7ft9oNY', NULL, NULL, 1568710795, 0, 1, 0, NULL, 0, '0.00', 0),
(71, NULL, 'oF0I34-_bgNB6ox5WSaYJrNrj0ps', NULL, NULL, 1568948900, 0, 1, 0, NULL, 0, '0.00', 0),
(72, NULL, 'oF0I344aswrXMBeCvFeKuvVzBG04', NULL, NULL, 1568977663, 0, 1, 0, NULL, 0, '0.00', 0),
(73, NULL, 'oF0I340rEZwsKPBSj7Yb8xFxoenw', NULL, NULL, 1569283048, 0, 1, 0, NULL, 0, '0.00', 0),
(74, NULL, 'oF0I349lZgYR7PudpADORLhs__hw', NULL, NULL, 1569808400, 0, 1, 0, NULL, 0, '0.00', 0),
(75, NULL, 'oF0I3447-AIW0OEyJgoWXvTYYghY', NULL, NULL, 1570406756, 0, 1, 0, NULL, 0, '0.00', 0),
(76, NULL, 'oF0I340CArttKGCz993NHLCPBKvc', NULL, NULL, 1571005356, 0, 1, 0, NULL, 0, '0.00', 0),
(77, NULL, 'oF0I347sm3pS-p7v4W3xPyD2ud9Q', NULL, NULL, 1571603900, 0, 1, 0, NULL, 0, '0.00', 0),
(78, NULL, 'oF0I34-6APNmZWEOQBoQp8HkV364', NULL, NULL, 1571801902, 0, 1, 0, NULL, 0, '0.00', 0),
(79, NULL, 'oF0I347g-E3NV1so4ST6KTurV-tE', NULL, NULL, 1572271572, 0, 1, 0, NULL, 0, '0.00', 0),
(80, NULL, 'oF0I34wdgh34Xektu_DzUKueGpVI', NULL, NULL, 1572494774, 0, 1, 0, NULL, 0, '0.00', 0),
(81, NULL, 'oF0I345uXCdvZnl9CtardsV0A4qc', NULL, NULL, 1572824556, 0, 1, 0, NULL, 0, '0.00', 0),
(82, NULL, 'oF0I34zU3qQTujDGhI4wwe2cH9b4', NULL, NULL, 1573113352, 0, 1, 0, NULL, 0, '0.00', 0),
(83, NULL, 'oF0I342nQDN-3BbtllA-ElY00BnI', NULL, NULL, 1573427983, 0, 1, 0, NULL, 0, '0.00', 0),
(84, NULL, 'oF0I346O0DEOiJv1zjRza5Dyg6Xw', NULL, NULL, 1573541628, 0, 1, 0, NULL, 0, '0.00', 0),
(85, NULL, 'oF0I34-312RiO_nzWmiiriTFsAas', NULL, NULL, 1573827955, 0, 1, 0, NULL, 0, '0.00', 0),
(86, NULL, 'oF0I34_7fxp6XP8V9BoaVsxXjNd0', NULL, NULL, 1574024955, 0, 1, 0, NULL, 0, '0.00', 0),
(87, NULL, 'oF0I348rP0qZZNnCW9FMXcqufE5g', NULL, NULL, 1574079029, 0, 1, 0, NULL, 0, '0.00', 0),
(88, NULL, 'oF0I348k5VydGxcABz6TOtgeDdcU', NULL, NULL, 1574628955, 0, 1, 0, NULL, 0, '0.00', 0),
(89, NULL, 'oF0I34wJKZAH923F3rYXXNXXg-Uc', NULL, NULL, 1575243046, 0, 1, 0, NULL, 0, '0.00', 0),
(90, NULL, 'oF0I34xg5345SLtLVdoDoWs16dV4', NULL, NULL, 1575832640, 0, 1, 0, NULL, 0, '0.00', 0),
(91, NULL, 'oF0I344uGsWC3RhYGHx49DsbaB2o', NULL, NULL, 1576326488, 0, 1, 0, NULL, 0, '0.00', 0),
(92, NULL, 'oF0I344dDfmewL33QK5_Y8EX4YHs', NULL, NULL, 1576893807, 0, 1, 0, NULL, 0, '0.00', 0),
(93, NULL, 'oF0I344jdxy4cHL_AtzzNYZ8FczY', NULL, NULL, 1576951449, 0, 1, 0, NULL, 0, '0.00', 0),
(94, NULL, 'oF0I342XXpu6_3dVl2VSmDr33GJM', NULL, NULL, 1577070130, 0, 1, 0, NULL, 0, '0.00', 0),
(95, NULL, 'oF0I349pknDlt-be4lpe8jCBkBP0', NULL, NULL, 1577501289, 0, 1, 0, NULL, 0, '0.00', 0),
(96, NULL, 'oF0I343-yEq3DPvmZpMK8fAd5RdM', NULL, NULL, 1578496560, 0, 1, 0, NULL, 0, '0.00', 0),
(97, NULL, 'oF0I341fTxZAXp1i-ItYMxGHFDjA', NULL, NULL, 1578886771, 0, 1, 0, NULL, 0, '0.00', 0),
(98, NULL, 'oF0I34ylZtWvW2VakXaotLU5PIm0', NULL, NULL, 1579460906, 0, 1, 0, NULL, 0, '0.00', 0),
(99, NULL, 'oF0I34zyWxRmQP0kmElpjcZziJZE', NULL, NULL, 1579471663, 0, 1, 0, NULL, 0, '0.00', 0),
(100, NULL, 'oF0I346Fd_d4hHztIKHp42I18ejI', NULL, NULL, 1579513629, 0, 1, 0, NULL, 0, '0.00', 0),
(101, NULL, 'oF0I345XStpIjp3CdlhLWPySKBQ4', NULL, NULL, 1579648260, 0, 1, 0, NULL, 0, '0.00', 0),
(102, NULL, 'oF0I349vN03SqdbfFHGcQKfZyWLo', NULL, NULL, 1579712733, 0, 1, 0, NULL, 0, '0.00', 0),
(103, NULL, 'oF0I343KCuKndji795LmAHumA894', NULL, NULL, 1580099277, 0, 1, 0, NULL, 0, '0.00', 0),
(104, NULL, 'oF0I34-FtjyQ0cjFAET93DcEHSuA', NULL, NULL, 1580128644, 0, 1, 0, NULL, 0, '0.00', 0),
(105, NULL, 'oF0I341zUxVIarQ6IZa5OA7-RCoc', NULL, NULL, 1580703470, 0, 1, 0, NULL, 0, '0.00', 0),
(106, NULL, 'oF0I343ApFOGcYrl9cIFtsgHaR9A', NULL, NULL, 1580778255, 0, 1, 0, NULL, 0, '0.00', 0),
(107, NULL, 'oF0I3443DMYLYM3JVLlcYoBuhAWQ', NULL, NULL, 1580891116, 0, 1, 0, NULL, 0, '0.00', 0),
(108, NULL, 'oF0I348BPqGi3VUsnR-Dw0iV-zaU', NULL, NULL, 1581065844, 0, 1, 0, NULL, 0, '0.00', 0),
(109, NULL, 'oF0I34w8-TW1l9tPGJXyNra-yOTA', NULL, NULL, 1581270365, 0, 1, 0, NULL, 0, '0.00', 0),
(110, NULL, 'oF0I34814mgMwZlZIFtWG9CaUlvw', NULL, NULL, 1581426478, 0, 1, 0, NULL, 0, '0.00', 0),
(111, NULL, 'oF0I342JOviUD27y-l9pjcN435CE', NULL, NULL, 1581643616, 0, 1, 0, NULL, 0, '0.00', 0),
(112, NULL, 'oF0I34ymJME2VPRrI5NfpsBHrc54', NULL, NULL, 1582516425, 0, 1, 0, NULL, 0, '0.00', 0),
(113, NULL, 'oF0I3419H9bOFTsCynIiy_OZDWc8', NULL, NULL, 1582682037, 0, 1, 0, NULL, 0, '0.00', 0),
(114, NULL, 'oF0I343sePbS0x0xQ0BtpMOS8fhU', NULL, NULL, 1582686461, 0, 1, 0, NULL, 0, '0.00', 0),
(115, NULL, 'oF0I34z_6JjVa06Lm-qgB71T7nCo', NULL, NULL, 1582686906, 0, 1, 0, NULL, 0, '0.00', 0),
(116, NULL, 'oF0I34-PL5KlsotU_jgorIcUD3Mk', NULL, NULL, 1582950924, 0, 1, 0, NULL, 0, '0.00', 0),
(117, NULL, 'oF0I34_iyfZkXHI0fm05avhFsejE', NULL, NULL, 1582971594, 0, 1, 0, NULL, 0, '0.00', 0),
(118, NULL, 'oF0I34yVImuAVlPAtZY5qWmdYYNg', NULL, NULL, 1583226445, 0, 1, 0, NULL, 0, '0.00', 0),
(119, NULL, 'oF0I341CxLTqGAxugtxHekcK1OXU', NULL, NULL, 1583373385, 0, 1, 0, NULL, 0, '0.00', 0),
(120, NULL, 'oF0I34yWnYpXM-NMIiElNj7g9uYg', NULL, NULL, 1583673093, 0, 1, 0, NULL, 0, '0.00', 0),
(121, NULL, 'oF0I348WEUAuGMENQQRFPjjC_IEU', NULL, NULL, 1583689784, 0, 1, 0, NULL, 0, '0.00', 0),
(122, NULL, 'oF0I342c4Tfda3RSr2nCsKELZKlY', NULL, NULL, 1583720220, 0, 1, 0, NULL, 0, '0.00', 0),
(123, NULL, 'oF0I34xabS_Lem4tmO-7aULbT6tU', NULL, NULL, 1583796555, 0, 1, 0, NULL, 0, '0.00', 0),
(124, NULL, 'oF0I34wrgtWW-K_hdYEazHwCHg-w', NULL, NULL, 1583810411, 0, 1, 0, NULL, 0, '0.00', 0),
(125, NULL, 'oF0I3492h3CHwyl0h2U0o4uh9-Xk', NULL, NULL, 1583865264, 0, 1, 0, NULL, 0, '0.00', 0),
(126, NULL, 'oF0I346RujbZeiL5SQgJ0Eb_4U2Y', NULL, NULL, 1583956385, 0, 1, 0, NULL, 0, '0.00', 0),
(127, NULL, 'oF0I343DYTZb1vQ0PaT8iJxPjgEc', NULL, NULL, 1584122719, 0, 1, 0, NULL, 0, '0.00', 0);

-- --------------------------------------------------------

--
-- 表的结构 `x_member_info`
--

CREATE TABLE `x_member_info` (
  `id` int(32) NOT NULL,
  `member_id` int(10) NOT NULL,
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` varchar(500) NOT NULL DEFAULT '' COMMENT 'head',
  `realname` varchar(12) DEFAULT NULL COMMENT '真实姓名',
  `gender` tinyint(1) DEFAULT NULL COMMENT '0:nv;1:nan',
  `region` varchar(64) DEFAULT NULL,
  `email` varchar(24) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `edu` varchar(12) DEFAULT NULL COMMENT 'xueli'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `x_mysession`
--

CREATE TABLE `x_mysession` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `openid` varchar(64) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_time` int(10) DEFAULT '0' COMMENT '登陆过期时间;0:无不限制'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='session表';

--
-- 转存表中的数据 `x_mysession`
--

INSERT INTO `x_mysession` (`id`, `uid`, `openid`, `token`, `expires_time`) VALUES
(1, 1, 'oF0I34xKGNNE5p1pTUG8wtVuBUKI', 'EZWxPi35KG718v0BR4HnrI80NV40Vynf', 1584627098),
(2, 2, 'oF0I345xcE3BEyaJ3UUpsIJbbl8k', 'ytqMpTyTpH192NyUMuGaI3QxjigTxpgX', 1578464371),
(3, 3, 'oF0I34-YYbO-rxVdZIK15pM-81U4', 'hZHkLaMMTprZbVxAFuTSZdw4xU9A7RaI', 1548296690),
(4, 4, 'oF0I34729FScrSJM9AAG7yR86Nvw', 'sAsDr3TSocPFyXEFOYZsYkPrI1IKSF9j', 1555571411),
(5, 5, 'oF0I343oAx8XdExh2JgEaMoPBbaI', 'uVHtZajNpL74tp4V1iKThSUR4aKhQiKi', 1548798368),
(6, 6, 'oF0I347QPIOwzvICK7eva5N1bocs', 'ARNbCOyeiqUFqJPTy8b8vzItGLVUVJyg', 1548512161),
(7, 7, 'oF0I340Ih7Wn_TMUs8EWVIsaF0vM', 'tFuSourznrRqkKbVLF4oIye7E62GJNiB', 1548601761),
(8, 8, 'oF0I348Rg6CxCnCQhpCYuF5FuqT0', 'On9B9ClvUtSqdIIMNYu2UGIQ2Rb6M60U', 1547966369),
(9, 9, 'oF0I34_gGNEjOiXdORLcBinK8tJg', 'cinumaQhXTSw085O0GXsUfCyLLLA349D', 1549223220),
(10, 10, 'oF0I347Bmtw3g2zbxefi7-EicmnQ', '5LKQVKTNezXzcXNJ7VzCZbtMLqFaFG4C', 1551640502),
(11, 11, 'oF0I340mAP6_EchaSsV3HhXTwFJ4', '9bD3ic2LOPkggROY3CV2nC8Ns3pjCwbJ', 1548423162),
(12, 12, 'oF0I341pbkgo4-TFVErj-0yMeN0o', 'hyQrksBdjHsg4iKfOYOUh2CUYwos4fPa', 1551046366),
(13, 13, 'oF0I34whtJT3B6-S4Ews-65FMLkk', 'jphQVuYrg2d4oMLcdO54qPCD1zSBUNf2', 1559785726),
(14, 14, 'oF0I342u9umGeBCVDAAU-adeswUA', 'fvZeWWIcC20pDjamyBnj1tneaZMp9ivp', 1549822789),
(15, 15, 'oF0I345j1DrZRGt06PI907ug0ktg', 'aZChOxwLXYrY9rWie5CecQx11sROj3qp', 1552246174),
(16, 16, 'oF0I34xtmWkrJt3SJXeW_dejK-Uc', 'YSudB6fO1xJyOI4AFTDN3QZPLBeDzqut', 1548248127),
(17, 17, 'oF0I347cBCZg6YHqJMLYgxIqeU2c', '9xxzWvfiwkAed0fcbEhC5shIAp174KIR', 1549712675),
(18, 18, 'oF0I345fz4pIRH-KQIj1Lq6SiEVQ', '8ozpUDtCllxKoglHkpDj9HpCfdIPfQVL', 1550429449),
(19, 19, 'oF0I34y7QISbQI3B_UrZb4syWh7s', 'AzkYGTSr3nM5B9arYYSgKaJs0IPWRYXz', 1550543028),
(20, 20, 'oF0I34-02YNGdmrp9vuB62jJ-wt4', '9kD6HL8Y4cyQYugQL0RgAlCmN8ehvqt2', 1550754335),
(21, 21, 'oF0I342bhGlmJznZKRIugwSdF35s', '6yIEBjOsuvrAROCadfOglW38dIt0A5XS', 1552854526),
(22, 22, 'oF0I34wr3bwdHuwRm8VdKVXOYJac', 'bMYuq5P1Oca7R02TXy83SQRYiZTqQr1z', 1553232431),
(23, 23, 'oF0I34wS5-3B6tpSKtT9yhWBA9_o', 'e2bTDp4xzzWp1Oe5TqXI6vWP3tKtmEMb', 1553477916),
(24, 24, 'oF0I346yNXY051Eh99N1UtbDj0sY', 'k0yqHi3dJY8zJJd1zhD3wl4v81oKfLYk', 1554069279),
(25, 25, 'oF0I344NlH7Zp7SSt7-GVxb1QcHI', 'nnD4norDD6z3hsiPaWII4i5UYJvYHuol', 1554670606),
(26, 26, 'oF0I34zTs7FHf9nngbhtZALlF4Hc', 'NMVNibxMyTzJ7sBAXxjS2dAglwkrj9HV', 1555269903),
(27, 27, 'oF0I34woMLWRUepvqGb0AB2Kz0-I', 'xuF5XflKVKBKT6dNkqIEfomIa9AZkxdB', 1555876723),
(28, 28, 'oF0I341IPpRjtYfpr2_sTEHl32iE', 'JSHaZkbcK83zRJzZE9GiacYRtsMJBmEy', 1556353389),
(29, 29, 'oF0I34zs2g06720sswZ_a_143lnc', 'UpPcRRp2gXvxHlHP9CkTSlF04yRowkWX', 1556446795),
(30, 30, 'oF0I34wD_qnt0kuTUMpk4t9QkC1A', 'cZOTIScv7aKxTgXdQrdte8quhcTktS0T', 1556484974),
(31, 31, 'oF0I346-ywfd3y5e5-z-5dSfVj44', 'wjoowi29Vh17yFRYsAAHldWZ34uhQjOj', 1557125453),
(32, 32, 'oF0I34-V4LBu3K7lqqpgyqR6394M', 'oiEenpeXnCP05r3E7rNcL6RTGbxsDBMS', 1557690605),
(33, 33, 'oF0I34y209BLj997XBqENvUV1EGY', 'fZ752HPP0WJB1mwcGug8n0063BWRA8ST', 1574968359),
(34, 34, 'oF0I340pi3-Vpcxb_KAIfnASe0DM', 'iT1Lcj9oTAGLtmCuFvN9nhQPlwtdf3JZ', 1558299287),
(35, 35, 'oF0I343Ok2aFapkR13POfZZsPYUw', 'JSl94FTYP58kgeuCnyBucQAIbPIpSo1x', 1558902668),
(36, 36, 'oF0I34yubdu59F5rWwhw4C7uNCIE', 'M3l843CvH6bllImxaPAWxwiBJWvkM1vG', 1559536357),
(37, 37, 'oF0I349EtVHXn5BJglHCNFa8eb8M', 'nYPOjkXZ4p3sMtBoL9fjUY5PfctdxLnV', 1568105574),
(38, 38, 'oF0I340Ys4R2geCQU2RZg43uYyOI', 'HXnlB9mNIlqF3IrBkMN7x3m8yWIglrTo', 1560102755),
(39, 39, 'oF0I34yJ2HC9LrAx_EoPqvAzMtYs', 'KoPbICpIF00hz1o3blVNkkl3zkxQuPyG', 1560126664),
(40, 40, 'oF0I34xHMQrsw7wVixkSqrkTw_iM', 'RHeqWuQRrUdaxHb7xTCsXuK3nZwq3kpY', 1560719364),
(41, 41, 'oF0I34y8TTL52wbphyKolZpOJR5Y', 'BLCj17kO8IlJv0g9So3UtldvLLwS08Z1', 1561323422),
(42, 42, 'oF0I34xIchlLQzgL02tUp5okXZxw', 'FLHG4asHLpU5JkoLuwl3pmqgcKiMakzQ', 1561345134),
(43, 43, 'oF0I345lhHviZFQ6nfXEew5owusw', 'uNIQy52Kq1zvCdsbKYaAG2rK08BUfqeN', 1561606604),
(44, 44, 'oF0I3433PiAM8Gu49BOm9eH_M1aA', 'NyCS7q3NGWxP8fiuQ5iM8dCHRXGec4IH', 1561918794),
(45, 45, 'oF0I342LCtp38UWZTajeaLxUNZ38', 'emT9ESnxwjahdL19CkyITZg2no39mCU0', 1562538584),
(46, 46, 'oF0I343aO6rrmzWE3R1RJzw89JFU', 'HgMUeGHLLh7QbnMZEyGtlGWquPxO7tzU', 1563134434),
(47, 47, 'oF0I34wTtwPbvc9bMP-HUWT9C3gI', 'fJAa7LQ4tu9PvqlaVgH8Fn8IeVii89e5', 1563733514),
(48, 48, 'oF0I34xrDln1ZLlnNMn52OCT7uKE', 'JEdwlIYf3q8MCB2P47YWQRA5sfNpUnAj', 1564346528),
(49, 49, 'oF0I341OZOnJRt3D7s-ov2KloM4g', 'TvBrMFQbJ6kK1Joecdx53na2QSYz3qae', 1564721244),
(50, 50, 'oF0I34wfTqWZaP98fYGDKDgq8gnE', 'F5A52d2I5l7Hnw7W83eSA2KM0grjxV4a', 1564907976),
(51, 51, 'oF0I34zUGjugiHHAbFXm1LDeQVxI', 'YdqGJM3XyGSpiUf7fEFdRN6ZL9xdC02A', 1564953535),
(52, 52, 'oF0I34zRjQuMO_5OIVwpNaUSrgsc', 'zrjk64PuiOzwuGol7ymO9SLpLiULYerR', 1564994676),
(53, 53, 'oF0I343gZwb6omEvnu875AUWSH-M', 'qOqyObF8R9jvokLbNlgLyQ9iDTq1gEli', 1565098179),
(54, 54, 'oF0I3443Xz3YEJuxWutLQmtkG8To', 'lBJlc4V22PV4OiLKtps8Ru5jldWcAlcf', 1565558218),
(55, 55, 'oF0I342acPMyhbNhw6-n8b8nJ3tU', 'H9DXih4cyyP10jlnDNDRyeC498GT2nvV', 1566127478),
(56, 56, 'oF0I3494aiylDMfly581tSxUhVPU', 'KOAvPG1TfrplBMBdgoh94yjjWa9Cq36R', 1566168548),
(57, 57, 'oF0I349hyoYiNrXHoeU1tPMPkUVM', 'UrkEIMbDHMAOQE99bwWMuKtGU4YxdqbU', 1566217662),
(58, 58, 'oF0I345Xk2mpCTuKzuNCZbOcDot0', 'obabktWOP6SQzOkqkzJ89U3r2eA6hhox', 1566788708),
(59, 59, 'oF0I34-cKbbw5BeN43ab8sELfMUQ', 'plzfri3EYyJWDSg5tAlvky8nB6E3UFYi', 1567135205),
(60, 60, 'oF0I349qU8Jh9Ij2XiHa_gsjBv48', 'Sy1wj1S0WtBbuVonmOWdNKGRbDf2DVM7', 1567382184),
(61, 61, 'oF0I3451YEVknW7wY4r5QQ_Enbg8', 'NWiY5vWLmNHWpor4QpSmlVdPIu1IWYNu', 1567429840),
(62, 62, 'oF0I34xDTSJR3ImBcdM-aAz_nx9c', 'DUGj0c4FBK9vlwyTIJtaE72XErp87hMZ', 1573904987),
(63, 63, 'oF0I346a_OpzjICmohqNvxmXMV1A', '7DHoJKjuZGbE4qI2DpzDSvM3RdeY2uaN', 1567824978),
(64, 64, 'oF0I34_R6zRX3Bh_UA_QqiwvhP34', 'VmPFJWOJqVbn1vFUtQUq57bFgoMOd1p0', 1567989366),
(65, 65, 'oF0I343jEwKgdyFcICViTIN7GlWs', 'lQZk43nAn525CQkDKPSzqEJxcsLUpgQ8', 1568131822),
(66, 66, 'oF0I34_5iwraLFNUwzeDytfWpH_g', 'deXmZBzqVMlr4V3BJhe9geR3Og7iuolL', 1568572019),
(67, 67, 'oF0I34xs6tPbCFnEudwBZ63-atYA', 'YCtTGGZdrSekhmtWOl5s6bbU1yCNsSvz', 1568722676),
(68, 68, 'oF0I3436CtdzX3B1mY0NCRgAGndA', 'SL1mKvuG9KdlymkNPK9E1Ru6nx4ApIlA', 1569182492),
(69, 69, 'oF0I34wDWeydo-OprPsUK1U6hFJY', 'JIm6yqIs4OxgXMxqRlMCEnC5oZHErPsZ', 1569223529),
(70, 70, 'oF0I34-alU6NEFXxm18vB7ft9oNY', 'WUFl7HbzHtG8gdqC8znfeHLVkK3H42Ko', 1569315595),
(71, 71, 'oF0I34-_bgNB6ox5WSaYJrNrj0ps', 'fG6DfDdGJW5l1FfTx5njMpPNLHMrBwNm', 1569553700),
(72, 72, 'oF0I344aswrXMBeCvFeKuvVzBG04', 'p5uP0n6LkAar4O64mWzxhID2m1ZHyWwy', 1569582463),
(73, 73, 'oF0I340rEZwsKPBSj7Yb8xFxoenw', '0bJfrXkqVdgVocmxFUQM45Bg3CgqUDcr', 1569887848),
(74, 74, 'oF0I349lZgYR7PudpADORLhs__hw', 'jhrR7jMTCH4tQpWdkjLB3cTXVaYlyvWt', 1570413200),
(75, 75, 'oF0I3447-AIW0OEyJgoWXvTYYghY', '7qo8Wi4MAlj3Vtt6xH4DJlBQuaZYl5wz', 1571011556),
(76, 76, 'oF0I340CArttKGCz993NHLCPBKvc', 'nqTCjkwlcEmL5sYWAif86xeUf3jlYtH5', 1571610156),
(77, 77, 'oF0I347sm3pS-p7v4W3xPyD2ud9Q', 'Au1T5XwzJeb0A70gt5sv5g36sC5QO88U', 1572208700),
(78, 78, 'oF0I34-6APNmZWEOQBoQp8HkV364', '1s4bZ1VhJUECiLtrzY4ZyEo5UrY9KCBA', 1574610891),
(79, 79, 'oF0I347g-E3NV1so4ST6KTurV-tE', '8Ww9S9QidUgVZ2L9xcZQg9Q33YdEJfvr', 1572876372),
(80, 80, 'oF0I34wdgh34Xektu_DzUKueGpVI', 'Ru38qDfMkFAOpMEgbQR9y56FYBoLitF0', 1573099590),
(81, 81, 'oF0I345uXCdvZnl9CtardsV0A4qc', 'YNVZvhp28t0zQtysDrqHTsgwL3ngnn9N', 1573429356),
(82, 82, 'oF0I34zU3qQTujDGhI4wwe2cH9b4', '5hkk7A6KGZuGkyl5gJ3yT5c5t8GLkPXz', 1573718167),
(83, 83, 'oF0I342nQDN-3BbtllA-ElY00BnI', 'PPgDl4V0lribJ9p6SXPIDEnuKqTHkeCZ', 1574032783),
(84, 84, 'oF0I346O0DEOiJv1zjRza5Dyg6Xw', 'Q7x35DMAwl8iHe4ny2514EYmzfaKqRww', 1574146428),
(85, 85, 'oF0I34-312RiO_nzWmiiriTFsAas', 'ZrldAbKyelTrREJnSWiW1J4UVya7cCs4', 1574432755),
(86, 86, 'oF0I34_7fxp6XP8V9BoaVsxXjNd0', 'K9n6zFHghz98zxd86PMf0boFmKD2jvwz', 1574629755),
(87, 87, 'oF0I348rP0qZZNnCW9FMXcqufE5g', 'GV4pDGFACfgfBMoje7jGdTlIE3cg4JLx', 1574683829),
(88, 88, 'oF0I348k5VydGxcABz6TOtgeDdcU', 'UfxlKAgQBu8R6ZFb8NHgOBTw7OowGbzc', 1575233755),
(89, 89, 'oF0I34wJKZAH923F3rYXXNXXg-Uc', 'Y0mX4kbjI3OTlBsCHRfLp4VIzOH6NAaK', 1575847846),
(90, 90, 'oF0I34xg5345SLtLVdoDoWs16dV4', 'fY17iyUvs3JtAB8r8vZyvY0KVTsUF5Dv', 1576437440),
(91, 91, 'oF0I344uGsWC3RhYGHx49DsbaB2o', 'YwATJ1XlpjQyPRvQD03FptTbOeWU3FdB', 1576931288),
(92, 92, 'oF0I344dDfmewL33QK5_Y8EX4YHs', 'ewtqWseslv4JTaucbFNntYgRK5Wssmbr', 1577498607),
(93, 93, 'oF0I344jdxy4cHL_AtzzNYZ8FczY', 'zIyaVtwCr9oWR2DQT2haHSnN1JRrlUFA', 1577556249),
(94, 94, 'oF0I342XXpu6_3dVl2VSmDr33GJM', 'dCdmsBU5paaEBbcQmVDhXRz29toUpdGL', 1577674930),
(95, 95, 'oF0I349pknDlt-be4lpe8jCBkBP0', '1c7pCDBBjuoTINBNSV3oQxZ2TCauaAUj', 1578150396),
(96, 96, 'oF0I343-yEq3DPvmZpMK8fAd5RdM', '7w8Xs03t9zplZCPqXgydFFstiRI1q2sr', 1579101360),
(97, 97, 'oF0I341fTxZAXp1i-ItYMxGHFDjA', '0tDnCcPjnz6z7TtmQDcs5o89HlIKnIF4', 1579491571),
(98, 98, 'oF0I34ylZtWvW2VakXaotLU5PIm0', 'r9Mkg5lKOIMVvnk8D2doTnWRGzNPrALL', 1580065719),
(99, 99, 'oF0I34zyWxRmQP0kmElpjcZziJZE', 'reZdP3dzONNuFIrSvRxMzwbKF2rDDSPM', 1580076463),
(100, 100, 'oF0I346Fd_d4hHztIKHp42I18ejI', 'PzP2MEdLqQ4S7ShT1h2Lh95xuMnN26dL', 1580118442),
(101, 101, 'oF0I345XStpIjp3CdlhLWPySKBQ4', 'c1OYaEiKHb1zpHe2COh0SOrKbNepOBRU', 1580253060),
(102, 102, 'oF0I349vN03SqdbfFHGcQKfZyWLo', 'lsYDGmOogsvRgCCg2EQnA7HrrAxuD1qp', 1580317534),
(103, 103, 'oF0I343KCuKndji795LmAHumA894', 'NMGVi2ZNh5MkKrl2w9EAheHAA3kjTVFM', 1580704077),
(104, 104, 'oF0I34-FtjyQ0cjFAET93DcEHSuA', 'yGh1qUY4dY5bAs4fBopblmKuDTSLUjic', 1580733444),
(105, 105, 'oF0I341zUxVIarQ6IZa5OA7-RCoc', 'mb3m3i8lUBsFK2Lxnzgjh92hlG2UKHtu', 1581308270),
(106, 106, 'oF0I343ApFOGcYrl9cIFtsgHaR9A', 'He9iRnEFcH5JqTk2Is5GNeLkuRuBZrmX', 1581383055),
(107, 107, 'oF0I3443DMYLYM3JVLlcYoBuhAWQ', '3yw13LwnXu41g3bbz8sGXkm65DE9BDhK', 1583050986),
(108, 108, 'oF0I348BPqGi3VUsnR-Dw0iV-zaU', '7dFqupvnOubX5egt7j86iaZwJrpMUBv2', 1581670644),
(109, 109, 'oF0I34w8-TW1l9tPGJXyNra-yOTA', 'ZwL4cGWw2znSrL7YCwPzX2crC1ysR2vD', 1581875165),
(110, 110, 'oF0I34814mgMwZlZIFtWG9CaUlvw', 'u3C1Co5idToehHftVqk4xlOxB52KK3Vp', 1582031278),
(111, 111, 'oF0I342JOviUD27y-l9pjcN435CE', 'saM0Iwt4WWnBJvNl4xa94kL8MJYiPlAe', 1582248416),
(112, 112, 'oF0I34ymJME2VPRrI5NfpsBHrc54', 'TSyNwOFPPh9J3vIvLAoAogzbY6C90jnp', 1583121225),
(113, 113, 'oF0I3419H9bOFTsCynIiy_OZDWc8', 'Ls8Bq9zyc7zcswXa9cULK0U5FJfaA1tR', 1583286837),
(114, 114, 'oF0I343sePbS0x0xQ0BtpMOS8fhU', '2Liv69HTq74AAlKT0n9er7A9Y4rcqLaL', 1583291261),
(115, 115, 'oF0I34z_6JjVa06Lm-qgB71T7nCo', 'JQ35rdZ48JaaDHMieylNXLZtgBa2M1UG', 1583291706),
(116, 116, 'oF0I34-PL5KlsotU_jgorIcUD3Mk', 'cJ2GhVGlGzoTrVixqDhBh0RgxbaRGIiG', 1583555724),
(117, 117, 'oF0I34_iyfZkXHI0fm05avhFsejE', 'J7NqoUUzlTG6BZahaf7689dRJX3QItGy', 1583576394),
(118, 118, 'oF0I34yVImuAVlPAtZY5qWmdYYNg', 'F0NfRrjGbMCYD0I9LU7vtnSVTQUb7KPV', 1583831245),
(119, 119, 'oF0I341CxLTqGAxugtxHekcK1OXU', 'XBDvfI6xTDiuBTJOZsdIGczLstXUMiey', 1584892606),
(120, 120, 'oF0I34yWnYpXM-NMIiElNj7g9uYg', 'EYXTbjAOMdPVyuErKNQTe83LjU960PF9', 1584322060),
(121, 121, 'oF0I348WEUAuGMENQQRFPjjC_IEU', 'X2M15nbYu41y20RPTy6KwnreCacVqLeg', 1584294584),
(122, 122, 'oF0I342c4Tfda3RSr2nCsKELZKlY', 'X5boaDbcV5kxTd76Tpgty9p4rRA3PezG', 1584325020),
(123, 123, 'oF0I34xabS_Lem4tmO-7aULbT6tU', 'hjWGL6w202CJE8eU3au4aowmRasYNHHO', 1584401356),
(124, 124, 'oF0I34wrgtWW-K_hdYEazHwCHg-w', 'yopvg6TwyOtzftHN8uZzDcLeA70xTtge', 1584415211),
(125, 125, 'oF0I3492h3CHwyl0h2U0o4uh9-Xk', 'Kfw3Hv9PjKgywJ4RTXo0NnqMsSlvRNPa', 1584470065),
(126, 126, 'oF0I346RujbZeiL5SQgJ0Eb_4U2Y', 'dAl3c3xRt3IGx0qUUwwqsg1BwAeVmeGS', 1584561186),
(127, 127, 'oF0I343DYTZb1vQ0PaT8iJxPjgEc', 'O2QVb6baRI3pRBrA0OUbzDhm93zIH3uV', 1584727520);

-- --------------------------------------------------------

--
-- 表的结构 `x_my_goods`
--

CREATE TABLE `x_my_goods` (
  `id` int(10) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1:专栏;2:课程;3:测试;4:线下预约',
  `member_id` int(10) NOT NULL COMMENT '会员id',
  `pro_id` int(10) NOT NULL,
  `buy_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_time` int(10) UNSIGNED DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) UNSIGNED DEFAULT NULL COMMENT '到期时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='我的商品';

--
-- 转存表中的数据 `x_my_goods`
--

INSERT INTO `x_my_goods` (`id`, `type`, `member_id`, `pro_id`, `buy_time`, `start_time`, `end_time`) VALUES
(1, 2, 1, 1, '2019-01-10 02:06:18', NULL, NULL),
(2, 2, 2, 1, '2019-01-10 02:23:10', NULL, NULL),
(3, 3, 1, 1, '2019-01-10 11:35:57', NULL, NULL),
(4, 3, 3, 1, '2019-01-10 11:45:42', NULL, NULL),
(5, 2, 3, 5, '2019-01-15 07:19:16', NULL, NULL),
(6, 2, 4, 1, '2019-01-15 07:19:40', NULL, NULL),
(7, 2, 1, 5, '2019-01-15 07:30:23', NULL, NULL),
(8, 2, 3, 1, '2019-01-15 11:37:34', NULL, NULL),
(9, 2, 4, 5, '2019-01-15 12:11:37', NULL, NULL),
(10, 2, 33, 5, '2019-05-12 16:48:35', NULL, NULL),
(11, 2, 78, 5, '2019-10-23 03:40:30', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `x_news`
--

CREATE TABLE `x_news` (
  `id` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `title` varchar(36) NOT NULL DEFAULT '',
  `img` varchar(64) DEFAULT NULL,
  `source` varchar(200) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `origin` varchar(12) NOT NULL DEFAULT '',
  `click` int(10) NOT NULL DEFAULT '0',
  `keywords` varchar(200) NOT NULL DEFAULT '',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '摘要',
  `content` text NOT NULL,
  `recommend` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(64) NOT NULL DEFAULT '' COMMENT '外链',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `x_news`
--

INSERT INTO `x_news` (`id`, `cid`, `title`, `img`, `source`, `create_time`, `origin`, `click`, `keywords`, `description`, `content`, `recommend`, `url`, `status`) VALUES
(1, 2, '叶问三经典打斗片段', 'ea219151e858fb5048e1e1cecda3a5bf.jpg', 'jw.mp4', '2018-12-24 10:12:23', '', 0, '', '《叶问3》是《叶问》系列电影的第三部，讲述了一位豪杰叶问落入种种困境后通过自强不息最终成为一代宗师历程的故事', '<p>《叶问3》是《叶问》系列电影的第三部，讲述了一位豪杰叶问落入种种困境后通过自强不息最终成为一代宗师历程的故事</p>', 0, '', 1),
(2, 2, '叶问3混剪', '7155cf5abed2df20e64c02317e8cf783.jpg', '叶问3混剪.mp4', '2019-01-09 08:05:52', '', 0, '', '叶问3', '', 0, '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `x_orders`
--

CREATE TABLE `x_orders` (
  `id` int(10) NOT NULL,
  `order_num` varchar(64) NOT NULL DEFAULT '',
  `trade_num` varchar(128) NOT NULL DEFAULT '' COMMENT '交易号',
  `member_id` int(10) NOT NULL,
  `pro_id` int(10) DEFAULT NULL,
  `org_id` int(10) DEFAULT NULL COMMENT '所属机构',
  `teacher_id` int(10) DEFAULT NULL COMMENT '所属讲师',
  `order_type` tinyint(1) NOT NULL COMMENT '1:专栏;2:课程;3:测试;4:线下预约;5:礼品包',
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `goods` varchar(500) NOT NULL COMMENT '商品信息',
  `deduction` varchar(500) DEFAULT NULL COMMENT '扣除明细',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pay_time` varchar(20) DEFAULT '' COMMENT '支付时间',
  `pay_way` varchar(24) NOT NULL DEFAULT '' COMMENT '支付途径',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0已删除,1未支付;2:已支付'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `x_orders`
--

INSERT INTO `x_orders` (`id`, `order_num`, `trade_num`, `member_id`, `pro_id`, `org_id`, `teacher_id`, `order_type`, `amount`, `goods`, `deduction`, `create_time`, `pay_time`, `pay_way`, `status`) VALUES
(1, '15470859630000001425', '4200000247201901102394340424', 1, 1, 1, NULL, 2, '0.01', 'a:1:{i:0;a:5:{s:6:\"pro_id\";s:1:\"1\";s:8:\"pro_type\";s:1:\"2\";s:8:\"pro_name\";s:12:\"测试课程\";s:9:\"pro_price\";s:4:\"0.02\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/8462add546a294343d06842861dd43cd.jpg\";}}', NULL, '2019-01-10 02:06:03', '20190110100617', '', 2),
(2, '15470869840000002308', '4200000258201901102230352263', 2, 1, 1, NULL, 2, '0.01', 'a:1:{i:0;a:5:{s:6:\"pro_id\";s:1:\"1\";s:8:\"pro_type\";s:1:\"2\";s:8:\"pro_name\";s:12:\"测试课程\";s:9:\"pro_price\";s:4:\"0.02\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/8462add546a294343d06842861dd43cd.jpg\";}}', NULL, '2019-01-10 02:23:04', '20190110102309', '', 2),
(3, '15471181360000001239', '', 1, 1, NULL, NULL, 3, '0.03', 'a:1:{i:0;a:5:{s:6:\"pro_id\";s:1:\"1\";s:8:\"pro_type\";s:1:\"3\";s:8:\"pro_name\";s:18:\"在线预约课程\";s:9:\"pro_price\";s:4:\"0.03\";s:9:\"pro_thumb\";s:49:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/\";}}', NULL, '2019-01-10 11:02:16', '', '', 1),
(4, '15471198580000001980', '', 1, 1, NULL, NULL, 3, '0.03', 'a:1:{i:0;a:5:{s:6:\"pro_id\";s:1:\"1\";s:8:\"pro_type\";s:1:\"3\";s:8:\"pro_name\";s:18:\"在线预约课程\";s:9:\"pro_price\";s:4:\"0.03\";s:9:\"pro_thumb\";s:49:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/\";}}', NULL, '2019-01-10 11:30:58', '', '', 1),
(5, '15471199100000001734', '', 1, 1, NULL, NULL, 3, '0.03', 'a:1:{i:0;a:5:{s:6:\"pro_id\";s:1:\"1\";s:8:\"pro_type\";s:1:\"3\";s:8:\"pro_name\";s:18:\"在线预约课程\";s:9:\"pro_price\";s:4:\"0.03\";s:9:\"pro_thumb\";s:49:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/\";}}', NULL, '2019-01-10 11:31:50', '', '', 1),
(6, '15471199710000001345', '', 1, 1, NULL, NULL, 3, '0.03', 'a:1:{i:0;a:5:{s:6:\"pro_id\";s:1:\"1\";s:8:\"pro_type\";s:1:\"3\";s:8:\"pro_name\";s:18:\"在线预约课程\";s:9:\"pro_price\";s:4:\"0.03\";s:9:\"pro_thumb\";s:49:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/\";}}', NULL, '2019-01-10 11:32:51', '', '', 1),
(7, '15471201440000001470', '4200000257201901109227411976', 1, 1, 1, NULL, 3, '0.01', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:1;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:18:\"在线预约课程\";s:9:\"pro_price\";s:4:\"0.03\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/ff4bb2726e9c907dac30789c8ad299b8.jpg\";}}', NULL, '2019-01-10 11:35:44', '20190110193556', '', 2),
(8, '15471205700000003813', '', 3, 1, 1, NULL, 3, '0.01', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:1;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:18:\"在线预约课程\";s:9:\"pro_price\";s:4:\"0.03\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/ff4bb2726e9c907dac30789c8ad299b8.jpg\";}}', NULL, '2019-01-10 11:42:50', '', '', 1),
(9, '15471207370000003128', '4200000239201901103793204084', 3, 1, 1, NULL, 3, '0.01', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:1;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:18:\"在线预约课程\";s:9:\"pro_price\";s:4:\"0.03\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/ff4bb2726e9c907dac30789c8ad299b8.jpg\";}}', NULL, '2019-01-10 11:45:37', '20190110194541', '', 2),
(10, '15473074660000007171', '', 7, 1, 1, NULL, 3, '0.01', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:1;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班一期\";s:9:\"pro_price\";s:4:\"0.03\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/ff4bb2726e9c907dac30789c8ad299b8.jpg\";}}', NULL, '2019-01-12 15:37:46', '', '', 1),
(11, '15474323510000009161', '', 9, 1, 1, NULL, 3, '0.08', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:1;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班一期\";s:9:\"pro_price\";s:4:\"8.80\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/99dbae91b6c479c9a1d0960226c0d351.png\";}}', NULL, '2019-01-14 02:19:11', '', '', 1),
(12, '15475367480000003573', '4200000240201901159923836556', 3, 5, 1, NULL, 2, '8.88', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:5;s:8:\"pro_type\";i:2;s:8:\"pro_name\";s:25:\"木人桩_完整套路篇\";s:9:\"pro_price\";s:4:\"8.88\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/85d2a3fd0423d2e01348b8383cef77fa.png\";}}', NULL, '2019-01-15 07:19:08', '20190115151915', '', 2),
(13, '15475367730000004348', '4200000252201901152615727040', 4, 1, 1, NULL, 2, '0.01', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:1;s:8:\"pro_type\";i:2;s:8:\"pro_name\";s:28:\"木人桩_散桩练习课程\";s:9:\"pro_price\";s:4:\"8.88\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/95b03a075189896b98950aa6b27f6119.png\";}}', NULL, '2019-01-15 07:19:33', '20190115151939', '', 2),
(14, '15475374170000001103', '4200000249201901159836446395', 1, 5, 1, NULL, 2, '0.01', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:5;s:8:\"pro_type\";i:2;s:8:\"pro_name\";s:25:\"木人桩_完整套路篇\";s:9:\"pro_price\";s:4:\"8.88\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/85d2a3fd0423d2e01348b8383cef77fa.png\";}}', NULL, '2019-01-15 07:30:17', '20190115153023', '', 2),
(15, '15475397070000003058', '', 3, 1, 1, NULL, 2, '0.01', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:1;s:8:\"pro_type\";i:2;s:8:\"pro_name\";s:28:\"木人桩_散桩练习课程\";s:9:\"pro_price\";s:4:\"8.88\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/95b03a075189896b98950aa6b27f6119.png\";}}', NULL, '2019-01-15 08:08:27', '', '', 1),
(16, '15475522470000003292', '4200000257201901153211450499', 3, 1, 1, NULL, 2, '0.01', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:1;s:8:\"pro_type\";i:2;s:8:\"pro_name\";s:28:\"木人桩_散桩练习课程\";s:9:\"pro_price\";s:4:\"8.88\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/95b03a075189896b98950aa6b27f6119.png\";}}', NULL, '2019-01-15 11:37:27', '20190115193734', '', 2),
(17, '15475538190000001014', '', 1, 2, 1, NULL, 3, '9.90', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:2;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班二期\";s:9:\"pro_price\";s:4:\"9.90\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/5ad7f6dce8797a62f9754aa2164932ba.png\";}}', NULL, '2019-01-15 12:03:39', '', '', 1),
(18, '15475542920000004651', '4200000254201901158106735621', 4, 5, 1, NULL, 2, '0.01', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:5;s:8:\"pro_type\";i:2;s:8:\"pro_name\";s:25:\"木人桩_完整套路篇\";s:9:\"pro_price\";s:4:\"8.88\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/85d2a3fd0423d2e01348b8383cef77fa.png\";}}', NULL, '2019-01-15 12:11:32', '20190115201137', '', 2),
(19, '15476917290000001629', '', 1, 2, 1, NULL, 3, '9.90', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:2;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班二期\";s:9:\"pro_price\";s:4:\"9.90\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/5ad7f6dce8797a62f9754aa2164932ba.png\";}}', NULL, '2019-01-17 02:22:09', '', '', 1),
(20, '15476917340000001759', '', 1, 2, 1, NULL, 3, '9.90', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:2;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班二期\";s:9:\"pro_price\";s:4:\"9.90\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/5ad7f6dce8797a62f9754aa2164932ba.png\";}}', NULL, '2019-01-17 02:22:14', '', '', 1),
(21, '15476917450000001997', '', 1, 2, 1, NULL, 3, '9.90', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:2;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班二期\";s:9:\"pro_price\";s:4:\"9.90\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/5ad7f6dce8797a62f9754aa2164932ba.png\";}}', NULL, '2019-01-17 02:22:25', '', '', 1),
(22, '15476917700000001234', '', 1, 2, 1, NULL, 3, '9.90', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:2;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班二期\";s:9:\"pro_price\";s:4:\"9.90\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/5ad7f6dce8797a62f9754aa2164932ba.png\";}}', NULL, '2019-01-17 02:22:50', '', '', 1),
(23, '15476917860000001948', '', 1, 2, 1, NULL, 3, '9.90', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:2;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班二期\";s:9:\"pro_price\";s:4:\"9.90\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/5ad7f6dce8797a62f9754aa2164932ba.png\";}}', NULL, '2019-01-17 02:23:06', '', '', 1),
(24, '15476918300000001985', '', 1, 2, 1, NULL, 3, '9.90', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:2;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班二期\";s:9:\"pro_price\";s:4:\"9.90\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/5ad7f6dce8797a62f9754aa2164932ba.png\";}}', NULL, '2019-01-17 02:23:50', '', '', 1),
(25, '15476918910000001391', '', 1, 2, 1, NULL, 3, '9.90', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:2;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班二期\";s:9:\"pro_price\";s:4:\"9.90\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/5ad7f6dce8797a62f9754aa2164932ba.png\";}}', NULL, '2019-01-17 02:24:51', '', '', 1),
(27, '15477114100000001970', '', 1, 2, 1, NULL, 3, '9.90', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:2;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班二期\";s:9:\"pro_price\";s:4:\"9.90\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/5ad7f6dce8797a62f9754aa2164932ba.png\";}}', NULL, '2019-01-17 07:50:10', '', '', 1),
(28, '15477153320000001581', '', 1, 2, 1, NULL, 3, '9.90', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:2;s:8:\"pro_type\";i:3;s:8:\"pro_name\";s:21:\"精英特训班二期\";s:9:\"pro_price\";s:4:\"9.90\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/5ad7f6dce8797a62f9754aa2164932ba.png\";}}', NULL, '2019-01-17 08:55:32', '', '', 1),
(29, '15557486440000028840', '', 28, 5, 1, NULL, 2, '8.88', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:5;s:8:\"pro_type\";i:2;s:8:\"pro_name\";s:25:\"木人桩_完整套路篇\";s:9:\"pro_price\";s:4:\"8.88\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/85d2a3fd0423d2e01348b8383cef77fa.png\";}}', NULL, '2019-04-20 08:24:04', '', '', 1),
(30, '15576796890000033942', '4200000294201905130983320334', 33, 5, 1, NULL, 2, '8.88', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:5;s:8:\"pro_type\";i:2;s:8:\"pro_name\";s:25:\"木人桩_完整套路篇\";s:9:\"pro_price\";s:4:\"8.88\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/85d2a3fd0423d2e01348b8383cef77fa.png\";}}', NULL, '2019-05-12 16:48:09', '20190513004833', '', 2),
(31, '15665304780000059756', '', 59, 1, 1, NULL, 2, '8.88', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:1;s:8:\"pro_type\";i:2;s:8:\"pro_name\";s:28:\"木人桩_散桩练习课程\";s:9:\"pro_price\";s:4:\"8.88\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/95b03a075189896b98950aa6b27f6119.png\";}}', NULL, '2019-08-23 03:21:18', '', '', 1),
(32, '15718020100000078518', '4200000404201910233383352807', 78, 5, 1, NULL, 2, '8.88', 'a:1:{i:0;a:5:{s:6:\"pro_id\";i:5;s:8:\"pro_type\";i:2;s:8:\"pro_name\";s:25:\"木人桩_完整套路篇\";s:9:\"pro_price\";s:4:\"8.88\";s:9:\"pro_thumb\";s:85:\"http://www.xinzhinetwork.com/gongfu/Upload/thumb/85d2a3fd0423d2e01348b8383cef77fa.png\";}}', NULL, '2019-10-23 03:40:10', '20191023114029', '', 2);

-- --------------------------------------------------------

--
-- 表的结构 `x_org`
--

CREATE TABLE `x_org` (
  `id` int(10) NOT NULL,
  `name` varchar(64) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logo` varchar(64) NOT NULL DEFAULT '',
  `tel` varchar(50) DEFAULT NULL,
  `addr` varchar(64) DEFAULT NULL,
  `contact` varchar(24) DEFAULT NULL,
  `introduce` text,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='机构';

--
-- 转存表中的数据 `x_org`
--

INSERT INTO `x_org` (`id`, `name`, `create_time`, `logo`, `tel`, `addr`, `contact`, `introduce`, `status`) VALUES
(1, '长辰功夫', '2018-12-23 19:44:17', '74de386520e43ae9edf31bcf55d962ee.png', '0760', '广东省中山市', '谢师傅', '<p>资料更新中……</p><p><img src=\"/gongfu/Upload/images/20190112/1547231670744087.jpg\" title=\"1547231670744087.jpg\" alt=\"137468447_15369673783731n.jpg\"/></p>', 1);

-- --------------------------------------------------------

--
-- 表的结构 `x_payresult_log`
--

CREATE TABLE `x_payresult_log` (
  `id` int(11) NOT NULL,
  `order_no` varchar(32) NOT NULL,
  `result_code` varchar(50) NOT NULL DEFAULT '',
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `x_payresult_log`
--

INSERT INTO `x_payresult_log` (`id`, `order_no`, `result_code`, `time`, `content`) VALUES
(1, '15469733310000001632', 'SUCCESS', '2019-01-09 02:49:01', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"CFT\",\"cash_fee\":\"1\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"rhZIRVzkecDqKod6\",\"openid\":\"oF0I34xKGNNE5p1pTUG8wtVuBUKI\",\"out_trade_no\":\"15469733310000001632\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"78A65F040FDA75B5A27FB301F5FF4416\",\"time_end\":\"20190109024900\",\"total_fee\":\"1\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000245201901098561221153\"}'),
(2, '15469734480000001102', 'SUCCESS', '2019-01-09 02:51:00', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"CFT\",\"cash_fee\":\"1\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"a4YkGAolRT0IKhpC\",\"openid\":\"oF0I34xKGNNE5p1pTUG8wtVuBUKI\",\"out_trade_no\":\"15469734480000001102\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"D44668D99911674EBC8D0C155D20A90B\",\"time_end\":\"20190109025059\",\"total_fee\":\"1\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000242201901097237377757\"}'),
(3, '15469745280000001468', 'SUCCESS', '2019-01-09 03:08:55', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"CFT\",\"cash_fee\":\"1\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"WfHJL1emPiVkQvDZ\",\"openid\":\"oF0I34xKGNNE5p1pTUG8wtVuBUKI\",\"out_trade_no\":\"15469745280000001468\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"95D6B69EC668A5F976AA2BB70EEDC791\",\"time_end\":\"20190109030854\",\"total_fee\":\"1\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000258201901098499417280\"}'),
(4, '15470859630000001425', 'SUCCESS', '2019-01-10 10:06:18', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"CFT\",\"cash_fee\":\"1\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"4idVeaCc69JnDQk1\",\"openid\":\"oF0I34xKGNNE5p1pTUG8wtVuBUKI\",\"out_trade_no\":\"15470859630000001425\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"6826392489077EDAD92D27D8CF6D14BE\",\"time_end\":\"20190110100617\",\"total_fee\":\"1\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000247201901102394340424\"}'),
(5, '15470869840000002308', 'SUCCESS', '2019-01-10 10:23:10', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"CFT\",\"cash_fee\":\"1\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"GEizc8IWC9yUOwrV\",\"openid\":\"oF0I345xcE3BEyaJ3UUpsIJbbl8k\",\"out_trade_no\":\"15470869840000002308\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"883D4270CCF77153C0290C06A2B97CE4\",\"time_end\":\"20190110102309\",\"total_fee\":\"1\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000258201901102230352263\"}'),
(6, '15471201440000001470', 'SUCCESS', '2019-01-10 19:35:57', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"CFT\",\"cash_fee\":\"1\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"UxTDE13qmQ7W4Ruh\",\"openid\":\"oF0I34xKGNNE5p1pTUG8wtVuBUKI\",\"out_trade_no\":\"15471201440000001470\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"B578A9B909F78744CC0EC6D6A2191F1A\",\"time_end\":\"20190110193556\",\"total_fee\":\"1\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000257201901109227411976\"}'),
(7, '15471207370000003128', 'SUCCESS', '2019-01-10 19:45:42', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"GDB_CREDIT\",\"cash_fee\":\"1\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"rNHfBMAeEt0P2yOX\",\"openid\":\"oF0I34-YYbO-rxVdZIK15pM-81U4\",\"out_trade_no\":\"15471207370000003128\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"2E8C9CFB54956E5C0B1D2ED7D4684F39\",\"time_end\":\"20190110194541\",\"total_fee\":\"1\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000239201901103793204084\"}'),
(8, '15475367480000003573', 'SUCCESS', '2019-01-15 15:19:16', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"GDB_CREDIT\",\"cash_fee\":\"888\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"mY1ovVnrEeD63NIS\",\"openid\":\"oF0I34-YYbO-rxVdZIK15pM-81U4\",\"out_trade_no\":\"15475367480000003573\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"2B3F664DBA32113C3E92E9DD491C0948\",\"time_end\":\"20190115151915\",\"total_fee\":\"888\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000240201901159923836556\"}'),
(9, '15475367730000004348', 'SUCCESS', '2019-01-15 15:19:40', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"CFT\",\"cash_fee\":\"1\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"VTxomyu9zQgJC62L\",\"openid\":\"oF0I34729FScrSJM9AAG7yR86Nvw\",\"out_trade_no\":\"15475367730000004348\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"7933B8D7F636DAFB901AE237D0BDFDCC\",\"time_end\":\"20190115151939\",\"total_fee\":\"1\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000252201901152615727040\"}'),
(10, '15475374170000001103', 'SUCCESS', '2019-01-15 15:30:23', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"CFT\",\"cash_fee\":\"1\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"QvWiEqZjIfOhATVN\",\"openid\":\"oF0I34xKGNNE5p1pTUG8wtVuBUKI\",\"out_trade_no\":\"15475374170000001103\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"DDA54A5640EEC20B8DDF9BC871C26A9D\",\"time_end\":\"20190115153023\",\"total_fee\":\"1\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000249201901159836446395\"}'),
(11, '15475522470000003292', 'SUCCESS', '2019-01-15 19:37:34', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"GDB_CREDIT\",\"cash_fee\":\"1\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"GEX0DywmPgp4KIhL\",\"openid\":\"oF0I34-YYbO-rxVdZIK15pM-81U4\",\"out_trade_no\":\"15475522470000003292\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"4BF170C939CDDE841479A36F20741D35\",\"time_end\":\"20190115193734\",\"total_fee\":\"1\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000257201901153211450499\"}'),
(12, '15475542920000004651', 'SUCCESS', '2019-01-15 20:11:37', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"CFT\",\"cash_fee\":\"1\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"9NEhJbpeF1mMD2dl\",\"openid\":\"oF0I34729FScrSJM9AAG7yR86Nvw\",\"out_trade_no\":\"15475542920000004651\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"812739DF4EE709D7BFF6EBEAFBCC277F\",\"time_end\":\"20190115201137\",\"total_fee\":\"1\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000254201901158106735621\"}'),
(13, '15576796890000033942', 'SUCCESS', '2019-05-13 00:48:35', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"ICBC_DEBIT\",\"cash_fee\":\"888\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"1OcKrgxAt4uy0357\",\"openid\":\"oF0I34y209BLj997XBqENvUV1EGY\",\"out_trade_no\":\"15576796890000033942\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"0D3F0285EC2339C3ADA675ABB6BE6CBB\",\"time_end\":\"20190513004833\",\"total_fee\":\"888\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000294201905130983320334\"}'),
(14, '15718020100000078518', 'SUCCESS', '2019-10-23 11:40:30', '{\"appid\":\"wx90918f938c2ce84f\",\"bank_type\":\"CFT\",\"cash_fee\":\"888\",\"fee_type\":\"CNY\",\"is_subscribe\":\"N\",\"mch_id\":\"1520278451\",\"nonce_str\":\"cMZyQYakvzHNF7Xr\",\"openid\":\"oF0I34-6APNmZWEOQBoQp8HkV364\",\"out_trade_no\":\"15718020100000078518\",\"result_code\":\"SUCCESS\",\"return_code\":\"SUCCESS\",\"sign\":\"9FA91F2CE661CCAB82997EB74628ECEC\",\"time_end\":\"20191023114029\",\"total_fee\":\"888\",\"trade_type\":\"JSAPI\",\"transaction_id\":\"4200000404201910233383352807\"}');

-- --------------------------------------------------------

--
-- 表的结构 `x_platform_account`
--

CREATE TABLE `x_platform_account` (
  `id` int(11) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `reg_time` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='平台账户系统';

-- --------------------------------------------------------

--
-- 表的结构 `x_present`
--

CREATE TABLE `x_present` (
  `id` int(10) NOT NULL,
  `member_id` int(11) NOT NULL,
  `accept_id` int(10) DEFAULT NULL COMMENT '接收人id',
  `pro_type` tinyint(2) NOT NULL COMMENT '产品类型,1:专栏;2:课程',
  `pro_id` int(10) NOT NULL,
  `secret` varchar(32) NOT NULL COMMENT '加密key',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '礼包内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否被领取0:否1:是'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='赠送表';

-- --------------------------------------------------------

--
-- 表的结构 `x_recharge`
--

CREATE TABLE `x_recharge` (
  `id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member_name` varchar(24) NOT NULL COMMENT '用户名',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(12,2) NOT NULL COMMENT '充值金额',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0:已取消;1:未支付;2:已完成支付'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员充值';

-- --------------------------------------------------------

--
-- 表的结构 `x_reply`
--

CREATE TABLE `x_reply` (
  `id` int(10) NOT NULL,
  `comment_id` int(10) NOT NULL,
  `content` varchar(500) NOT NULL DEFAULT '',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论回复表';

-- --------------------------------------------------------

--
-- 表的结构 `x_sms_code`
--

CREATE TABLE `x_sms_code` (
  `id` int(11) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `code` int(6) NOT NULL,
  `create_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='验证码表';

-- --------------------------------------------------------

--
-- 表的结构 `x_teacher`
--

CREATE TABLE `x_teacher` (
  `id` int(11) NOT NULL,
  `org_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `position` varchar(100) NOT NULL DEFAULT '',
  `introduce` varchar(500) NOT NULL DEFAULT '',
  `avatar` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `x_teacher`
--

INSERT INTO `x_teacher` (`id`, `org_id`, `name`, `position`, `introduce`, `avatar`, `status`) VALUES
(1, 1, '张天志', '这是个高手', '咏春拳是一门中国传统武术，是一门制止侵袭的技术，是一个积极、精简的正当防卫系统、合法使用武力的拳术。较其它中国传统武术、更专注于尽快制服对手、以此将当事人的损害降至最低。', 'd9736b3853ab33dc35e3d7715f639939.jpg', 1),
(2, 1, '李教练', '2018国际咏春大赛85KG冠军，2017国际咏春85KG亚军', '资料更新中', '2ee94412acf3b81971fc0e19190600c0.jpg', 1),
(3, 1, '谢冠成', '谢冠成，名朗，1978年7月，出生于广东廉江市，自幼随父习武，大学本科毕业于广州体育学院运动训练系武术专业（本科）。', '属[叶问咏春]第二代弟子，师承[叶准]恩师，常年从事咏春及武术领域技术、传统拳术、国学文化及青少年素质教育事业发展研究。', 'fbae6772f090324e3cdb714f740dad2f.jpg', 1);

-- --------------------------------------------------------

--
-- 表的结构 `x_user`
--

CREATE TABLE `x_user` (
  `id` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `realname` varchar(24) NOT NULL DEFAULT '',
  `role` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_lock` tinyint(1) NOT NULL DEFAULT '0',
  `lock_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '开始锁定的时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `x_user`
--

INSERT INTO `x_user` (`id`, `username`, `password`, `realname`, `role`, `status`, `is_lock`, `lock_time`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '管理员', 1, 1, 0, 0),
(2, 'ccgf001', 'e10adc3949ba59abbe56e057f20f883e', '编辑', 0, 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `x_admin_rule`
--
ALTER TABLE `x_admin_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indexes for table `x_balance_log`
--
ALTER TABLE `x_balance_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `x_banner`
--
ALTER TABLE `x_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_booking`
--
ALTER TABLE `x_booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `status` (`status`),
  ADD KEY `org_id` (`org_id`) USING BTREE;

--
-- Indexes for table `x_booking_log`
--
ALTER TABLE `x_booking_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `x_collection`
--
ALTER TABLE `x_collection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `x_columnist`
--
ALTER TABLE `x_columnist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_columnist_article`
--
ALTER TABLE `x_columnist_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_columnist_student`
--
ALTER TABLE `x_columnist_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_comment`
--
ALTER TABLE `x_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `x_content_cate`
--
ALTER TABLE `x_content_cate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_coupon`
--
ALTER TABLE `x_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_coupon_log`
--
ALTER TABLE `x_coupon_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_course`
--
ALTER TABLE `x_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_course_section`
--
ALTER TABLE `x_course_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_course_student`
--
ALTER TABLE `x_course_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `x_feedback`
--
ALTER TABLE `x_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_main_cate`
--
ALTER TABLE `x_main_cate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_member`
--
ALTER TABLE `x_member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `x_member_info`
--
ALTER TABLE `x_member_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `x_mysession`
--
ALTER TABLE `x_mysession`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `x_my_goods`
--
ALTER TABLE `x_my_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `x_news`
--
ALTER TABLE `x_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_orders`
--
ALTER TABLE `x_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_org`
--
ALTER TABLE `x_org`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `x_payresult_log`
--
ALTER TABLE `x_payresult_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_platform_account`
--
ALTER TABLE `x_platform_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_present`
--
ALTER TABLE `x_present`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_recharge`
--
ALTER TABLE `x_recharge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `x_reply`
--
ALTER TABLE `x_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `x_sms_code`
--
ALTER TABLE `x_sms_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_teacher`
--
ALTER TABLE `x_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_user`
--
ALTER TABLE `x_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `x_admin_rule`
--
ALTER TABLE `x_admin_rule`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- 使用表AUTO_INCREMENT `x_balance_log`
--
ALTER TABLE `x_balance_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- 使用表AUTO_INCREMENT `x_banner`
--
ALTER TABLE `x_banner`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `x_booking`
--
ALTER TABLE `x_booking`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `x_booking_log`
--
ALTER TABLE `x_booking_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `x_collection`
--
ALTER TABLE `x_collection`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `x_columnist`
--
ALTER TABLE `x_columnist`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `x_columnist_article`
--
ALTER TABLE `x_columnist_article`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `x_columnist_student`
--
ALTER TABLE `x_columnist_student`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `x_comment`
--
ALTER TABLE `x_comment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `x_content_cate`
--
ALTER TABLE `x_content_cate`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `x_coupon`
--
ALTER TABLE `x_coupon`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `x_coupon_log`
--
ALTER TABLE `x_coupon_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `x_course`
--
ALTER TABLE `x_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `x_course_section`
--
ALTER TABLE `x_course_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- 使用表AUTO_INCREMENT `x_course_student`
--
ALTER TABLE `x_course_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `x_feedback`
--
ALTER TABLE `x_feedback`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `x_main_cate`
--
ALTER TABLE `x_main_cate`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `x_member`
--
ALTER TABLE `x_member`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
--
-- 使用表AUTO_INCREMENT `x_member_info`
--
ALTER TABLE `x_member_info`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `x_mysession`
--
ALTER TABLE `x_mysession`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
--
-- 使用表AUTO_INCREMENT `x_my_goods`
--
ALTER TABLE `x_my_goods`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- 使用表AUTO_INCREMENT `x_news`
--
ALTER TABLE `x_news`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `x_orders`
--
ALTER TABLE `x_orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- 使用表AUTO_INCREMENT `x_org`
--
ALTER TABLE `x_org`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `x_payresult_log`
--
ALTER TABLE `x_payresult_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- 使用表AUTO_INCREMENT `x_platform_account`
--
ALTER TABLE `x_platform_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `x_present`
--
ALTER TABLE `x_present`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `x_recharge`
--
ALTER TABLE `x_recharge`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `x_reply`
--
ALTER TABLE `x_reply`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `x_sms_code`
--
ALTER TABLE `x_sms_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `x_teacher`
--
ALTER TABLE `x_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `x_user`
--
ALTER TABLE `x_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
