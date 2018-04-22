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
    <!-- header -->
    <div class="g-wrap m-hd">
        <div class="w-main g-row-bt">
            <h1 class="u-logo">
                <a href="<?php echo U('index');?>}"></a>
            </h1>
            <div class="m-top-search">
                <form action="">
                    <div class="input-wrap">
                        <input type="text" name="keyword" maxlength="50" placeholder="请输入关键字">
                        <input type="submit" value="搜索">
                    </div>
                </form>
                <div class="tags">
                    <span>热门搜索：</span><a href="">好玩</a><a href="">折扣</a><a href="">酒店</a><a href="">美食</a>
                </div>
            </div>
        </div>
    </div>
    <div class="g-wrap m-nav">
        <div class="w-main">
            <a href="<?php echo U('Index/index');?>" class="<?php if(!empty($isIndex)): ?>active<?php endif; ?>">
                首页</a><a href="<?php echo U('Article/index?cate=1');?>" class="<?php if(($_GET['cate']) == "1"): ?>active<?php endif; ?>">
                旅游</a><a href="<?php echo U('Article/index?cate=2');?>" class="<?php if(($_GET['cate']) == "2"): ?>active<?php endif; ?>">
                美食</a><a href="<?php echo U('Article/index?cate=3');?>" class="<?php if(($_GET['cate']) == "3"): ?>active<?php endif; ?>">
                购物</a><a href="<?php echo U('Article/index?cate=4');?>" class="<?php if(($_GET['cate']) == "4"): ?>active<?php endif; ?>">
                酒店</a><a href="<?php echo U('Article/index?cate=5');?>" class="<?php if(($_GET['cate']) == "5"): ?>active<?php endif; ?>">
                生活</a><a href="<?php echo U('Article/index?cate=6');?>" class="<?php if(($_GET['cate']) == "6"): ?>active<?php endif; ?>">
                时尚</a>
        </div>
    </div>

    <!-- banner -->
    <div id="index-banner" class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="background-image:url(/zhmlife/Uploads/images/index-banner-01.jpg)"></div>
            <div class="swiper-slide" style="background-image:url(/zhmlife/Uploads/images/index-banner-01.jpg)"></div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <!---recomment-->
    <div id="index-recomment" class="g-wrap">
        <div class="w-main">
            <div class="m-bar-center">
                <h2 class="title">每日推荐</h2>
            </div>
            <ul class="m-pic-list">
                <li class="item">
                    <div class="img-box">
                        <a href="<?php echo U('Article/detail');?>" target="_blank">
                            <img src="/zhmlife/Uploads/images/pro-img-01.jpg" alt="【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍">
                        </a>
                    </div>
                    <a href="<?php echo U('Article/detail');?>" target="_blank" class="title" title="人氣鹹蛋魚皮！新加坡過江龍">【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍</a>
                    <div class="f-cb foot-info">
                        <a href="<?php echo U('Article/index');?>" class="f-fl category">旅游</a>
                        <div class="f-fr u-statistics">
                            <span class="view">1244</span>
                            <span class="time">03/12</span>
                        </div>
                    </div>
                </li>
                <li class="item">
                    <div class="img-box">
                        <a href="<?php echo U('Article/detail');?>" target="_blank">
                            <img src="/zhmlife/Uploads/images/pro-img-02.jpg" alt="人氣鹹蛋魚皮！新加坡過江龍">
                        </a>
                    </div>
                    <a href="<?php echo U('Article/detail');?>" target="_blank" class="title" title="人氣鹹蛋魚皮！新加坡過江龍">【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍</a>
                    <div class="f-cb foot-info">
                        <a href="<?php echo U('Article/index');?>" class="f-fl category">旅游</a>
                        <div class="f-fr u-statistics">
                            <span class="view">1244</span>
                            <span class="time">03/12</span>
                        </div>
                    </div>
                </li>
                <li class="item">
                    <div class="img-box">
                        <a href="<?php echo U('Article/detail');?>" target="_blank">
                            <img src="/zhmlife/Uploads/images/pro-img-03.jpg" alt="人氣鹹蛋魚皮！新加坡過江龍">
                        </a>
                    </div>
                    <a href="<?php echo U('Article/detail');?>" target="_blank" class="title" title="人氣鹹蛋魚皮！新加坡過江龍">【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍</a>
                    <div class="f-cb foot-info">
                        <a href="<?php echo U('Article/index');?>" class="f-fl category">旅游</a>
                        <div class="f-fr u-statistics">
                            <span class="view">1244</span>
                            <span class="time">03/12</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- new -->
    <div class="">
        <div class="w-main f-cb">
            <div class="g-b-side f-fl">
                <div class="m-bar-default">
                    <h2 class="title">最新发布</h2>
                </div>
                <ul class="m-pic-list">
                    <li class="item">
                        <div class="img-box">
                            <a href="<?php echo U('Article/detail');?>" target="_blank">
                                <img src="/zhmlife/Uploads/images/pro-img-01.jpg" alt="【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍">
                            </a>
                        </div>
                        <a href="<?php echo U('Article/detail');?>" target="_blank" class="title" title="人氣鹹蛋魚皮！新加坡過江龍">【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍</a>
                        <div class="f-cb foot-info">
                            <a href="<?php echo U('Article/index');?>" class="f-fl category">旅游</a>
                            <div class="f-fr u-statistics">
                                <span class="view">1244</span>
                                <span class="time">03/12</span>
                            </div>
                        </div>
                    </li>
                    <li class="item">
                        <div class="img-box">
                            <a href="<?php echo U('Article/detail');?>" target="_blank">
                                <img src="/zhmlife/Uploads/images/pro-img-02.jpg" alt="人氣鹹蛋魚皮！新加坡過江龍">
                            </a>
                        </div>
                        <a href="<?php echo U('Article/detail');?>" target="_blank" class="title" title="人氣鹹蛋魚皮！新加坡過江龍">【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍</a>
                        <div class="f-cb foot-info">
                            <a href="<?php echo U('Article/index');?>" class="f-fl category">旅游</a>
                            <div class="f-fr u-statistics">
                                <span class="view">1244</span>
                                <span class="time">03/12</span>
                            </div>
                        </div>
                    </li>
                    <li class="item">
                        <div class="img-box">
                            <a href="<?php echo U('Article/detail');?>" target="_blank">
                                <img src="/zhmlife/Uploads/images/pro-img-03.jpg" alt="人氣鹹蛋魚皮！新加坡過江龍">
                            </a>
                        </div>
                        <a href="<?php echo U('Article/detail');?>" target="_blank" class="title" title="人氣鹹蛋魚皮！新加坡過江龍">【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍</a>
                        <div class="f-cb foot-info">
                            <a href="<?php echo U('Article/index');?>" class="f-fl category">旅游</a>
                            <div class="f-fr u-statistics">
                                <span class="view">1244</span>
                                <span class="time">03/12</span>
                            </div>
                        </div>
                    </li>
                    <li class="item">
                        <div class="img-box">
                            <a href="<?php echo U('Article/detail');?>" target="_blank">
                                <img src="/zhmlife/Uploads/images/pro-img-03.jpg" alt="人氣鹹蛋魚皮！新加坡過江龍">
                            </a>
                        </div>
                        <a href="<?php echo U('Article/detail');?>" target="_blank" class="title" title="人氣鹹蛋魚皮！新加坡過江龍">【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍</a>
                        <div class="f-cb foot-info">
                            <a href="<?php echo U('Article/index');?>" class="f-fl category">旅游</a>
                            <div class="f-fr u-statistics">
                                <span class="view">1244</span>
                                <span class="time">03/12</span>
                            </div>
                        </div>
                    </li>
                    <li class="item">
                        <div class="img-box">
                            <a href="<?php echo U('Article/detail');?>" target="_blank">
                                <img src="/zhmlife/Uploads/images/pro-img-03.jpg" alt="人氣鹹蛋魚皮！新加坡過江龍">
                            </a>
                        </div>
                        <a href="<?php echo U('Article/detail');?>" target="_blank" class="title" title="人氣鹹蛋魚皮！新加坡過江龍">【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍</a>
                        <div class="f-cb foot-info">
                            <a href="<?php echo U('Article/index');?>" class="f-fl category">旅游</a>
                            <div class="f-fr u-statistics">
                                <span class="view">1244</span>
                                <span class="time">03/12</span>
                            </div>
                        </div>
                    </li>
                    <li class="item">
                        <div class="img-box">
                            <a href="<?php echo U('Article/detail');?>" target="_blank">
                                <img src="/zhmlife/Uploads/images/pro-img-03.jpg" alt="人氣鹹蛋魚皮！新加坡過江龍">
                            </a>
                        </div>
                        <a href="<?php echo U('Article/detail');?>" target="_blank" class="title" title="人氣鹹蛋魚皮！新加坡過江龍">【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍</a>
                        <div class="f-cb foot-info">
                            <a href="<?php echo U('Article/index');?>" class="f-fl category">旅游</a>
                            <div class="f-fr u-statistics">
                                <span class="view">1244</span>
                                <span class="time">03/12</span>
                            </div>
                        </div>
                    </li>
                    <li class="item">
                        <div class="img-box">
                            <a href="<?php echo U('Article/detail');?>" target="_blank">
                                <img src="/zhmlife/Uploads/images/pro-img-03.jpg" alt="人氣鹹蛋魚皮！新加坡過江龍">
                            </a>
                        </div>
                        <a href="<?php echo U('Article/detail');?>" target="_blank" class="title" title="人氣鹹蛋魚皮！新加坡過江龍">【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍</a>
                        <div class="f-cb foot-info">
                            <a href="<?php echo U('Article/index');?>" class="f-fl category">旅游</a>
                            <div class="f-fr u-statistics">
                                <span class="view">1244</span>
                                <span class="time">03/12</span>
                            </div>
                        </div>
                    </li>
                    <li class="item">
                        <div class="img-box">
                            <a href="<?php echo U('Article/detail');?>" target="_blank">
                                <img src="/zhmlife/Uploads/images/pro-img-03.jpg" alt="人氣鹹蛋魚皮！新加坡過江龍">
                            </a>
                        </div>
                        <a href="<?php echo U('Article/detail');?>" target="_blank" class="title" title="人氣鹹蛋魚皮！新加坡過江龍">【邊間最好食】Top7 人氣鹹蛋魚皮！新加坡過江龍</a>
                        <div class="f-cb foot-info">
                            <a href="<?php echo U('Article/index');?>" class="f-fl category">旅游</a>
                            <div class="f-fr u-statistics">
                                <span class="view">1244</span>
                                <span class="time">03/12</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="g-s-side f-fr">
                <div class="g-column-wrap">
                    <div class="m-bar-default">
                        <h2 class="title">人气排行</h2>
                    </div>
                    <ul class="m-imgtext m-imgtext-sm">
                        <li class="item">
                            <a href="" class="img-box">
                                <img src="/zhmlife/Uploads/images/s-pro-img-01.jpg" alt="">
                            </a>
                            <div class="text-box">
                                <a class="title" href="">帶着媽媽去旅行！嚴選4間媽媽必冧性價比極高大阪住宿</a>
                                <div class="u-statistics">
                                    <span class="view">1244</span>
                                    <span class="time">03/12</span>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <a href="" class="img-box">
                                <img src="/zhmlife/Uploads/images/s-pro-img-02.jpg" alt="">
                            </a>
                            <div class="text-box">
                                <a class="title" href="">明明五官没变，为什么倪妮能完成去“土气”逆袭之路？</a>
                                <div class="u-statistics">
                                    <span class="view">1244</span>
                                    <span class="time">03/12</span>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <a href="" class="img-box">
                                <img src="/zhmlife/Uploads/images/s-pro-img-03.jpg" alt="">
                            </a>
                            <div class="text-box">
                                <a class="title" href="">和景甜拍拖的直男张继科连口红都分不清</a>
                                <div class="u-statistics">
                                    <span class="view">1244</span>
                                    <span class="time">03/12</span>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <a href="" class="img-box">
                                <img src="/zhmlife/Uploads/images/s-pro-img-04.jpg" alt="">
                            </a>
                            <div class="text-box">
                                <a class="title" href="">40岁的女性夏季怎么穿才减龄又时尚，刘涛、袁泉都爱这样穿</a>
                                <div class="u-statistics">
                                    <span class="view">1244</span>
                                    <span class="time">03/12</span>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <a href="" class="img-box">
                                <img src="/zhmlife/Uploads/images/s-pro-img-04.jpg" alt="">
                            </a>
                            <div class="text-box">
                                <a class="title" href="">40岁的女性夏季怎么穿才减龄又时尚，刘涛、袁泉都爱这样穿</a>
                                <div class="u-statistics">
                                    <span class="view">1244</span>
                                    <span class="time">03/12</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="u-ad">
                    <a href="" target="_blank">
                        <img src="/zhmlife/Uploads/images/ad-sm-01.jpg" alt="" width="100%" height="230">
                    </a>
                </div>
                <div class="g-column-wrap">
                    <div class="m-bar-default">
                        <h2 class="title">人气排行</h2>
                    </div>
                    <ul class="m-imgtext m-imgtext-sm">
                        <li class="item">
                            <a href="" class="img-box">
                                <img src="/zhmlife/Uploads/images/s-pro-img-01.jpg" alt="">
                            </a>
                            <div class="text-box">
                                <a class="title" href="">帶着媽媽去旅行！嚴選4間媽媽必冧性價比極高大阪住宿</a>
                                <div class="u-statistics">
                                    <span class="view">1244</span>
                                    <span class="time">03/12</span>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <a href="" class="img-box">
                                <img src="/zhmlife/Uploads/images/s-pro-img-02.jpg" alt="">
                            </a>
                            <div class="text-box">
                                <a class="title" href="">明明五官没变，为什么倪妮能完成去“土气”逆袭之路？</a>
                                <div class="u-statistics">
                                    <span class="view">1244</span>
                                    <span class="time">03/12</span>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <a href="" class="img-box">
                                <img src="/zhmlife/Uploads/images/s-pro-img-03.jpg" alt="">
                            </a>
                            <div class="text-box">
                                <a class="title" href="">和景甜拍拖的直男张继科连口红都分不清</a>
                                <div class="u-statistics">
                                    <span class="view">1244</span>
                                    <span class="time">03/12</span>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <a href="" class="img-box">
                                <img src="/zhmlife/Uploads/images/s-pro-img-04.jpg" alt="">
                            </a>
                            <div class="text-box">
                                <a class="title" href="">40岁的女性夏季怎么穿才减龄又时尚，刘涛、袁泉都爱这样穿</a>
                                <div class="u-statistics">
                                    <span class="view">1244</span>
                                    <span class="time">03/12</span>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <a href="" class="img-box">
                                <img src="/zhmlife/Uploads/images/s-pro-img-04.jpg" alt="">
                            </a>
                            <div class="text-box">
                                <a class="title" href="">40岁的女性夏季怎么穿才减龄又时尚，刘涛、袁泉都爱这样穿</a>
                                <div class="u-statistics">
                                    <span class="view">1244</span>
                                    <span class="time">03/12</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- footer ad -->
    <div class="g-wrap">
        <div class="w-main">
            <div class="u-ad-ft">
                <a href="" target="_blank">
                    <img src="/zhmlife/Uploads/images/big-ad-img.png">
                </a>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="g-ft" id="footer">
    <div class="w-main">
        <div class="left-box">
            <div class="link">
                <a href="<?php echo U('Single/index');?>" target="_blank">关于我们</a>
                <span class="fg">|</span>
                <a href="<?php echo U('Single/index');?>" target="_blank">联系我们</a>
                <span class="fg">|</span>
                <a href="<?php echo U('Single/index');?>" target="_blank">隐私协议</a>
            </div>
            <p class="copyright">©2018 珠港澳网 All rights reserved 粤ICP备17077518号-1</p>
            <div class="link">
                <span>友情链接：</span>
                <a href="https://www.aliyun.com/" target="_blank">阿里云</a>
                <a href="https://www.baidu.com/" target="_blank">百度</a>
            </div>
        </div>
        <div class="right-box">
            <div class="item">
                <img src="/zhmlife/Web/Assets/images/qrcode-gzh.jpg" alt="">
                <p>公众号</p>
            </div>
            <div class="item">
                <img src="/zhmlife/Web/Assets/images/qrcode-xcx.jpg" alt="">
                <p>小程序</p>
            </div>
        </div>
    </div>
</div>
</body>

</html>
<script src="/zhmlife/Public/Js/plugins/swiper/swiper.min.js"></script>
<script>
    var swiper = new Swiper('#index-banner', {
        autoplay: 5000,
        speed: 1000,
        pagination: '.swiper-pagination',
        paginationClickable: true,
    });
</script>