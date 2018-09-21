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
            <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">添加Banner</div>
    </div>
    <div class="panel-body">
        <div class="alert alert-info">
            <p>首页Banner尺寸，高度必须为400px,宽度至少1440px，建议1920px.</p>
            <p>其他Banner尺寸，高度必须为300px,宽度795px</p>
            <p>每个栏目最多显示五张Banner图</p>
        </div>
        <form name="banner-form" class="form form-horizontal" action="<?php echo U('save');?>" role="form">
            <div class="form-group">
                <label class="control-label col-xs-1"><span class="text-danger">*</span>展示位置:</label>
                <div class="col-xs-2">
                    <select name="position_key" class="form-control">
                        <option value="0">首页</option>
                        <?php if(is_array($cate)): foreach($cate as $key=>$pt): ?><option value="<?php echo ($pt['id']); ?>"><?php echo ($pt['title']); ?></option><?php endforeach; endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1"><span class="text-danger">*</span>上传图片:</label>
                    <div class="col-xs-2">
                        <div class="m-thumbnail-upload" id="js-thumb-upload-panel">
                            <a href="javascript:" class="add-btn js-add-btn"><i class="glyphicon glyphicon-plus-sign"></i></a>
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
                    <label class="control-label col-xs-1">标题:</label>
                    <div class="col-xs-4">
                        <input type="text" name="title" class="form-control" value="" placeholder="首页可不填写，其他栏目建议填写；15个字符以内">
                    </div>
                    <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">链接地址:</label>
                <div class="col-xs-4">
                    <input type="text" name="url" class="form-control" value="" placeholder="完整地址，以http或https开头">
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