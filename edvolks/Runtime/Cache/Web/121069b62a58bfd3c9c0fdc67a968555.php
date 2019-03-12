<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no" />
    <meta http-equiv="Cache" content="no-cache">
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1">
    <meta name="keywords" content="Macao, Macau, Architecture, Interior Design, Design Firm, the EdVolks, the Volks, Eddie Ieong, Manuel Lam, Harvard, Architect, Macau Architecture Firm, Macao Interior Design Firm">
    <meta name="description" content="">
    <link href="/edvolks/Web/Assets/css/global.css" rel="stylesheet" />
    <link href="/edvolks/Web/Assets/css/swiper.min.css" rel="stylesheet" />
    <link href="/edvolks/Web/Assets/css/main.css?v=5" rel="stylesheet" />
    <title><?php echo ($siteTitle); ?></title>

</head>

<body id="news-body" class="dark-style">
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
            <div class="u-head-fg line-black"></div>
        </div>
    </div>

    <div class="g-bd">
        <div class="w-main">
            <div class="news-content f-cb main-content-wrap">
                <div class="img-box">
                    <?php if(is_array($info['picture'])): foreach($info['picture'] as $key=>$pic): ?><img src="/edvolks/Uploads/plupload/<?php echo ($pic); ?>" alt="<?php echo ($info['title']); ?>"><?php endforeach; endif; ?>
                </div>
                <div class="text-box">
                    <div class="type">/ NEWS /</div>
                    <div class="time"><?php echo ($info['date']); ?></div>
                    <div class="description">
                        <?php echo ($info['title']); ?>
                    </div>
                    <div class="fg"></div>
                    <div class="detail">
                        <p>Extract from <?php echo ($info['origin']); ?></p>
                        <?php echo ($info['content']); ?>
                    </div>
                </div>
            </div>
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