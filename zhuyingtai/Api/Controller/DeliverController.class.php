<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class DeliverController extends BaseController {
  /**
   * deliver log list
   * @condition
   * @page
   */
  public function mylog(){
    $page = I("get.p/d",1);
    $pageSize = 20;
    $condition = "DL.uid=".$this->uid;
    if(isset($_GET['stage'])) {
      $condition .= " and stage=".I("get.stage/d");
    }

    $total = M("DeliverLog")->alias("DL")->where($condition)->count();
    $list = M("DeliverLog")
    ->alias("DL")
    ->field("DL.id,DL.stage,date(DL.create_time) as date,JB.id as jobid,JB.name as jobname,JB.wages")
    ->join("__JOBS__ as JB on DL.job_id = JB.id")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();

    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "info"      => array(
        "list"  =>$list,
        "page"  =>$page,
        "total" =>$total,
        "hasMore" => $total - ($page*$pageSize) > 0
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * do deliver
   * @id
   */
  public function doit(){
    if(empty($_GET["jobid"]) || empty($_GET['type']) || empty($_GET['resumeid'])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }

    $model = M("DeliverLog");
    $insertData = array(
      "uid"       =>$this->uid,
      "job_id"    =>I("get.jobid/d"),
      "type"      =>I("get.type/d"),
      "resume_id" =>I("get.resumeid/d")
    );
    $insertResult = $model->data($insertData)->fetchSql(false)->add();
    if($insertResult){
      $backData = array(
        "code"      =>200,
        "msg"       =>"ok"
      );
    }else {
      $backData = array(
        "code"      =>13001,
        "msg"       =>"操作失败;ERR_CODE:13001"
      );
    }
    $this->ajaxReturn($backData);
  }


}