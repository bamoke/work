<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title><?php echo ($output['title']); ?></title>
    <link href="/yikeyun/./Manage/Asset/Css/font-awesome.min.css" rel="stylesheet">
    <link href="/yikeyun/Public/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/yikeyun/./Manage/Asset/Css/default.css" rel="stylesheet">
    <script>
        const rootDir = "/yikeyun";
    </script>
    
    <?php if(isset($output['script'])): $script = $output['script']; ?>
        <?php else: ?>
        <?php $script = 'common/init'; endif; ?>
    <script type="text/javascript" src="/yikeyun/Public/lib/require/require.js" data-main="/yikeyun/./Manage/Asset//Js/<?php echo ($script); ?>"></script>
    <style type="text/css">
    html {
        width:100%;height:100%;
    }
        @keyframes bgAnimation {
            0% {
                background-color: #176eff;
            }

            /*25% {background-color:#17e1ff;}*/
            50% {
                background-color: #2fc4b2;
            }

            100% {
                background-color: #176eff;
            }
        }

        body {background-color:#176eff;animation:bgAnimation 10s linear infinite}
        .form-control,#login-form input:-webkit-autofill {background-color:#000!important;border-color:#333!important;}
    </style>
</head>

<body style="width:100%;height:100%;padding-top:0;">
    <div id="login-background"></div>
    <div class="login-form-wrap">
        <h3 class="login-page-title text-center">一课云后台管理系统V1.01</h3>
        <!-- <h2 class="caption text-center">用户登录</h2> -->
        <form name="loginform" role="form" action="<?php echo U('login');?>" method="post" id="login-form">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="请输入用户名" value="" />
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="请输入密码" value="" />
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-7">
                        <input type="text" name="code" class="form-control" placeholder="请输入验证码" />
                    </div>
                    <div class="col-xs-5 text-right">
                        <img id="verifyCode" src="<?php echo U('Main/code');?>" style="cursor: pointer" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-danger btn-block">登录</button>
            </div>
        </form>
    </div>
</body>

</html>