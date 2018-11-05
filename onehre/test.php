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
$data = array(
    "《论语》","《春秋》","《道德经》","《史记》"
);
echo serialize($data);