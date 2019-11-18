-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2019-10-26 08:44:41
-- 服务器版本： 5.7.15
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nujiang`
--

DELIMITER $$
--
-- 存储过程
--
CREATE DEFINER=`btc`@`%` PROCEDURE `p_auto_redemption` ()  BEGIN
DECLARE mypro_id_ int(10);	DECLARE member_name_ VARCHAR(24); DECLARE capital_ DECIMAL(12,2); 
DECLARE done INT DEFAULT 0;
DECLARE mycorcur_ CURSOR  for( 
	SELECT 
		id,
		member_name, 
        amount
	from b_my_product
    where status = 0 
    and end_time < (DATE_SUB(CURDATE(),INTERVAL 0 DAY)+0)
);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET done=1; 
DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done=3;

OPEN mycorcur_;

f_loop: LOOP
    FETCH mycorcur_ into mypro_id_, member_name_, capital_;

    IF done=1 OR done=3 THEN
        LEAVE f_loop;
    END IF;
	
    if isnull(mypro_id_) then
    set done = 0;
    end if;
    
    if isnull(member_name_) then
    set done = 0;
    end if;
    
UPDATE b_member 
SET 
    capital = capital + capital_
WHERE
    username = member_name_ AND status = 1
        AND is_lock = 0;
    
UPDATE b_my_product 
SET 
    status = 1
WHERE
    status = 0 AND id = mypro_id_;
    
    SET capital_ = 0.00;
	SET done = 0;

 COMMIT;
END LOOP f_loop;
CLOSE mycorcur_;   

 COMMIT;
END$$

CREATE DEFINER=`btc`@`%` PROCEDURE `p_interest_settle` ()  BEGIN
DECLARE mypro_id_ int(10);	DECLARE member_name_ VARCHAR(24); DECLARE pro_id_ int(10);	DECLARE pro_name_ VARCHAR(64); DECLARE buy_time_ timestamp; DECLARE start_time_ INT(10); DECLARE end_time_ INT(10); DECLARE amount_ DECIMAL(12,2); DECLARE real_ratio_ DECIMAL(12,6);  DECLARE gains_date_ date;    DECLARE gains_day_ DECIMAL(12,2);  
DECLARE t_today INT(10); DECLARE t_yesterday INT(10); 
DECLARE done INT DEFAULT 0;
DECLARE mycorcur_ CURSOR  for( 
	SELECT 
		id,
		member_name, 
		pro_id, 
		pro_name,
        buy_time,
        start_time,
        end_time,
        amount,
        real_ratio
	from b_my_product
    where status = 0 and is_settle = 0
    and start_time <= (DATE_SUB(CURDATE(),INTERVAL 0 DAY)+0)  
    and end_time >= (DATE_SUB(CURDATE(),INTERVAL 0 DAY)+0)
);

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET done=1; 
DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done=3;

set t_today = (DATE_SUB(CURDATE(),INTERVAL 0 DAY)+0);
set t_yesterday = (DATE_SUB(CURDATE(),INTERVAL 1 DAY)+0);

OPEN mycorcur_;

f_loop: LOOP
    FETCH mycorcur_ into mypro_id_, member_name_, pro_id_, pro_name_, buy_time_, start_time_, end_time_, amount_, real_ratio_;

    IF done=1 OR done=3 THEN
        LEAVE f_loop;
    END IF;
	   
    set gains_date_ = t_yesterday;
    set gains_day_ = round(amount_ * real_ratio_ / 100, 2);
    
UPDATE b_member 
SET 
    gains_yesterday = gains_day_,
    gains = gains + gains_day_,
    capital = capital + gains
WHERE
    username = member_name_ AND status = 1
        AND is_lock = 0;
        
	INSERT INTO b_gains_detail(member_name,pro_id,pro_name,buy_time,start_time,end_time,amount,real_ratio,gains_date,gains_day)
	VALUES(member_name_, pro_id_, pro_name_, buy_time_, start_time_, end_time_, amount_, real_ratio_, gains_date_, gains_day_);
    
UPDATE b_my_product 
SET 
    is_settle = 1
WHERE
    status = 0 AND is_settle = 0
        AND id = mypro_id_;
    
	SET done = 0;

 COMMIT;
END LOOP f_loop;
CLOSE mycorcur_;   

 COMMIT;

END$$

CREATE DEFINER=`btc`@`%` PROCEDURE `p_upt_current_rate` ()  BEGIN
DECLARE product_id int(10);
DECLARE min_day_ratio DECIMAL(12,6); DECLARE max_day_ratio DECIMAL(12,6); DECLARE real_day_ratio DECIMAL(12,6); 
DECLARE done INT DEFAULT 0;
DECLARE mycorcur_ CURSOR  for( 
	SELECT 
		id, 
		ratio_min, 
		ratio_max
	from b_product
    where status = 1 and parent_id in (4, 6) 
); 

DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET done=1; 
DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done=3;

OPEN mycorcur_;

f_loop: LOOP
    FETCH mycorcur_ into product_id, min_day_ratio, max_day_ratio;

    IF done=1 OR done=3 THEN
        LEAVE f_loop;
    END IF;
	   
    set real_day_ratio = round(floor(min_day_ratio * 1000000 + rand() * (max_day_ratio * 1000000 - min_day_ratio * 1000000 + 1)) / 1000000, 6);
    
UPDATE b_my_product 
SET 
    real_ratio = real_day_ratio
WHERE
    pro_id = product_id AND status = 0;
    
    set product_id = 0;
    set real_day_ratio = 0.00;
	SET done = 0;

 COMMIT;
END LOOP f_loop;
CLOSE mycorcur_;

UPDATE b_my_product 
SET 
    is_settle = 0
WHERE
    status = 0 AND is_settle = 1;

 COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `b_admin_rule`
--

CREATE TABLE `b_admin_rule` (
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
-- 转存表中的数据 `b_admin_rule`
--

INSERT INTO `b_admin_rule` (`id`, `parent_id`, `controller`, `action`, `type`, `title`, `short_name`, `url`, `icon`, `status`, `sort`) VALUES
(1, 0, 'Sys', '', 1, '系统管理', '系统', NULL, 'icon-cog', 1, 0),
(2, 0, 'Rbac', '', 1, '权限管理', '权限', NULL, 'icon-cog', 0, 0),
(3, 0, 'User', '', 1, '用户管理', '用户', NULL, 'icon-user', 1, 0),
(4, 0, 'Member', '', 1, '会员管理', '会员', NULL, 'icon-list', 0, 0),
(5, 0, 'Orders', '', 1, '订单管理', '订单', NULL, 'icon-bell-alt', 0, 5),
(6, 1, 'Sys', 'index', 1, '系统信息', '', 'Sys/index', '', 1, 0),
(7, 1, 'Sys', 'conf', 1, '系统配置', '', 'Sys/conf', '', 1, 0),
(8, 1, 'Sys', 'menu', 1, '菜单管理', '', 'Sys/menu', '', 0, 0),
(9, 2, 'Rbac', 'index', 1, '角色管理', '', 'Rbac/index', '', 1, 0),
(10, 0, 'Jobs', '', 1, '岗位管理', '岗位', NULL, 'icon-file', 1, 0),
(11, 3, 'User', 'index', 1, '用户列表', '', 'User/index', '', 1, 0),
(12, 3, 'User', 'add', 1, '添加用户', '', 'User/add', '', 1, 2),
(13, 0, 'Finance', '', 1, '财务管理', '财务', '', '', 0, 3),
(14, 13, 'Finance', 'buy', 1, '购买记录', '', 'Finance/buy', '', 1, 1),
(15, 13, 'Finance', 'pay', 1, '充值记录', '', 'Finance/pay', '', 1, 0),
(16, 4, 'Member', 'index', 1, '会员列表', '', 'Member/index', '', 1, 0),
(17, 0, 'Content', '', 1, '内容管理', '内容', NULL, '', 1, 8),
(18, 10, 'Jobs', 'index', 1, '岗位列表', '', 'Jobs/index', '', 1, 0),
(19, 10, 'Jobs', 'add', 1, '添加岗位', '', 'Jobs/add', '', 1, 1),
(20, 17, 'Content', 'index', 1, '内容管理', '内容管理', 'Content/index', '', 1, 0),
(21, 5, 'Orders', 'index', 1, '订单列表', '', 'Orders/index', '', 1, 0),
(22, 5, 'Orders', 'add', 1, '创建订单', '', 'Orders/add', '', 1, 1),
(23, 1, 'Sys', 'scroll', 1, '滚动屏设置', '', 'Sys/scroll', '', 1, 2),
(24, 4, 'Member', 'cash', 1, '会员提现', '', 'Member/cash', '', 0, 1),
(25, 4, 'Member', 'recharge', 1, '会员充值', '', 'Member/recharge', '', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `b_banner`
--

CREATE TABLE `b_banner` (
  `id` int(10) NOT NULL,
  `img` varchar(128) NOT NULL DEFAULT '',
  `url` varchar(64) DEFAULT NULL,
  `position_key` int(10) NOT NULL COMMENT '识别标识',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `b_banner`
--

INSERT INTO `b_banner` (`id`, `img`, `url`, `position_key`, `status`) VALUES
(1, '5f578399e7467f687c60ee32bfd94d4a.jpg', '/index.php/Web/Product/index/pid/4', 0, 1),
(2, '91126176ac281fed72c40bfccb2ebd0c.jpg', '', 0, 1),
(3, 'f89bb5ae09cef4aab04fd22feb20c55b.jpg', '', 1, 1),
(4, 'f406d0e08aa6b9229e2bae601e309ea3.jpg', '', 8, 1),
(5, '8b78d646b87478f3688dc14b615deb25.jpg', '', 2, 1),
(6, '23f7bd8c7a9ca188f18ad735cadeb46c.jpg', '', 7, 1);

-- --------------------------------------------------------

--
-- 表的结构 `b_content_cate`
--

CREATE TABLE `b_content_cate` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `pid` tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(24) NOT NULL DEFAULT '',
  `type` varchar(12) NOT NULL DEFAULT '' COMMENT 'single\\pic\\news\\product\\banner',
  `sort` tinyint(4) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `is_nav` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是导航'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容分类';

--
-- 转存表中的数据 `b_content_cate`
--

INSERT INTO `b_content_cate` (`id`, `pid`, `title`, `type`, `sort`, `status`, `is_nav`) VALUES
(1, 0, '关于我们', 'single', 3, 1, 1),
(8, 0, '工作动态', 'news', 4, 1, 1),
(9, 0, '人才政策', 'news', 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `b_jobs`
--

CREATE TABLE `b_jobs` (
  `id` int(10) NOT NULL,
  `title` varchar(32) NOT NULL,
  `link` varchar(120) NOT NULL DEFAULT '',
  `company` varchar(32) NOT NULL,
  `wage` varchar(24) NOT NULL,
  `person_limit` tinyint(3) NOT NULL DEFAULT '0',
  `end_date` date DEFAULT NULL,
  `content` text,
  `sort` int(10) NOT NULL DEFAULT '9',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='岗位';

--
-- 转存表中的数据 `b_jobs`
--

INSERT INTO `b_jobs` (`id`, `title`, `link`, `company`, `wage`, `person_limit`, `end_date`, `content`, `sort`, `create_time`, `status`) VALUES
(1, '测试岗位', 'http://www.zh-hr.com/jsp/person/ckzw/position-info.jsp?position=228263', '格力电器', '面议', 0, '2019-11-02', '<p>1、基本工资：试用期内2040元，试用期1个月，试用期后2190元。综合工资4500-5500元。优秀员工再加每月奖金100元。&nbsp;<br/>2、夜班津贴：15元/晚，部分岗位有岗位津贴。&nbsp;<br/>3、加班工资：试用期内平日：17.58元/H&nbsp;休日：23.45元/H&nbsp;节日：35.17元/H；试用期后平日：18.88元/H&nbsp;休日：25.17元/H&nbsp;节日：37.76元/H；&nbsp;<br/>4、餐补：按工时计算，封顶208元/月，为夜班人员免费提供夜宵。餐厅配有电视机、小卖部、免费Wifi.&nbsp;<br/>5、住宿：4至8人一间，带洗手间，24H供热水冲凉，（配有洗衣机、空调）水电费宿舍内人员平摊。&nbsp;<br/><br/>有意者，无需投递简历，请带上本人有效证件到门卫室面试，周一至周五上午08：30正式接受面试。&nbsp;<br/><br/>公司订单常年充足，现大量招聘普工。待遇优福利好，欢迎加入！</p>', 9, '2019-10-25 15:43:47', 1),
(2, '总经理助理', 'http://www.zh-hr.com/jsp/person/ckzw/position-info.jsp?position=337182', '珠海市巴莫克网络科技有限公司', '面议', 2, '2019-11-24', '1、年齡：18-45岁，身体健康，四肢灵活； \r\n2、工资4100-8000元，提供食宿，能适应两班倒，上夜班有夜班津贴10元/晚； \r\n主要部門有：包裝、拋光、壓鑄、加工、電鍍、品檢等 \r\n有意者可致電：0756-7513168转8358咨询详情！！', 9, '2019-10-26 05:16:06', 1),
(3, '网络运营总监', 'http://www.zh-hr.com/jsp/person/ckzw/position-info.jsp?position=337182', '珠海市巴莫克网络科技有限公司', '面议', 1, '2019-11-17', '详细介绍', 9, '2019-10-26 05:17:30', 1);

-- --------------------------------------------------------

--
-- 表的结构 `b_news`
--

CREATE TABLE `b_news` (
  `id` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `title` varchar(36) NOT NULL DEFAULT '',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `origin` varchar(12) NOT NULL DEFAULT '',
  `click` int(10) NOT NULL DEFAULT '0',
  `keywords` varchar(200) NOT NULL DEFAULT '',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '摘要',
  `content` text,
  `recommend` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(64) NOT NULL DEFAULT '' COMMENT '外链',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `b_news`
--

INSERT INTO `b_news` (`id`, `cid`, `title`, `create_time`, `origin`, `click`, `keywords`, `description`, `content`, `recommend`, `url`, `status`) VALUES
(1, 8, '工作动态测试内容', '2019-10-22 00:23:59', '', 0, '', '省部共建中医湿证国家重点实验室依托广州中医药大学建设，与此前已经建立的中药类国家重点实验室一起，共同组成了我国日臻完善的中医药国家重点实验室体系。', '<p>速度输3</p>', 0, '', 1),
(2, 8, '习近平对科技特派员制度推行20周年作出重要指示', '2019-10-22 00:27:15', '', 0, '', '新华社北京10月21日电 近日，中共中央总书记、国家主席、中央军委主席习近平对科技特派员制度推行20周年作出重要指示指出，科技特派员制度推行20年来，坚持人才下沉、科技下乡、服务“三农”，队伍不断壮大，成为党的“三农”政策的宣传队、农业科技的传播者、科技创新创业的领头羊、乡村脱贫致富的带头人，使广大农民有了更多获得感、幸福感。', '<p>新华社北京10月21日电 近日，中共中央总书记、国家主席、中央军委主席习近平对科技特派员制度推行20周年作出重要指示指出，科技特派员制度推行20年来，坚持人才下沉、科技下乡、服务“三农”，队伍不断壮大，成为党的“三农”政策的宣传队、农业科技的传播者、科技创新创业的领头羊、乡村脱贫致富的带头人，使广大农民有了更多获得感、幸福感。</p>', 0, '', 1),
(3, 8, '中国首个中医类国家重点实验室在广东省中医院启动', '2019-10-22 00:28:14', '', 0, '', '南都记者从广东省中医院获悉，由广东省中医院承建的我国中医类首个国家重点实验室建设运行实施方案通过科技部、广东省科技厅组织的专家论证。这在中医药发展史上具有里程碑意义。', '<p>南都记者从广东省中医院获悉，由广东省中医院承建的我国中医类首个国家重点实验室建设运行实施方案通过科技部、广东省科技厅组织的专家论证。这在中医药发展史上具有里程碑意义。</p>', 0, '', 1),
(4, 9, '关于公开征求《关于印发珠海市支持港澳青年来珠就业（创业）意见的通告', '2019-10-25 21:28:35', '', 0, '', '为扎实推进粤港澳大湾区建设，促进港澳青年在珠就业创业，我局会同市财政局拟订了《关于印发珠海市支持港澳青年来珠就业（创业）和技能培训（训练）补贴办法的通知（征求意见稿）》，现向社会公开征求意见，公众可以通过以下途径和方式提出反馈意见', '<p>为扎实推进粤港澳大湾区建设，促进港澳青年在珠就业创业，我局会同市财政局拟订了《关于印发珠海市支持港澳青年来珠就业（创业）和技能培训（训练）补贴办法的通知（征求意见稿）》，现向社会公开征求意见，公众可以通过以下途径和方式提出反馈意见：</p><p>一、电子邮箱：zhuhaijyk@163.com。</p><p>二、通信地址：珠海市人力资源和社会保障局（地址：珠海市香洲区康宁路66号909-1室，邮编：519000），并请在信封上注明“关于印发珠海市支持港澳青年来珠就业（创业）和技能培训（训练）补贴办法的通知”字样。</p><p>意见反馈截止时间为2019年11月13日。</p><p>联系人：冯先生、刘小组，联系电话：2128803、2128681（兼传真）。</p><p>&nbsp;</p><p>附件：关于印发珠海市支持港澳青年来珠就业（创业）和技能培训（训练）补贴办法的通知（征求意见稿）</p><p><br/></p>', 0, '', 1),
(5, 9, '关于《珠海市社会保险基金监督举报奖励办法（征求意见稿）》公开征求', '2019-10-25 21:29:43', '', 0, '', '2019年5月22日，我局就《珠海市社会保险基金监督举报奖励办法（征求意见稿）》向社会公开征求意见，公众可以通过网站、邮件以及通信等形式反馈意见，意见反馈截止时间为2019年6月6日', '<p>2019年5月22日，我局就《珠海市社会保险基金监督举报奖励办法（征求意见稿）》向社会公开征求意见，公众可以通过网站、邮件以及通信等形式反馈意见，意见反馈截止时间为2019年6月6日。<br/>&nbsp;&nbsp;&nbsp;截止到2019年6月6日，我局未收到公众对《珠海市社会保险基金监督举报奖励办法（征求意见稿）》的修改意见。</p>', 0, '', 1),
(6, 9, '珠海市人才创新创业基金正式成立，首期5000万元财政出资到位', '2019-10-25 21:30:31', '', 0, '', '好消息！9月18日，珠海市人才创新创业投资基金有限合伙企业完成工商注册，首期5000万元财政出资到位，标志着珠海市人才创新创业投资基金正式成立。', '<p>好消息！9月18日，珠海市人才创新创业投资基金有限合伙企业完成工商注册，首期5000万元财政出资到位，标志着珠海市人才创新创业投资基金正式成立。&nbsp;<br/>&nbsp;&nbsp; 下面小编带您看看这一好消息的重要意义！&nbsp;<br/>&nbsp;&nbsp;&nbsp;<strong>人才新政的关键一招&nbsp;<br/></strong>&nbsp;&nbsp; 在珠海市委组织部的统一部署下，珠海市金融工作局会同市人社局、市财政局、市科创局等单位启动了珠海市人才创新创业基金的工作。2018年底，珠海市人民政府批准了《珠海市人才创新创业基金设立方案》，决定设立首期规模2亿元的政策性投资基金，支持高层次人才创新创业。&nbsp;<br/>&nbsp;&nbsp;&nbsp;在此之前，为落实“英才计划”，优化支持高层次人才创新创业的金融环境，中国银行珠海分行等银行机构推出了“珠海英才贷”等贷款产品，为高层次人才提供最高达2000万元、最长达5年的授信，用于创新创业过程中的技术研发、成果转化、厂房立业、设备购置等用途，为“英才计划”落地提供了良好的金融生态环境。&nbsp;<br/>&nbsp;&nbsp; 在此基础上，人才基金采取风险投资的模式，投向高端人才发起或参与的创新创业项目，为高层次创新创业进一步提供股权投资支持，将“英才计划”的金融生态推进到2.0时代。&nbsp;<br/>&nbsp;&nbsp;&nbsp;<strong>创新创业的天使之翼</strong>&nbsp;<br/>&nbsp;&nbsp; 人才基金的设立具有很强的针对性。人才创新创业项目要完成从创意到项目、从发明到产品的转换，失败率非常高，市场化金融机构的趋利本能使其倾向于投资成长期、成熟期的项目，极少为创新创业项目融资。研究表明，80%的初创期企业未曾获得金融支持，种子期项目获得的金融支持更少，在完全市场化的环境中，与创新链相伴的金融链缺失了关键一环。&nbsp;<br/>&nbsp;&nbsp; 为解决市场化融资机制失灵的问题，珠海市人才创新创业基金定位为政策性基金，将投资阶段锁定在种子期、初创期的创新创业项目上，发挥财政资金的引导作用，解决这些项目早期市场化投资空白的问题，补上创新创业金融服务的关键一环。同时，人才基金不以营利为目的，坚持“能投尽投”的原则，最大力度吸引高端人才在珠海创新创业。&nbsp;<br/>&nbsp;&nbsp;&nbsp;<strong>产业高地的金融支柱</strong>&nbsp;<br/>&nbsp;&nbsp; 在所投资项目产业领域上，人才基金聚焦在珠海市现代产业体系重点发展的产业项目，通过“政府播种，市场培育”的方式，增强我市经济持续发展的内生动力，为创新驱动发展储备有潜力的现代产业项目。&nbsp;<br/>&nbsp;&nbsp; 近期，人才基金将瞄准新兴高潜产业中的移动互联网、机器人及智能装备、集成电路、人工智能、新能源汽车和医疗器械及设备等细分领域，深入发掘具备发展潜力的项目。&nbsp;<br/>&nbsp;&nbsp; 人才基金落地后，将加速人才创新创业项目在珠海市落地转化，并与珠海知识产权质押融资风险补偿基金、“四位一体”融资平台等政策性融资措施，以及创业投资基金、股权投资基金等市场化融资手段形成相互配合、相互支撑的创新创业融资机制，构建“种子-天使-风投”的金融培育链，通过对初创项目的广泛持续跟踪，做大优质创新创业项目基数，发掘培育现代产业项目亮点，为珠海市建设粤港澳大湾区现代产业高地提供有力的金融支撑。&nbsp;</p>', 0, '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `b_scroll`
--

CREATE TABLE `b_scroll` (
  `id` int(10) NOT NULL,
  `speed` int(10) NOT NULL,
  `delay` int(10) NOT NULL,
  `font_size` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='岗位滚动屏';

--
-- 转存表中的数据 `b_scroll`
--

INSERT INTO `b_scroll` (`id`, `speed`, `delay`, `font_size`) VALUES
(1, 500, 5000, 16);

-- --------------------------------------------------------

--
-- 表的结构 `b_single`
--

CREATE TABLE `b_single` (
  `id` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `b_single`
--

INSERT INTO `b_single` (`id`, `cid`, `title`, `keywords`, `content`) VALUES
(1, 1, '关于我们', '', '<p style="padding-right: 20px; padding-left: 20px; margin-top: 10px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: medium; white-space: normal; background-color: rgb(255, 255, 255);">怒江州西邻缅甸，北靠西藏自治区，东连迪庆藏族自治州、大理白族自治州、丽江市，南接保山市，国土面积1.47万平方公里，辖4个县（市）、29个乡（镇）、255个村委会、17个社区，总人口54.4万人，是 “三江并流”世界自然遗产核心区、重要生态功能区、民族直过区、涉边涉藏区和少数民族聚居区，集“边疆、民族、贫困”为一体。</p><p style="padding-right: 20px; padding-left: 20px; margin-top: 10px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: medium; white-space: normal; background-color: rgb(255, 255, 255);">（一）高山峡谷，交通滞后。全州98%以上的面积是高山峡谷，境内山高谷深、崎岖不平，最高海拔5128米，最低海拔为738米。山多、山大、山陡，“看天一条缝、看地一道沟，出门靠溜索、种地像攀岩”是这里的真实写照。由于长期欠投入，怒江交通基础设施非常滞后，全州无高速路、无机场、无铁路、无航运、无管道运输，道路等级低，高等级公路不足100公里。全州至今还有30%自然村未通公路，部分地区的群众出行靠走路、运输靠人背马驮。</p><p style="padding-right: 20px; padding-left: 20px; margin-top: 10px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: medium; white-space: normal; background-color: rgb(255, 255, 255);">（二）涉边涉藏，民族和谐。全州国境线长450公里，占中缅边境线的22.3%。全州4县（市）中3个县（市）属边境县（市），2个县属涉藏工作县，是云南省唯一既沿边又涉藏的州市。境内居住着傈僳、怒、普米、独龙等民族，少数民族人口49.5万人，占总人口的93.6%。独龙族和怒族是怒江特有的民族，傈僳族和普米族主要居住在怒江。长期以来，怒江州多民族互相包容、和睦相处、和衷共济、和谐共存，从来没有发生过大的纷争。</p><p style="padding-right: 20px; padding-left: 20px; margin-top: 10px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: medium; white-space: normal; background-color: rgb(255, 255, 255);">（三）资源禀赋，产业弱小。境内有极其丰富的水能资源，水资源总量达956亿立方米，水能资源蕴藏量达2000多万千瓦，可开发装机容量1800万千瓦。有极其丰富的矿产资源，有亚洲最大的铅锌矿床，铅、锌、铜、大理石等矿产种类多、储量大、品位高。有丰富独特的生物资源，列入国家保护的动植物有1500多种，是全球三大生物多样性中心之一。有极其独特的旅游文化资源，是“三江并流”世界自然遗产风景名胜区重点景区之一，是绚丽多姿的原生态民族文化汇聚之地。但丰富的水资源利用率不足1%，矿产、生物、旅游等资源未充分开发利用，未能建立起支撑全州经济发展的支柱产业，现有的产业小、散、弱，发展的内生动力严重不足，资源优势未转化为经济优势。</p><p style="padding-right: 20px; padding-left: 20px; margin-top: 10px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: medium; white-space: normal; background-color: rgb(255, 255, 255);">（四）生态良好，脆弱敏感。怒江州是我国重要的生态功能区，属“三江并流”世界自然遗产腹地，境内森林覆盖率75.31%。境内怒江、澜沧江、独龙江三大水系水质一直保持在III类以上，全州生态环境状况指数等级排在云南省第一位。61%的面积纳入各种保护区范围，保护任务重。全州几乎没有一块平整的土地，坡度在25°以上的耕地占总耕地面积的一半以上，可耕地面积少，人地矛盾突出。滑坡、泥石流灾害频繁，一方水土养不活一方人。</p><p style="padding-right: 20px; padding-left: 20px; margin-top: 10px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: medium; white-space: normal; background-color: rgb(255, 255, 255);">（五）贫穷落后，潜力巨大。全州4个县（市）均为深度贫困县，255个行政村中有225个贫困村（深度贫困村218个），有16.4万建档立卡贫困人口，贫困发生率为38.14 %，在全国深度贫困“三区三州”中，贫困发生率最高，是全国平均水平的10倍以上。2017年，全州实现地区生产总值仅为141.5亿元，地方一般公共预算收入仅为9.93亿元，农村常住居民人均可支配收入仅为5871元，与全国平均水平相比，差距很大。2018年1至9月，全州实现地区生产总值95.28亿元，可比增长10.1%，增速全省第一；地方公共财政预算收入完成7.72亿元，同比增长11.2%，增速全省第四；地方公共财政预算支出完成87.96亿元，同比增长27.2%，增速全省第一；城镇常住居民人均可支配收入14862元，同比增长8.6%，增速全省第一；农村常住居民人均可支配收入达4759元，同比增长9.6%，增速全省第一。怒江属于典型的民族“直过区”，全州29个乡（镇）中，26个属“直过区”，全州社会发育程度低，人均受教育年限仅为7.65年，现在还有40%的老百姓不会讲通用语言。但怒江资源独特，生态良好，特别是党的十八大以来，习近平总书记多次对怒江发展问题作出批示指示，汪洋主席两次深入怒江调研指导工作，出台了一系列政策支持怒江发展，各族群众摆脱贫困的愿望日趋强烈，怒江未来发展的潜力巨大。</p><p><br/></p>');

-- --------------------------------------------------------

--
-- 表的结构 `b_site_config`
--

CREATE TABLE `b_site_config` (
  `id` int(10) NOT NULL,
  `site_name` varchar(64) NOT NULL DEFAULT '',
  `keywords` varchar(128) NOT NULL DEFAULT '',
  `description` varchar(500) NOT NULL DEFAULT '',
  `tel` varchar(48) NOT NULL DEFAULT '',
  `email` varchar(32) NOT NULL DEFAULT '',
  `qq` varchar(64) NOT NULL DEFAULT '',
  `weibo` varchar(64) NOT NULL DEFAULT '',
  `icp` varchar(24) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `b_site_config`
--

INSERT INTO `b_site_config` (`id`, `site_name`, `keywords`, `description`, `tel`, `email`, `qq`, `weibo`, `icp`) VALUES
(1, '珠海市对口怒江州劳务协作专栏', '珠海市对口怒江州劳务协作专栏', '珠海市对口怒江州劳务协作专栏', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `b_user`
--

CREATE TABLE `b_user` (
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
-- 转存表中的数据 `b_user`
--

INSERT INTO `b_user` (`id`, `username`, `password`, `realname`, `role`, `status`, `is_lock`, `lock_time`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '管理员', 1, 1, 0, 0),
(2, '0001', '25bbdcd06c32d477f7fa1c3e4a91b032', 'xiaocheng', 0, 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `b_admin_rule`
--
ALTER TABLE `b_admin_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indexes for table `b_banner`
--
ALTER TABLE `b_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `b_content_cate`
--
ALTER TABLE `b_content_cate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `b_jobs`
--
ALTER TABLE `b_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `b_news`
--
ALTER TABLE `b_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `b_scroll`
--
ALTER TABLE `b_scroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `b_single`
--
ALTER TABLE `b_single`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `b_site_config`
--
ALTER TABLE `b_site_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `b_user`
--
ALTER TABLE `b_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `b_admin_rule`
--
ALTER TABLE `b_admin_rule`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- 使用表AUTO_INCREMENT `b_banner`
--
ALTER TABLE `b_banner`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `b_content_cate`
--
ALTER TABLE `b_content_cate`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `b_jobs`
--
ALTER TABLE `b_jobs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `b_news`
--
ALTER TABLE `b_news`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `b_scroll`
--
ALTER TABLE `b_scroll`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `b_single`
--
ALTER TABLE `b_single`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `b_site_config`
--
ALTER TABLE `b_site_config`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `b_user`
--
ALTER TABLE `b_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
DELIMITER $$
--
-- 事件
--
CREATE DEFINER=`btc`@`%` EVENT `job_p_upt_current_rate` ON SCHEDULE EVERY 1 DAY STARTS '2016-08-11 02:30:00' ON COMPLETION PRESERVE ENABLE DO CALL p_upt_current_rate()$$

CREATE DEFINER=`btc`@`%` EVENT `job_p_interest_settle` ON SCHEDULE EVERY 1 DAY STARTS '2017-07-01 00:10:00' ON COMPLETION PRESERVE ENABLE DO CALL p_interest_settle()$$

CREATE DEFINER=`btc`@`%` EVENT `job_p_interest_settle_again` ON SCHEDULE EVERY 1 DAY STARTS '2017-07-01 01:10:00' ON COMPLETION PRESERVE ENABLE DO CALL p_interest_settle()$$

CREATE DEFINER=`btc`@`%` EVENT `job_p_auto_redemption` ON SCHEDULE EVERY 1 DAY STARTS '2017-07-01 03:00:00' ON COMPLETION PRESERVE ENABLE DO CALL p_auto_redemption()$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
