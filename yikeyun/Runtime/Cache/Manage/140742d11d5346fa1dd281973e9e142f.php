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
            <a href="<?php echo U('add');?>" class="btn btn-info">添加班级</a>
    </div>
    <div class="panel-body">
        <?php if(empty($output['list'])): echo ($emptyHtml); ?>
            <?php else: ?>
            <table class="table table-bordered m-product-list" border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th width="200">名称</th>
                    <th width="">介绍</th>
                    <th width="">创建时间</th>
                    <th width="300">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($output['list'])): foreach($output['list'] as $key=>$vo): ?><tr>
                        <!-- <td><div class="avatar-box"><img src="<?php echo (UPLOAD); ?>/thumb/<?php echo ($vo['logo']); ?>" class="avatar" /></div> </td> -->
                        <td><?php echo ($vo['name']); ?></td>
                        <td><?php echo ($vo['description']); ?></td>
                        <td><?php echo ($vo['create_time']); ?></td>
                        <td>
                            <a class="btn btn-inline btn-primary btn-sm" href="<?php echo U('Course/index',array('classid'=>$vo['id']));?>">班级课程</a>&nbsp;&nbsp;
                             <a class="btn btn-inline btn-primary btn-sm" href="<?php echo U('Member/index',array('classid'=>$vo['id']));?>">班级学员</a> &nbsp;&nbsp;
                             <a class="btn btn-inline btn-warning btn-sm" href="<?php echo U('edit',array('id'=>$vo['id']));?>">修改</a></td>
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