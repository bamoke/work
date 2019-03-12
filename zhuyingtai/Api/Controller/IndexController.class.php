<?php
namespace Api\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $page = I("get.p/d",1);
        $pageSize = 5;
        $list = M("Test")
        ->field("id,title,description,total")
        ->where(array("is_released"=>1))
        ->page($page,$pageSize)
        ->order("id desc")
        ->select();
        $banner = "/static/images/index-banner-02.jpg";
        // $banner = M("Banner")->where("status=1")->order("sort,id desc")->select();
        $backData = array(
            "code"      =>200,
            "msg"       =>"ok",
            "data"      =>array(
                "banner"    => $banner,
                "testList"=>$list,
            )
        );
        $this->ajaxReturn($backData);
    }
}