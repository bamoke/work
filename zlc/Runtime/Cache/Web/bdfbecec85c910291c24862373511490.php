<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
  <meta name="renderer" content="webkit|ie-comp|ie-stand" />
  <meta name="author" content="中拉网" />
  <title>中拉合作网-<?php echo ($pageName); ?></title>
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
      <div class="banner column-banner">
          <img src="/zlc/Uploads/banner/<?php echo ($banner["img"]); ?>" alt="">
      </div>
    </div>
  </div>


  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <div id="sideBar" class="m-side-nav">
          <h3 class="parentCateName"><?php echo ($pageName); ?><br><span class="small">PRODUCTS</span></h3>
          <ul class="cateList"><?php echo ($childNavHtml); ?></ul>
        </div>
      </div>
      <div class="col-sm-9" id="bigContentBox">
        <div class="contentTopBar clearfix">
          <h4 class="pageName"><?php echo ($curCateName); ?></h4>
          <div class="location hidden-xs">
            当前位置：<a href="/">首页</a><span class="fg">&gt;</span><?php echo ($pageName); ?><span class="fg">&gt;</span><?php echo ($curCateName); ?>
          </div>
        </div>
        <div class="m-content-wrap"><div class="single-main-content">
        <div class="bar">
            <h2 class="title"><?php echo ($info['title']); ?></h2>
        </div>
        <div class="content">
            <?php echo ($info['content']); ?>
        </div>
    </div></div>
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
  $("#nav-switch-btn").click(function(){
    var $navList = $("#js-nav-list")
    $navList.toggleClass("hidden-xs");
  })
</script>