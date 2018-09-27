<?php
/**
 * Created by PhpStorm.
 * User: bamoke
 * Date: 2018/04/10
 * Time: 17:21
 */
//php环境检测
if(version_compare(PHP_VERSION,'5.3.0','<')) die('require PHP > 5.3.0 !');

//设置开发模式；当前开启调试模式
define("APP_DEBUG",true);

//定义应用名称,3.2可以不用定义
// define("APP_NAME","中拉合作网");

//定义应用目录
define("APP_PATH","./");

//设置是否生成目录安全文件
define("BUILD_DIR_SECURE",false);

//生成模块并绑定,默认生成Home模块； (另有$_GET['m']方法绑定)
define("BIND_MODULE","Web");

//生成控制器并绑定，默认生成Index控制器； (另有$_GET['c']方法绑定)
// define("BIND_CONTROLLER","Index");

// 定义应用目录
//define("ROOT","");
define("ROOT","/");
define('APP_STATUS','server');
// define('APP_STATUS','local');
define("DEFAULT_THEME_NAME","Cn");//定义对应的模板主题

//引入PHP框架文件
require("../ThinkPHP/ThinkPHP.php");