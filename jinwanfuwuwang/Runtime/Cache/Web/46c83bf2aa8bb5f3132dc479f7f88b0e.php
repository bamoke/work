<?php if (!defined('THINK_PATH')) exit();?><html class="no-js" lang="zh">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>金湾区第八届大学生创业大赛</title>
    <meta name="description" content="金湾区第八届大学生创业大赛">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Place favicon.ico in the root directory -->
    <link href="/jinwanfuwuwang/Web/Static/images/favicon.ico" type="img/x-icon" rel="shortcut icon">

    <link rel="stylesheet" href="/jinwanfuwuwang/Web/Static/css/chuangye.css?v=2">


    <style>
        html,body {
            margin:0;
            padding:0;
        }
        a {
            text-decoration: none;
        }
        .main-wrapper {
            margin:0 auto;
            width:1444px;
        }
        .content-wrap {
            margin:0 auto;
            width:1020px;
        }
        .m-header {
            position: relative;
        }
        .m-nav {
            position: absolute;
            left:0;
            top:0;
            z-index:1;
            padding-top:30px;
            width:100%;
            text-align: right;
            display: -webkit-flex;
            justify-content: flex-end;
        }
        .m-nav a {
            margin-left:50px;
            display: inline-block;
            padding-bottom:12px;
            color: #fff;
            text-decoration: none;
            line-height: 1;
            font-size:18px;
        }
        .m-nav a:hover {
            opacity: .8;
        }
        .m-nav .cur {
            border-bottom:2px solid #fff;
        }
        img {
            display: block;
        }
        .bg-grey {
            background-color:#f6fafd;
        }
        .bg-white {
            background-color:#fff;
        }
        .about-date-box {
            padding:84px 0;
            background-color: #251347;
        }
        .about-date-box .date {
            margin:0 auto;
            width:780px;
            height:88px;
            line-height: 88px;
            text-align: center;
            color:#fff;
            border:1px solid #fff;
            font-size:22px;
        }

        .news-box .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100px;
            color:#484848;
            border-bottom: 1px solid #dcdeed;
        }
        .news-box .item .title {
            flex-grow: 1;
            padding-left:20px;
            box-sizing: border-box;
        }
        .news-box .item .icon {
            flex: 0 0 auto;
            width:16px;
            height:2px;
            background-color: #333;
        }
        .news-box .item .date {
            flex:0 0 auto;
            width: 100px;
            text-align: right;
        }
        .news-box .item:hover .title {
            opacity: .7;
        }
    </style>
</head>

<body class="">
    <div class="m-header main-wrapper">
        <div class="m-nav">
            <div class="content-wrap">
                <a href="<?php echo U('index');?>" class="<?php if((ACTION_NAME) == "index"): ?>cur<?php endif; ?>">关于大赛</a>
                <a href="<?php echo U('richeng');?>" class="<?php if((ACTION_NAME) == "richeng"): ?>cur<?php endif; ?>">赛事日程</a>
                <a href="<?php echo U('projects');?>" class="<?php if((ACTION_NAME) == "projects"): ?>cur<?php endif; ?>">项目展示</a>
                <a href="<?php echo U('news');?>" class="<?php if((ACTION_NAME) == "news"): ?>cur<?php endif; ?>">赛事动态</a>
                <a href="<?php echo U('Index/index');?>">返回人力资源服务网</a>
            </div>
        </div>
        <div class="img-box">
            <img src="/jinwanfuwuwang/Web/Static/images/cyds-header-img.jpg" alt="" srcset="">
        </div>
    </div>
            <div class="main-wrapper bg-grey">
    <div class="content-wrap">
        <img src="/jinwanfuwuwang/Web/Static/images/cyds-about-1.jpg" alt="" srcset="">
    </div>
</div>
<div class="main-wrapper">
    <img src="/jinwanfuwuwang/Web/Static/images/cyds-about-2.jpg" alt="" srcset="">
</div>
<div class="main-wrapper bg-grey">
    <div class="content-wrap">
        <img src="/jinwanfuwuwang/Web/Static/images/cyds-about-3.jpg" alt="" srcset="">
    </div>
</div>
<div class="main-wrapper about-date-box">
    <div class="content-wrap">
        <div class="date">报名时间：即日起至2021年9月18日18:00</div>
    </div>
</div>
<div class="main-wrapper" style="background:#dbdeed;">
    <div class="content-wrap">
        <img src="/jinwanfuwuwang/Web/Static/images/cyds-about-4.jpg" alt="" srcset="">
    </div>
</div>
    <div class="m-footer main-wrapper">
        <div class="">
            <img src="/jinwanfuwuwang/Web/Static/images/cyds-footer-img.gif" alt="" srcset="">
        </div>
    </div>
</body>

</html>