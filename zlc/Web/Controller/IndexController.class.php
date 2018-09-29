<?php
namespace Web\Controller;
use Web\Common\WebController;
class IndexController extends WebController {
    public function index(){
        layout(false);
        $newsModel = D("News");
        $bannerList = M("Banner")->where("position_key=0 and status=1")->order("sort,id desc")->limit(5)->select();

        // 贸促新闻
        $mcxwList = $newsModel
        ->field("id,cid,title,description,thumb,date(create_time) as date")
        ->where("cid=16 and status=1 and recommend=1")
        ->order("id desc")
        ->limit(1)
        ->select();

        //信息公开
        $xxgkList = $newsModel
        ->field("id,cid,title")
        ->where("cid=17 and status=1")
        ->order("recommend desc,id desc")
        ->limit(4)
        ->select();

        //经贸信息
        $jmxxList = $newsModel
        ->field("id,cid,title,description,date(create_time) as date,thumb")
        ->where("cid=19 and status=1")
        ->order("recommend desc,id desc")
        ->limit(4)
        ->select();

        // 经贸预警
        $jmyjList = $newsModel
        ->field("id,cid,title,date(create_time) as date")
        ->where("cid=23 and status=1")
        ->order("recommend desc,id desc")
        ->limit(4)
        ->select();

        // 展会信息
        $fairsList = M("fairs")->field("id,cid,title,place,times")->where("status=1 and recommend=1")->order("id desc")->limit(2)->select();

        // 商机
        $businessList = M("Business")
        ->alias("B")
        ->field("B.id,B.title,B.cid,date(FROM_UNIXTIME(B.create_time)) as date,C.title as catename")
        ->join("__CONTENT_CATE__ as C on C.id=B.cid")
        ->where("B.status=1")
        ->order("B.id desc")
        ->limit(5)
        ->select();
        //advertisement
        // var_dump($businessList);
        $this->assign("isIndex",1);
        $this->assign("banner",$bannerList);
        $this->assign("mcxwInfo",$mcxwList[0]);
        $this->assign("xxgkList",$xxgkList);
        $this->assign("jmxxList",$jmxxList);
        $this->assign("jmyjList",$jmyjList);
        $this->assign("fairsList",$fairsList);
        $this->assign("businessList",$businessList);
        $this->assign("businessTypeArr",array("1"=>"求购","2"=>"供应","3"=>"项目"));
        $this->display();
    }
    public function test(){
        var_dump("nim");
    }
}