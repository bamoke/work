<?php
namespace En\Controller;
use En\Common\WebController;
use En\Common\BasePage;
class DownloadController extends WebController {

    public function index($navid,$cid=null){
        //cate
        $BasePage = new BasePage();
        $curCateInfo = $BasePage->index($navid,$cid);
        //
        $mainModel = D("Download");
        $listField = "*,date(create_time) as date";
        $conditon = array(
            "cid" =>$curCateInfo['id'],
            "status"    =>1
        );
        $count = $mainModel->where($conditon)->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","Next");
        $Page->setConfig("prev","Previous");
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



}