<?php
namespace Web\Controller;
use Web\Common\WebController;
use Web\Common\BasePage;
class ArticleController extends WebController {

    public function index($pid,$cid=null){
        //
        $cid = I("get.cid");
        $newsModel = D("News");
        $listField = "id,cid,title,thumb,description,DATE_FORMAT(create_time,'%d/%m/%Y') as date,(init_click + click) as click";
        $conditon = array(
            "cid" =>$cid,
            "status"    =>1
        );
        $count = $newsModel->where($conditon)->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();
        $mainList = $newsModel
        ->field($listField)
        ->where($conditon)
        ->limit($Page->firstRow.",".$Page->listRows)
        ->order("recommend desc,id desc")
        ->select();

        $this->assign("data",$mainList);
        $this->assign("page",$show);
        $this->assign("btnStyle","btn-dark");
        $this->display();
    }
    
    public function detail($id){
        //cate


        $update = M()->execute('update __NEWS__ set click = click+1 where id='.$id);
        $info=M("News")
        ->field("*,date_format(create_time,'%Y/%m') as date,(init_click + click) as click")
        ->where("id=$id")
        ->find();
        $info['picture'] = explode(",",$info['picture']);
        $this->assign("info",$info);
        $this->assign("siteKeywords",$info['title']);
        $this->assign("siteDescription",$info['description']);
        $this->assign("siteTitle",$info['title']);
        $this->assign("btnStyle","btn-dark");
        $this->display();
    }


}