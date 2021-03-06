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
            <span class="caption">Introduce</span>
        </div>
        <div class="m-introduce-form">
            <form name="studio-introduce-form" class="form form-horizontal" action="<?php echo U('introduceupdate');?>">
                <input type="hidden" name="id" value="<?php echo ($introduce['id']); ?>">
                <div class="form-group">
                    <label class="col-xs-2 control-label">The First paragraph:</label>
                    <div class="col-xs-8">
                        <textarea class="form-control" name="big_fonts" rows="5"><?php echo ($introduce["big_fonts"]); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">The Second:</label>
                    <div class="col-xs-8">
                        <textarea class="form-control" name="small_fonts" rows="5"><?php echo ($introduce["small_fonts"]); ?></textarea>
                    </div>

                </div>


                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-2">
                        <button type="submit" class="form-control btn-info">Send</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="u-page-title">
            <span class="caption">Founders</span>
            <a href="<?php echo U('add',array('navid'=>$_GET['navid'],'cid'=>$_GET['cid']));?>" class="btn btn-info">Add</a>
        </div>
        <table class="table js-table-list">
            <thead>
                <tr>
                    <th>Name</th>
                    <th width="200">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($data)): foreach($data as $key=>$list): ?><tr>
                        <td><?php echo ($list['en_name']); ?></td>
                        <td class="operation-box">
                            <a
                                href="<?php echo U('edit',array('navid'=>$_GET['navid'],'id'=>$list['id'],'cid'=>$list['cid']));?>">Modify</a>
                            <a href="javascript:" data-url="<?php echo U('del',array('id'=>$list['id']));?>"
                                class="js-del-one">Delete</a>
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