<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_NAME'   => 'lscms', // 数据库名
    'DB_HOST'   => '112.74.42.16', // 服务器地址
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'vjEj31NP8x', // 密码
    // 'DB_HOST'   => 'localhost', // 服务器地址
    // 'DB_USER'   => 'zhmlifesql', // 用户名
    // 'DB_PWD'    => 'zhm!2#4%6&8', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'cms_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  => false, // 数据库调试模式 开启后可以记录SQL日志

    'SHOW_PAGE_TRACE'   =>false,//开启页面调试
    "UPLOAD_BASE_URL"	=>"https://lscms.oss-cn-shenzhen.aliyuncs.com/images",
    	// OSS
	// "OSS_BASE_URL"	=>"https://bmk-jygw.oss-cn-shenzhen.aliyuncs.com"
);