<?php
namespace Web\Controller;
use Web\Common\Controller\BaseController;
class IndexController extends BaseController {

    public function index(){
        $workNews = M("News")
        ->field("id,cid,title,IF(LENGTH(description) <= 48,description,CONCAT(LEFT(description,48),'...')) as description")
        ->where("cid =8 and status = 1")
        ->order('recommend desc,id desc')
        ->limit(3)
        ->select();
        $policyNews = M("News")
        ->field("id,cid,title,IF(LENGTH(description) <= 48,description,CONCAT(LEFT(description,48),'...')) as description")
        ->where("cid =9 and status = 1")
        ->order('recommend desc,id desc')
        ->limit(3)
        ->select();
        $jobsCondition = array(
            "status"    =>1
        );
        $jobs = M("Jobs")
        ->field("id,title,link,company,end_date,IF(person_limit=0,'不限',person_limit) as person_limit,wage,DATE(create_time) as create_time")
        ->where($jobsCondition)
        ->limit(5)
        ->order("sort,id desc")
        ->select();
        $this->assign('worknews',$workNews);
        $this->assign('policynews',$policyNews);
        $this->assign('jobsList',$jobs);
        $this->display();
    }
    
    public function video ($id){
        $videoArr = array (
            "1"=>"http://eos-beijing-1.cmecloud.cn/tmp/vadio1.mp4",
            "2"=>"http://eos-beijing-1.cmecloud.cn/tmp/vadio2.mp4"
        );
        $this->assign('videoUrl',$videoArr[$id]);
        $this->display();
    }

    /***
     * 
     */
    public function about (){
        $staffHome = M("Single")->find();
        $this->display();
    }

    /***
     * 
     */

    public function contact (){

        $this->assign('curPage',"contact");
        $this->display();
    }



    /****============================== */
}