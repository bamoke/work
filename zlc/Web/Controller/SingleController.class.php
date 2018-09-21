<?php
namespace Web\Controller;
use Web\Common\WebController;
class SingleController extends WebController {
    public function index(){
        $pid = I("get.cid");
        $cateList = M("Single")->field("id,pid,title")->where("pid=".$pid." and status=1")->order("id")->select();
        if(!empty(I("get.id"))){
            $id = I("get.id");
        }else {
            $id = $cateList[0]['id'];
        }
        $info = M("Single")->where("id=$id")->find();
        $this->assign("info",$info);
        $this->assign("curId",$id);
        $this->assign("cateList",$cateList);
        $this->display();
    }

}