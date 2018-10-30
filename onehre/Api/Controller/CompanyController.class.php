<?php
namespace Api\Controller;
use Think\Controller;
class CompanyController extends Controller {
  /**
   * company list
   * @condition
   * @page
   */
  public function vlist(){

  }

  /**
   * Detail
   * @id
   */
  public function detail(){
    if(empty($_GET["id"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }

    $comId = I("get.id/d");
    $pageSize = 20;
    $page = 1;
    $comInfo = M("Company")->where("id=$comId")->fetchSql(false)->find();
    $jobCondition = array(
      "com_id"  => $comId
    );
    $jobTotal = M("Jobs")->where($jobCondition)->count();
    $jobList = M("Jobs")
    ->where($jobCondition)
    ->page($page,$pageSize)
    ->order("id desc")
    ->select();

    
    // Data transform
    $dataEduArr = C("DATA_EXP_NAME");
    $dataWagesArr = C("DATA_WAGE_NAME");
    $dataComsizeArr = C("DATA_COM_SIZE_NAME");

    if(count($jobList)){
      foreach($jobList as $k=>$v){
        if($v['tags']){
          $jobList[$k]["tags"] = explode(",",$v["tags"]);
        }
      }
    }


    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "jobInfo"    => array(
          "list"  =>$jobList,
          "total" =>$jobTotal,
          "page"  =>$page,
          "hasMore" => ($jobTotal > $page*$pageSize)
        ),
        "comInfo"     =>$comInfo,
    );
    $this->ajaxReturn($backData);
  }

  public function get_jobs($p=1){
    if(empty($_GET["comid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }

    $comId = I("get.comid/d");
    $page = (int)$p;
    $pageSize = 20;
    $jobCondition = array(
      "com_id"  => $comId
    );
    $jobTotal = M("Jobs")->where($comCondition)->count();
    $jobList = M("Jobs")
    ->where($comCondition)
    ->page($page,$pageSize)
    ->order("id desc")
    ->select();
    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "jobInfo"    => array(
          "list"  =>$jobList,
          "total" =>$jobTotal,
          "page"  =>$page,
          "hasMore" => ($jobTotal > $page*$pageSize)
        ),
        "fairsInfo"     =>$fairsInfo,
    );
    $this->ajaxReturn($backData);
  }
}