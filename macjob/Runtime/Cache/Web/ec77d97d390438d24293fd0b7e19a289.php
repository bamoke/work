<?php if (!defined('THINK_PATH')) exit();?><html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>澳门招聘</title>
    <meta name="description" content="澳门招聘,珠海市人力资源网澳门招聘专栏">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Place favicon.ico in the root directory -->
    <link href="/macjob/Web/Static/images/favicon.ico" type="img/x-icon" rel="shortcut icon">
    <!-- All css files are included here. -->
    <link rel="stylesheet" href="/macjob/Web/Static/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/macjob/Web/Static/css/vendor/iconfont.min.css">
    <link rel="stylesheet" href="/macjob/Web/Static/css/vendor/helper.css">
    <!-- <link rel="stylesheet" href="/macjob/Web/Static/css/plugins/plugins.css"> -->
    <!-- <link rel="stylesheet" href="/macjob/Web/Static/css/style.css"> -->

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="/macjob/Web/Static/css/plugins/plugins.min.css?v=1">
    <link rel="stylesheet" href="/macjob/Web/Static/css/style.min.css?v=2">
    <!-- Modernizr JS -->
    <script src="/macjob/Web/Static/js/vendor/modernizr-3.10.0.min.js"></script>
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

<body class="template-color-1">

    <div id="main-wrapper">
                <!--Header section start-->
        <div class="<?php echo ($pageName=='首页' ? 'header-absolute ':'black-logo-version sticky-white '); ?>sb-border header-sticky d-none d-lg-block">
            <div class="main-header">
                <div class="container-fluid pl-50 pl-lg-15 pl-md-15 pr-0">
                    <div class="row align-items-center no-gutters">

                        <!--Logo start-->
                        <div class="col-xl-2 col-lg-2 col-12">
                            <div class="logo">
                                <a href="<?php echo U('Index/index');?>"><img src="/macjob/Web/Static/images/<?php echo ($pageName=='首页' ? 'logo-white':'logo'); ?>.png" alt=""></a>
                            </div>
                        </div>
                        <!--Logo end-->

                        <!--Menu start-->
                        <div class="col-xl-7 col-lg-7 col-12">
                            <nav class="main-menu">
                                <ul>
                                    <li><a href="<?php echo U('Index/index');?>">首页</a>
                                    </li>
                                    <li><a href="<?php echo U('Jobs/index');?>">招聘职位</a>
                                    </li>
                                    <li><a href="<?php echo U('News/index',array('cid'=>10));?>">政策法规</a>
                                    </li>
                                    <li><a href="<?php echo U('Index/index');?>">走进澳门</a>
                                    <li><a href="<?php echo U('News/index',array('cid'=>8));?>">最新动态</a>
                                    </li>
                                    <li><a href="<?php echo U('News/index',array('cid'=>9));?>">赴澳须知</a>
                                    </li>
                                    <li><a href="<?php echo U('Single/index',array('id'=>12));?>">人才培训</a>
                                    </li>
                                    <li><a href="<?php echo U('Single/index',array('id'=>1));?>">关于我们</a>
                                    </li>

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
        <header class="header-mobile bg_color--2 d-block d-lg-none">
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
                                                <img src="/macjob/Web/Static/images/logo-mobile.png" class="img-fluid" alt="">
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
                                    <img src="/macjob/Web/Static/images/logo-mobile.png" alt="Multipurpose">
                                </a>
                            </div>
                            <a class="mobile-close" href="#"></a>
                        </div>
                        <div class="menu-content">
                            <ul class="menulist object-custom-menu">
                                <li><a href="<?php echo U('Index/index');?>">首页</a>
                                </li>
                                <li><a href="<?php echo U('Jobs/index');?>">招聘职位</a>
                                </li>
                                <li><a href="<?php echo U('News/index',array('cid'=>10));?>">政策法规</a>
                                </li>
                                <li><a href="<?php echo U('Index/index');?>">走进澳门</a>
                                <li><a href="<?php echo U('News/index',array('cid'=>8));?>">最新动态</a>
                                </li>
                                <li><a href="<?php echo U('News/index',array('cid'=>9));?>">赴澳须知</a>
                                </li>
                                <li><a href="<?php echo U('Single/index',array('id'=>12));?>">人才培训</a>
                                </li>
                                <li><a href="<?php echo U('Single/index',array('id'=>1));?>">关于我们</a>
                                </li>
        

                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Popup Menu -->
                    <!--slider section start-->
        <div class="hero-section section position-relative">
            <!--Hero Item start-->
            <div class="hero-item bg_image--1">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">

                            <!--Hero Content start-->
                            <div class="hero-content-2 left">
                                <h2 class="title">珠海人力资源网-澳门招聘</h2>
                                <h3 class="sub-title">做专业的澳门劳务平台</h3>

                                <div class="job-search-wrap mt-60 mt-md-70 mt-sm-50 mt-xs-30">
                                    <p>“珠海人力资源网·澳门招聘”栏目是由珠海市珠光集团控股有限公司的属下企业珠海市南方人力资源服务有限公司与珠海国际（澳门）职业介绍所有限公司合力打造的具有唯一、正规化及国企性质的免费澳门招聘品牌栏目。</p>
                                    <P>“珠海人力资源网·澳门招聘”栏目将始终以维护澳门经济繁荣与稳定和为澳门雇主输送优秀对口人才为宗旨，依法依规发布各类输澳劳务岗位，为促进两地劳务合作持续健康发展，推动珠澳合作迈向更宽领域、更深层次、更高水平做出不懈努力。</P>
                                    <p><a class="ht-btn lg-btn" href="">我要揾工</a></p>
                                </div>

                            </div>
                            <!--Hero Content end-->

                        </div>
                    </div>
                </div>
            </div>
            <!--Hero Item end-->
        </div>
        <!--slider section end-->



        <!-- Job Location Section Start -->
        <div class="job-location section pt-110 pt-lg-95 pt-md-75 pt-sm-55 pt-xs-45 pb-120 pb-lg-100 pb-md-80 pb-sm-60 pb-xs-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-wrap mb-45">
                            <div class="section-title">
                                <span>JOB BY LOCATIONS</span>
                                <h3 class="title">走进澳门</h3>
                            </div>
                            <!-- <div class="jetapo-link">
                                <a href="#">Browse All Locations <i class="lnr lnr-chevron-right"></i></a>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="job-location-slider row">

                            <div class="col-lg-3">
                                <!-- Single Job Location Start -->
                                <div class="single-job-location bg-image" data-bg="/macjob/Web/Static/images/location/petaling.jpg">
                                    <div class="overlay-gradient"></div>
                                    <div class="location-info">
                                        <a class="city-name" href="http://www.fsm.gov.mo/psp/pspmonitor/mobile/" target="_blank">通关实时视频</a>
                                        <!-- <span class="count-job">20 职位</span> -->
                                    </div>
                                </div>
                                <!-- Single Job Location End -->
                            </div>

                            <div class="col-lg-3">
                                <!-- Single Job Location Start -->
                                <div class="single-job-location bg-image" data-bg="/macjob/Web/Static/images/location/jacksonville.jpg">
                                    <div class="overlay-gradient"></div>
                                    <div class="location-info">
                                        <a class="city-name" href="http://www.macaupublicbus.com/webapp.php/line/index.html" target="_blank">澳门公交巴士</a>
                                        <!-- <span class="count-job">56 职位</span> -->
                                    </div>
                                </div>
                                <!-- Single Job Location End -->
                            </div>

                            <div class="col-lg-3">
                                <!-- Single Job Location Start -->
                                <div class="single-job-location bg-image" data-bg="/macjob/Web/Static/images/location/houston.jpg">
                                    <div class="overlay-gradient"></div>
                                    <div class="location-info">
                                        <a class="city-name" href="#">澳门天气</a>
                                        <!-- <span class="count-job">16 职位</span> -->
                                    </div>
                                </div>
                                <!-- Single Job Location End -->
                            </div>

                            <div class="col-lg-3">
                                <!-- Single Job Location Start -->
                                <div class="single-job-location bg-image" data-bg="/macjob/Web/Static/images/location/Seville.jpg">
                                    <div class="overlay-gradient"></div>
                                    <div class="location-info">
                                        <a class="city-name" href="https://mp.weixin.qq.com/s/SfCm6Suh3yfRN7jF7yP0yA" target="_blank">澳门的城市竞争力</a>
                                        <!-- <span class="count-job">13 职位</span> -->
                                    </div>
                                </div>
                                <!-- Single Job Location End -->
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Job Location Section End -->

        <!-- Job Section Start -->
        <div class="job-section section bg-image-proparty bg_image--2 pt-115 pt-lg-95 pt-md-75 pt-sm-55 pt-xs-45 pb-120 pb-lg-100 pb-md-80 pb-sm-60 pb-xs-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-wrap mb-45">
                            <div class="section-title">
                                <span>SEASON FEATURE JOBS</span>
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

                                    <div class="col-lg-6 mb-30">
                                        <!-- Single Job Start  -->
                                        <div class="single-job">
                                            <div class="info-top">
                                                <div class="job-image">
                                                    <a href="#">
                                                        <img src="/macjob/Web/Static/images/companies_logo/logo-big/logo1.jpg" alt="logo">
                                                    </a>
                                                </div>
                                                <div class="job-info">
                                                    <div class="job-info-inner">
                                                        <div class="job-info-top">
                                                            <div class="saveJob for-listing">
                                                                <!-- <span class="featured-label">featured</span> -->
                                                                <a class="save-job ml-20" href="#quick-view-modal-container" data-toggle="modal">
                                                                    <i class="far fa-heart"></i>
                                                                </a>
                                                            </div>
                                                            <div class="title-name">
                                                                <h3 class="job-title">
                                                                    <a href="#">中西厨师</a>
                                                                </h3>
                                                                <div class="employer-name">
                                                                    <a href="employer-details.html">澳门美**茶餐厅</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="job-salary">MOP$17,000 - MOP$19,000</span>
                                                        <div class="job-meta">
                                                            <div class="job-location"><i class="lnr lnr-map-marker"></i><a href="#">花地玛堂区</a></div>

                                                            <div class="job-type"><i class="lnr lnr-briefcase"></i><a class="def-color" href="#">全职</a></div>

                                                            <div class="job-date"><i class="lnr lnr-clock"></i>2020-06-10</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Job End -->
                                    </div>

                                    <div class="col-lg-6 mb-30">
                                        <!-- Single Job Start  -->
                                        <div class="single-job">
                                            <div class="info-top">
                                                <div class="job-image">
                                                    <a href="#">
                                                        <img src="/macjob/Web/Static/images/companies_logo/logo-big/logo3.jpg" alt="logo">
                                                    </a>
                                                </div>
                                                <div class="job-info">
                                                    <div class="job-info-inner">
                                                        <div class="job-info-top">
                                                            <div class="saveJob for-listing">
                                                                <span class="featured-label">featured</span>
                                                                <a class="save-job ml-20" href="#quick-view-modal-container" data-toggle="modal">
                                                                    <i class="far fa-heart"></i>
                                                                </a>
                                                            </div>
                                                            <div class="title-name">
                                                                <h3 class="job-title">
                                                                    <a href="#">美容师（语言不限）</a>
                                                                </h3>
                                                                <div class="employer-name">
                                                                    <a href="employer-details.html">澳门某美容店</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="job-salary">MOP$9,000 - MOP$12,000</span>
                                                        <div class="job-meta">
                                                            <div class="job-location"><i class="lnr lnr-map-marker"></i><a href="#">嘉模堂区</a></div>

                                                            <div class="job-type"><i class="lnr lnr-briefcase"></i><a class="def-color" href="#">全职</a></div>

                                                            <div class="job-date"><i class="lnr lnr-clock"></i>2020-06-10</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Job End -->
                                    </div>

                                    <div class="col-lg-6 mb-30">
                                        <!-- Single Job Start  -->
                                        <div class="single-job">
                                            <div class="info-top">
                                                <div class="job-image">
                                                    <a href="#">
                                                        <img src="/macjob/Web/Static/images/companies_logo/logo-big/logo4.jpg" alt="logo">
                                                    </a>
                                                </div>
                                                <div class="job-info">
                                                    <div class="job-info-inner">
                                                        <div class="job-info-top">
                                                            <div class="saveJob for-listing">
                                                                <!-- <span class="featured-label">featured</span> -->
                                                                <a class="save-job ml-20" href="#quick-view-modal-container" data-toggle="modal">
                                                                    <i class="far fa-heart"></i>
                                                                </a>
                                                            </div>
                                                            <div class="title-name">
                                                                <h3 class="job-title">
                                                                    <a href="#">管理员/保安</a>
                                                                </h3>
                                                                <div class="employer-name">
                                                                    <a href="employer-details.html">澳门**物业公司</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="job-salary">MOP$10,000 - $15,000</span>
                                                        <div class="job-meta">
                                                            <div class="job-location"><i class="lnr lnr-map-marker"></i><a href="#">圣安多尼堂区</a></div>

                                                            <div class="job-type"><i class="lnr lnr-briefcase"></i><a class="def-color" href="#">全职</a></div>

                                                            <div class="job-date"><i class="lnr lnr-clock"></i>2020-06-11</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Job End -->
                                    </div>

                                    <div class="col-lg-6 mb-30">
                                        <!-- Single Job Start  -->
                                        <div class="single-job">
                                            <div class="info-top">
                                                <div class="job-image">
                                                    <a href="#">
                                                        <img src="/macjob/Web/Static/images/companies_logo/logo-big/logo2.jpg" alt="logo">
                                                    </a>
                                                </div>
                                                <div class="job-info">
                                                    <div class="job-info-inner">
                                                        <div class="job-info-top">
                                                            <div class="saveJob for-listing">
                                                                <!-- <span class="featured-label">featured</span> -->
                                                                <a class="save-job ml-20" href="#quick-view-modal-container" data-toggle="modal">
                                                                    <i class="far fa-heart"></i>
                                                                </a>
                                                            </div>
                                                            <div class="title-name">
                                                                <h3 class="job-title">
                                                                    <a href="#">客户服务代表</a>
                                                                </h3>
                                                                <div class="employer-name">
                                                                    <a href="employer-details.html">澳门某商业银行</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="job-salary">MOP$15,000 - MOP$20,000</span>
                                                        <div class="job-meta">
                                                            <div class="job-location"><i class="lnr lnr-map-marker"></i><a href="#"> 望德堂区</a></div>

                                                            <div class="job-type"><i class="lnr lnr-briefcase"></i><a class="def-color" href="#">全职</a></div>

                                                            <div class="job-date"><i class="lnr lnr-clock"></i>2020-06-10</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Job End -->
                                    </div>

                                    <div class="col-lg-6 mb-30">
                                        <!-- Single Job Start  -->
                                        <div class="single-job">
                                            <div class="info-top">
                                                <div class="job-image">
                                                    <a href="#">
                                                        <img src="/macjob/Web/Static/images/companies_logo/logo-big/logo5.jpg" alt="logo">
                                                    </a>
                                                </div>
                                                <div class="job-info">
                                                    <div class="job-info-inner">
                                                        <div class="job-info-top">
                                                            <div class="saveJob for-listing">
                                                                <!-- <span class="featured-label">featured</span> -->
                                                                <a class="save-job ml-20" href="#quick-view-modal-container" data-toggle="modal">
                                                                    <i class="far fa-heart"></i>
                                                                </a>
                                                            </div>
                                                            <div class="title-name">
                                                                <h3 class="job-title">
                                                                    <a href="#">面包师傅</a>
                                                                </h3>
                                                                <div class="employer-name">
                                                                    <a href="employer-details.html">澳门氹仔**餐厅</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="job-salary">MOP$9,000 - MOP$12,000</span>
                                                        <div class="job-meta">
                                                            <div class="job-location"><i class="lnr lnr-map-marker"></i><a href="#">路氹城</a></div>

                                                            <div class="job-type"><i class="lnr lnr-briefcase"></i><a class="def-color" href="#">全职</a></div>

                                                            <div class="job-date"><i class="lnr lnr-clock"></i>2020-06-09</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Job End -->
                                    </div>

                                    <div class="col-lg-6 mb-30">
                                        <!-- Single Job Start  -->
                                        <div class="single-job">
                                            <div class="info-top">
                                                <div class="job-image">
                                                    <a href="#">
                                                        <img src="/macjob/Web/Static/images/companies_logo/logo-big/logo1.jpg" alt="logo">
                                                    </a>
                                                </div>
                                                <div class="job-info">
                                                    <div class="job-info-inner">
                                                        <div class="job-info-top">
                                                            <div class="saveJob for-listing">
                                                                <!-- <span class="featured-label">featured</span> -->
                                                                <a class="save-job ml-20" href="#quick-view-modal-container" data-toggle="modal">
                                                                    <i class="far fa-heart"></i>
                                                                </a>
                                                            </div>
                                                            <div class="title-name">
                                                                <h3 class="job-title">
                                                                    <a href="#">中西厨师</a>
                                                                </h3>
                                                                <div class="employer-name">
                                                                    <a href="employer-details.html">澳门美**茶餐厅</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="job-salary">MOP$17,000 - MOP$19,000</span>
                                                        <div class="job-meta">
                                                            <div class="job-location"><i class="lnr lnr-map-marker"></i><a href="#">花地玛堂区</a></div>

                                                            <div class="job-type"><i class="lnr lnr-briefcase"></i><a class="def-color" href="#">全职</a></div>

                                                            <div class="job-date"><i class="lnr lnr-clock"></i>2020-06-10</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Job End -->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="all-link-button text-center mt-15">
                            <a class="ht-btn lg-btn" href="#">浏览更多招聘职位</a>
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
                                <h3 class="title"> 最新动态</h3>
                            </div>
                            <!-- <div class="jetapo-link">
                                <a href="#"> Browse All Articles <i class="lnr lnr-chevron-right"></i></a>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-4 col-md-6 mb-30">
                        <!-- Single Blog Start -->
                        <div class="single-blog">
                            <div class="blog-image">
                                <a href="#">
                                    <img src="/macjob/Web/Static/images/blog/blog1.jpg" alt="">
                                </a>
                                <!-- <div class="blog-cat">
                                    <a href="#" rel="category tag">Job Skills</a>
                                </div> -->
                            </div>
                            <div class="blog-content">
                                <h4 class="title">
                                    <a href="#">劳工事务局关注有特别需要的服务说明各项服务时可获优先轮候</a>
                                </h4>
                                <div class="blog-meta">
                                    <p class="blog-author">
                                        <i class="lnr lnr-user"></i>
                                        <span class="text">Posted:</span>
                                        <span class="author">Hien Tran</span>
                                    </p>
                                    <p class="blog-date-post">
                                        <i class="lnr lnr-clock"></i>2020-05-20
                                    </p>
                                </div>
                                <p class="blog-desc">
                                    凡年满65岁或以上人士、持残疾人士评估登记证人士及孕妇，亲临劳工事务局总办事处办理
                                </p>
                                <a href="#" class="read-more">Read More <i class="lnr lnr-chevron-right"></i></a>
                            </div>
                        </div>
                        <!-- Single Blog End -->
                    </div>

                    <div class="col-lg-4 col-md-6 mb-30">
                        <!-- Single Blog Start -->
                        <div class="single-blog">
                            <div class="blog-image">
                                <a href="#">
                                    <img src="/macjob/Web/Static/images/blog/blog2.jpg" alt="">
                                </a>
                                <!-- <div class="blog-cat">
                                    <a href="#" rel="category tag">News & Update</a>
                                </div> -->
                            </div>
                            <div class="blog-content">
                                <h4 class="title">
                                    <a href="#">今起内地输澳劳务人员不用隔离，拱北海关发出提醒</a>
                                </h4>
                                <div class="blog-meta">
                                    <p class="blog-author">
                                        <i class="lnr lnr-user"></i>
                                        <span class="text">Posted:</span>
                                        <span class="author">中国网直播</span>
                                    </p>
                                    <p class="blog-date-post">
                                        <i class="lnr lnr-clock"></i>2020-02-19
                                    </p>
                                </div>
                                <p class="blog-desc">
                                    2月20日起，内地赴澳门劳务人员须在珠海的指定地点实施医学观察14天
                                </p>
                                <a href="#" class="read-more">Read More <i class="lnr lnr-chevron-right"></i></a>
                            </div>
                        </div>
                        <!-- Single Blog End -->
                    </div>

                    <div class="col-lg-4 col-md-6 mb-30">
                        <!-- Single Blog Start -->
                        <div class="single-blog">
                            <div class="blog-image">
                                <a href="#">
                                    <img src="/macjob/Web/Static/images/blog/blog3.jpg" alt="">
                                </a>
                                <!-- <div class="blog-cat">
                                    <a href="#" rel="category tag">Career Advice</a>
                                </div> -->
                            </div>
                            <div class="blog-content">
                                <h4 class="title">
                                    <a href="#">澳门中职协会：内地在澳劳务人员达11.8万人</a>
                                </h4>
                                <div class="blog-meta">
                                    <p class="blog-author">
                                        <i class="lnr lnr-user"></i>
                                        <span class="text">Posted:</span>
                                        <span class="author">新华网客户端</span>
                                    </p>
                                    <p class="blog-date-post">
                                        <i class="lnr lnr-clock"></i>2019-04-10
                                    </p>
                                </div>
                                <p class="blog-desc">
                                    中资（澳门）职业介绍所协会，截至2018年底，内地在澳劳务人员已达11.8万人
                                </p>
                                <a href="#" class="read-more">Read More <i class="lnr lnr-chevron-right"></i></a>
                            </div>
                        </div>
                        <!-- Single Blog End -->
                    </div>

                </div>
            </div>
        </div>
        <!-- Blog Section End -->

                <!--Footer section start-->
        <footer class="footer-section section">

            <!-- Footer Top Section Start -->
            <!-- Footer Top Section End -->

            <!--Footer bottom start-->
            <div class="footer-bottom section fb-60">
                <div class="container">
                    <div class="row no-gutters st-border pt-35 pb-35 align-items-center justify-content-between">
                        <div class="col-lg-6 col-md-6">
                            <div class="copyright">
                                <p>&copy;2020 <a href="http://www.zh-hr.com">www.zh-hr.com</a>. All rights reserved.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="footer-social">
                                珠海人力资源网
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
<script src="/macjob/Web/Static/js/vendor/jquery-3.5.0.min.js"></script>
<script src="/macjob/Web/Static/js/vendor/jquery-migrate-3.1.0.min.js"></script>
<script src="/macjob/Web/Static/js/vendor/bootstrap.bundle.min.js"></script>
<!-- <script src="/macjob/Web/Static/js/plugins/plugins.js"></script> -->

<!-- Use the minified version files listed below for better performance and remove the files listed above -->
<script src="/macjob/Web/Static/js/plugins/plugins.min.js"></script>
<script src="/macjob/Web/Static/js/main.js"></script>