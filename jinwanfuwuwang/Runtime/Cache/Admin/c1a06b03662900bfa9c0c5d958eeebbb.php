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
        <div class="panel-title">Banner修改</div>
    </div>
    <div class="panel-body">
        <form name="banner-form" class="form form-horizontal" action="<?php echo U('Banner/update');?>">
            <input type="hidden" name="id" value="<?php echo ($_GET['id']); ?>">
            <div class="form-group">
                <label class="control-label col-xs-1">上传图片:</label>

                    <div class="col-xs-2">
                        <div class="m-thumbnail-upload" id="js-thumb-upload-panel">
                            <?php if(empty($data['img'])): ?><a href="javascript:" class="add-btn js-add-btn"></a>
                                <div class="thumb-box hidden">
                                    <img class="thumb" style="">
                                    <span class="del-btn">删除</span>
                                </div>
                                <?php else: ?>
                                <a href="javascript:" class="add-btn js-add-btn hidden"></a>
                                <div class="thumb-box">
                                    <img class="thumb" src="/jinwanfuwuwang/Uploads/banner/<?php echo ($data['img']); ?>">
                                    <span class="del-btn">删除</span>
                                </div>
                                <input type="hidden" class="js-old-thumb" name="old_img" value="<?php echo ($data['img']); ?>"><?php endif; ?>
                            <input type="file" name="img" class="js-file-input" style="display: none;">
                        </div>
                    </div>
  
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">排序:</label>
                <div class="col-xs-2">
                    <input type="number" name="sort" class="form-control" value="<?php echo ($data['sort']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">状态:</label>
                <div class="col-xs-2">
                    <label class="radio-inline">
                        <input type="radio" name="status" id="" value="1" <?php if(($data['status']) == "1"): ?>checked<?php endif; ?> >显示</label>
                    <label class="radio-inline">
                        <input type="radio" name="status" id="" value="0" <?php if(($data['status']) == "0"): ?>checked<?php endif; ?> >隐藏</label>
                </div>
            </div>
            <div class="form-group">
                    <label class="control-label col-xs-1">图片说明:</label>
                    <div class="col-xs-4">
                        <input type="text" name="description" class="form-control" value="<?php echo ($data['description']); ?>" maxlength="36" placeholder="15个字符以内">
                    </div>
                    <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">链接地址:</label>
                <div class="col-xs-4">
                    <input type="text" name="url" class="form-control" value="<?php echo ($data['url']); ?>" placeholder="">
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