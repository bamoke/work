<?php
namespace Home\Common;
use Think\Controller;
class BaseController extends Controller {
    public function _initialize(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods:POST,GET'); 
        header("Access-Control-Allow-Headers:Content-type,accept,X-URL-PATH,x-access-token");
        if($_SERVER['REQUEST_METHOD'] != "OPTIONS") {
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $this->requestData = json_decode(file_get_contents("php://input"),true);
            }elseif($_SERVER['REQUEST_METHOD'] == "GET") {
                $this->requestData = $_GET;
            }
        }else {
            header("HTTP/1.0 204 Not Content");
            exit;
        }
    }
}