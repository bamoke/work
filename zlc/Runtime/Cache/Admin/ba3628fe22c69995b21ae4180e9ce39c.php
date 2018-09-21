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
            <span class="caption">编辑展会</span>
        </div>
        <form name="fairs-form" class="form form-horizontal" action="<?php echo U('update',array('pid'=>$_GET['pid'],'id'=>$_GET['id']));?>">
            <input type="hidden" name="cid" value="<?php echo ($data["cid"]); ?>">
            <div class="form-group">
                <label class="control-label col-xs-2">
                    <span class="text-danger">*</span>展会名称:</label>
                <div class="col-xs-6">
                    <input type="text" name="title" class="form-control" value="<?php echo ($data["title"]); ?>" placeholder="建议20个字符以内">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">召开时间:</label>
                <div class="col-xs-6">
                    <input type="text" name="times" class="form-control" value="<?php echo ($data["times"]); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">召开地点:</label>
                <div class="col-xs-6">
                    <input type="text" name="place" class="form-control" value="<?php echo ($data["place"]); ?>" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">是否推荐:</label>
                <div class="col-xs-6">
                    <label class="radio-inline">
                        <input type="radio" name="recommend" value="1" <?php if(($data['recommend']) == "1"): ?>checked<?php endif; ?> />是</label>
                    <label class="radio-inline">
                        <input type="radio" name="recommend" value="0" <?php if(($data['recommend']) == "0"): ?>checked<?php endif; ?>  />否</label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">显示状态:</label>
                <div class="col-xs-8">
                    <label class="radio-inline"><input type="radio" name="status" value="1" <?php if($data['status'] == 1): ?>checked<?php endif; ?> />显示</label>
                    <label class="radio-inline"><input type="radio" name="status" value="0" <?php if($data['status'] == 0): ?>checked<?php endif; ?> />隐藏</label>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">内容详情:</label>
                <div class="col-xs-6">
                    <script id="editorContainer" name="content"><?php echo ($data['content']); ?></script>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-2 col-xs-offset-2">
                    <button type="button" class="form-control btn-default" onclick="window.history.back()">返回列表</button>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="form-control btn-info">提交</button>
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