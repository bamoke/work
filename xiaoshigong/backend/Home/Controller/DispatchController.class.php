<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 * 企业管理
 */
namespace Home\Controller;

use Home\Common\Auth;

class DispatchController extends Auth {
  public function vlist(){
    $mainModel = M("Dispatch");
    $pageSize = 15;
    $page = I("get.page/d",1);
    $where = array();

    if(!empty($_GET['keyword'])){
      // $where['J.title'] = array("like","%".I("get.keyword")."%");
    }

    $list = $mainModel
    ->alias("D")
    ->field("D.*,W.name as worker_name,COM.name as comname,JOB.title as jobname")
    ->join("__WORKER__ as W on W.id= D.workerid")
    ->join("__COMPANY__ as COM on COM.id= D.comid")
    ->join("__JOB__ as JOB on JOB.id= D.jobid")
    ->where($where)
    ->page($page,$pageSize)
    ->order("id asc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->alias("D")->where($where)->count();
    $pageInfo = array(
      "page"  =>$page,
      "total" =>intval($total),
      "pageSize"  =>$pageSize
    );
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "pageInfo"  =>$pageInfo
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 
   */
  public function all_list(){
    $mainModel = M("Job");
    $where = array(
      "is_deleted" =>0
    );

    if(!empty($_GET['keyword'])){
      $where['name'] = array("like","%".I("get.keyword")."%");
    }

    $list = $mainModel
    ->field("id,name")
    ->where($where)
    ->limit('1000')
    ->order("id asc")
    ->fetchSql(false)
    ->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list
      )
    );
    $this->ajaxReturn($backData);
  }

  public function info($id){
    $model = M('Job');
    $result = $model
    ->alias("J")
    ->field("J.id,J.title,J.wage,J.description,J.status,J.comid,J.type,J.create_time,C.name as comname,CATE.name as typename")
    ->join("__COMPANY__ as C on C.id=J.comid")
    ->join("__CLASSIFICATION__ as CATE on CATE.id= J.type")
    ->where("J.id = $id")
    ->find();
    $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        'data'      => array(
            "info"  =>$result
        )
    );
    $this->ajaxReturn($backData);
}




  // 数据保存
  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $requestData = $this->requestData;
    $jobId = $requestData["jobid"];
    if($jobId == 'null') {
      $backData = array(
        'code'      => 10003,
        "msg"       => "参数错误"    
      );
      $this->ajaxReturn($backData);
    }

    // 检测企业和职位状态
    $jobInfo = M("Job")
    ->field("J.id,J.comid,J.status as job_status,J.is_deleted as job_deleted,C.status as com_status,C.is_deleted as com_deleted")
    ->alias("J")
    ->join("__COMPANY__ as C on C.id=J.comid")
    ->where("J.id = $jobId")
    ->fetchSql(false)
    ->find();

    if($jobInfo["job_status"] == 0 || $jobInfo["job_deleted"] == 1) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "职位已下架或删除"    
      );
      $this->ajaxReturn($backData);
    }

    if($jobInfo["com_status"] == 0 || $jobInfo["com_deleted"] == 1) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "企业已下架或删除"    
      );
      $this->ajaxReturn($backData);
    }

    // 检查劳工状态 

    $workerIds = $requestData["workerid"];
    $statusWhere = array(
      "dispatch_status" =>1,
      "status"  =>0,
      "_logic"  =>"or"
    );
    $workerWhere = array(
      "id"  =>array("in",$workerIds),
      "_complex" =>$statusWhere
    );
    $hasDispatch = M("Worker")
    ->where($workerWhere)
    ->count();
    if($hasDispatch) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "已选择劳工已删除或禁用"    
      );
      $this->ajaxReturn($backData);
    }
    

    $insertData = array();
    foreach($workerIds as $val) {
      $insertData[] = array(
        "workerid"  =>$val,
        "jobid" =>$jobInfo["id"],
        "comid" =>$jobInfo["comid"],
        "create_by" =>$this->uid
      );
    }
    
    $inserResult = M("Dispatch")
    ->addAll($insertData);

    if($inserResult === false) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "系统错误"    
      );
      $this->ajaxReturn($backData);
    }

    // update
    $updateWhere = array(
      "id"  =>array("in",$workerIds)
    );
    $update = M("Worker")->where($updateWhere)->setField("dispatch_status",1);
    $backData = array(
      'code'      => 200,
      "msg"       => "ok"
    );
    $this->ajaxReturn($backData);
  }








  //==================//
}