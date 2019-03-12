<?php
namespace Web\Controller;
use Web\Common\WebController;
use Web\Common\BasePage;
class ProjectController extends WebController {

    public function index($pid,$cid=null){
        //
        $cid = I("get.cid");
        $newsModel = D("Project");
        $listField = "id,cid,title,thumb,description,status,picture,location,year,class_name";
        $conditon = array(
            "cid" =>$cid
        );
        $count = $newsModel->where($conditon)->count();
        $Page = new \Think\Page($count,10);
        $Page->setConfig("next","Next");
        $Page->setConfig("prev","Prev");
        $show = $Page->show();
        $mainList = $newsModel
        ->field($listField)
        ->where($conditon)
        ->limit($Page->firstRow.",".$Page->listRows)
        ->order("id asc")
        ->select();

        $this->assign("data",$mainList);
        $this->assign("page",$show);
        $this->assign("btnStyle","btn-dark");
        $this->display();
    }
    
    public function detail($id){
        //cate


        $update = M()->execute('update __PROJECT__ set click = click+1 where id='.$id);
        $info=M("Project")
        ->where("id=$id")
        ->find();
        if($info['picture']){
            $info['picture_arr'] = explode(",",$info['picture']);
        }
        $this->assign("info",$info);
        $this->assign("siteKeywords",$info['title']);
        $this->assign("siteDescription",$info['description']);
        $this->assign("btnStyle","btn-dark");
        $this->display();
    }


}