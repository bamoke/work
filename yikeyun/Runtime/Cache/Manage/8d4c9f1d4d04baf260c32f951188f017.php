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
    <div class="panel-heading">
        <div class="panel-title">添加机构</div>
    </div>
    <div class="panel-body">
        <form name="add-form" class="form form-horizontal" action="<?php echo U('a_add');?>">
            <div class="form-group">
                <label class="control-label col-xs-2">机构名称:</label>
                <div class="col-xs-5">
                    <input type="text" name="name" class="form-control" value="">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">机构LOGO:</label>
                <div class="col-xs-2">
                    <div class="m-thumbnail-upload" id="js-thumb-upload-panel">
                        <a href="javascript:" class="add-btn js-add-btn"></a>
                        <div class="thumb-box hidden"><img class="thumb" style=""><span class="del-btn">删除</span> </div>
                        <input type="file" name="thumb" class="js-file-input" style="opacity: 0">
                    </div>
                </div>
                <div class="col-xs-3 tips">建议尺寸：250px×250px,格式jpg或png</div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">电话:</label>
                <div class="col-xs-5">
                    <input type="text" name="tel" class="form-control" value="">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">地址:</label>
                <div class="col-xs-5">
                    <input type="text" name="addr" class="form-control" value="">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">联系人:</label>
                <div class="col-xs-5">
                    <input type="text" name="contact" class="form-control" value="">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">详细介绍:</label>
                <div class="col-xs-8">
                    <script id="editorContainer" name="introduce"></script>
                </div>
                <div class="col-xs-3 tips"></div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-1"><button type="button" class="form-control btn-default" onclick="window.history.back()">返回</button></div>
                <div class="col-xs-2"><button type="submit" class="form-control btn-info">提交</button></div>

            </div>
        </form>
    </div>
</div>
        </div>
    </div>

</div>
</body>
</html>