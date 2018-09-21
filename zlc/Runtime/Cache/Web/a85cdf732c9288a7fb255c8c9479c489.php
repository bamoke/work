<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="renderer" content="webkit|ie-comp|ie-stand" />
	<meta name="author" content="中拉网" />
	<title>中拉合作网</title>
	<meta name="keywords" content="中拉网" />
	<meta name="description" content="中拉网" />
	<link href="/zlc/Public/Js/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
	<link href="/zlc/Public/Js/swiper/css/swiper.min.css" rel="stylesheet" />
	<link href="/zlc/Web/Assets/css/base.css" rel="stylesheet" />
	<link href="/zlc/Web/Assets/css/index.css" rel="stylesheet" />
	<script type="text/javascript" src="/zlc/Public/Js/jquery/jquery-1.10.1.min.js"></script>
</head>

<body>
	<div class="m-top-bar">
	<div class="container">
		<div class="language">
			<a href="/cn.php" class="cur">中文</a>
			<a href="/en.php" class="">English</a>
			<a href="javascript:" class="">Espanol</a>
		</div>
	</div>
</div>
<!---header-->
<div class="m-header">
	<div class="container">
		<div class="hidden-xs row top">
			<div class="col-sm-6">
				<img src="/zlc/Web/Assets/images/back2.png" alt="" style="max-width:100%;">
			</div>
			<div class="col-sm-6 right-info">
				<div class="account-box">
					<img src="/zlc/Web/Assets/images/login.png" alt="" class="login-img">
					<div class="login-box">
						<a href="<?php echo U('Main/login');?>">登录</a><span class="fg">|</span><a href="<?php echo U('Main/regist');?>">注册</a>
					</div>
					<!-- <a href="<?php echo U('Home/index');?>" class="user-name">Bamoke2163.com</a> -->
				</div>
				<div class="m-top-search">
					<div class="input-group">
						<input type="text" name="keyword" value="" class="form-control" placeholder="请输入关键字">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-search"></span>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="m-nav">
				<div id="nav-switch-btn" class="visible-xs-block">
					<div class="content-wrap">
							<div class=""><img src="/zlc/Web/Assets/images/back2.png" alt="" height="48" style="max-width:100%;"></div>
							<div>
								<a class="state-close js-state-close"></a>
								<a class="state-open js-state-close" style="display: none;"></a>
							</div>
					</div>
				</div>
				<ul id="js-nav-list" class="list clearfix hidden-xs">
					<li class="<?php if($isIndex): ?>active<?php endif; ?>"><a href="<?php echo U('Index/index');?>" class="">首页</a><span class="bar"></span></li>
					<?php if(is_array($nav)): foreach($nav as $key=>$list): ?><li class="<?php if($list[isActive]): ?>active<?php endif; ?>"><a href="<?php echo ($list['url']); ?>" class=""><?php echo ($list['title']); ?></a><span class="bar"></span></li><?php endforeach; endif; ?>
				</ul>
			</div>
		</div>

	</div>
