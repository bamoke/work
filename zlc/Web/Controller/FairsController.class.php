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
        $update = M()->execute('update __NEWS__ set click = click+1 where id='.$id);
        $info=M("News")
        ->alias("N")
        ->field("N.*,DATE(N.create_time) as time,(N.init_click + N.click) as click,C.title as catename")
        ->join("__CONTENT_CATE__ as C on C.id=N.cid")
        ->where("N.id=$id")
        ->find();
        $recommendList = M("News")->field("id,cid,thumb,title")->where("status=1 and recommend=1")->order("id desc")->limit(3)->select();
        $this->_mainassign($cid);
        $this->assign("info",$info);
        $this->assign("recommend",$recommendList);
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