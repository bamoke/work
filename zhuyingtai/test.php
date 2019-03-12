<?php
/* header("Access-Control-Allow-Origin:*");
if($_SERVER['REQUEST_METHOD'] =='OPTIONS'){
    header("HTTP/1.0 204 Not Content");
}

header("Content-type:application/json;charset=utf-8");
header('Access-Control-Allow-Methods:GET,HEAD,PUT,POST,DELETE,PATCH'); 
header("Access-Control-Allow-Headers:content-type,x-access-token,x-url-path"); */
// $data = file_get_contents('php://input');
// echo (json_encode($_POST)) ;
// var_dump($data);
/* $data = array(
    "五险一金","假期福利（法定假期、事假、病假等）","带薪年假","都没有"
);
echo serialize($data); */
/* $str = '<p>aaa</p><style>a {color:#fff;}</style>';
$pattern = '/<(style.*?)>(.*?)<(\/style.*?)>/si';
$result = preg_replace($pattern,'',$str);
var_dump($result); */
echo md5("abc987***");