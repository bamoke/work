<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class ParttimeMyController extends BaseController {

  /**
   * 投递
   */
  public function deliver(){
    if(empty($_GET["jobid"]) || empty($_GET['resumeid'])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $mainModel = M("ParttimeApply");
    $insertData = array(
      "pt_id" =>I("get.jobid"),
      "uid"   =>$this->uid,
      "resume_id" =>I("get.resumeid")

    );

    //检测是否已经投递
    $condition =array(
      "pt_id" =>I("get.jobid"),
      "resume_id" =>I("get.resumeid")
    );
    $isExisted = $mainModel->where($condition)->count();
    if($isExisted > 0) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "已经投递过了"
      );  
      $this->ajaxReturn($backData);
    }

    $insertResult = $mainModel->data($insertData)->fetchSql(false)->add();
    // var_dump($insertResult);
    // exit();
    if(!$insertResult) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "数据保存错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok"
    );
    $this->ajaxReturn($backData);

  }


  /**
   * 兼职项目列表
   */
  public function myparttime(){

    $condition = array(
      "PM.uid" =>$this->uid,
      "PM.status" =>1
    );
    $page = I("get.p",1);
    $pageSize = 20;
    $total = M("ParttimeMember")->alias("PM")->where($condition)->fetchSql(false)->count();

    $list = M("ParttimeMember")
    ->alias("PM")
    ->field("PM.*,P.title,P.stage")
    ->join("__PARTTIME__ as P on PM.pt_id = P.id")
    ->where($condition)
    ->fetchSql(false)
    ->select();

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

  public function detail(){
    if(empty($_GET["id"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $parttimeId = I("get.id");

    // 检查是否是项目成员
    $memberCondition = array(
      "pt_id" =>$parttimeId,
      "uid"   =>$this->uid,
      "status"  =>1
    );
    $memberInfo = M("ParttimeMember")->where($memberCondition)->fetchSql(false)->find();
    if(!$memberInfo) {
      $backData = array(
        "code"  => 14002,
        "msg"   => "不是项目成员"
      );  
      $this->ajaxReturn($backData); 
    }

    $parttimeInfo = M("Parttime")->where("id=$parttimeId")->find();
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      =>array(
        "parttimeInfo"  =>$parttimeInfo,
        "memberInfo"    =>$memberInfo
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 获取当前项目的discuss
   */
  public function discuss(){
    if(empty($_GET["parttimeid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $parttimeId = I("get.parttimeid");
    $condition = array(
      "obj_id"  =>$parttimeId,
      "type"    =>2
    );
    $parttimeInfo = M("Parttime")->where("id=$parttimeId")->find();
    $discussList = M("Discuss")->where($condition)->limit(20)->select();
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      =>array(
        "discuss"  =>$discussList,
        "parttimeInfo"  =>$parttimeInfo
      )
    );
    $this->ajaxReturn($backData);

  }

  /**
   * 项目成员
   */
  public function member(){
    if(empty($_GET["parttimeid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $parttimeId = I("get.parttimeid");
    $page = I("get.p/d",1);
    $pageSize=20;
    $condition = array(
      "pt_id"  =>$parttimeId,
      "status"  =>1
    );
    if(!empty($_GET['keywords'])){
      $condition["realname"] = array("like","%".I('get.keywords')."%");
    }
    $total = M("ParttimeMember")->where($condition)->fetchSql(false)->count();

    $list = M("ParttimeMember")
    ->where($condition)
    ->page($page,$pageSize)
    ->select();
 
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

  /**
   * 项目进度
   */
  public function progress(){
    if(empty($_GET["parttimeid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $parttimeId = I("get.parttimeid");
    $parttimeInfo = M("Parttime")->field("id,status,stage,create_time")->where("id=$parttimeId")->find();
    $condition = array(
      "pt_id" =>$parttimeId
    );
    $progressList = M("ParttimeProgress")->where($condition)->order("sort")->select();
    $memberCondition = array(
      "uid" =>$this->uid,
      "pt_id" =>$parttimeId
    );
    $memberInfo = M("ParttimeMember")->where($memberCondition)->find();
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      =>array(
        "memberInfo"  =>$memberInfo,
        "progressInfo"  =>$progressList,
        "parttimeInfo"  =>$parttimeInfo
      )
    );
    $this->ajaxReturn($backData);
  }


  public function changeprogress(){
    if(empty($_GET["progressid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $progressId = I("get.progressid");
    $status = I("get.status");
    $update = M("ParttimeProgress")->where("id=$progressId")->data(array("status"=>$status))->save();
    if(!$update) {
      $backData = array(
        "code"  => 13002,
        "msg"   => "操作失败"
      );  
      $this->ajaxReturn($backData); 
    }
    $backData = array(
      "code"  => 200,
      "msg"   => "success"
    );  
    $this->ajaxReturn($backData); 
  }

  /**
   * 项目完成
   */
  public function docomplete(){
    if(empty($_GET['parttimeid'])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData);      
    }
    $parttimeId = I('get.parttimeid');
    $updateData = array(
      "stage" => 2,
      "complete_time" =>date("Y-m-d H:i:s",time())
    );
    $updateResult = M("Parttime")->where(array('id'=>$parttimeId))->data($updateData)->fetchSql(false)->save();
    if($updateResult === false){
      $backData = array(
        "code"  => 13002,
        "msg"   => "操作失败"
      );  
      $this->ajaxReturn($backData); 
    }
    $backData = array(
      "code"  => 200,
      "msg"   => "success"
    );  
    $this->ajaxReturn($backData); 
  }




    /********************** */
}