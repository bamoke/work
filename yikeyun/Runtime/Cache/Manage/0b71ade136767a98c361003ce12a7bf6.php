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
        <div class="btn btn-info js-add-parent">添加一级分类</div>
        <div class="m-cate-tree" id="cateTree" data-del-url="<?php echo U('del_cate');?>">
            <?php echo ($output['tree']); ?>
        </div>
    </div>
</div>
<!--modal-->
<div class="modal" id="cateModal" style="width:800px;" role="dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">创建分类</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="cateForm" action="<?php echo U('save_cate');?>">
                <div class="form-group">
                    <label class="col-xs-2 control-label">分类名称:</label>
                    <div class="col-xs-6">
                        <input class="form-control" type="text" name="name" placeholder="请输入分类名称">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">所属类别:</label>
                    <div class="col-xs-6">
                        <input type="text" class="form-control js-input-parent-name" value="一级类别" readonly>
                        <input type="hidden" name="pid" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">分类标识:</label>
                    <div class="col-xs-6">
                        <input class="form-control" type="text" name="identification" placeholder="请输入分类标识">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                关闭
            </button>
            <button type="button" class="btn btn-primary js-submit-cate-form">
                提交保存
            </button>
        </div>
    </div>

</div>

        </div>
    </div>

</div>
</body>
</html>