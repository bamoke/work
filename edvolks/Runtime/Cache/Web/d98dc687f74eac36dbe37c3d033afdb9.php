<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no" />
    <meta http-equiv="Cache" content="no-cache">
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1">
    <meta name="keywords" content="<?php echo ($baseInfo['keywords']); ?>">
    <meta name="description" content="">
    <link href="/edvolks/Web/Assets/css/global.css" rel="stylesheet" />
    <link href="/edvolks/Web/Assets/css/swiper.min.css" rel="stylesheet" />
    <link href="/edvolks/Web/Assets/css/main.css?v=5" rel="stylesheet" />
    <title>Projects</title>
</head>

<body id="project-body" class="dark-style">
    <div class="g-hd" id="js-head">
        <div class="w-main head-top f-cb">
    <a class="u-logo" href="<?php echo U('Index/index');?>">
        <h1>The EdVolks Architecture Design Ltd.</h1>
    </a>
    <!--             <div class="u-language">
                    <a href="index.html">ENG</a>
                    <span class="fg">|</span>
                    <a href="index-cn.html">中</a>
                </div> -->
    <div id="" class="navigation-btn <?php echo ($btnStyle?$btnStyle:'btn-white'); ?>"></div>
    <div class="nav-masker"></div>
    <ul class="m-nav s-text-light">
        <?php if(is_array($nav)): foreach($nav as $key=>$list): ?><li>
                <a href="<?php echo ($list['parent']['url']); ?>"><?php echo ($list['parent']['title']); ?></a>
            </li><?php endforeach; endif; ?>

    </ul>
</div>
        <div class="w-main">
            <div class="u-head-fg"></div>
        </div>
    </div>

    <div class="g-bd">
        <div class="w-main">
            <div class="project-content main-content-wrap f-cb">
                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 4 );++$i; if(($mod == 3) or ($mod == 2)): ?><div class="item">
                            <?php if(empty($item['picture'])): ?><a>
                                <?php else: ?>
                                <a href="<?php echo U('detail',array('id'=>$item['id']));?>"><?php endif; ?>
                                <div class="text-box <?php echo ($item['class_name']); ?>">
                                    <?php echo ($item['title']); ?>
                                    <br><?php echo ($item['location']); ?>
                                    <br><?php echo ($item['year']); if(($item['status']) == "1"): ?>-ongoing<?php endif; ?>
                                </div>
                                <div class="img-box">
                                    <img src="/edvolks/Uploads/thumb/<?php echo ($item['thumb']); ?>" alt="<?php echo ($data['title']); ?>">
                                </div>

                            </a>
                        </div>
                        <?php else: ?>
                        <div class="item">
                                <?php if(empty($item['picture'])): ?><a>
                                        <?php else: ?>
                                        <a href="<?php echo U('detail',array('id'=>$item['id']));?>"><?php endif; ?>
                                <div class="img-box">
                                    <img src="/edvolks/Uploads/thumb/<?php echo ($item['thumb']); ?>" alt="<?php echo ($data['title']); ?>">
                                </div>
                                <div class="text-box <?php echo ($item['class_name']); ?>">
                                    <?php echo ($item['title']); ?>
                                    <br><?php echo ($item['location']); ?>
                                    <br><?php echo ($item['year']); if(($item['status']) == "1"): ?>-ongoing<?php endif; ?>
                                </div>
                            </a>
                        </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="m-pagination"><?php echo ($page); ?></div>
        </div>
    </div>


    <div class="g-ft">
        <div class="w-main footer-style-3 s-line-dark">
            <span class="copyright">&copy; All images and materials in this website are copyright protected and are the
                property of the EdVolks Architecture
                Design Ltd.</span>
        </div>
    </div>


</body>

</html>
<script src="/edvolks/Web/Assets/js/zepto.min.js"></script>
<script src="/edvolks/Web/Assets/js/main.js"></script>