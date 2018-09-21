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
            <table class="table table-bordered" border="0" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <th width="200">用户</th>
        <th width="200">称呼</th>
        <th>状态</th>
        <!--<th width="300">操作</th>-->
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($output['list'])): $i = 0; $__LIST__ = $output['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["username"]); ?></td>
            <td><?php echo ($vo["realname"]); ?></td>
            <?php if ($vo['status'] == 1){?>
            <td class="text-success"><i class="icon icon-ok-circle"></i>正常</td>
            <?php }else {?>
            <td class="text-warning"><i class="icon icon-remove-circle"></i>禁用</td>
            <?php }?>

  <!--          <td class="operation-box">
                <a href="<?php echo U('edit','id='.$vo['id']);?>" class="edit">编辑</a>|
                <a href="javascript:" data-url="<?php echo U('reset','id='.$vo[id]);?>">重置密码</a>|
                <?php if($vo['status'] == 1){?>
                    <a href="javascript:" data-url="{:U('disable',array('id'=>$vo['id'],'status'=>0))}">禁用</a>
                <?php }else {?>
                    <a href="javascript:" data-url="{:U('disable',array('id'=>$vo['id'],'status'=>1))}">启用</a>
                <?php }?>

            </td>-->
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

    </tbody>
</table>
<div class="m-pagination">
    <?php echo ($outData['paging']); ?>
</div>
        </div>
    </div>

</div>
</body>
</html>