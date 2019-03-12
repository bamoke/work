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
        ->order("id desc")
        ->limit(3)
        ->select();
        $this->assign("projectList",$projectList);
        $this->assign("news",$newsInfo[0]);
        $this->assign("isIndex",1);
        $this->display();
    }

}