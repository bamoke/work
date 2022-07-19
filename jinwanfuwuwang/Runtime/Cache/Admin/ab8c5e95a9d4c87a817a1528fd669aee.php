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

    <div class="panel-heading u-page-title">
            <span class="caption">Banner列表</span>
        <a href="<?php echo U('add');?>" class="btn btn-info">添加Banner</a>
    </div>

    <div class="panel-body">

        <table class="table js-table-list">
            <thead>
                <tr>
                    <th>缩略图</th>
                    <th width="200">图片说明</th>
                    <th width="300">链接地址</th>
                    <th width="80">显示</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($info)): foreach($info as $key=>$list): ?><tr>
                        <td width="200">
                            <img class="u-banner-thumb" src="/jinwanfuwuwang//Uploads/banner/<?php echo ($list['img']); ?>">
                        </td>
                        <td><?php echo ((isset($list['description'] ) && ($list['description'] !== ""))?($list['description'] ):"无"); ?></td>
                        <td><?php echo ((isset($list['url'] ) && ($list['url'] !== ""))?($list['url'] ):"无"); ?></td>
                        <td>
                            <?php if($list['status'] == 1): ?><span class="text-success">正常</span>
                                <?php else: ?> <span class="text-danger">不显示</span><?php endif; ?>
                        </td>
                        <td class="operation-box">
                            <a href="<?php echo U('edit',array('id'=>$list['id']));?>">修改</a>
                            <a href="javascript:" data-url="<?php echo U('Banner/del',array('id'=>$list['id']));?>" class="js-del-one">删除</a>
                        </td>
                    </tr><?php endforeach; endif; ?>

            </tbody>
        </table>


    </div>
    <div class="panel-footer">
        <div class="m-pagination">
            <?php echo ($pagination); ?>
        </div>
    </div>
</div>
        </div>
    </div>

</div>
</body>
</html>