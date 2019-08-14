<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" id="index-page">

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

<body class="">
    <div class="g-index-hd" id="js-head">
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

    <div id="index-banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div id="slide-bg-1-for-pc" style="background-image:url(/edvolks/Uploads/banner/<?php echo ($banner['img']); ?>)" class="slide-item-bg"></div>
                    <div id="slide-bg-1-for-mobile" style="background-image:url(/edvolks/Uploads/banner/<?php echo ($banner['small_img']); ?>)" class="slide-item-bg"></div>
                    <div class="index-banner-text index-banner-news-text">
                        <div class="w-main">
                            <div class="type">/ NEWS /</div>
                            <div class="middle-box">
                                <span class="time"><?php echo ($news['date']); ?></span>
                                <a href="<?php echo U('Article/detail',array('id'=>$news['id'],'cid'=>$news['cid']));?>" class="u-index-more-btn">more</a>
                            </div>
                            <div class="description"><?php echo ($news['title']); ?></div>
                        </div>
                    </div>
                </div>
                <?php if(is_array($projectList)): $i = 0; $__LIST__ = $projectList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$project): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
                        <div id="slide-bg-<?php echo ($key+2); ?>" class="slide-item-bg" style="background-image:url(/edvolks/Uploads/banner/<?php echo ($project['banner']); ?>)"></div>
                        <div class="index-banner-text">
                            <div class="w-main index-banner-single-text">
                                <div class="text-box">
                                    <span><?php echo ($project['category']); ?> <?php echo ($project['year']); ?> </span>
                                    <span><?php echo ($project['title']); ?>, <?php echo ($project['location']); ?></span>
                                </div>
                                <a href="<?php echo U('Project/detail',array('id'=>$project['id']));?>" class="u-index-more-btn">more</a>
                            </div>
                        </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <!-- Add Pagination -->

        </div>
    </div>

    <div class="index-ft">
        <div class="w-main">
            <span class="copyright">&copy; All images and materials in this website are copyright protected and are the property of the EdVolks Architecture
                Design Ltd.</span>
            <div class="swiper-pagination"></div>
        </div>
    </div>


</body>

</html>
<script src="/edvolks/Web/Assets/js/swiper.min.js"></script>
<script src="/edvolks/Web/Assets/js/zepto.min.js"></script>
<script src="/edvolks/Web/Assets/js/main.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        // autoplay:5000,
        speed: 1000,
        pagination: '.swiper-pagination',
        paginationClickable: true,
        onSlideChangeStart: function (o) {
            var curIndex = o.activeIndex;
            console.log(curIndex)
            // $(".slide-item-bg").removeClass("slide-bg-enlarge").eq(curIndex).addClass("slide-bg-enlarge")
        },
        onSlideChangeEnd: function (o) {
            var curIndex = o.activeIndex;
            // $(".slide-item-bg").removeClass("slide-bg-enlarge").eq(curIndex).addClass("slide-bg-enlarge")

        },

    });

</script>