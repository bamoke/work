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
            <style type="text/css">
    .course-thumb-box {
        width: 120px;
        height: 60px;
    }
</style>
<div class="panel">
    <div class="panel-heading">
        <a href="<?php echo U('add');?>" class="btn btn-info">添加课程</a>
    </div>
    <div class="panel-body">
        <?php if(empty($output['list'])): echo ($emptyHtml); ?>
            <?php else: ?>
            <table class="table table-bordered m-product-list" border="0" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="80" id="js-order-title" data-url="<?php echo U('changeorder');?>">排序</th>
                        <th width="150">封面</th>
                        <th width="300">课程名称</th>
                        <th width="150">课程类型</th>
                        <th width="80">主讲老师</th>

                        <th width="65">总章节</th>
                        <th width="65">状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($output['list'])): foreach($output['list'] as $key=>$vo): ?><tr <?php if($vo['recommend'] == 1): ?>style="background-color:#fff7e5;"<?php endif; ?> >
                            <td><input type="number" min="1" data-id="<?php echo ($vo['id']); ?>" data-val="<?php echo ($vo['sort']); ?>" class="form-control js-order-input"
                                    value="<?php echo ($vo['sort']); ?>"></td>
                            <td>
                                <div class="course-thumb-box"><img width="120" height="60" src="<?php echo ((isset($vo['thumb']) && ($vo['thumb'] !== ""))?($vo['thumb']):'$Think.const.UPLOAD/thumb/course-default.jpg'); ?>" /></div>
                            </td>
                            <td><?php echo ($vo['title']); ?></td>
                            <td><?php echo ($vo['typename']); ?></td>
                            <td><?php echo ($vo['teacher_name']); ?></td>


                            <td><?php echo ($vo['period']); ?></td>
                            <td>
                                <?php if($vo['status'] == 1): ?><span class="text-success">上架中</span>
                                    <?php else: ?>
                                    <span class="text-danger">已下架</span><?php endif; ?>
                            </td>
                            <td class="operation-box">
                                <a href="<?php echo U('edit',array('id'=>$vo['id']));?>">编辑</a><?php if(($vo['type']) == "1"): ?><span class="fg">|</span><a href="<?php echo U('section',array('cid'=>$vo['id']));?>">课程章节</a><?php endif; ?>
                            </td>
                        </tr><?php endforeach; endif; ?>

                </tbody>
            </table><?php endif; ?>

    </div>
    <div class="panel-footer">
        <div class="m-pagination">
            <?php echo ($output['paging']); ?>
        </div>
    </div>
</div>
        </div>
    </div>

</div>
</body>
</html>