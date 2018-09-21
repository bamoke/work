<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title><?php echo ($pageName); ?></title>
    <!-- <link href="/zlc/Public/Style/font-awesome.min.css" rel="stylesheet"> -->
    <link href="/zlc/Public/Js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/zlc/Admin/Assets/Style/default.css" rel="stylesheet">
    <link href="/zlc/Public/Js/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    
    <?php if(isset($output['script'])): $script = $output['script']; ?>
        <?php else: ?>
        <?php $script = 'Common/init'; endif; ?>
    <script type="text/javascript" src="/zlc/Public/Js/require/require.js" data-main="/zlc/Admin/Assets/Js/<?php echo ($script); ?>"></script>
    <script>
    const rootDir = '/zlc';
    </script>
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
                <img src="/zlc/Uploads/avatars/avatar.jpg" class="avatar">
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
        <?php echo ($nav); echo ($contentNav); ?>
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
    <form class="form-horizontal" role="form" name="conf-form" action="<?php echo U('save_conf');?>">
        <div class="form-group">
            <label for="sys-name" class="col-lg-1 control-label">站点名称：</label>
            <div class="col-lg-6">
                <input type="text" name="site_name" value="<?php echo ($output['config']['site_name']); ?>" class="form-control" id="sys-name" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-1 control-label">关键词</label>
            <div class="col-lg-6">
                <input type="text" name="keywords" value="<?php echo ($output['config']['keywords']); ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-1 control-label">网站描述：</label>
            <div class="col-lg-6">
                <textarea name="description" class="form-control"><?php echo ($output['config']['description']); ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-1 control-label">联系地址</label>
            <div class="col-lg-6">
                <input type="text" name="addr" value="<?php echo ($output['config']['addr']); ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-1 control-label">电话：</label>
            <div class="col-lg-3">
                <input type="text" name="tel" value="<?php echo ($output['config']['tel']); ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-1 control-label">传真：</label>
            <div class="col-lg-3">
                <input type="text" name="fax" value="<?php echo ($output['config']['fax']); ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-1 control-label">邮编：</label>
            <div class="col-lg-3">
                <input type="text" name="zipcode" value="<?php echo ($output['config']['zipcode']); ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-1 control-label">邮箱：</label>
            <div class="col-lg-3">
                <input type="text" name="email" value="<?php echo ($output['config']['email']); ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-1 control-label">QQ：</label>
            <div class="col-lg-3"><input type="text" name="qq" value="<?php echo ($output['config']['qq']); ?>" class="form-control" /></div>
        </div>
        <div class="form-group">
            <label class="col-lg-1 control-label">新浪微博：</label>
            <div class="col-lg-3"><input type="text" name="weibo" value="<?php echo ($output['config']['weibo']); ?>" class="form-control"
                /></div>
        </div>
        <div class="form-group">
            <label class="col-lg-1 control-label">ICP备案：</label>
            <div class="col-lg-3"><input type="text" name="icp" value="<?php echo ($output['config']['icp']); ?>" class="form-control" /></div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-3">
                <input type="submit" value="保存" class="btn btn-block btn-info" />
            </div>
        </div>
    </form>
</div>
        </div>
    </div>

</div>
</body>
</html>