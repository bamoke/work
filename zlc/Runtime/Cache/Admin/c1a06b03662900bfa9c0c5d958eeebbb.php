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
        <div class="panel-title">Banner修改</div>
    </div>
    <div class="panel-body">
        <form name="banner-form" class="form form-horizontal" action="<?php echo U('update');?>">
            <input type="hidden" name="id" value="<?php echo ($_GET['id']); ?>">
            <div class="form-group">
                <label class="control-label col-xs-1">展示位置:</label>
                <div class="col-xs-2">
                    <select name="position_key" class="form-control">
                        <option value="0" <?php if(($data['position_key']) == "0"): ?>selected<?php endif; ?> >首页</option>
                        <?php if(is_array($cate)): foreach($cate as $key=>$pt): ?><option value="<?php echo ($pt['id']); ?>" <?php if(($data['position_key']) == $pt['id']): ?>selected<?php endif; ?> ><?php echo ($pt['title']); ?></option><?php endforeach; endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">上传图片:</label>

                    <div class="col-xs-2">
                        <div class="m-thumbnail-upload" id="js-thumb-upload-panel">
                            <?php if(empty($data['img'])): ?><a href="javascript:" class="add-btn js-add-btn"><i class="glyphicon glyphicon-plus-sign"></i></a>
                                <div class="thumb-box hidden">
                                    <img class="thumb" style="">
                                    <span class="del-btn">删除</span>
                                </div>
                                <?php else: ?>
                                <a href="javascript:" class="add-btn js-add-btn hidden"><i class="glyphicon glyphicon-plus-sign"></i></a>
                                <div class="thumb-box">
                                    <img class="thumb" src="/zlc/Uploads/banner/<?php echo ($data['img']); ?>">
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
                    <label class="control-label col-xs-1">标题:</label>
                    <div class="col-xs-4">
                        <input type="text" name="title" class="form-control" value="" placeholder="首页可不填写，其他栏目建议填写；15个字符以内">
                    </div>
                    <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">链接地址:</label>
                <div class="col-xs-4">
                    <input type="text" name="url" class="form-control" value="<?php echo ($data['url']); ?>" placeholder="完整地址，以http或https开头">
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