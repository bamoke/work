<?php
namespace Wechat\Controller;
use Wechat\Common\WebController;
class IndexController extends WebController {
    public function index(){
        $newsModel = D("News");
        $newsListField ="N.id,N.title,N.cid,N.thumb,DATE_FORMAT(N.create_time,'%m-%d') as time,(N.init_click + N.click) as click,C.title as catename";
        $bannerList = M("Banner")->where("position_key=0 and status=1")->order("sort,id desc")->limit(5)->select();
        $recommendList = M("News")
        ->alias("N")
        ->field($newsListField)
        ->join("__CONTENT_CATE__ as C on C.id = N.cid")
        ->where("N.recommend=1 and N.status=1")
        ->limit(2)
        ->order("N.id desc")
        ->select();
        //main
        $mainList = M("News")
        ->alias("N")
        ->field($newsListField)
        ->join("__CONTENT_CATE__ as C on C.id = N.cid")
        ->where("N.status=1")
        ->limit(10)
        ->order("N.id desc")
        ->select();

        // $hotList = $newsModel->getHot();
        // $hotSearchList = $newsModel->getHotSearch();
        //advertisement
        $adModel = M("Advertisement");
        $adList = $adModel->where("status=1")->order("id desc")->select();
        $backData = array(
            "Code"  =>"10000",
            "info"  =>array(
                "recommend" =>$recommendList,
                "new"       =>$mainList,
                "ad"        =>$adList,
                "banner"    =>$bannerList,
                "nav"       =>$this->navList
            )
        );
        $this->ajaxReturn($backData);
    }
    public function test(){
        var_dump("nim");
    }
}