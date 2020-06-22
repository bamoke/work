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
    <div class="panel-body">
        <div class="u-page-title"><?php echo ($pageName); ?></div>
        <?php $courseInfo = $output['courseInfo']; ?>
        <form name="add-form" class="form form-horizontal" action="<?php echo U('a_update',array('id'=>$courseInfo['id']));?>">
            <div class="form-group">
                <label class="control-label col-xs-2"><span class="symbol">*</span>课程类型:</label>
                <div class="col-xs-2">
                    <input type="text" name="" class="form-control" value="<?php echo ($courseInfo['typename']); ?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2"><span class="symbol">*</span>课程名称:</label>
                <div class="col-xs-5">
                    <input type="text" name="title" class="form-control" value="<?php echo ($courseInfo['title']); ?>" placeholder="建议6-14个字符">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>





            <div class="form-group">
                <label class="control-label col-xs-2"><span class="symbol">*</span>课程描述:</label>
                <div class="col-xs-5">
                    <input type="text" name="description" class="form-control" placeholder="建议25个字符以内" value="<?php echo ($courseInfo['description']); ?>">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2"><span class="symbol">*</span>封面:</label>
                <div class="col-xs-2">
                    <div class="m-thumbnail-upload" id="js-thumb-upload-panel">
                        <?php if(empty($courseInfo['thumb'])): ?><a href="javascript:" class="add-btn js-add-btn"></a>
                            <div class="thumb-box hidden"><img class="thumb" style=""><span class="del-btn">删除</span> </div>
                            <?php else: ?>
                            <a href="javascript:" class="add-btn js-add-btn hidden"></a>
                            <div class="thumb-box">
                                <img class="thumb" src="<?php echo ($courseInfo['thumb']); ?>">
                                <span class="del-btn">删除</span>
                            </div>
                            <input type="hidden" class="js-old-thumb" name="oldthumb" value="<?php echo ($courseInfo['thumb']); ?>"><?php endif; ?>
                        <input type="file" name="thumb" class="js-file-input" style="opacity: 0" >
                    </div>
                </div>
                <div class="col-xs-3 tips">建议尺寸750px×300px</div>
            </div>
            <?php if(($courseInfo['type']) == "2"): ?><div class="form-group">
                    <label class="control-label col-xs-2"><span class="symbol">*</span>视频名称:</label>
                    <div class="col-xs-5">
                        <input type="text" name="source" class="form-control" value="<?php echo ($courseInfo['source']); ?>">
                    </div>
                    <div class="col-xs-3 tips"></div>
                </div>                 
                <div class="form-group">
                    <label class="control-label col-xs-2"><span class="symbol">*</span>视频时长:</label>
                    <div class="col-xs-2">
                        <input type="text" name="duration" class="form-control" value="<?php echo ($courseInfo['duration']); ?>">
                    </div>
                    <div class="col-xs-3 tips"></div>
                </div><?php endif; ?>
            <div class="form-group">
                <label class="control-label col-xs-2"><span class="symbol">*</span>总课时:</label>
                <div class="col-xs-2">
                    <input type="text" name="period" class="form-control" value="<?php echo ($courseInfo['period']); ?>" readonly >
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2"><span class="symbol">*</span>讲师:</label>
                <div class="col-xs-2">
                    <select name="teacher_id" class="form-control">
                        <option value="">请选择讲师</option>
                        <?php if(is_array($output['teacherList'])): foreach($output['teacherList'] as $key=>$v): ?><option value="<?php echo ($v['id']); ?>" <?php if($v['id'] == $courseInfo['teacher_id']): ?>selected<?php endif; ?>><?php echo ($v['name']); ?></option><?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">课程介绍详情:</label>
                <div class="col-xs-8">
                    <script id="editorContainer" name="content"><?php echo ($courseInfo['content']); ?></script>
                </div>
            </div>


            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-1"><button type="button" class="form-control btn-default" onclick="window.history.back()">返回</button></div>
                <div class="col-xs-2"><button type="submit" class="form-control btn-info">提交</button></div>

            </div>
        </form>
    </div>
</div>
        </div>
    </div>

</div>
</body>
</html>