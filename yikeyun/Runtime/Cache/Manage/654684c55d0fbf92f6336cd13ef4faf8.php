<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title><?php echo ($pageName); ?></title>
    <link href="/yikeyun/./Manage/Asset/Css/font-awesome.min.css" rel="stylesheet">
    <link href="/yikeyun/Public/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/yikeyun/Public/lib/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="/yikeyun/./Manage/Asset/Css/default.css" rel="stylesheet">
    <script>
     const rootDir = "/yikeyun";
    </script>
    
    <?php if(isset($output['script'])): $script = $output['script']; ?>
        <?php else: ?>
        <?php $script = 'Common/init'; endif; ?>
    <script type="text/javascript" src="/yikeyun/Public/lib/require/require.js" data-main="/yikeyun/./Manage/Asset/Js/<?php echo ($script); ?>"></script>
</head>
<body>
<div id="loadingProgress"></div>
<div id="header" class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header">
        <!--<div class="navbar-brand">logo</div>-->
        <p class="navbar-text"><?php echo (APP_NAME); ?></p>
    </div>

    <ul class="nav navbar-nav navbar-right">
<!--        <li>
            <a href="#">
                <i class="icon-bell-alt"></i>消息
                <span class="badge">8</span>
            </a>
        </li>-->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="/yikeyun/Upload/avatar/avatar.jpg" class="avatar">
                <?php echo (session('realname')); ?>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo U('Main/logout');?>">退出登陆</a></li>
            </ul>
        </li>
    </ul>
</div>
<div class="g-wrap">
    <div id="side-menu">
    <ul>
        <?php echo ($nav); ?>
    </ul>

</div>
    <div class="g-main-wrap">
        <div class="g-main-top">
    <div class="page-name"><?php echo ($mainTop['bigTitle']); ?></div>
    <ul class="m-sub-nav f-cb">
        <?php echo ($mainTop['childMenu']); ?>
    </ul>

</div>
        <div class="g-main-content">
            <div class="panel">
    <div class="panel-body">
        <div class="u-page-title">
            <span class="caption"> <?php echo ($pageTitle); ?></span>
            <a href="<?php echo U('banner',array('t'=>'add'));?>" class="btn btn-danger">添加Banner</a>
        </div>
        <div class="alert alert-info">
            <p>只有首页可以展示多张图片轮播。Banner建议尺寸宽度750px,高度320px</p>
        </div>
        <table class="table js-table-list">
            <thead>
            <tr>
                <th width="300">缩略图</th>
                <th width="200">说明</th>
                <th>展示位置</th>
                <th width="200">链接地址</th>
                <th>显示</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($bannerList)): foreach($bannerList as $key=>$list): ?><tr>
                    <td><img class="u-banner-thumb" src="<?php echo (UPLOAD); ?>/banner/<?php echo ($list['img']); ?>"></td>
                    <td><?php echo ($list['title']); ?></td>
                    <td><?php echo ($list['position_key'] == 1?"首页":"在线测试栏目"); ?></td>
                    <td><?php echo ($list['url']); ?></td>
                    <td>
                        <?php if($list['status'] == 1): ?><span class="text-success">正常</span>
                            <?php else: ?>
                            隐藏<?php endif; ?>
                    </td>
                    <td class="operation-box">
                        <a href="<?php echo U('banner',array('t'=>'edit','id'=>$list['id']));?>">修改</a>
                        <a href="javascript:" data-url="<?php echo U('banner_del',array('id'=>$list['id']));?>" class="js-del-one">删除</a>
                    </td>
                </tr><?php endforeach; endif; ?>

            </tbody>
        </table>


    </div>
</div>
        </div>
    </div>

</div>
</body>
</html>