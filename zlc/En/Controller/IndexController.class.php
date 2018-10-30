<?php
namespace En\Controller;
use En\Common\WebController;
class IndexController extends WebController {
    public function index(){
        layout(false);
        $newsModel = D("News");
        $bannerList = M("Banner")->where("position_key=0 and status=1")->order("sort,id desc")->limit(5)->select();

        // 贸促新闻
        $jmxxList = $newsModel
        ->field("id,cid,title,description,thumb,date(create_time) as date")
        ->where("cid=9 and status=1 and recommend=1")
        ->order("id desc")
        ->limit(4)
        ->select();

        //信息公开
        // $businessCate  = M("ContentCate")->field("id")->where(array("pid"=>2))->select();
        $businessCondition = array(
            "cid"       =>array("in","5,6,7"),
            "status"    =>1
        );
        $chinabusiness = $newsModel
        ->field("id,cid,title")
        ->where($businessCondition)
        ->order("recommend desc,id desc")
        ->limit(4)
        ->select();

        //头条
        $topStories = $newsModel
        ->field("id,cid,title as title,description,date(create_time) as date,thumb")
        ->where("cid=8 and status=1 and recommend=1")
        ->order("id desc")
        ->limit(2)
        ->select();



        // 展会信息
        $fairsList = M("fairs")->field("id,cid,title,place,times")->where("status=1 and recommend=1")->order("id desc")->limit(2)->select();

        //advertisement
        // var_dump(implode(",",$businessCate));
        $this->assign("isIndex",1);
        $this->assign("banner",$bannerList);
        $this->assign("topStories",$topStories);
        $this->assign("chinabusiness",$chinabusiness);
        $this->assign("xxgkList",$xxgkList);
        $this->assign("jmxxList",$jmxxList);
        $this->assign("fairsList",$fairsList);
        $this->display();
    }

    public function search($keyword){
        layout(false);
        $condition = "N.title like '%".$keyword."%'";
        $count = M("News")->alias("N")->where($condition)->count();
        $Page = new \Think\Page($count,5);
        $Page->setConfig("next","Next");
        $Page->setConfig("prev","Previous");
        $show = $Page->show();
        $result = M("News")
        ->alias("N")
        ->field("N.id,N.cid,N.title,N.thumb,N.description,DATE_FORMAT(N.create_time,'%m-%d') as date,(N.init_click + N.click) as click")
        ->where($condition)
        ->limit($Page->firstRow.",".$Page->listRows)
        ->order("id desc")
        ->fetchSql(false)
        ->select();
        $this->assign("data",$result);
        $this->assign("page",$show);
        $this->assign("count",$count);
        $this->display();
    }
    public function test(){
        var_dump("nim");
    }
}