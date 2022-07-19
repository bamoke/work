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
            <div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">岗位列表</h3>
    </div>
    <div class="panel-body">
        <table class="table js-table-list">
            <thead>
                <tr>
                    <th>职位名称</th>
                    <th>公司名称</th>
                    <th width="150">招聘人数</th>
                    <th width="100">截至日期</th>
                    <th width="80">状态</th>
                    <th width="250">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($output['list'])): foreach($output['list'] as $key=>$list): ?><tr>
                        <td><a href="<?php echo U('edit',array('id'=>$list['id']));?>"><?php echo ($list['title']); ?></a></td>
                        <td><?php echo ($list["company"]); ?></td>
                        <td><?php echo ($list["person_limit"]); ?></td>
                        <td><?php echo ($list["end_date"]); ?></td>
                        <td>
                            <?php if($list['status'] == 1): ?><span class="text-success">正常</span>
                                <?php else: ?> 停止<?php endif; ?>
                        </td>
                        <td class="operation-box">
                            <a href="<?php echo U('edit',array('id'=>$list['id']));?>">修改</a>
                            <a href="javascript:" data-url="<?php echo U('del',array('id'=>$list['id']));?>" class="js-del-one">删除</a>
                        </td>
                    </tr><?php endforeach; endif; ?>

            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        <div class="m-pagination"><?php echo ($output['paging']); ?></div>
    </div>
</div>
        </div>
    </div>

</div>
</body>
</html>