<?php
namespace Api\Controller;
use Think\Controller;
class HeadhunterController extends Controller {

  public function index(){
    $mainModel = M("Headhunter");
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
    ->field("id,title,work_addr,date(create_time) as date,comname,edu,experience as exp,wages")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();

    if(count($list)){

    }
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
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
    $mainInfo = M("Headhunter")->where("id=$jobId")->fetchSql(false)->find();
    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"    => array(
          "info"  =>$mainInfo
        )
    );
    $this->ajaxReturn($backData);
  }


  public function contact(){
    $info = M("HeadhunterContact")->find(1);
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"    => array(
        "info"  =>$info
      )
    );
    $this->ajaxReturn($backData);
  }


    /********************** */
}