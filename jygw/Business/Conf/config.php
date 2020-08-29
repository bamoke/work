<?php
return array(
	//'配置项'=>'配置值'
	'LAYOUT_ON' 		=> true,
	'LAYOUT_NAME'		=>"Layout/main",
	'TMPL_LAYOUT_ITEM' => '{__CONTENT__}',
	'SHOW_PAGE_TRACE'   =>false,//开启页面调试
	"TMPL_PARSE_STRING"	=>array(
        "__BUSINESS_ASSET__"     =>__ROOT__."/Business/Assets"
	),
	"MODULE_ASSET"	=>__ROOT__."/Business/Assets"
);