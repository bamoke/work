<?php
namespace Api\Controller;
use Think\Controller;
class ParttimeController extends Controller {

  public function index(){
    $mainModel = M("Parttime");
    $condition = array(
      "status"  =>1
    );
    if(!empty($_GET['keywords'])){
      $condition['title'] = array("like","%".I("get.keywords")."%");
    }
    $page = I("get.p/d",1);
    $pageSize = 15;
    $total = $mainModel->where($condition)->count();

    $list = $mainModel
    ->field("id,title,work_addr,date(create_time) as date,person_num,work_day,wage,requirement,stage")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->order("id desc")
    ->select();

    if(count($list)){

    }
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "banner"  =>C("OSS_BASE_URL")."/images/banner-jz.jpg",
        "list"  =>$list,
        "page"  =>$page,
        "total" =>$total,
        "hasMore" => $total - ($page*$pageSize) > 0
      )
    );
    $this->ajaxReturn($backData);

  }

  /***Detail */
  public function detail(){
    if(empty($_GET["id"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }

    $jobId = I("get.id/d");
    $mainInfo = M("Parttime")->where("id=$jobId")->fetchSql(false)->find();
    $isMember = 0;
    $applyed = 0;
    if(!empty($_SERVER["HTTP_X_ACCESS_TOKEN"])){
      $Account = A("Account");
      $uid =$Account->getMemberId();
      $condition = array(
        "pt_id" =>$jobId,
        "uid" =>$uid
      );
      $isMember = M("ParttimeMember")->where($condition)->count();
      $applyed = M("ParttimeApply")->where($condition)->count();
    }
    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"    => array(
          "mainInfo"    =>$mainInfo,
          "isMember"=>$isMember,
          "applyed" =>$applyed
        )
    );
    $this->ajaxReturn($backData);
  }






    /********************** */
}