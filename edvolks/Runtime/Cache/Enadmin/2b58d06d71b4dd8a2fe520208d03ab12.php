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
            <link rel="stylesheet" href="/edvolks/Public/Js/plupload-2.3.6/js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css"
    media="screen" />
<style>
    .upload-img{
    width:100%;
}
.file-item {
    margin-bottom:10px;
}
.file-name {
    margin-bottom:10px;
}
.color-box {
    display: inline-block;
    width:16px;
    height: 16px
}
.s-gray-1 {background:#939598;}
.s-gray-2 {background:#58595B;}
.s-blue-1 {background:#034377;}
.s-blue-2 {background:#002147;}
</style>
<div class="panel">
    <div class="panel-body">
        <div class="u-page-title">
            <span class="caption">Modify Project</span>
        </div>
        <form name="project-form" class="form form-horizontal" action="<?php echo U('update',array('navid'=>$_GET['navid'],'id'=>$_GET['id']));?>">
            <input type="hidden" name="cid" value="<?php echo ($_GET['cid']); ?>">
            <div class="form-group">
                <label class="control-label col-xs-2">
                    <span class="text-danger">*</span>Title:</label>
                <div class="col-xs-6">
                    <input type="text" name="title" class="form-control" value="<?php echo ($data['title']); ?>" placeholder="Less than 50 characters">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">
                    <span class="text-danger">*</span>Thumbnail:</label>
                <div class="col-xs-3">
                    <div class="m-thumbnail-upload" id="js-thumb-upload-panel">
                        <?php if(empty($data['thumb'])): ?><a href="javascript:" class="add-btn js-add-btn"><i class="glyphicon glyphicon-plus-sign"></i></a>
                            <div class="thumb-box hidden"><img class="thumb" style=""><span class="del-btn">delete</span>
                            </div>
                            <?php else: ?>
                            <a href="javascript:" class="add-btn js-add-btn hidden"><i class="glyphicon glyphicon-plus-sign"></i></a>
                            <div class="thumb-box">
                                <img class="thumb" src="/edvolks/Uploads/thumb/<?php echo ($data['thumb']); ?>">
                                <span class="del-btn">delete</span>
                            </div>
                            <input type="hidden" class="js-old-thumb" name="old_img" value="<?php echo ($data['thumb']); ?>"><?php endif; ?>
                        <input type="file" name="thumb" class="js-file-input" style="opacity: 0">
                    </div>
                    <span>size:360px×360px</span>
                </div>
                <div class="col-xs-3 tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">Show on home page:</label>
                <div class="col-xs-7">
                    <label class="radio-inline">
                        <input type="radio" class="js-recommend-radio" name="recommend" value="1" <?php if(($data['recommend']) == "1"): ?>checked<?php endif; ?>
                        />yes</label>
                    <label class="radio-inline">
                        <input type="radio" class="js-recommend-radio" name="recommend" value="0" <?php if(($data['recommend']) == "0"): ?>checked<?php endif; ?>
                        />no</label>
                </div>
            </div>
            <div id="js-banner-wrap" class="form-group" style="display: <?php echo ($data['recommend']==1?'block':'none'); ?>">
                <label class="control-label col-xs-2">Home page banner:</label>
                <div class="col-xs-6">
                    <input type="hidden" name="banner" id="js-banner-input" value="<?php echo ($data['banner']); ?>">
                    <div id="js-banner-filelist">
                        <?php if(!empty($data['banner'])): ?><div class="row file-item">
                                <div class="col-xs-4"><img class="upload-img" src="/edvolks/Uploads/banner/<?php echo ($data['banner']); ?>"
                                        alt=""></div>
                                <div class="col-xs-8">
                                    <div class="file-name"><?php echo ($data['banner']); ?></div>
                                    <div class="js-del-btn btn btn-default">Delete</div>
                                </div>
                            </div><?php endif; ?>
                    </div>
                    <div id="js-banner" style="display:<?php echo ($data['banner']?'none':'block'); ?>;">
                        <a id="pickfiles" data-upload-url="<?php echo U('Plupload/banner');?>" class="btn btn-default" href="javascript:;">Select
                            files</a>
                        <a id="uploadfiles" class="btn btn-primary" href="javascript:;">Upload files</a>
                        <span>(minimum size:width:1920px,height:1080px)</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">Keywords:</label>
                <div class="col-xs-6">
                    <input type="text" name="keywords" class="form-control" value="<?php echo ($data['keywords']); ?>" placeholder="Keyword is separated by','">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">Sort:</label>
                <div class="col-xs-1">
                    <input type="number" name="sort" class="form-control" value="<?php echo ($data['sort']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">Pictures:</label>
                <div class="col-xs-6">
                    <input type="hidden" name="picture" id="js-upload-files-input" value="<?php echo ($data['picture']); ?>">
                    <div id="upload-file-list">
                        <?php if(!empty($data['picture'])): if(is_array($data['picture_arr'])): foreach($data['picture_arr'] as $key=>$pic): ?><div class="row file-item">
                                    <div class="col-xs-4"><img class="upload-img" src="/edvolks/Uploads/plupload/<?php echo ($pic); ?>"
                                            alt=""></div>
                                    <div class="col-xs-8">
                                        <div class="file-name"><?php echo ($pic); ?></div>
                                        <div class="js-del-btn btn btn-default">Delete</div>
                                    </div>
                                </div><?php endforeach; endif; endif; ?>
                    </div>
                    <div>
                        <span class="btn btn-info" id="js-show-uploader">Upload</span>
                        <span>(width:1600px;height:auto)</span>
                    </div>
                    <div class="modal fade" id="js-uploader-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div id="uploader" data-upload-url="<?php echo U('Plupload/upload');?>">
                                        <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">Description:</label>
                <div class="col-xs-6">
                    <script id="editorContainer" name="description"><?php echo ($data["description"]); ?></script>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2"><span class="text-danger">*</span>Select style:</label>
                <div class="col-xs-6">
                    <label class="radio-inline">
                        <input type="radio" name="class_name" value="s-gray-1" <?php if(($data['class_name']) == "s-gray-1"): ?>checked<?php endif; ?>
                        > <span class="color-box s-gray-1"></span>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="class_name" value="s-gray-2" <?php if(($data['class_name']) == "s-gray-2"): ?>checked<?php endif; ?>
                        > <span class="color-box s-gray-2"></span>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="class_name" value="s-blue-1" <?php if(($data['class_name']) == "s-blue-1"): ?>checked<?php endif; ?>
                        > <span class="color-box s-blue-1"></span>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="class_name" value="s-blue-2" <?php if(($data['class_name']) == "s-blue-2"): ?>checked<?php endif; ?>
                        > <span class="color-box s-blue-2"></span>
                    </label>

                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2"><span class="text-danger">*</span>Year:</label>
                <div class="col-xs-6">
                    <input type="text" name="year" class="form-control" value="<?php echo ($data['year']); ?>" placeholder="">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-2">Category:</label>
                <div class="col-xs-6">
                    <input type="text" name="category" class="form-control" value="<?php echo ($data['category']); ?>" placeholder="">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">Area:</label>
                <div class="col-xs-6">
                    <input type="text" name="area" class="form-control" value="<?php echo ($data['area']); ?>" placeholder="">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2"><span class="text-danger">*</span>Location:</label>
                <div class="col-xs-6">
                    <input type="text" name="location" class="form-control" value="<?php echo ($data['location']); ?>" placeholder="">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2"><span class="text-danger">*</span>Status:</label>
                <div class="col-xs-6">
                    <label class="radio-inline">
                        <input type="radio" name="status" value="1" <?php if(($data['status']) == "1"): ?>checked<?php endif; ?> >
                        ongoing
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" value="2" <?php if(($data['status']) == "2"): ?>checked<?php endif; ?> >
                        completed
                    </label>
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">The year for completion:</label>
                <div class="col-xs-6">
                    <input type="text" name="completed_year" class="form-control" value="<?php echo ($data['completed_year']); ?>"
                        placeholder="">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">Partners in Charge:</label>
                <div class="col-xs-6">
                    <input type="text" name="charge" class="form-control" value="<?php echo ($data['charge']); ?>" placeholder="">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">Team:</label>
                <div class="col-xs-6">
                    <input type="text" name="team" class="form-control" value="<?php echo ($data['team']); ?>" placeholder="">
                </div>
                <div class="col-xs-3 js-tips"></div>
            </div>


            <div class="form-group">
                <div class="col-xs-2 col-xs-offset-2">
                    <button type="button" class="form-control btn-default" onclick="window.history.back()">Back</button>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="form-control btn-info">Send</button>
                </div>

            </div>
        </form>
    </div>
</div>
        </div>
    </div>

</div>
</body>
</html>