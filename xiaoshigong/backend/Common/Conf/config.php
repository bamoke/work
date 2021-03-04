<?php
/*
 * @Author: Joy wang
 * @Date: 2021-02-16 21:47:05
 * @LastEditTime: 2021-02-19 23:05:12
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
return array(

	//database settting
	'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_NAME'   => 'xiaoshigong', // 数据库名
    'DB_HOST'   => '39.105.2.50', // 服务器地址
    'DB_USER'   => 'xsgsql', // 用户名
    'DB_PWD'    => 'xsg2021***', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'xsg_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  => false, // 数据库调试模式 开启后可以记录SQL日志

    'SHOW_PAGE_TRACE'   =>false,//开启页面调试
    "UPLOAD_BASE_URL"	=>"https://www.bamoke.com/jygw/Uploads",
    	// OSS
	"OSS_BASE_URL"	=>"https://bmk-jygw.oss-cn-shenzhen.aliyuncs.com"

);