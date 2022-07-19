<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2015/10/27
 * Time: 17:21
 */


//设置开发模式；当前开启调试模式
define("APP_DEBUG",true);
//define('STATIC_DEBUG',time());

//定义应用名称,3.2可以不用定义
// define("APP_NAME","XLAB项目管理系统基于THINKPHP框架重构");

//定义应用目录
define("APP_PATH","./");

//设置是否生成目录安全文件
define("BUILD_DIR_SECURE",false);
          
//生成模块并绑定,默认生成Home模块； (另有$_GET['m']方法绑定)
define("BIND_MODULE","Home");
//$_GET['m']='Api';  

//生成控制器并绑定，默认生成Index控制器； (另有$_GET['c']方法绑定)
//define("BIND_CONTROLLER","Index");


// define
define('ROOT',dirname(__FILE__));
//引入PHP框架文件
require("../ThinkPHP/ThinkPHP.php"); // local
// require("../../ThinkPHP/ThinkPHP.php");  // server     