<?php
namespace En\Controller;
use En\Common\WebController;
use En\Common\BasePage;
class NewsController extends WebController {

    public function index($navid,$cid=null){
        $pid = I("get.navid");
        //cate
        $BasePage = new BasePage();
        $curCateInfo = $BasePage->index($pid,$cid);
        //
        $newsModel = D("News");
        $listField = "id,cid,title,thumb,description,DATE_FORMAT(create_time,'%m-%d') as date,(init_click + click) as click";
        $conditon = array(
            "cid" =>$curCateInfo['id'],
            "status"    =>1
        );
        $count = $newsModel->where($conditon)->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","Next");
        $Page->setConfig("prev","Previous");
        $show = $Page->show();
        $mainList = $newsModel
        ->field($listField)
        ->where($conditon)
        ->limit($Page->firstRow.",".$Page->listRows)
        ->order("recommend desc,id desc")
        ->select();

        $this->assign("data",$mainList);
        $this->assign("page",$show);
        $this->display();
    }
    public function detail($cid,$id){
        //cate
        $curPid = M("ContentCate")->where("id=$cid")->getField("pid");
        $BasePage = new BasePage();
        $curCateInfo = $BasePage->index($curPid,$cid);

        $update = M()->execute('update __NEWS__ set click = click+1 where id='.$id);
        $info=M("News")
        ->field("*,date(create_time) as date,(init_click + click) as click")
        ->where("id=$id")
        ->find();
        $this->assign("info",$info);
        $this->assign("siteKeywords",$info['title']);
        $this->assign("siteDescription",$info['description']);
        $this->assign("siteTitle",$info['title']);
        $this->display();
    }

    public function search(){
        $newsModel = D("News");
        $listField = "id,cid,title,thumb,description,DATE_FORMAT(create_time,'%m-%d') as time,(init_click + click) as click";
        $keyword = I("get.keyword");
        $where = "status=1 and title like '%".$keyword."%'";
        $count = $newsModel->where($where)->count();
        $Page = new \Think\Page($count,10);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();
        $mainList = $newsModel
        ->field($listField)
        ->where($where)
        ->limit($Page->firstRow.",".$Page->listRows)
        ->order("id desc")
        ->select();
        $this->assign("count",$count);
        $this->assign("mainlist",$mainList);
        $this->_mainassign(null);
        $this->assign("page",$show);
        $this->display();
    }
}