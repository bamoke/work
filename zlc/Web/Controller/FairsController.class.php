<?php
namespace Web\Controller;
use Web\Common\WebController;
use Web\Common\BasePage;
class FairsController extends WebController {

    public function index($pid,$cid=null){
        //cate
        $BasePage = new BasePage();
        $curCateInfo = $BasePage->index($pid,$cid);
        //
        $mainModel = D("Fairs");
        $listField = "id,cid,title,times,place,thumb,description";
        $conditon = array(
            "cid" =>$curCateInfo['id'],
            "status"    =>1
        );
        $count = $mainModel->where($conditon)->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();
        $mainList = $mainModel
        ->field($listField)
        ->where($conditon)
        ->limit($Page->firstRow.",".$Page->listRows)
        ->order("id desc")
        ->select();

        $this->assign("data",$mainList);
        $this->assign("page",$show);
        $this->display();
    }
    public function detail($cid,$id){
        $pid= I("get.pid");
        //cate
        $BasePage = new BasePage();
        $curCateInfo = $BasePage->index($pid,$cid);

        $info=M("Fairs")
        ->where("id=$id")
        ->find();
        $this->assign("info",$info);
        $this->assign("siteKeywords",$info['title']);
        $this->assign("siteDescription",$info['description']);
        $this->assign("siteTitle",$info['title']);
        $this->display();
    }


}