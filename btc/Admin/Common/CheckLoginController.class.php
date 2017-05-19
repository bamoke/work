<?php
/**
 * 登录检测
 * User: joy.wangxiangyin
 * Date: 2015/11/25
 * Time: 21:01
 */
namespace Admin\Common;
use Think\Controller;
class CheckLoginController extends Controller {
     protected function _initialize(){
        if(!$this->loginCheck()){
            echo "no login";
            exit();
        }
    }
    private function loginCheck(){
        if(isset($_SESSION['username'])){
            return true;
        }else {
            return false;
        }
    }
}