</div>


	<!--banner-->
	<div class="m-banner-wrap">
		<div class="container">
			<div class="banner index-banner">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<?php if(is_array($banner)): foreach($banner as $key=>$item): ?><div class="swiper-slide">
								<img src="/zlc/Uploads/banner/<?php echo ($item["img"]); ?>" alt="">
							</div><?php endforeach; endif; ?>
					</div>
				</div>
				
			</div>
			<div class="swiper-pagination"></div>
		</div>
	</div>


	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-xs-12">
				<div class="index-column-wrap">
					<div class="title-bar">
						<span class="caption">贸促新闻</span><span class="small-title">PUBLIC INFORMATION</span>
						<a href="<?php echo U('Article/index',array('pid'=>1,'cid'=>16));?>" class="view-more">更多&gt;</a>
					</div>

					<div class="content-wrap">
						<div class="index-img-news">
							<div class="row item">
								<div class="col-xs-12 col-sm-6 img-box">
									<a href="<?php echo U('Article/detail',array('id'=>$mcxwInfo['id']));?>"><img src="/zlc/Uploads/thumb/<?php echo ($mcxwInfo['thumb']); ?>"></a>
								</div>
								<div class="col-xs-12 col-sm-6 text-info">
									<div class="top clearfix">
										<div class="date-box">
											<?php echo explode("-",$mcxwInfo['date'])[1];?>-<?php echo explode("-",$mcxwInfo['date'])[2];?>
											<span class="year"><?php echo explode("-",$mcxwInfo['date'])[0];?></span>
										</div>
										<span class="title"><?php echo ($mcxwInfo['title']); ?></span>
									</div>
									<div class="description"><?php echo ($mcxwInfo['description']); ?></div>
									<div><a href="<?php echo U('Article/detail',array('pid'=>1,'cid'=>$mcxwInfo['cid'],'id'=>$mcxwInfo['id']));?>">查看详情&gt;&gt;</a></div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<div class="index-column-wrap">
					<div class="title-bar">
						<span class="caption">信息公开</span><span class="small-title">PUBLIC INFORMATION</span>
						<a href="<?php echo U('Article/index',array('pid'=>1,'cid'=>17));?>" class="view-more">更多&gt;</a>
					</div>

					<div class="content-wrap">
						<div class="index-text-news">
							<?php if(is_array($xxgkList)): $i = 0; $__LIST__ = $xxgkList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$news): $mod = ($i % 2 );++$i;?><div class="item">
									<div class="title"><a href="<?php echo U('Article/detail',array('pid'=>1,'id'=>$news['id'],'cid'=>$news['cid']));?>" target="_blank"><?php echo ($news['title']); ?></a></div>
								</div><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!---part-2-->
		<div class="row">
			<div class="col-sm-8 col-xs-12">
				<div class="index-column-wrap">
					<div class="title-bar">
						<span class="caption">经贸信息</span><span class="small-title">PUBLIC INFORMATION</span>
						<a href="<?php echo U('Article/index',array('pid'=>1,'cid'=>19));?>" class="view-more">更多&gt;</a>
					</div>

					<div class="content-wrap">
						<div class="index-img-news">
							<div class="row item">
								<div class="col-xs-12 col-sm-6 img-box">
									<a href="<?php echo U('Article/detail',array('pid'=>2,'cid'=>19,'id'=>$jmxxList[0]['id']));?>"><img src="/zlc/Uploads/thumb/<?php echo ($jmxxList[0]['thumb']); ?>"></a>
								</div>
								<div class="col-xs-12 col-sm-6 text-info">
									<div class="top clearfix">
										<div class="date-box">
											<?php echo explode("-",$mcxwInfo['date'])[1];?>-<?php echo explode("-",$mcxwInfo['date'])[2];?>
											<span class="year"><?php echo explode("-",$mcxwInfo['date'])[0];?></span>
										</div>
										<span class="title"><a href="<?php echo U('Article/detail',array('pid'=>2,'cid'=>19,'id'=>$jmxxList[0]['id']));?>"><?php echo ($jmxxList[0]['title']); ?></a></span>
									</div>
									<div class="description"><?php echo ($jmxxList[0]['description']); ?></div>
									<div><a href="<?php echo U('Article/detail',array('pid'=>2,'cid'=>19,'id'=>$jmxxList[0]['id']));?>">查看详情&gt;&gt;</a></div>
								</div>
							</div>
						</div>
						<div class="jmxx-news">
							<?php if(is_array($jmxxList)): $i = 0; $__LIST__ = array_slice($jmxxList,1,null,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="item">
									<div class="date-box">
										<p class="day"><?php echo explode("-",$mcxwInfo['date'])[2];?></p>
										<p class="month"><?php echo explode("-",$mcxwInfo['date'])[1];?>月</p>
									</div>
									<div class="link">
										<a href="<?php echo U('Article/detail',array('pid'=>2,'id'=>$v['id'],'cid'=>$v['cid']));?>" target="_blank"><?php echo ($v['title']); ?></a>
									</div>
								</div><?php endforeach; endif; else: echo "" ;endif; ?>

						</div>

					</div>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<div class="index-column-wrap">
					<div class="title-bar">
						<span class="caption">政务公开</span><span class="small-title">PUBLIC INFORMATION</span>
					</div>

					<div class="content-wrap zwgk-content">
						<div class="cate">
							<a class="" href="<?php echo U('Single/index',array('pid'=>11,'id'=>4,'cid'=>12));?>">
								<span class="glyphicon glyphicon-briefcase"></span><span class="name">业务职能</span>
							</a><a class="" href="<?php echo U('Single/index',array('pid'=>11,'id'=>5,'cid'=>13));?>">
								<span class="glyphicon glyphicon-home"></span><span class="name">机构设置</span>
							</a><a class="" href="<?php echo U('Single/index',array('pid'=>11,'id'=>6,'cid'=>14));?>">
								<span class="glyphicon glyphicon-user"></span><span class="name">领导介绍</span>
							</a><a class="" href="<?php echo U('Article/index',array('pid'=>11,'cid'=>15));?>">
								<span class="glyphicon glyphicon-list-alt"></span><span class="name">财政公开</span>
							</a>
						</div>
						<div class="link-select clearfix">
							<div class="dropdown">
								<button type="button" class="btn btn-block dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">相关政府机构
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="http://www.zhuhai.gov.cn" target="_blank">珠海市政府网</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="http://www.zhsswj.gov.cn/" target="_blank">珠海市商务局</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="http://www.zhfao.gov.cn/" target="_blank">珠海市外事局</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="http://www.zhciq.gov.cn/" target="_blank">珠海出入境检验检疫局</a>
									</li>
								</ul>
							</div>
							<div class="dropdown">
								<button type="button" class="btn btn-block dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown">经贸数据查询
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu2">
									<li role="presentation">
										<a role="menuitem" tabindex="-1" target="_blank" href="http://wmsw.mofcom.gov.cn/wmsw/">进出口税费</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" target="_blank" href="http://hd.chinatax.gov.cn/fagui/action/InitChukou.do">出口退税率</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="index-column-wrap">
					<div class="title-bar">
						<span class="caption">贸易预警</span><span class="small-title">PUBLIC INFORMATION</span>
						<a href="<?php echo U('Article/index',array('pid'=>3,'cid'=>23));?>" class="view-more">更多&gt;</a>
					</div>

					<div class="content-wrap">
						<div class="index-text-news">
							<?php if(is_array($jmyjList)): $i = 0; $__LIST__ = $jmyjList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$news): $mod = ($i % 2 );++$i;?><div class="item">
									<div class="title">
										<a href="<?php echo U('Article/detail',array('pid'=>3,'id'=>$news['id'],'cid'=>$news['cid']));?>" target="_blank"><?php echo ($news['title']); ?></a>
									</div>
									<!-- <span class="time"><?php echo ($news['date']); ?></span> -->
								</div><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!---part-3-->
		<div class="row">
			<div class="col-sm-4 col-xs-12">
				<div class="index-column-wrap">
					<div class="title-bar">
						<span class="caption">重点展会</span><span class="small-title">PUBLIC INFORMATION</span>
						<a href="<?php echo U('Article/index',array('pid'=>3,'cid'=>20));?>" class="view-more">&gt;更多</a>
					</div>

					<div class="content-wrap">
						<div class="index-fairs">
							<?php if(is_array($fairsList)): $i = 0; $__LIST__ = $fairsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a class="item" href="<?php echo U('Fairs/detail',array('pid'=>3,'id'=>$v['id'],'cid'=>$v['cid']));?>">
									<div class="title"><?php echo ($v['title']); ?></div>
									<div class="other">
										<p class=""><span class="glyphicon glyphicon-time"></span><?php echo ($v['times']); ?></p>
										<p class=""><span class="glyphicon glyphicon-map-marker"></span><?php echo ($v['place']); ?></p>
									</div>
								</a><?php endforeach; endif; else: echo "" ;endif; ?>

						</div>

					</div>
				</div>
			</div>
			<div class="col-sm-8 col-xs-12">
				<div class="index-column-wrap">
					<div class="title-bar">
						<span class="caption">企业商机</span><span class="small-title">PUBLIC INFORMATION</span>
						<a href="<?php echo U('Content/index',array('pid'=>4));?>" class="view-more">&gt;更多</a>
					</div>

					<div class="content-wrap">
						<div class="index-business">
							<?php if(is_array($businessList)): $i = 0; $__LIST__ = $businessList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="item">
									<div class="row">
										<div class="title col-sm-10">
											<span class="type"><?php echo ($businessTypeArr[$v['type']]); ?></span>
											<a href="<?php echo U('');?>"><?php echo ($v['title']); ?></a></div>
										<div class="time col-sm-2 hidden-xs"><?php echo ($v[date]); ?></div>
									</div>
								</div><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="m-footer-brand">
			<div class="clearfix">
				<a class="item" href="" target="_blank">
					<img src="/zlc/Uploads/brand/zgmch.jpg" alt="中国国际贸易促进委员会">
				</a>
				<a class="item" href="" target="_blank">
					<img src="/zlc/Uploads/brand/zggjsh.jpg" alt="中国国际商会">
				</a>
				<a class="item" href="" target="_blank">
					<img src="/zlc/Uploads/brand/zlgtlt.jpg" alt="中国-拉共体论坛">
				</a>
				<a class="item" href="" target="_blank">
					<img src="/zlc/Uploads/brand/zghg.jpg" alt="中国海关总署">
				</a>
				<a class="item" href="" target="_blank">
					<img src="/zlc/Uploads/brand/zhswyb.jpg" alt="珠海商务预报">
				</a>
				<a class="item" href="" target="_blank">
					<img src="/zlc/Uploads/brand/zhwstzxh.jpg" alt="珠海外商投资企业协会">
				</a>
				<a class="item" href="" target="_blank">
					<img src="/zlc/Uploads/brand/zhhg.jpg" alt="珠海海关">
				</a>
				<a class="item" href="" target="_blank">
					<img src="/zlc/Uploads/brand/jrhz.jpg" alt="今日会展">
				</a>
			</div>
		</div>

	</div>

	<!-- footer -->
	<div id="footer">
    <div class="container">
        <div class="content-wrap clearfix">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contact">
                        <p>地址:<?php echo ($baseInfo['addr']); ?></p>
                        <p>电话:<?php echo ($baseInfo['tel']); ?></p>
                        <p>传真:<?php echo ($baseInfo['fax']); ?></p>
                        <p>邮箱:<?php echo ($baseInfo['email']); ?></p>
                    </div>
                </div>
                <div class="col-sm-3 hidden-xs">
                    <div class="link clearfix ">
                        <?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($vo['url']); ?>" target="_blank"><?php echo ($vo['title']); ?></a>
                            <!-- <span class="fg">|</span> --><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="other">
                        <p>©2018 <?php echo ($baseInfo['site_name']); ?> All rights reserved </p><?php echo ($baseInfo['icp']); ?>
                    </div>
                </div>
            </div>




        </div>

    </div>
</div>
<div id="m-footer-bar">
    <div class="container">
        <div class="content-wrap clearfix">
            <!-- <span class="pull-left"><?php echo ($baseInfo['site_name']); ?></span> -->
            <!-- <span class="pull-right">©2018 <?php echo ($baseInfo['site_name']); ?> All rights reserved <?php echo ($baseInfo['icp']); ?></span> -->
        </div>
    </div>
</div>

</body>

</html>
<script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
<script type="text/javascript" src="/zlc/Public/Js/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/zlc/Public/Js/swiper/swiper.min.js"></script>
<script type="text/javascript">
	var mySwiper = new Swiper('.swiper-container', {
		pagination: '.swiper-pagination',
		paginationClickable: true,
		autoplay: 5000,
		speed: 1000,
	})
</script>