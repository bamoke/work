<?php
namespace Web\Controller;
use Web\Common\BasePage;
use Web\Common\WebController;
class SingleController extends WebController {
    public function index(){
                //cate

        $cid =I("get.cid");
        $info = M("Single")->where(array("cid"=>$cid))->find();
        $this->assign("info",$info);
        $tempName = "index";
        switch($cid){
            case 2:
            $tempName = "studio";
            break;
            case 4:
            $tempName = "careers";
            break;
            case 5:
            $tempName = "contact";
            break;
        }
        $this->display($tempName);
    }
    

}