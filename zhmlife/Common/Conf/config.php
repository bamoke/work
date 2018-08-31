<?php
return array(
	// template replace rule;only can set once
	"TMPL_PARSE_STRING"	=>array(
        "__WEB_ASSET__"     =>__ROOT__."/Web/Assets",
		"__UPLOAD__"        =>"http://www.zhmlife.com/Uploads",
		// "__UPLOAD__"        =>__ROOT__."/Uploads",
		"__MOBILE_ASSET__"   =>__ROOT__."/Mobile/Assets",
		"__ADMIN_ASSET__"   =>__ROOT__."/Admin/Assets"
	),

	//database settting
	'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_NAME'   => 'zhmlife', // 数据库名
    'DB_HOST'   => '39.105.2.50', // 服务器地址
    'DB_USER'   => 'remotesql', // 用户名
    'DB_PWD'    => '123456', // 密码
    // 'DB_HOST'   => 'localhost', // 服务器地址
    // 'DB_USER'   => 'zhmlifesql', // 用户名
    // 'DB_PWD'    => 'zhm!2#4%6&8', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'b_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  => false, // 数据库调试模式 开启后可以记录SQL日志

    'SHOW_PAGE_TRACE'   =>false,//开启页面调试
);