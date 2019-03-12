<?php
return array(
	// template replace rule;only can set once
	"TMPL_PARSE_STRING"	=>array(
        "__WEB_ASSET__"     =>__ROOT__."/Web/Assets",
		"__UPLOAD__"        =>__ROOT__."/Uploads",
		"__ADMIN_ASSET__"   =>__ROOT__."/Enadmin/Assets"
	),

	//database settting
	'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_NAME'   => 'edvolks', // 数据库名
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'b_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  => false, // 数据库调试模式 开启后可以记录SQL日志

    'SHOW_PAGE_TRACE'   =>false,//开启页面调试
);