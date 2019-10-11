<?php
namespace Api\Controller;
class HomeController extends BaseController {
    public function index(){
        $condition = array(
            "uid"   =>$this->uid
        );
        $info = M("Card")->field("id,realname,avatar,phone,partment,position,company")->where($condition)->find();
        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "cardInfo"      =>$info
            )
        );
        $this->ajaxReturn($backData);
    }

    public function feedback(){
        if(IS_POST){
            $insertData = array(
                "content"   =>I("post.content"),
                "contact"   =>I("post.contact"),
                "uid"       =>$this->uid
            );
            $insertResult = M("Feedback")->data($insertData)->add();
            if(!$insertResult) {
                $backData = array(
                    "code"  =>13001,
                    "msg"   =>"保存失败请稍后再试"
                );
                $this->ajaxReturn($backData);  
            }
            $backData = array(
                "code"  =>200,
                "msg"   =>"success"
            );
            $this->ajaxReturn($backData);  
        }
    }
}