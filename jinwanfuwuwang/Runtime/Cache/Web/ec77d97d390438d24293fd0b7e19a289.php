<?php if (!defined('THINK_PATH')) exit();?><html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>金湾区人力资源服务网</title>
    <meta name="description" content="金湾区人力资源服务网">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Place favicon.ico in the root directory -->
    <link href="/jinwanfuwuwang/Web/Static/images/favicon.ico" type="img/x-icon" rel="shortcut icon">
    <!-- All css files are included here. -->
    <link rel="stylesheet" href="/jinwanfuwuwang/Web/Static/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/jinwanfuwuwang/Web/Static/css/vendor/iconfont.min.css">
    <link rel="stylesheet" href="/jinwanfuwuwang/Web/Static/css/vendor/helper.css">
    <!-- <link rel="stylesheet" href="/jinwanfuwuwang/Web/Static/css/plugins/plugins.css"> -->
    <!-- <link rel="stylesheet" href="/jinwanfuwuwang/Web/Static/css/style.css"> -->

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="/jinwanfuwuwang/Web/Static/css/plugins/plugins.min.css?v=1">
    <link rel="stylesheet" href="/jinwanfuwuwang/Web/Static/css/style.css?v=2">
    <!-- Modernizr JS -->
    <script src="/jinwanfuwuwang/Web/Static/js/vendor/modernizr-3.10.0.min.js"></script>
    <!------>
    <link rel="stylesheet" href="/jinwanfuwuwang/Web/Static/js/swiper/css/swiper.min.css">
    <script src="/jinwanfuwuwang/Web/Static/js/swiper/swiper.min.js"></script>

    <style>
        .breadcrumb-section {
            background-color:#002168;
            color:#fff;
        }
        .breadcrumb-section .page-breadcrumb li a {
            color:#fff;
        }
        .breadcrumb-section .page-breadcrumb-content h1 {
            color:#fff;
        }
        .newsList {
    padding: 0 10px;
}

