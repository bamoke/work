<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class IndexController extends BaseController {
    public function index(){
        $condition = array(
            "uid"   =>$this->uid
        );
        $info = M("Card")->where($condition)->find();
        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>$info
        );
        $this->ajaxReturn($backData);
    }
}