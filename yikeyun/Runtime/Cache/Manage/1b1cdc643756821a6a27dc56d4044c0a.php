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
        <h3 class="panel-title">
            <?php echo ($output['memberName']); ?>的学习记录
            <button type="button" onclick="window.history.back()" class="btn btn-info btn-inline">返回</button>
        </h3>
    </div>
    <div class="panel-body">
        <?php if(empty($output['list'])): echo ($emptyHtml); ?>
            <?php else: ?>
            <table class="table table-bordered" border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th>课程名称</th>
                    <?php if(($vo['type']) == "1"): ?><th>章节名称</th><?php endif; ?>
                    <th>学习进度</th>
                    <th width="200">观看至</th>
                    <th>观看时间</th>
                    <!--<th width="80">操作</th>-->
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($output['list'])): foreach($output['list'] as $key=>$vo): ?><tr>
                        <td><?php echo ($vo['course_name']); ?></td>
                        <?php if(($vo['type']) == "1"): ?><td><?php echo ($vo['section_name']); ?></td><?php endif; ?>
                        <td class="<?php if(($vo[complete]) == "100"): ?>text-success<?php endif; ?>"><?php echo ($vo["complete"]); ?>%</td>
                        <td><?php echo ($vo['record_time']); ?></td>
                        <td><?php echo ($vo['update_time']); ?></td>
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