<?php
namespace Web\Controller;
use Web\Common\WebController;
class ArticleController extends WebController {
    public function index($cid){
        //cate
        $cateInfo = M("ContentCate")->where("status=1 and id = $cid")->find();

        //advertisement
        $adModel = M("Advertisement");
        $adList = $adModel->where("status=1")->order("id desc")->select();

        //banner
        $bannerList = M("Banner")->where("position_key=$cid and status=1")->order("sort,id desc")->limit(5)->select();

        //
        $newsModel = D("News");
        $listField = "id,cid,title,thumb,description,DATE_FORMAT(create_time,'%m-%d') as time,click";
        $count = $newsModel->where("cid=".$cid)->count();
        $Page = new \Think\Page($count,1);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();
        $mainList = $newsModel
        ->field($listField)
        ->where("status=1")
        ->limit(10)
        ->order("id desc")
        ->select();

        $hotList = $newsModel->getHot($cid);
        $hotSearchList = $newsModel->getHotSearch($cid);
        $this->assign("banner",$bannerList);
        $this->assign("hot",$hotList);
        $this->assign("hotsearch",$hotSearchList);
        $this->assign("mainlist",$mainList);
        $this->assign("adlist",$adList);
        $this->assign("cateinfo",$cateInfo);
        $this->assign("page",$show);
        $this->display();
    }
    public function detail($cid,$id){
        $this->assign("pageTitle","帶着媽媽去旅行！嚴選4間媽媽必冧性價比極高大阪住宿
        ");
        $this->display();
    }
}