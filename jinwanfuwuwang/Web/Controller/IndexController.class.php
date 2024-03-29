<?php
namespace Web\Controller;
use Web\Common\Controller\BaseController;
class IndexController extends BaseController {

    public function index(){
        $workNews = M("News")
        ->field("id,cid,title,external_link,IF(LENGTH(description) <= 48,description,CONCAT(LEFT(description,48),'...')) as description,DATE(create_time) as date,origin")
        ->where("cid =8 and status = 1 and recommend=1")
        ->order('recommend desc,id desc')
        ->limit(3)
        ->select();

        $policyNews = M("News")
        ->field("id,cid,title,external_link,IF(LENGTH(description) <= 48,description,CONCAT(LEFT(description,48),'...')) as description,DATE(create_time) as date")
        ->where("cid =10 and status = 1 and recommend=1")
        ->order('recommend desc,id desc')
        ->limit(3)
        ->select();
        $jobsCondition = array(
            "status"    =>1
        );
        $jobs = M("Jobs")
        ->field("id,title,link,addr,type,company,end_date,IF(person_limit=0,'不限',person_limit) as person_limit,wage,DATE(create_time) as date")
        ->where($jobsCondition)
        ->limit(6)
        ->order("sort,id desc")
        ->select();

        $bannerWhere = array(
            "position_key"=>1,
            "status"    =>1
        );
        $banner = M("Banner")->field("id,url,img")->where($bannerWhere)->select();

        foreach($workNews as $key=>$val) {
            $url = U('News/detail',array('id'=>$val['id'],'cid'=>$val["cid"]));
            if($val['external_link'] != '') {
                $url = $val['external_link'];
            }
            $workNews[$key]["realurl"] = $url;
        }

        foreach($policyNews as $key=>$val) {
            $url = U('News/detail',array('id'=>$val['id'],'cid'=>$val["cid"]));
            if($val['external_link'] != '') {
                $url = $val['external_link'];
            }
            $policyNews[$key]["realurl"] = $url;
        }

        foreach($jobs as $key=>$val) {
            $url = U('Jobs/detail',array('id'=>$val['id']));
            if($val['link'] != '') {
                $url = $val['link'];
            }
            $jobs[$key]["realurl"] = $url;
        }


        $this->assign('worknews',$workNews);
        $this->assign('policynews',$policyNews);
        $this->assign('jobsList',$jobs);
        $this->assign('banner',$banner);
        $this->assign('pageName',"首页");
        $this->display();
    }
    
    public function video ($id){
        $videoArr = array (
            "1"=>"http://eos-beijing-1.cmecloud.cn/tmp/vadio1.mp4",
            "2"=>"http://eos-beijing-1.cmecloud.cn/tmp/vadio2.mp4"
        );
        $this->assign('videoUrl',$videoArr[$id]);
        $this->assign('pageName',"视频");
        $this->display();
    }

    /***
     * 
     */
    public function about (){
        $staffHome = M("Single")->find(3);
        $workSite = M("Single")->find(4);
        $this->assign('staffHome',$staffHome);
        $this->assign('workSite',$workSite);
        $this->assign('curPage',"about");
        $this->assign('pageName',"机构简介");
        $this->display();
    }

    /***
     * 
     */

    public function contact (){
        $ygzjInfo = M("Contact")->find(1);
        $gzzInfo = M("Contact")->find(2);

        $initiCoordinate = array('113.583446','22.276822');
        if($ygzjInfo["coordinate"]) {
            $ygzjCoordinate = explode(",",$ygzjInfo["coordinate"]);
            $ygzjInfo["lati"] = $ygzjCoordinate[0];
            $ygzjInfo["longi"] = $ygzjCoordinate[1];
        }else {
            $ygzjInfo["lati"] = $initiCoordinate[0];
            $ygzjInfo["longi"] = $initiCoordinate[1];
        }

        if($gzzInfo["coordinate"]) {
            $gzzCoordinate = explode(",",$gzzInfo["coordinate"]);
            $gzzInfo["lati"] = $gzzCoordinate[0];
            $gzzInfo["longi"] = $gzzCoordinate[1];
        }else {
            $gzzInfo["lati"] = $initiCoordinate[0];
            $gzzInfo["longi"] = $initiCoordinate[1];
        }
        $this->assign('ygzjInfo',$ygzjInfo);
        $this->assign('gzzInfo',$gzzInfo);
        $this->assign('curPage',"contact");
        $this->assign('pageName',"联系我们");
        $this->display();
    }



    /****============================== */
}