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
            <div class="panel">
    <div class="panel-body">
        <div class="u-page-title">
            <span class="caption">文章列表</span>
            <a href="<?php echo U('index',array('pid'=>$_GET['pid'],'cid'=>$_GET['cid'],'actype'=>'add'));?>" class="btn btn-info">添加文章</a>
        </div>
        <table class="table js-table-list">
            <thead>
                <tr>
                    <th>标题</th>
                    <th width="80">状态</th>
                    <th width="80">是否推荐</th>
                    <th width="80">访问量</th>
                    <th width="200">发布时间</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($data)): foreach($data as $key=>$list): ?><tr>
                        <td><?php echo ($list['title']); ?></td>
                        <td>
                            <?php if($list['status'] == 1): ?><span class="text-success">正常</span>
                                <?php else: ?> 隐藏<?php endif; ?>
                        </td>
                        <td>
                            <?php if($list['recommend'] == 1): ?><span class="text-danger">推荐</span>
                                <?php else: ?> 否<?php endif; ?>
                        </td>
                        <td><?php echo ($list['click']); ?></td>
                        <td><?php echo ($list['create_time']); ?></td>
                        <td class="operation-box">
                            <a href="<?php echo U('index',array('pid'=>$_GET['pid'],'id'=>$list['id'],'actype'=>'edit','cid'=>$list['cid']));?>">修改</a>
                            <!-- <a href="javascript:" data-url="<?php echo U('del',array('id'=>$list['id'],'type'=>$pageType));?>" class="js-del-one">删除</a> -->
                        </td>
                    </tr><?php endforeach; endif; ?>

            </tbody>
        </table>
        <div class="m-pagination"><?php echo ($page); ?></div>
    </div>
</div>
        </div>
    </div>

</div>
</body>
</html>