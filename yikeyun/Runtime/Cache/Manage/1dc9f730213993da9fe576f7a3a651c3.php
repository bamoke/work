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
            <div>
    <form class="form-horizontal" role="form" name="user-form" action="<?php echo U('save');?>">
        <div class="form-group">
            <label for="username" class="col-lg-1 control-label">用户名：</label>
            <div class="col-lg-3">
                <input type="text" name="username" value="" class="form-control" id="username" placeholder="建议使用工号作为用户名"/>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-lg-1 control-label">设置密码：</label>
            <div class="col-lg-3"><input type="password" name="password" class="form-control" id="password" placeholder="请输入密码" /></div>
        </div>
        <div class="form-group">
            <label for="realname" class="col-lg-1 control-label">称呼或姓名：</label>
            <div class="col-lg-3"><input type="text" name="realname" class="form-control" id="realname" placeholder="如：小王或王思聪" /></div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-3">
                <input type="submit" value="提交" class="btn btn-block btn-info"/>
            </div>
        </div>
    </form>
</div>
        </div>
    </div>

</div>
</body>
</html>