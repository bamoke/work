<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <title><?php echo ($siteConfig['site_name']); ?></title>
    <link href="/nujiang/Web/Static/css/style.css?v=<?php echo time() ?>" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/nujiang/Web/Static/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="/nujiang/Web/Static/js/jquery.SuperSlide.js"></script>
    <style type="text/css">
        html,
        body {
            margin: 0;
            padding: 0;
        }

        .iw_poi_title {
            color: #CC5522;
            font-size: 14px;
            font-weight: bold;
            overflow: hidden;
            padding-right: 13px;
            white-space: nowrap
        }

        .iw_poi_content {
            font: 12px arial, sans-serif;
            overflow: visible;
            padding-top: 4px;
            white-space: -moz-pre-wrap;
            word-wrap: break-word
        }
    </style>
    <script type="text/javascript" src="/nujiang/Web/Static/js/main.js"></script>




</head>

<body>
    <div class="wrapper">
        <div id="header">
    <div class="k1120 clearfix">
        <div id="menu">
            <ul class="clearfix">
                <li><a href="<?php echo U('Index/index');?>" class="nav_home <?php if($curPage == 'index') echo 'current' ?>"><span>首页</span></a></li>
                <li><a href="<?php echo U('Jobs/index');?>" class="nav_pro <?php if($curPage == 'jobs') echo 'current' ?>"><span>岗位信息</span></a></li>
                <li><a href="<?php echo U('News/index',array('cid'=>8));?>" class="nav_news <?php if($curPage == 'news' && $_GET['cid'] == 8) echo 'current' ?>"><span>工作动态</span></a></li>
                <li><a href="<?php echo U('News/index',array('cid'=>9));?>" class="nav_news <?php if($curPage == 'news' && $_GET['cid'] == 9) echo 'current' ?>"><span>奖励政策</span></a></li>
                <li><a href="<?php echo U('News/index',array('cid'=>10));?>" class="nav_news <?php if($curPage == 'news' && $_GET['cid'] == 10) echo 'current' ?>"><span>办事指南</span></a></li>
                <li><a href="<?php echo U('Single/index',array('id'=>1));?>" class="nav_save <?php if($curPage == 'single' && $_GET['id'] == 1) echo 'current' ?>"><span>怒江风情</span></a></li>
                <li><a href="<?php echo U('Single/index',array('id'=>11));?>" class="nav_save <?php if($curPage == 'single' && $_GET['id'] == 11) echo 'current' ?>"><span>珠海概况</span></a></li>
                <li><a href="<?php echo U('Index/about');?>" class="nav_save <?php if($curPage == 'about') echo 'current' ?>"><span>关于我们</span></a></li>
                <li><a href="<?php echo U('Index/contact');?>" class="nav_save <?php if($curPage == 'contact') echo 'current' ?>"><span>联系我们</span></a></li>

            </ul>
        </div>
    </div>
</div>
        <div class="pageMain">
            <div class="sub-banner"></div>
<div class="k1120">
    <div class="job-table">
      <table width="100%" cellpadding="0">
        <tr>
          <th width="20%" align="left">岗位名称</th>
          <th width="30%" align="left">公司名称</th>
          <th width="10%">招聘人数</th>
          <th width="10%">薪资待遇</th>
          <th width="10%">招聘截至</th>
          <th width="10%">发布日期</th>
          <th width="10%">查看</th>
        </tr>
        <?php if(is_array($jobsList)): $i = 0; $__LIST__ = $jobsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$job): $mod = ($i % 2 );++$i;?><tr>
            <td><a class="jobname" href="<?php echo U('detail',array('id'=>$job['id']));?>" target="_blank"><?php echo ($job['title']); ?></a></td>
            <td><?php echo ($job['company']); ?></td>
            <td align="center"><?php echo ($job['person_limit']); ?></td>
            <td align="center"><?php echo ($job['wage']); ?></td>
            <td align="center"><?php echo ($job['end_date']); ?></td>
            <td align="center"><?php echo ($job['create_time']); ?></td>
            <td align="right"><a href="<?php echo U('detail',array('id'=>$job['id']));?>" target="_blank" class="newsListView">查看详情</a> </td>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      </table>
    </div>
    <div class="m-paging">
        <?php echo ($outData['page']); ?>
    </div>
</div>
        </div>
        <div class="footer">
    <p class="copyright">©2019 珠海市人力资源网 All rights reserved <?php echo ($siteConfig['icp']); ?></p>
</div>
    </div>

</body>

</html>