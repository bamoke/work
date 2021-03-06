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
    <title>The EdVolks Architecture Design Ltd.</title>

</head>

<body id="careers-body">
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

    <div class="g-bd">
        <div class="w-main">
            <div class="careers-content">
                <div class="content-bg"></div>
                <div class="u-main-title">JOIN OUR TEAM</div>
                <div class="content">
                    <div class="left">
                        <p>We are always
                            <span class="important-text">looking for people with passion for design</span> to join our young, creative and multidisciplinary
                            team either full-time or interns.</p>
                        <p>We &nbsp;&nbsp;
                            <span class="important-text">respect, listen &amp; value your creative thoughts</span>. Only by contributing and combining
                            different ideas, we create unique and exceptional design solutions for each projects. We are
                            proud to offer equal design opportunities for all. Each will have chance to develop your design
                            ideas, present your thoughts, refine them and elaborate them into construction drawings. </p>
                    </div>
                    <div class="right">
                        <p>We
                            <span class="important-text">value your creative ideas as you value them</span>. Welcome the best talent from around the globe
                            to join our creative team. If you are interested, please send your cover letter, resume and portfolio
                            to <a href="mailto:admin@theEdVolks.com">admin@theEdVolks.com</a></p>
                        <p>File sizes should be no more than 8Mb. For portfolio, you can upload them through a service like
                            Dropbox or WeTransfer.</p>
                        <div class="font-img">
                            <img src="/edvolks/Web/Assets/images/text-icon.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="g-ft">
        <div class="w-main footer-style-3">
            <span class="copyright">&copy; All images and materials in this website are copyright protected and are the property of the EdVolks Architecture
                Design Ltd.</span>
        </div>
    </div>


</body>

</html>
<script src="/edvolks/Web/Assets/js/zepto.min.js"></script>
<script src="/edvolks/Web/Assets/js/main.js"></script>