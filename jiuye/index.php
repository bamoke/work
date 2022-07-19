<?php
/*
 * @Author: Joy wang
 * @Date: 2021-04-09 05:43:40
 * @LastEditTime: 2021-04-09 08:44:50
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */



//设置开发模式；当前开启调试模式
define("APP_DEBUG",true);
//define('STATIC_DEBUG',time());

//定义应用名称,3.2可以不用定义
define("APP_NAME","古月迁香酒业");

//定义应用目录
define("APP_PATH","../jiuye/");

//设置是否生成目录安全文件
define("BUILD_DIR_SECURE",false);

//生成模块并绑定,默认生成Home模块； (另有$_GET['m']方法绑定)
define("BIND_MODULE","Home");
//$_GET['m']='Api';

//生成控制器并绑定，默认生成Index控制器； (另有$_GET['c']方法绑定)
//define("BIND_CONTROLLER","Index");

//
define("ROOT",dirname(__FILE__));
define("WEB_BASE","/");
//引入PHP框架文件
require("../ThinkPHP/ThinkPHP.php");