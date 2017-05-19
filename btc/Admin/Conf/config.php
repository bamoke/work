<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_PARSE_STRING'=>array(
        '__TMPL_STATIC__'=>__ROOT__."/Admin/Tpl/Static",
    ),

    /***********模板布局设置***********/
    'LAYOUT_ON' =>true,//开启模板布局功能
    'LAYOUT_NAME'   =>'Main/layout',//定义模板文件
    'TMPL_LAYOUT_ITEM'  =>'{__REPLACE__}',//特定替换字符串
);