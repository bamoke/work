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
    <title><?php echo ($baseInfo['site_name']); ?></title>

</head>

<body id="studio-body">
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
            <div class="u-head-fg line-white"></div>
        </div>
    </div>

    <div class="g-bd studio-content-1">
        <div class="w-main">
            <div class="studio-content">
                <div class="content-bg"></div>
                <div class="u-main-title">WE BELIEVES ...</div>
                <div class="content">
                    <div class="part-1">
                        <span>“</span>Good design should be for all mankind.
                        <br> We value relationship with our clients and respect our teams for their contributions.
                        <br> the EdVolks focuses on design with environmental concerns for people and by people.
                        <span>”</span>
                    </div>
                    <div class="part-2">Our design teams are lead by Harvard graduated and Australian educated architects. We offer design solutions
                        ranging from architecture to interior design, from product design to branding solution, from exhibition
                        design to temporary installations. By understanding the wholistic strategy and considering every
                        detail aspects of each projects, we are able to deliver exclusive and tailored design solutions for
                        each individual clients. </div>
                </div>
            </div>
        </div>
    </div>
    <div class="g-bd studio-content-2">
        <div class="w-main">
            <div class="bg-fg"></div>
            <div class="content-wrap">

                <div class="top-title">OUR FOUNDERS</div>
                <div class="content">
                    <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$person): $mod = ($i % 2 );++$i;?><div class="item">
                        <div class="person-info">
                            <div class="name">
                                <span><?php echo ($person['en_name']); ?></span><?php echo ($person['cn_name']); ?></div>
                            <div class="desc"><?php echo ($person['position']); ?></div>
                        </div>
                        <div class="introduce">
                                <?php echo ($person['introduce']); ?>
                        </div>
                    </div>
                    <?php if(($mod) == "1"): ?></div><div class="content"><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="g-ft">
        <div class="w-main footer-style-3 s-line-dark">
            <span class="copyright">&copy; All images and materials in this website are copyright protected and are the property of the EdVolks Architecture
                Design Ltd.</span>
        </div>
    </div>


</body>

</html>
<script src="/edvolks/Web/Assets/js/zepto.min.js"></script>
<script src="/edvolks/Web/Assets/js/main.js"></script>