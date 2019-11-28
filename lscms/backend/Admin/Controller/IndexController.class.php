<?php
namespace Organization\Controller;
use Organization\Common\Auth;
// use Think\Controller;
class IndexController extends Auth {
    public function index(){
        $backData = array(
            "code"  =>200,
            "msg"   =>'success',
            'data'  =>""
        );
        $this->ajaxReturn($backData);
    }
}