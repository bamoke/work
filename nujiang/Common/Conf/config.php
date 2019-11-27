<?php
return array(
    'TMPL_PARSE_STRING'=>array(
        "__WEB_ASSET__"     =>BASE_URL."Web/Static",
		"__UPLOAD__"        =>__ROOT__."/Uploads",
		"__ADMIN_ASSET__"   =>BASE_URL."Admin/Assets"
    ),

    // APP setting
//    "MODULE_ALLOW_LIST" =>array("Home"),

    // APP Default RESET


    // APP URL 设定
    "URL_MODEL" =>1,
    "URL_HTML_SUFFIX"   =>"",
    'DEFAULT_V_LAYER' => 'View',

    // APP Template Setting
    "TMPL_LAYOUT_ITEM"  =>"{__REPLACE__}",
    "LAYOUT_ON" =>true,
    "LAYOUT_NAME"   =>"Layout/main",

    // DB setting
/*    "DB_HOST"   =>"119.23.171.184",
    "DB_PORT"   =>"3306",
    "DB_NAME"   =>"btc",
    "DB_TYPE"   =>"mysql",
    "DB_USER"   =>"btc",
    "DB_PWD"    =>"Btc123456",
    "DB_PREFIX" =>"b_",*/

    "DB_HOST"   =>"39.105.2.50",
    "DB_PORT"   =>"3306",
    "DB_NAME"   =>"nujiang",
    "DB_TYPE"   =>"mysql",
    "DB_USER"   =>"remotesql",
    "DB_PWD"    =>"123456",
    // "DB_PWD"    =>"bamoke2018***",
    "DB_PREFIX" =>"b_",

    // Trace
    // "SHOW_PAGE_TRACE"   =>true



);