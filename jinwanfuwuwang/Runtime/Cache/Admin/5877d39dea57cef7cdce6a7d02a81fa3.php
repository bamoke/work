<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title><?php echo ($pageName); ?></title>
    <link href="/jinwanfuwuwang/Admin/Assets/Style/font-awesome.min.css" rel="stylesheet">
    <link href="/jinwanfuwuwang/Admin/Assets/Plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/jinwanfuwuwang/Admin/Assets/Style/default.css" rel="stylesheet">
    <link href="/jinwanfuwuwang/Admin/Assets/Plugins/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    
    <?php if(isset($output['script'])): $script = $output['script']; ?>
        <?php else: ?>
        <?php $script = 'Common/init'; endif; ?>
    <script type="text/javascript" src="/jinwanfuwuwang/Admin/Assets/Plugins/require/require.js" data-main="/jinwanfuwuwang/Admin/Assets/Js/<?php echo ($script); ?>"></script>
    <script>
    const rootDir = '/jinwanfuwuwang/Admin';
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
                <img src="/jinwanfuwuwang/Admin/Assets/Images/default-avatar.png" class="avatar">
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
            <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">添加Banner</div>
    </div>
    <div class="panel-body">
        <div class="alert alert-info">
            <p>Banner尺寸，建议宽度：1200像素,高度：360像素.</p>
            <p>前台最多显示五张Banner图</p>
        </div>
        <form name="banner-form" class="form form-horizontal" action="<?php echo U('Banner/save');?>" role="form">
            <input type="hidden" name="position_key" value="1">
            <div class="form-group">
                <label class="control-label col-xs-1"><span class="text-danger">*</span>上传图片:</label>
                    <div class="col-xs-2">
                        <div class="m-thumbnail-upload" id="js-thumb-upload-panel">
                            <a href="javascript:" class="add-btn js-add-btn"></a>
                            <div class="thumb-box hidden">
                                <img class="thumb" style="">
                                <span class="del-btn">删除</span>
                            </div>
                            <input type="file" name="img" class="js-file-input" style="display: none;">
                        </div>
                    </div>

            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">排序:</label>
                <div class="col-xs-1">
                    <input type="number" name="sort" class="form-control" value="0">
                </div>
            </div>
            <div class="form-group">
                    <label class="control-label col-xs-1">图片描述:</label>
                    <div class="col-xs-4">
                        <input type="text" name="title" class="form-control" value="" maxlength="24" placeholder="15个字符以内">
                    </div>
                    <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">链接地址:</label>
                <div class="col-xs-4">
                    <input type="text" name="url" class="form-control" value="" placeholder="请联系小程序开发人员获取链接地址">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>


            <div class="form-group">
                <div class="col-xs-2 col-xs-offset-1">
                    <button type="button" class="form-control btn-default" onclick="window.history.back()">返回列表</button>
                </div>
                <div class="col-xs-2">
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