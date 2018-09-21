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
            <?php $info = $output['info']; ?>
<?php
$typeArr = array('single'=>'单页面','news'=>'文章列表',"download"=>"下载","custom"=>"自定义","product"=>"产品","pic"=>"图片"); ?>
<div class="panel">
    <div class="panel-body">
        <form class="form-horizontal" id="cateForm" action="<?php echo U('save_cate',array('actype'=>$actype));?>">
            <?php if(!empty($_GET['id'])): ?><input type="hidden" name="id" value="<?php echo ($_GET['id']); ?>"><?php endif; ?>
            <?php if(!empty($_GET['id'])): ?><input type="hidden" name="id" value="<?php echo ($_GET['id']); ?>"><?php endif; ?>
            <div class="form-group">
                <label class="col-xs-2 control-label">栏目名称:</label>
                <div class="col-xs-4">
                    <input class="form-control" type="text" name="title" placeholder="请输入栏目名称" value="<?php echo ($info['title']); ?>">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="col-xs-2 control-label">栏目英文名称:</label>
                <div class="col-xs-4">
                    <input class="form-control" type="text" name="en_title" placeholder="请输入栏目名称" value="<?php echo ($info['en_title']); ?>">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>

            <div class="form-group">
                <label class="col-xs-2 control-label">所属栏目:</label>
                <div class="col-xs-4">

                    <select name="pid" id="js-change" class="form-control">
                        <option value="0">一级栏目</option>
                        <?php if(is_array($cate)): foreach($cate as $key=>$vo): ?><option value="<?php echo ($vo['id']); ?>" <?php if(($info['pid']) == $vo['id']): ?>selected<?php endif; ?> ><?php echo ($vo['title']); ?>
                            </option><?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>

            <div class="form-group">
                <label class="col-xs-2 control-label">首页导航:</label>
                <div class="col-xs-4">
                    <label class="radio-inline">
                        <input name="is_nav" type="radio" value="0" <?php if(($info['is_nav']) != "1"): ?>checked<?php endif; ?> >否</label>
                    <label class="radio-inline">
                        <input name="is_nav" type="radio" value="1" <?php if(($info['is_nav']) == "1"): ?>checked<?php endif; ?> >是</label>
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <?php if(($actype) == "add"): ?><div class="form-group">
                    <label class="col-xs-2 control-label">栏目类型:</label>
                    <div class="col-xs-4">
                        <select name="type" id="js-column-type" class="form-control">
                            <option value="">请选择</option>
                            <option value="single" <?php if(($info['type']) == "single"): ?>selected<?php endif; ?> >单页面
            </option>
            <option value="news" <?php if(($info['type']) == "news"): ?>selected<?php endif; ?> >文章列表
            </option>
            <option value="download" <?php if(($info['type']) == "download"): ?>selected<?php endif; ?> >图片
            </option>
            <option value="custom" <?php if(($info['type']) == "custom"): ?>selected<?php endif; ?> >自定义
            </option>
            <!-- <option value="product" <?php if(($info['type']) == "product"): ?>selected<?php endif; ?> >产品</option> -->
            </select>
            </div>
            <div class="col-xs-3 js-tips"></div>
            </div>
            <?php else: ?>
            <div class="form-group">
                <label class="col-xs-2 control-label">栏目类型:</label>
                <div class="col-xs-4">
                    <input class="form-control" readonly type="text" value="<?php echo ($typeArr[$info['type']]); ?>">
                    <input type="hidden" id="js-column-type" name="type" value="<?php echo ($info['type']); ?>">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div><?php endif; ?>
            <div class="form-group <?php if(($info[type]) != "custom"): ?>hidden<?php endif; ?>" id="js-router-set">
                <label class="col-xs-2 control-label">路由设置:</label>
                <div class="col-xs-2">
                    <input class="form-control" type="text" placeholder="控制器名称" name="controller_name" value="<?php echo ($info['controller_name']); ?>" <?php if(($info["type"]) != "custom"): ?>disabled<?php endif; ?> >
                </div>
                <div class="col-xs-2">
                    <input class="form-control" type="text" placeholder="方法名称" name="action_name" value="<?php echo ($info['action_name']); ?>" <?php if(($info["type"]) != "custom"): ?>disabled<?php endif; ?> >
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <!--            <div class="form-group">
                <label class="col-xs-2 control-label">栏目关键词:</label>
                <div class="col-xs-4">
                    <input class="form-control" type="text" name="keyword" value="<?php echo ($info['keyword']); ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-2 control-label">栏目描述:</label>
                <div class="col-xs-4">
                    <textarea class="form-control" type="text" name="description"><?php echo ($info['description']); ?></textarea>
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div> -->
            <div class="form-group">
                <div class="col-xs-2 col-xs-offset-2">
                    <a href="javascript:window.history.back()" class="btn-block btn btn-default" type="button">返回</a>
                </div>
                <div class="col-xs-2">
                    <button class="btn-block btn btn-info" type="submit">提交</button>
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