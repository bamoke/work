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

<body id="contact-body">
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
            <div class="contact-content">
                <div class="content-bg"></div>
                <div class="u-main-title">CONTACT US</div>
                <div class="content">
                    <div class="part-1">Office Address: 
                        <p class="cn">
                            <?php if(is_array($info['addr'])): foreach($info['addr'] as $key=>$item): echo ($item); ?><br><?php endforeach; endif; ?>
                        </p>
                    </div>
                    <div class="part-2">
                        <p><span class="caption">Telephone </span><?php echo ($info['tel']); ?>  </p>
                        <p><span class="caption">Fax </span><?php echo ($info['fax']); ?></p>
                        <p><span class="caption">Email </span>
                            <?php if(is_array($info['email'])): foreach($info['email'] as $key=>$item): ?><a href="mailto:<?php echo ($item); ?>"><?php echo ($item); ?></a>&nbsp;&nbsp;<?php endforeach; endif; ?>
                        </p>
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