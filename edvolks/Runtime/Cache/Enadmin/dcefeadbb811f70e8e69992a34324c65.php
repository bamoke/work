<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title><?php echo (APP_NAME); ?></title>
    <!-- <link href="/edvolks/Public/Style/font-awesome.min.css" rel="stylesheet"> -->
    <link href="/edvolks/Public/Js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/edvolks/Enadmin/Assets/Style/default.css" rel="stylesheet">
    <link href="/edvolks/Public/Js/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    
    <?php if(isset($output['script'])): $script = $output['script']; ?>
        <?php else: ?>
        <?php $script = 'Common/init'; endif; ?>
    <script type="text/javascript" src="/edvolks/Public/Js/require/require.js" data-main="/edvolks/Enadmin/Assets/Js/<?php echo ($script); ?>"></script>
    <script>
    const rootDir = '/edvolks';
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
                <img src="/edvolks/Uploads/avatars/default-avatar.png" class="avatar"><?php echo (session('realname')); ?><b class="caret"></b>
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
            <div class="panel">
    <div class="panel-body">
        <div class="u-page-title">
            <span class="caption">Add founder-member</span>
        </div>
        <form name="studio-form" class="form form-horizontal" action="<?php echo U('save',array('navid'=>$_GET['navid']));?>">
            <input type="hidden" name="cid" value="<?php echo ($_GET['cid']); ?>">
            <div class="form-group">
                <label class="control-label col-xs-2">
                    <span class="text-danger">*</span>English name:</label>
                <div class="col-xs-4">
                    <input type="text" name="en_name" class="form-control" value="" placeholder="">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">
                <span class="text-danger">*</span>Chinese name:</label>
                <div class="col-xs-4">
                    <input type="text" name="cn_name" class="form-control" value="" placeholder="">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2"><span class="text-danger">*</span>Person's title:</label>
                <div class="col-xs-6">
                    <input type="text" name="position" class="form-control">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">Introduce:</label>
                <div class="col-xs-6">
                    <script id="editorContainer" name="introduce"></script>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-2 col-xs-offset-2">
                    <button type="button" class="form-control btn-default" onclick="window.history.back()">Back</button>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="form-control btn-info">Send</button>
                </div>

            </div>
        </form>
    </div>
</div>
        </div>
    </div>

</div>
</body>
</html>