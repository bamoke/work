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
    <div class="panel-heading">
        <div class="panel-title">添加课程</div>
    </div>
    <div class="panel-body">
        <form name="add-form" class="form form-horizontal" action="<?php echo U('a_add');?>">
            <div class="form-group">
                <label class="control-label col-xs-2"><span class="symbol">*</span> 课程类型:</label>
                <div class="col-xs-2">
                    <label class="radio-inline">
                        <input type="radio" name="type" value="1" id="js-course-type1" checked> 专题系列
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="type" value="2" id="js-course-type2"> 单节课程
                    </label>
                </div>
                <div class="col-xs-3 tips"></div>
            </div>



            <div class="form-group">
                <label class="control-label col-xs-2"><span class="symbol">*</span>专家\讲师:</label>
                <div class="col-xs-5">
                    <select name="teacher_id" class="form-control">
                        <option value="">请选择讲师</option>
                        <?php if(is_array($output['teacherList'])): foreach($output['teacherList'] as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['name']); ?></option><?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="col-xs-3 tips"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2"><span class="symbol">*</span>课程名称:</label>
                <div class="col-xs-5">
                    <input type="text" name="title" class="form-control" value="" placeholder="建议6-14个字符">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">推荐展示:</label>
                <div class="col-xs-5">
                    <label class="radio-inline">
                        <input type="radio" name="recommend" value="1">是
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="recommend" value="0" checked>否
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2"><span class="symbol">*</span>课程描述:</label>
                <div class="col-xs-5">
                    <input type="text" name="description" class="form-control" placeholder="建议25个字符以内">
                </div>
                <div class="col-xs-3 tips"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2"><span class="symbol">*</span>封面:</label>
                <div class="col-xs-2">
                    <div class="m-thumbnail-upload" id="js-thumb-upload-panel">
                        <a href="javascript:" class="add-btn js-add-btn"></a>
                        <div class="thumb-box hidden"><img class="thumb" style=""><span class="del-btn">删除</span> </div>
                        <input type="file" name="thumb" class="js-file-input" style="display: none;">
                    </div>
                </div>
                <div class="col-xs-3 tips">建议尺寸750px×300px</div>
            </div>

            <div class="form-group js-for-single" style="display: none;">
                <label class="control-label col-xs-2"><span class="symbol">*</span>视频名称:</label>
                <div class="col-xs-5">
                    <input type="text" name="source" class="form-control" value="" disabled>
                </div>
                <div class="col-xs-3 tips"></div>
            </div> 
            <div class="form-group js-for-single" style="display: none;">
                <label class="control-label col-xs-2"><span class="symbol">*</span>视频时长:</label>
                <div class="col-xs-2">
                    <input type="text" name="duration" class="form-control" value="" disabled>
                </div>
                <div class="col-xs-3 tips"></div>
            </div> 

            <div class="form-group">
                <label class="control-label col-xs-2">课程介绍详情:</label>
                <div class="col-xs-8">
                    <script id="editorContainer" name="content"></script>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">是否免费:</label>
                <div class="col-xs-4 js-isfree-radio">
                    <label class="radio-inline">
                        <input type="radio" name="isfree" value="1" checked> 免费
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="isfree" value="0"> 收费
                    </label>
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <!--div class="form-group">
                <label class="control-label col-xs-2">价格:</label>
                <div class="col-xs-2">
                    <input type="text" name="price" value="" placeholder="请填入整数或小数" class="form-control js-price">
                </div>
                <div class="col-xs-3 tips"></div>
            </div -->
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