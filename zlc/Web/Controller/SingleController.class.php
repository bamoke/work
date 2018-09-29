<?php
namespace Web\Controller;
use Web\Common\BasePage;
use Web\Common\WebController;
class SingleController extends WebController {
    public function index($pid,$cid=null){
                //cate
        $BasePage = new BasePage();
        $curCateInfo = $BasePage->index($pid,$cid);
        $info = M("Single")->where(array("cid"=>$curCateInfo['id']))->find();
        $this->assign("info",$info);
        $this->display();
    }
    
    public function country(){
        
        $this->display();
    }

}