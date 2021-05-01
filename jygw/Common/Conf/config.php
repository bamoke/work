<?php
/*
 * @Author: Joy wang
 * @Date: 2019-10-11 15:43:05
 * @LastEditTime: 2021-04-20 01:32:50
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
return array(
	// template replace rule;only can set once
	"TMPL_PARSE_STRING"	=>array(
        "__WEB_ASSET__"     =>__ROOT__."/jygw/Web/Assets",
		"__UPLOAD__"        =>"http://bmk-jygw.oss-cn-shenzhen.aliyuncs.com/",
		// "__UPLOAD__"        =>__ROOT__."/Uploads",
		"__ADMIN_ASSET__"   =>__ROOT__."/jygw/Admin/Assets"
	),

	//database settting
	'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_NAME'   => 'jygw', // 数据库名
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'bamoke2018***', // 密码

    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'x_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  => false, // 数据库调试模式 开启后可以记录SQL日志

    'SHOW_PAGE_TRACE'   =>true,//开启页面调试
    "UPLOAD_BASE_URL"	=>"https://www.bamoke.com/jygw/Uploads",
    
    // OSS config
	"OSS_ENDPOINT"		=>"oss-cn-shenzhen.aliyuncs.com",
	"OSS_BUCKET"		=>"bmk-jygw",
	"OSS_ACCESS_ID"		=>"LTAI95IEfCXiiAzB",
	"OSS_ACCESS_KEY"	=>"WjxGGajMb4iM8YPJYVLHwCloUhUJSn",
	"OSS_BASE_URL"	    =>"https://bmk-jygw.oss-cn-shenzhen.aliyuncs.com"

);