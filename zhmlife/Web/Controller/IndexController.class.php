<?php
namespace Web\Controller;
use Web\Common\WebController;
class IndexController extends WebController {
    public function index(){
        $newsModel = D("News");
        $newsListField ="id,title,thumb,create_time,click";
        $bannerList = M("Banner")->where("position_key=0 and status=1")->order("sort,id desc")->limit(5)->select();
        // $recommendList = M("News")->field($newsListField)->where("status=1")->order("recommend desc,id desc")->limit(3)->select();
        $hotList = $newsModel->getHot();
        $this->assign("isIndex",1);
        $this->assign("banner",$bannerList);
        $this->assign("recommend",$recommendList);
        $this->assign("hot",$hotList);
        $this->display();
    }
    public function test(){
        var_dump("nim");
    }
}