<?php
return array(

    "DEFAULT_THEME"    =>"Default",
    // APP URL 设定
    "URL_MODEL" =>1,
    "URL_HTML_SUFFIX"   =>"",
    'DEFAULT_V_LAYER' => 'View',

    // APP Template Setting
    "TMPL_LAYOUT_ITEM"  =>"{__REPLACE__}",
    "LAYOUT_ON" =>true,
    "LAYOUT_NAME"   =>"Layout/main",

    //MODULE Template Setting
    "TMPL_PARSE_STRING" =>array(
        "__MODULE_ASSET__"     =>__ROOT__."/".MODULE_PATH."Asset/",
        "__MODULE_UPLOAD__"    =>__ROOT__."/".MODULE_PATH."Uploads/",
        "__UPLOADS__"   =>"/yikeyun/Upload"
    ),
    "OSS_ACCESS_ID"     =>"LTAI4GG3qKgF2hk3zJ2o75NB",
    "OSS_ACCESS_KEY"    =>"bFRi2B1TvT3xdjGONNapLV8Q6zyfY2",
    "OSS_ENDPOINT_LOCAL"      =>"oss-cn-shenzhen-internal.aliyuncs.com",
    "OSS_ENDPOINT"      =>"oss-cn-shenzhen.aliyuncs.com",
    "OSS_BUCKET"        =>"bmk-yikeyun",

    define("MODULE_ASSET",ROOT."/".MODULE_NAME."/Asset/"),
    define("MODULE_UPLOAD",ROOT."/".MODULE_NAME."/Asset/"),

    define("OSS_BASE_URL",'http://bmk-yikeyun.oss-cn-shenzhen.aliyuncs.com'),

);