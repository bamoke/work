<?php
namespace En\Controller;
use En\Common\BasePage;
use En\Common\WebController;
class SingleController extends WebController {
    public function index($navid,$cid=null){
                //cate
        $BasePage = new BasePage();
        $curCateInfo = $BasePage->index($navid,$cid);
        $info = M("Single")->where(array("cid"=>$curCateInfo['id']))->find();
        $this->assign("info",$info);
        $this->display();
    }
    
    public function country(){
        
        $this->display();
    }

}