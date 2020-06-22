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
            <style type="text/css">
    .course-thumb-box {width:120px;height:60px;}
</style>
<div class="panel">
    <div class="panel-body">
        <div class="u-page-title">课程详情</div>
        <div class="m-columnist-single">
            <div class="bd">
                <div class="thumb"><img src="<?php echo (UPLOAD); ?>/thumb/<?php echo ((isset($courseInfo[thumb]) && ($courseInfo[thumb] !== ""))?($courseInfo[thumb]):'course-default.jpg'); ?>"></div>
                <div class="info">
                    <div class="title"><?php echo ($courseInfo['title']); ?></div>
                    <div class="desc"><?php echo ($courseInfo['description']); ?></div>
                    <?php if($courseInfo['isfree']): ?><div class="text-success">免费</div>
                        <?php else: ?>
                        <div class="price">￥<?php echo ($courseInfo['price']); ?></div><?php endif; ?>
                    
                    <div class="total-info"><span>学习人数:<?php echo ($courseInfo['study_num']); ?></span></div>
                </div>
            </div>
            <div class="right-info">
                <div>
                    <a href="<?php echo U('edit',array('id'=>$courseInfo['id']));?>">编辑</a>
                    <?php if($courseInfo['status'] == 1): ?><a href="javascript:void(0)" data-url="<?php echo U('change_course_status',array('id'=>$courseInfo['id'],'status'=>0));?>" class="js-change-status">下架</a>
                        <?php else: ?>
                        <a href="javascript:void(0)" data-url="<?php echo U('change_course_status',array('id'=>$courseInfo['id'],'status'=>1));?>" class="js-change-status">上架</a><?php endif; ?>
                </div>
                <div class="" style="margin-top:20px;">
                    <?php if($courseInfo['status'] == 1): ?><span class="btn btn-default">上架中</span>
                        <?php else: ?>
                        <span class="btn btn-danger">已下架</span><?php endif; ?>
                </div>
            </div>
        </div>

        <a href="<?php echo U('addsection',array('cid'=>$courseInfo['id']));?>" style="margin:20px 0" class="btn btn-info">添加课程章节</a>
        <?php if(empty($sectionList)): echo ($emptyHtml); ?>
            <?php else: ?>
            <table class="table table-bordered m-product-list" border="0" cellpadding="0" cellspacing="0" >
                <thead>
                <tr>
                    <th width="400">章节名称</th>
                    <th width="150">类型</th>
                    <th width="150">视频名称</th>
                    <th width="150">时长</th>
                    <th width="200">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($sectionList)): foreach($sectionList as $key=>$vo): ?><tr class="item">
                        <td class="js-title"><?php echo ($vo['title']); ?></td>
                        <td class=""><?php echo ($typeArr[$vo['type']]); ?></td>
                        <td class=""><?php echo ($vo['source']); ?></td>
                        <td><?php echo ($vo['duration']); ?></td>
                        <td class="operation-box">
                            <a href="<?php echo U('updatesection',array('id'=>$vo['id']));?>">编辑</a>
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

<div class="modal" id="sectionModal" style="width:800px;left:50%;margin-left:-400px;" role="dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">添加章节</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="sectionForm" action="<?php echo U('a_add_section');?>" style="display: none">
                <input type="hidden" name="course_id" value="<?php echo ($_GET['cid']); ?>">
                <div class="form-group">
                    <label class="col-xs-2 control-label">章节标题:</label>
                    <div class="col-xs-6">
                        <input class="form-control" type="text" name="title" placeholder="章节标题">
                    </div>
                    <div class="col-xs-4 tips">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">时长:</label>
                    <div class="col-xs-6">
                        <input type="text" name="time_long" class="form-control" value="" placeholder="请输入时长，如45分32秒表示为45:32">
                    </div>
                    <div class="col-xs-4 tips">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">资源地址:</label>
                    <div class="col-xs-6">
                        <input class="form-control" type="text" name="source" placeholder="请输入视频资源地址">
                    </div>
                    <div class="col-xs-4 tips">

                    </div>
                </div>

            </form>
            <form class="form-horizontal" id="sectionEditForm" action="<?php echo U('a_update_section');?>" style="display: none">
                <input type="hidden" name="id" value="">
                <div class="form-group">
                    <label class="col-xs-2 control-label">章节标题:</label>
                    <div class="col-xs-6">
                        <input class="form-control" type="text" name="title" placeholder="章节标题">
                    </div>
                    <div class="col-xs-4 tips">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">时长:</label>
                    <div class="col-xs-6">
                        <input type="text" name="time_long" class="form-control" value="" placeholder="请输入时长，如45分32秒表示为45:32">
                    </div>
                    <div class="col-xs-4 tips">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">资源地址:</label>
                    <div class="col-xs-6">
                        <input class="form-control" type="text" name="source" placeholder="请输入视频资源地址">
                    </div>
                    <div class="col-xs-4 tips">

                    </div>
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                关闭
            </button>
            <button type="button" class="btn btn-primary js-submit-section-form">
                提交保存
            </button>
        </div>
    </div>

</div>


        </div>
    </div>

</div>
</body>
</html>