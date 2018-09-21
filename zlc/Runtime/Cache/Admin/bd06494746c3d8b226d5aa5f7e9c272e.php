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
            <div class="panel">
    <div class="panel-body">
        <div class="u-page-title">
            <span class="caption">编辑</span>
        </div>
        <form name="single-form" class="form form-horizontal" action="<?php echo U('update',array('pid'=>$_GET['pid'],'id'=>$data['id']));?>">
            <input type="hidden" name="cid" value="<?php echo ($data['cid']); ?>">
            <div class="form-group">
                <label class="col-xs-2 control-label">关键词:</label>
                <div class="col-xs-8"><input type="text" name="keywords" class="form-control" value="<?php echo ($data['keywords']); ?>"></div>
            </div>
            <div class="form-group">
                <label class="col-xs-2 control-label">内容详情:</label>
                <div class="col-xs-8"><script id="editorContainer" name="content"><?php echo ($data['content']); ?></script></div>
            </div>
            <div class="form-group">
                <label class="col-xs-2 control-label">显示状态:</label>
                <div class="col-xs-4">
                    <label class="radio-inline">
                        <input type="radio" name="status" value="1" <?php if(($data['status']) == "1"): ?>checked<?php endif; ?> >显示</label>
                    <label class="radio-inline">
                        <input type="radio" name="status" value="0" <?php if(($data['status']) == "0"): ?>checked<?php endif; ?> >隐藏</label>
                </div>
            </div>
            <div class="form-group">
                    <div class="col-xs-2 col-xs-offset-2">
                        <button type="button" class="form-control btn-default" onclick="window.history.back()">返回</button>
                    </div>
                    <div class="col-xs-2">
                        <button type="submit" class="form-control btn-info">提交</button>
                    </div>
            </div>
        </form>

    </div>
    <div class="panel-foot"></div>
</div>
        </div>
    </div>

</div>
</body>
</html>