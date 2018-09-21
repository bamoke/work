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
        <div  class="u-page-title"><span class="caption">修改文章</span> </div>
        <form name="news-form" class="form form-horizontal" action="<?php echo U('update',array('pid'=>$_GET['pid'],'id'=>$data['id']));?>">
            <input type="hidden" name="cid" value="<?php echo ($_GET['cid']); ?>">
            <div class="form-group">
                <label class="control-label col-xs-1">新闻标题:</label>
                <div class="col-xs-8">
                    <input type="text" name="title" class="form-control" value="<?php echo ($data['title']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1"><span class="text-danger">*</span>封面:</label>
                <div class="col-xs-3">
                    <div class="m-thumbnail-upload" id="js-thumb-upload-panel">
                        <?php if(empty($data['thumb'])): ?><a href="javascript:" class="add-btn js-add-btn"><i class="glyphicon glyphicon-plus-sign"></i></a>
                            <div class="thumb-box hidden"><img class="thumb" style=""><span class="del-btn">删除</span> </div>
                            <?php else: ?>
                            <a href="javascript:" class="add-btn js-add-btn hidden"><i class="glyphicon glyphicon-plus-sign"></i></a>
                            <div class="thumb-box">
                                <img class="thumb" src="/zlc/Uploads/thumb/<?php echo ($data['thumb']); ?>">
                                <span class="del-btn">删除</span>
                            </div>
                            <input type="hidden" class="js-old-thumb" name="old_img" value="<?php echo ($data['thumb']); ?>"><?php endif; ?>
                        <input type="file" name="thumb" class="js-file-input" style="opacity: 0" >
                    </div>
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">视频地址:</label>
                <div class="col-xs-4">
                    <textarea name="video" class="form-control"><?php echo ($data['video']); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                    <label class="control-label col-xs-1">是否推荐:</label>
                    <div class="col-xs-7">
                        <label class="radio-inline">
                            <input type="radio" name="recommend" value="1" <?php if(($data['recommend']) == "1"): ?>checked<?php endif; ?> />是</label>
                        <label class="radio-inline">
                            <input type="radio" name="recommend" value="0" <?php if(($data['recommend']) == "0"): ?>checked<?php endif; ?>  />否</label>
                    </div>
                </div>
            <div class="form-group">
                <label class="control-label col-xs-1">其他设置:</label>
                <div class="col-xs-7">
                    <label class="radio-inline"><input type="radio" name="otherset" value="1" <?php if(($data['otherset']) == "1"): ?>checked<?php endif; ?>  />人气</label>
                    <label class="radio-inline"><input type="radio" name="otherset" value="2" <?php if(($data['otherset']) == "2"): ?>checked<?php endif; ?>  />热搜</label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">显示状态:</label>
                <div class="col-xs-8">
                    <label class="radio-inline"><input type="radio" name="status" value="1" <?php if($data['status'] == 1): ?>checked<?php endif; ?> />显示</label>
                    <label class="radio-inline"><input type="radio" name="status" value="0" <?php if($data['status'] == 0): ?>checked<?php endif; ?> />隐藏</label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">来源:</label>
                <div class="col-xs-8">
                    <input type="text" name="origin" class="form-control" value="<?php echo ($data['origin']); ?>">
                </div>
            </div>
<!--             <div class="form-group">
                <label class="control-label col-xs-1">外部链接:</label>
                <div class="col-xs-8">
                    <input type="text" name="url" class="form-control" value="<?php echo ($data['url']); ?>">
                </div>
            </div> -->
            <div class="form-group">
                <label class="control-label col-xs-1">关键词:</label>
                <div class="col-xs-8">
                    <input type="text" name="keywords" class="form-control" value="<?php echo ($data['keywords']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">新闻描述:</label>
                <div class="col-xs-8">
                    <textarea name="description" class="form-control"><?php echo ($data['description']); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-1">内容详情:</label>
                <div class="col-xs-8">
                    <script id="editorContainer" name="content"><?php echo ($data['content']); ?></script>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-2 col-xs-offset-1"><button type="button" class="form-control btn-default" onclick="window.history.back()">返回列表</button></div>
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