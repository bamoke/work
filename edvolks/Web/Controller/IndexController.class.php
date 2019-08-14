<?php
namespace Web\Controller;
use Web\Common\WebController;
class IndexController extends WebController {
    public function index(){
        $newsInfo = M("News")
        ->field("id,title,DATE_FORMAT(create_time,'%Y/%m') as date")
        ->where(array('recommend'=>1))
        ->order("id desc")
        ->limit(1)
        ->select();
        $projectList = M("Project")
        ->field("id,title,category,location,year,banner")
        ->where(array('recommend'=>1))
        ->order("sort,id desc")
        ->limit(3)
        ->select();
        $bannerList = M("Banner")
        ->where(array("status"=>1,"position_key"=>0))
        ->order("sort,id desc")
        ->limit(1)
        ->select();
        $this->assign("projectList",$projectList);
        $this->assign("news",$newsInfo[0]);
        $this->assign("banner",$bannerList[0]);
        $this->assign("isIndex",1);
        $this->display();
    }

}