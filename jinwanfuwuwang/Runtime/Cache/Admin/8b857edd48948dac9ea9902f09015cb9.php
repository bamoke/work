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
    <div class="panel-body">
        <div class="u-page-title"><span class="caption"><?php echo ($pageName); ?></span> </div>
        <form name="jobs-form" class="form form-horizontal" action="<?php echo U('do_update');?>">
            <input type="hidden" name="id" value="<?php echo ($_GET['id']); ?>">
            <div class="form-group">
                <label class="control-label col-xs-1"><span class="text-danger">*</span>岗位名称:</label>
                <div class="col-xs-4">
                    <input type="text" name="title" class="form-control" value="<?php echo ($mainInfo['title']); ?>">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                    <label class="control-label col-xs-1">岗位状态:</label>
                    <div class="col-xs-3">
                        <label class="radio-inline"><input type="radio" name="status" value="1" <?php if(($mainInfo['status']) == "1"): ?>checked<?php endif; ?> >正常</label>
                        <label class="radio-inline"><input type="radio" name="status" value="0" <?php if(($mainInfo['status']) == "0"): ?>checked<?php endif; ?> >隐藏</label>
                    </div>
                    <div class="col-xs-3 tips"></div>
                </div>
            <div class="form-group">
                <label class="control-label col-xs-1"><span class="text-danger">*</span>公司名称:</label>
                <div class="col-xs-4">
                    <input type="text" name="company" class="form-control" placeholder="24字符以内"
                        value="<?php echo ($mainInfo['company']); ?>">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-1">薪资:</label>
                <div class="col-xs-2">
                    <input type="text" name="wage" class="form-control" placeholder="12字符以内" maxlength="12"
                        value="<?php echo ($mainInfo['wage']); ?>">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-1"><span class="text-danger">*</span>工作地点:</label>
                <div class="col-xs-2">
                    <input type="text" name="addr" class="form-control" placeholder="12字符以内" maxlength="12" value="<?php echo ($mainInfo['addr']); ?>">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1"><span class="text-danger">*</span>工作类型:</label>
                <div class="col-xs-2">
                    <select class="form-control" name="type">
                        <option value="全职" <?php if(($mainInfo['type']) == "全职"): ?>selected<?php endif; ?> >全职</option>
                        <option value="兼职" <?php if(($mainInfo['type']) == "兼职"): ?>selected<?php endif; ?> >兼职</option>
                    </select>
                </div>
                <div class="col-xs-3 tips"></div>
            </div>


            <div class="form-group">
                <label class="control-label col-xs-1"><span class="text-danger">*</span>招聘人数:</label>
                <div class="col-xs-2">
                    <input type="number" min="1" max="100" name="person_limit" id="person-limit-input"
                        class="form-control" placeholder="招聘人数" value="<?php echo ($mainInfo['person_limit']); ?>" <?php if(($mainInfo['person_limit']) == "0"): ?>disabled<?php endif; ?> >

                </div>
                <div class="col-xs-1">
                    <label class="control-label"><input type="checkbox" name="no_limit_person" id="js-person-unlimited"
                            <?php if(($mainInfo['person_limit']) == "0"): ?>checked<?php endif; ?>>不限</label>
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1"><span class="text-danger">*</span>招聘截至:</label>
                <div class="col-xs-2">
                    <div class="input-group date" id="datetimepicker">
                        <input type="text" name="end_date" class="form-control" value="<?php echo ($mainInfo['end_date']); ?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <div class="col-xs-3 tips"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-1">外部链接:</label>
                <div class="col-xs-3">
                    <input type="text" name="link" maxlength="12" class="form-control" placeholder="120字符以内"
                        value="<?php echo ($mainInfo['link']); ?>">
                </div>
                <div class="col-xs-3 tips">设置外部链接后可不用填写联系方式及内容详情</div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-1">联系人:</label>
                <div class="col-xs-3">
                    <input type="text" name="contact_person" maxlength="12" class="form-control" placeholder="请输入联系人"
                        value="<?php echo ($mainInfo['contact_person']); ?>">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">联系电话:</label>
                <div class="col-xs-3">
                    <input type="text" name="contact_phone" maxlength="24" class="form-control" placeholder="请输入联系电话"
                        value="<?php echo ($mainInfo['contact_phone']); ?>">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">联系邮箱:</label>
                <div class="col-xs-3">
                    <input type="text" name="contact_email" maxlength="24" class="form-control" placeholder="请输入联系邮箱"
                        value="<?php echo ($mainInfo['contact_email']); ?>">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-1">岗位描述:</label>
                <div class="col-xs-8">
                    <script id="editorContainer" name="content"><?php echo ($mainInfo['content']); ?></script>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-2 col-xs-offset-1"><button type="button" class="form-control btn-default"
                        onclick="window.history.back()">返回列表</button></div>
                <div class="col-xs-4"><button type="submit" class="form-control btn-info">提交</button></div>

            </div>
        </form>
    </div>
</div>
        </div>
    </div>

</div>
</body>
</html>