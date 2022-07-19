<?php
return array(
	//'配置项'=>'配置值'
	'LAYOUT_ON' 		=> true,
	'LAYOUT_NAME'		=>"Layout/main",
	'TMPL_LAYOUT_ITEM' => '{__CONTENT__}',
	'SHOW_PAGE_TRACE'   =>false,//开启页面调试
	"TMPL_PARSE_STRING"	=>array(
        "__HOME_ASSET__"     =>__ROOT__."/Home/Assets"
	),
	"MODULE_ASSET"	=>__ROOT__."/device/Assets"
);