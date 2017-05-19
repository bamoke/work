<?php
return array(
    'DEFAULT_MODULE'    =>'Web',

    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'webcms', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '123456', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'wc_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  => TRUE, // 数据库调试模式 开启后可以记录SQL日志

    'SHOW_PAGE_TRACE'   =>true,//开启页面调试

    define("UPLOAD",ROOT."/Upload"),

);