.m-news-list li {padding:16px 0;border-bottom:1px solid #ddd;}
.m-news-list li:after {content:"";clear:both;display:block;visibility:hidden;}
.m-news-list .title {font-size:18px;}
.m-news-list .time {float:left;padding:0 10px;width:100px;height:80px;border:1px solid #ddd;text-align:center;}
.m-news-list .time span {display: block;}
.m-news-list .time .days {height:44px;line-height:44px;border-bottom:1px solid #ddd;font-size:22px;font-weight:bold;}
.m-news-list .time .y-m {line-height:34px;font-size:16px;color:#9c9c9c;}
.m-news-list .right-info {margin-left:140px;}
.m-news-list .n-title {margin-bottom:14px;font-size:20px;font-weight: 700;color:#222;}
@media (max-width: 767px) {
    .m-news-list .time {
        display: none;
    }
    .m-news-list .right-info {
        margin-left:0;
    }
}
    </style>
</head>

<body class="template-color-3">

    <div id="main-wrapper">
        <!--Header section start-->
<div
    class="black-logo-version sticky-white sb-border header-sticky d-none d-lg-block">
    <div class="main-header">
        <div class="container pl-lg-15 pl-md-15 pr-0">
            <div class="row align-items-center no-gutters">

                <!--Logo start-->
                <div class="col-xl-3 col-lg-2 col-12">
                    <div class="logo">
                        <a href="<?php echo U('Index/index');?>"><img
                                src="/jinwanfuwuwang/Web/Static/images/logo-white.png" alt=""></a>
                    </div>
                </div>
                <!--Logo end-->

                <!--Menu start-->
                <div class="col-xl-9 col-lg-7 col-12">
                    <nav class="main-menu">
                        <ul>
                            <li><a href="<?php echo U('Index/index');?>">首页</a></li>
                            <li><a href="<?php echo U('Jobs/index');?>">招聘职位</a></li>
                            <li><a href="https://www.zhtfw.net/zph/">现场招聘</a></li>
                            <li><a href="<?php echo U('News/index',array('cid'=>8));?>">人社动态</a></li>
                            <li><a href="<?php echo U('News/index',array('cid'=>10));?>">人社政策</a></li>
                            <li><a href="<?php echo U('School/index');?>">校园频道</a></li>
                            <li><a href="<?php echo U('Chuangyedasai/index');?>">创业大赛</a></li>
                            <li><a href="<?php echo U('Single/index',array('id'=>1));?>">关于我们</a></li>

                        </ul>
                    </nav>
                </div>
                <!--Menu end-->

            </div>

        </div>
    </div>
</div>
<!--Header section end-->

<!--Header Mobile section start-->
<header class="header-mobile bg_color--4 d-block d-lg-none">
    <div class="header-bottom menu-right">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-mobile-navigation d-block d-lg-none">
                        <div class="row align-items-center">
                            <div class="col-3 col-md-3">
                                <div class="mobile-navigation text-right">
                                    <div class="header-icon-wrapper">
                                        <ul class="icon-list justify-content-start">
                                            <li class="popup-mobile-click">
                                                <a href="javascript:void(0)"><i class="lnr lnr-menu"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-6">
                                <div class="header-logo text-center">
                                    <a href="<?php echo U(Index/index);?>">
                                        <img src="/jinwanfuwuwang/Web/Static/images/logo-mobile.png" class="img-fluid" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-3 col-md-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>
<!--Header Mobile section end-->

<!-- Start Popup Menu -->
<div class="popup-mobile-manu popup-mobile-visiable">
    <div class="inner">
        <div class="mobileheader">
            <div class="logo">
                <a href="<?php echo U('Index/index');?>}">
                    <img src="/jinwanfuwuwang/Web/Static/images/logo-mobile.png" alt="Multipurpose">
                </a>
            </div>
            <a class="mobile-close" href="#"></a>
        </div>
        <div class="menu-content">
            <ul class="menulist object-custom-menu">
                <li><a href="<?php echo U('Index/index');?>">首页</a></li>
                <li><a href="<?php echo U('Jobs/index');?>">招聘职位</a></li>
                <li><a href="https://www.zhtfw.net/zph/">现场招聘</a></li>
                <li><a href="<?php echo U('News/index',array('cid'=>8));?>">人社动态</a></li>
                <li><a href="<?php echo U('News/index',array('cid'=>10));?>">人社政策</a></li>
                <li><a href="<?php echo U('School/index');?>">校园频道</a></li>
                <li><a href="<?php echo U('Chuangyedasai/index');?>">创业大赛</a></li>
                <li><a href="<?php echo U('Single/index',array('id'=>1));?>">关于我们</a></li>


            </ul>
        </div>
    </div>
</div>
<!-- End Popup Menu -->
            <div class="blog-section section">
    <div class="container pl-0 pr-0">
        <div class="m-main-banner" id="js-swiper-banner">
            <div class="swiper-wrapper">
                <?php if(is_array($banner)): foreach($banner as $key=>$item): if($item["url"] != ''): ?><a href="<?php echo ($item["url"]); ?>" class="swiper-slide"
                            style="background-image:url(/jinwanfuwuwang//Uploads/banner/<?php echo ($item["img"]); ?>)">
                        </a>
                        <?php else: ?>
                        <div class="swiper-slide" style="background-image:url(/jinwanfuwuwang//Uploads/banner/<?php echo ($item["img"]); ?>)">
                        </div><?php endif; endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Job Section Start -->
<div
    class="job-section section bg-image-proparty bg_image--2 pt-115 pt-lg-95 pt-md-75 pt-sm-55 pt-xs-45 pb-120 pb-lg-100 pb-md-80 pb-sm-60 pb-xs-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-wrap mb-45">
                    <div class="section-title">
                        <span>JOBS</span>
                        <h3 class="title">最新职位</h3>
                    </div>
                    <!-- <div class="jetapo-tab-menu">
                                <ul class="nav">
                                    <li><a class="active show" data-toggle="tab" href="#fullTime"> Full Time </a></li>
                                    <li><a data-toggle="tab" href="#partTime"> Part Time </a></li>
                                    <li><a data-toggle="tab" href="#remote"> Remote </a></li>
                                    <li><a data-toggle="tab" href="#freelancer"> Freelancer </a></li>
                                    <li><a data-toggle="tab" href="#internship"> Internship </a></li>
                                </ul>
                            </div> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="tab-content">
                    <div id="fullTime" class="tab-pane fade show active">
                        <div class="row">
                            <?php if(is_array($jobsList)): $i = 0; $__LIST__ = $jobsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$job): $mod = ($i % 2 );++$i;?><div class="col-lg-6 mb-30">
                                <!-- Single Job Start  -->
                                <div class="single-job">
                                    <div class="info-top">
                                        <div class="job-info">
                                            <div class="job-info-inner">
                                                <div class="job-info-top">
                                                    <div class="title-name">
                                                        <h3 class="job-title">
                                                            <a href="<?php echo ($job['realurl']); ?>"><?php echo ($job['title']); ?></a>
                                                        </h3>
                                                        <div class="employer-name"><?php echo ($job['company']); ?></div>
                                                    </div>
                                                </div>
                                                <div>薪资：<span class="job-salary"><?php echo ($job['wage']); ?></span></div>
                                                <div class="job-meta">
                                                    <div class="job-location"><i class="lnr lnr-map-marker"></i><?php echo ($job['addr']); ?></div>

                                                    <div class="job-type"><i class="lnr lnr-briefcase"></i><?php echo ($job['type']); ?></div>

                                                    <div class="job-date"><i class="lnr lnr-clock"></i><?php echo ($job['date']); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Job End -->
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="all-link-button text-center mt-15">
                    <a class="ht-btn lg-btn" href="<?php echo U('Jobs/index');?>">浏览更多招聘职位</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Job Section End -->

<!-- Blog Section Start  -->
<div class="blog-section section pt-115 pt-lg-95 pt-md-75 pt-sm-55 pt-xs-45 pb-90 pb-lg-70 pb-md-50 pb-sm-30 pb-xs-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-wrap mb-45">
                    <div class="section-title">
                        <span> LATEST NEWS</span>
                        <h3 class="title"> 人社动态</h3>
                    </div>
                    <!-- <div class="jetapo-link">
                                <a href="#"> Browse All Articles <i class="lnr lnr-chevron-right"></i></a>
                            </div> -->
                </div>
            </div>
        </div>
        <div class="row">
            <?php if(is_array($worknews)): foreach($worknews as $key=>$item): ?><div class="col-lg-4 col-md-6 mb-30">
                    <!-- Single Blog Start -->
                    <div class="single-blog">
                        <div class="blog-image">
                            <a href="<?php echo ($item['realurl']); ?>">
                                <img src="/jinwanfuwuwang/Web/Static/images/blog/blog1.jpg" alt="">
                            </a>
                            <!-- <div class="blog-cat">
                                        <a href="#" rel="category tag">Job Skills</a>
                                    </div> -->
                        </div>
                        <div class="blog-content">
                            <h4 class="title">
                                <a href="<?php echo ($item['realurl']); ?>"><?php echo ($item['title']); ?></a>
                            </h4>
                            <div class="blog-meta">
                                <p class="blog-author">
                                    <i class="lnr lnr-user"></i>
                                    <span class="text">来源:</span>
                                    <span class="author"><?php echo ($item['origin']); ?></span>
                                </p>
                                <p class="blog-date-post">
                                    <i class="lnr lnr-clock"></i><?php echo ($item['date']); ?>
                                </p>
                            </div>
                            <p class="blog-desc">
                                <?php echo ($item['description']); ?>
                            </p>
                            <a href="<?php echo ($item['realurl']); ?>" class="read-more">查看详情 <i class="lnr lnr-chevron-right"></i></a>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                </div><?php endforeach; endif; ?>





        </div>
    </div>
</div>
<!-- Blog Section End -->

<!-- Blog Section Start  -->
<div
    class="blog-section section bg-image-proparty bg_image--2 pt-115 pt-lg-95 pt-md-75 pt-sm-55 pt-xs-45 pb-90 pb-lg-70 pb-md-50 pb-sm-30 pb-xs-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-wrap mb-45">
                    <div class="section-title">
                        <span> LATEST NEWS</span>
                        <h3 class="title"> 人社政策</h3>
                    </div>
                    <!-- <div class="jetapo-link">
                                <a href="#"> Browse All Articles <i class="lnr lnr-chevron-right"></i></a>
                            </div> -->
                </div>
            </div>
        </div>
        <div class="row">
            <?php if(is_array($policynews)): foreach($policynews as $key=>$item): ?><div class="col-lg-4 col-md-6 mb-30">
                    <!-- Single Blog Start -->
                    <div class="single-blog" style="background-color:#fff;">
                        <div class="blog-content">
                            <h4 class="title">
                                <a href="<?php echo ($item['realurl']); ?>"><?php echo ($item['title']); ?></a>
                            </h4>
                            <div class="blog-meta">

                                <p class="blog-date-post">
                                    <i class="lnr lnr-clock"></i><?php echo ($item['date']); ?>
                                </p>
                            </div>
                            <p class="blog-desc">
                                <?php echo ($item['description']); ?>
                            </p>
                            <a href="<?php echo ($item['realurl']); ?>" class="read-more">查看详情 <i class="lnr lnr-chevron-right"></i></a>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                </div><?php endforeach; endif; ?>





        </div>
    </div>
</div>
<!-- Blog Section End -->

<footer class="link-section section pt-35 pb-35">

    <!--Footer bottom start-->
    <div class="container">
        <ul class="row link-box">
            <li class="col-lg-2 mb-10"><a target="_blank"
                    href="http://www.career.zju.edu.cn/jyxt/jyweb/webIndex.zf"><span>浙江大学</span></a></li>
            <li class="col-lg-2 mb-10"><a target="_blank" href="http://jobs.xtu.edu.cn/"><span>湘潭大学</span></a></li>
            <li class="col-lg-2 mb-10"><a target="_blank" href="http://www.cpu.edu.cn/"><span>中国药科大学</span></a></li>
            <li class="col-lg-2 mb-10"><a target="_blank" href="http://www.gxust.edu.cn/"><span>桂林电子科技大学</span></a></li>
            <li class="col-lg-2 mb-10"><a target="_blank" href="http://jy.hnust.edu.cn/"><span>湖南科技大学</span></a></li>
            <li class="col-lg-2 mb-10"><a target="_blank" href="http://www.glut.edu.cn/"><span>桂林理工大学</span></a></li>
            <li class="col-lg-2 mb-10"><a target="_blank" href="http://www.zmu.edu.cn/"><span>遵义医科大学</span></a></li>
            <li class="col-lg-2 mb-10"><a href="http://www.gxust.edu.cn/" target="_blank"><span>广西科技大学</span></a></li>
            <li class="col-lg-2 mb-10"><a href="http://jy.hnie.edu.cn/" target="_blank"><span>湖南工程学院</span></a></li>
            <li class="col-lg-2 mb-10"><a href="http://www.zhuhai.gov.cn/" target="_blank"><span>珠海市政府</span></a></li>
            <li class="col-lg-2 mb-10"><a href="http://job.jluzh.com" target="_blank"><span>吉林大学珠海学院就业网</span></a></li>
            <li class="col-lg-2 mb-10"><a href="http://jyxxw.zhcpt.edu.cn/"
                    target="_blank"><span>珠海市城市职业技术学院就业网</span></a></li>
            <li class="col-lg-2 mb-10"><a href="http://www.zhac.net/xin/jiuye/Article_Show.asp?NID=104&amp;Type=1"
                    target="_blank"><span>珠海艺术职业学院就业网</span></a></li>
            <li class="col-lg-2 mb-10"><a href="http://gdit.jobsys.cn/unijob/index.php/web/Index/index"
                    target="_blank"><span>广东科学技术职业学院就业网</span></a></li>
        </ul>
    </div>
    <!--Footer bottom end-->

</footer>
        <!--Footer section start-->
<footer class="footer-section section">

    <!-- Footer Top Section Start -->
    <!-- Footer Top Section End -->

    <!--Footer bottom start-->
    <div class="footer-bottom section fb-60" style="font-size:12px;color:#969696;">
        <div class="container">
            <div class="row no-gutters st-border pt-35 pb-35 align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6">
                    <div class="copyright">
                        <p>珠海市金湾区人力资源和社会保障局版权所有</p>
                        联系地址：珠海市金湾区红旗镇南翔路313号3楼&nbsp;&nbsp;电话：0756-7262615 
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="footer-social">
                        珠海金湾人力资源服务网<br>粤ICP备16089975号
                        <!-- <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-google"></i></a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Footer bottom end-->

</footer>
<!--Footer section end-->
    </div>

</body>

</html>
<!-- All jquery file included here -->
<script src="/jinwanfuwuwang/Web/Static/js/vendor/jquery-3.5.0.min.js"></script>
<script src="/jinwanfuwuwang/Web/Static/js/vendor/jquery-migrate-3.1.0.min.js"></script>
<script src="/jinwanfuwuwang/Web/Static/js/vendor/bootstrap.bundle.min.js"></script>
<!-- <script src="/jinwanfuwuwang/Web/Static/js/plugins/plugins.js"></script> -->

<!-- Use the minified version files listed below for better performance and remove the files listed above -->
<script src="/jinwanfuwuwang/Web/Static/js/plugins/plugins.min.js"></script>
<script src="/jinwanfuwuwang/Web/Static/js/main.js"></script>
<script>
    $(function () {
        var swiper = new Swiper('#js-swiper-banner', {
            autoplay: 5000,
        });
    })
</script>