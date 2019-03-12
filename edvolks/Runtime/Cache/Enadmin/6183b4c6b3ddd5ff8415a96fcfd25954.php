<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title><?php echo ($output['title']); ?></title>
    <link href="/edvolks/Public/Js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/edvolks/Enadmin/Assets/Style/default.css" rel="stylesheet">
    
    <?php if(isset($output['script'])): $script = $output['script']; ?>
        <?php else: ?>
        <?php $script = 'common/init'; endif; ?>
    <script type="text/javascript" src="/edvolks/Public/Js/require/require.js" data-main="/edvolks/Enadmin/Assets/Js/<?php echo ($script); ?>"></script>
    <style type="text/css">
        @keyframes bgAnimation{
            0% {background-color:#176eff;}
            /*25% {background-color:#17e1ff;}*/
            50% {background-color:#17ffbb;}
            100% {background-color:#176eff;}
        }
        body {background-color:#176eff;animation:bgAnimation 5s linear infinite}
    </style>
    <script>
        const rootDir = '/edvolks';
    </script>
</head>
<body>
<div>
    <div class="login-form-wrap">
        <div class="login-page-title"></div>
        <h2 class="caption text-center">用户登录</h2>
        <form name="loginform" role="form" action="<?php echo U('login');?>" method="post">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="请输入用户名" value=""/>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-eye-open"></i></span>
                    <input type="password" name="password" class="form-control" value=""/>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-7">
                        <input type="text" name="code" class="form-control" placeholder="请输入验证码" />
                    </div>
                    <div class="col-xs-5 text-right">
                        <img id="verifyCode" src="<?php echo U('Main/code');?>" style="cursor: pointer"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-danger form-control">登录</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>