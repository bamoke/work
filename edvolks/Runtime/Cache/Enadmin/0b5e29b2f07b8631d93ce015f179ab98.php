<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title><?php echo (APP_NAME); ?></title>
    <!-- <link href="/edvolks/Public/Style/font-awesome.min.css" rel="stylesheet"> -->
    <link href="/edvolks/Public/Js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/edvolks/Enadmin/Assets/Style/default.css" rel="stylesheet">
    <link href="/edvolks/Public/Js/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    
    <?php if(isset($output['script'])): $script = $output['script']; ?>
        <?php else: ?>
        <?php $script = 'Common/init'; endif; ?>
    <script type="text/javascript" src="/edvolks/Public/Js/require/require.js" data-main="/edvolks/Enadmin/Assets/Js/<?php echo ($script); ?>"></script>
    <script>
    const rootDir = '/edvolks';
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
                <img src="/edvolks/Uploads/avatars/default-avatar.png" class="avatar"><?php echo (session('realname')); ?><b class="caret"></b>
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
            <span class="caption">List</span>
            <a href="<?php echo U('add',array('navid'=>$_GET['navid'],'cid'=>$_GET['cid']));?>" class="btn btn-info">Add</a>
        </div>
        <table class="table js-table-list">
            <thead>
                <tr>
                    <th width="120">thumb</th>
                    <th>Title</th>
                    <th width="100">show on home page</th>
                    <th width="80">Sort</th>
                    <th width="200">create time</th>
                    <th width="200">operation</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                        <td><img width="120" src="/edvolks/Uploads/thumb/<?php echo ($list['thumb']); ?>" alt=""></td>
                        <td><?php echo ($list['title']); ?></td>
                        <td>
                            <?php if($list['recommend'] == 1): ?><span class="text-danger">yes</span>
                                <?php else: ?> no<?php endif; ?>
                        </td>
                        <td><?php echo ($list['sort']); ?></td>
                        <td><?php echo ($list['create_time']); ?></td>
                        <td class="operation-box">
                            <a href="<?php echo U('edit',array('navid'=>$_GET['navid'],'id'=>$list['id'],'cid'=>$list['cid']));?>">modify</a>
                            <a href="javascript:" data-url="<?php echo U('del',array('id'=>$list['id']));?>" class="js-del-one">delete</a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

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