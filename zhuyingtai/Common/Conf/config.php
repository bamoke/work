<?php
/*
 * @Author: Joy wang
 * @Date: 2019-03-12 09:28:45
 * @LastEditTime: 2021-04-20 01:48:39
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
return array(
	//'配置项'=>'配置值'
	'SHOW_PAGE_TRACE'   =>false,//开启页面调试
	//database settting
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_NAME'   => 'bamoke', // 数据库名

	'DB_HOST'   => 'localhost', // 服务器地址
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'bamoke2018***', // 密码

	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'zyt_', // 数据库表前缀
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  => false, // 数据库调试模式 开启后可以记录SQL日志

	// static catgory data
	"DATA_EXP_NAME" => array("应届毕业生", "1年", "2年", "3年", "4年", "5年", "6年", "7年", "8年", "9年", "10年", "10年以上"),
	"DATA_EDU_NAME" => array("大专", "本科", "硕士", "博士", "其他"),
	"DATA_SEX_NAME" => array("请选择", "男", "女"),
	"DATA_WAGE_NAME" => array("面议", "3k以下", "3k-5k", "5k-10k", "10k-15k", "15k-25k", "25k-50k", "50k以上"),
	"DATA_COM_SIZE_NAME" => array("50人以下","50-150人","150-500人","500-1000人","1000-2000人","2000人以上"),
	// OSS
	"OSS_BASE_URL"	=>"https://onehre.oss-cn-shenzhen.aliyuncs.com"

);