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
    <link rel="stylesheet" href="/macjob/Web/Static/css/style.min.css?v=1">
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
                                <li class="has-mega-menu"><a href="#"><span>Home</span></a>
                                </li>
        
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
                    <!-- Breadcrumb Section Start -->
        <div class="breadcrumb-section section bg_color--5 pt-60 pt-sm-50 pt-xs-40 pb-60 pb-sm-50 pb-xs-40">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <div class="page-breadcrumb-content">
                          <ul class="page-breadcrumb">
                              <li><a href="<?php echo U('Index/index');?>">首页</a></li>
                              <li><?php echo ($pageName); ?></li>
                          </ul>
                          <h1><?php echo ($pageName); ?></h1>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Breadcrumb Section Start -->

        <!-- Job Listing Section Start -->
        <div class="job-listing-section section bg_color--5 pb-120 pb-lg-100 pb-md-80 pb-sm-60 pb-xs-50">
          <div class="container pt-50">
              <div class="row no-gutters">

                  <div class="col-lg-12 order-lg-2 order-1">
                      <div class="filter-form">
                          <div class="result-sorting">
                              <div class="total-result">
                                  <span class="total">(22)</span>
                                  职位列表
                              </div>
                              <div class="form-left">
                                  <div class="sort-by">
                                        浏览模式：
                                  </div>
                                  <div class="layout-switcher">
                                      <ul class="nav">
                                          <li><a class="active show" data-toggle="tab" href="#list"><i class="fa fa-list"></i></a></li>
                                          <li><a data-toggle="tab" href="#grid"><i class="fa fa-th"></i></a></li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="tab-content">
                          <div id="list" class="tab-pane fade show active">
                              <div class="row">

                                  <?php if(is_array($jobsList)): $i = 0; $__LIST__ = $jobsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$job): $mod = ($i % 2 );++$i;?><div class="col-lg-12 mb-20">
                                      <!-- Single Job Start  -->
                                      <div class="single-job style-two">
                                          <div class="info-top">
                                              <div class="job-image">
                                                  <a href="<?php echo U('detail',array('id'=>$job['id']));?>">
                                                      <img src="/macjob/Web/Static/images/companies_logo/logo-big/logo2.jpg" alt="logo">
                                                  </a>
                                              </div>
                                              <div class="job-info">
                                                  <div class="job-info-inner">
                                                      <div class="job-info-top">
                                                          <div class="title-name">
                                                              <h3 class="job-title">
                                                                  <a href="<?php echo U('detail',array('id'=>$job['id']));?>"><?php echo ($job['title']); ?></a>
                                                              </h3>
                                                              <div class="employer-name">
                                                                  <a href="<?php echo U('detail',array('id'=>$job['id']));?>"><?php echo ($job['company']); ?></a>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="job-meta-two">
                                                          <div class="field-salary_from">
                                                            <?php echo ($job['wage']); ?>
                                                          </div>
                                                          <div class="field-datetime"><i class="lnr lnr-clock"></i><?php echo ($job['create_time']); ?></div>
                                                          <div class="field-map"><i class="lnr lnr-map-marker"></i>花地玛堂区</div>
                                                      </div>
                                                      <div class="job-skill-tag">
                                                          <a href="#">Android</a>
                                                          <a href="#">app</a>
                                                          <a href="#">ReactJs</a>
                                                          <a href="#">Ruby</a>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <!-- Single Job End -->
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>


                              </div>
                              <div class="row">
                                  <div class="col-12">
                                      <ul class="page-pagination">
                                          <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                          <li class="active"><a href="#">1</a></li>
                                          <li><a href="#">2</a></li>
                                          <li><a href="#">3</a></li>
                                          <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                          <div id="grid" class="tab-pane fade">
                              <div class="row">
                                <?php if(is_array($jobsList)): $i = 0; $__LIST__ = $jobsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$job): $mod = ($i % 2 );++$i;?><div class="col-md-6 mb-20">
                                      <!-- Single Job Start  -->
                                      <div class="single-job-grid-two">
                                          <div class="job-image">
                                              <a href="<?php echo U('detail',array('id'=>$job['id']));?>">
                                                  <img src="/macjob/Web/Static/images/companies_logo/logo-big/logo2.jpg" alt="">
                                              </a>
                                          </div>
                                          <div class="job-info">
                                              <div class="job-info-top">
                                                  <div class="title-name">
                                                      <h3 class="job-title">
                                                          <a href="/macjob/Web/Static/images/companies_logo/logo-big/logo2.jpg"><?php echo ($job['title']); ?></a>
                                                      </h3>
                                                      <div class="employer-name">
                                                          <a href="employer-details.html"><?php echo ($job['company']); ?></a>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="job-meta-two">
                                                  <div class="field-salary_from">
                                                      <i class="gj-icon gj-icon-money"></i>
                                                      <?php echo ($job['wage']); ?>
                                                  </div>
                                                  <div class="field-datetime"><i class="lnr lnr-clock"></i><?php echo ($job['create_time']); ?></div>
                                                  <div class="field-map"><i class="lnr lnr-map-marker"></i>花地玛堂区</div>
                                              </div>
                                              <div class="field-descriptions">
                                                  <p>这里是职位简单描述信息这里是职位简单描述信息这里是职位简单描述信息</p>
                                              </div>
                                              <div class="job-skill-tag">
                                                  <a href="#">福利好</a>
                                                  <a href="#">5天8小时</a>
                                                  <a href="#">有年假</a>
                                                  <a href="#">年底3薪</a>
                                              </div>
                                          </div>
                                      </div>
                                      <!-- Single Job End -->
                                  </div><?php endforeach; endif; else: echo "" ;endif; ?>


                              </div>
                              <div class="row">
                                  <div class="col-12">
                                    <?php echo ($outData['page']); ?>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>

              </div>
          </div>
      </div>
      <!-- Job Listing Section End -->
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