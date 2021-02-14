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
    <div class="panel-heading clearfix">
        <row>
            <?php if(!empty($_GET['classid'])): ?><div class="col-xs-4">
                    <div class="panel-title">当前班级：<strong><?php echo ($output['className']); ?></strong></div>
                </div>
                <div class="col-xs-1">
                    <?php $classId = $_GET['classid']; ?>
                    <a id="js-refresh-btn" href="javascript:" data-url="<?php echo U('refresh',array('classid'=>$classId));?>" class="btn btn-info btn-block">
                        <i class="icon icon-refresh"></i>刷新学习进度
                    </a>
                </div><?php endif; ?>
            
            <div class="col-xs-6">
                <form class="form form-inline f-right" action="/yikeyun/admin.php/Manage/Member/index/classid/4/p/3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="keywords" value="<?php echo ($_GET['keywords']); ?>" placeholder="请输入姓名或手机号">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">搜索</button>
                    </div>
                </form>
            </div>
        </row>


    </div>
    <div class="panel-body">
        <?php if(empty($output['list'])): echo ($emptyHtml); ?>
            <?php else: ?>
            <table class="table table-bordered" border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th width="200">头像</th>
                    <th width="200">姓名</th>
                    <th width="200">手机号</th>
                    <th>班级名称</th>
                    <th>报到状态</th>
                    <th>总学习进度</th>
                    <th>创建时间</th>
                    <th width="260">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($output['list'])): foreach($output['list'] as $key=>$vo): ?><tr>
                        <td>
                            <img src="<?php echo ((isset($vo["avatar"]) && ($vo["avatar"] !== ""))?($vo["avatar"]):'/Upload/avatar/default.jpg'); ?>" class="avatar" width="48" height="48" style="border-radius:50%;"/>
                        </td>
                        <td><?php echo ($vo["realname"]); ?></td>
                        <td><?php echo ($vo["mobile"]); ?></td>
                        
                        <td><?php echo ($vo['class_name']); ?></td>
                        <?php if ($vo['member_id']){?>
                        <td class="text-success"><i class="icon icon-ok-circle"></i>已报到</td>
                        <?php }else {?>
                        <td class="text-warning"><i class="icon icon-remove-circle"></i>未报到</td>
                        <?php }?>
                        <td><?php echo ($vo["progress"]); ?>%</td>
                        <td><?php echo ($vo['create_time']); ?></td>
                        <td class="operation-box">
                            <?php if(!empty($vo['member_id'])): ?><a href="<?php echo U('study_record','memberid='.$vo['member_id'].'&classid='.$vo['class_id']);?>" class="edit">学习记录</a>
                                <a href="<?php echo U('export_study_record','memberid='.$vo['member_id'].'&classid='.$vo['class_id']);?>" class="edit">导出学习记录</a><?php endif; ?>
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