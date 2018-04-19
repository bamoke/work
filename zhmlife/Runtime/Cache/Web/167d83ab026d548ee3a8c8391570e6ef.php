<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title><?php echo ($pageTitle); ?></title>
    <link rel="stylesheet" href="/zhmlife/Public/Js/plugins/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="/zhmlife/Web/Assets/css/global.css">
    <link rel="stylesheet" href="/zhmlife/Web/Assets/css/main.css">
</head>

<body>
    <div class="g-wrap m-hd">
        <div class="w-main g-row-bt">
            <h1 class="u-logo">
                <a href="<?php echo U('index');?>}"></a>
            </h1>
            <div></div>
        </div>
    </div>
    <div class="g-wrap m-nav">
        <div class="w-main">
            <a href="" class="active">首页</a>
            <a href="">旅游</a>
            <a href="">美食</a>
            <a href="">购物</a>
            <a href="">酒店</a>
            <a href="">生活</a>
            <a href="">时尚</a>
        </div>
    </div>
    <div id="index-banner" class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="background-image:url(/zhmlife/Uploads/images/index-banner-01.jpg)"></div>
            <div class="swiper-slide" style="background-image:url(/zhmlife/Uploads/images/index-banner-01.jpg)"></div>
        </div>
    </div>

</body>

</html>
<script src="/zhmlife/Public/Js/plugins/swiper/swiper.min.js"></script>
<script>
    var swiper = new Swiper('#index-banner', {
        autoplay: 5000,
        speed: 1000,
        // pagination: '.swiper-pagination',
        // paginationClickable: true,
    });
</script>