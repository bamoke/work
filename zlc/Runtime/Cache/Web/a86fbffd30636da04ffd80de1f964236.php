<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
  <meta name="renderer" content="webkit|ie-comp|ie-stand" />
  <meta name="author" content="中拉网" />
  <title><?php echo ((isset($siteTitle) && ($siteTitle !== ""))?($siteTitle):$baseInfo['site_name'].'-'.$pageName); ?></title>
  <meta name="keywords" content="<?php echo ((isset($siteKeywords) && ($siteKeywords !== ""))?($siteKeywords):$baseInfo['keywords']); ?>" />
  <meta name="description" content="<?php echo ((isset($siteDescription) && ($siteDescription !== ""))?($siteDescription):$baseInfo['description']); ?>" />
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
          <?php if(!empty($banner['img'])): ?><img src="/zlc/Uploads/banner/<?php echo ($banner["img"]); ?>" alt=""><?php endif; ?>  
      </div>
    </div>
  </div>


  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <div id="sideBar" class="m-side-nav">
          <h3 class="parentCateName"><?php echo ($parentName); ?><br><span class="small"><?php echo strtoupper($parentEnName);?></span></h3>
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
        <div class="m-content-wrap"><?php if(!empty($data)): ?><ul class="m-imgtext m-imgtext-big">
                <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li class="item">
                        <?php if($vo['thumb']): ?><a href="<?php echo U('detail',array('cid'=>$vo['cid'],'id'=>$vo['id']));?>" class="img-box">
                                <img src="/zlc/Uploads/thumb/<?php echo ($vo['thumb']); ?>" alt="<?php echo ($vo['title']); ?>">
                            </a><?php endif; ?>
            
                        <div class="text-box">
                            <a class="title" href="<?php echo U('detail',array('pid'=>$curPid,'cid'=>$vo['cid'],'id'=>$vo['id']));?>"><?php echo ($vo['title']); ?></a>
                            <p class="desc"><?php echo ($vo['description']); ?></p>
                            <p class=""><span class="glyphicon glyphicon-time"></span><?php echo ($vo['times']); ?></p>
                            <p class=""><span class="glyphicon glyphicon-map-marker"></span><?php echo ($vo['place']); ?></p>
                        </div>
                    </li><?php endforeach; endif; ?>
            
            </ul>
            
            <div class="m-pagination">
                <?php echo ($page); ?>
            </div>
    <?php else: ?>
    <div class="m-empty">
        <img src="/zlc/Web/Assets/images/null-page-draw.png">
        <div class="tips">暂无相关记录！</div>
    </div><?php endif; ?>
</div>
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