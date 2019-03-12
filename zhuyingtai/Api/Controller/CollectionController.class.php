<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class CollectionController extends BaseController {
  /**
   * collection list
   * @condition
   * @page
   */
  public function vlist(){
    $page = I("get.p/d",1);
    $pageSize = 20;
    $condition = "CO.status=1 and CO.uid=".$this->uid;
    $total = M("Collection")->alias("CO")->where($condition)->count();
    $list = M("Collection")
    ->field("CO.id,date(CO.create_time) as create_time,JB.id as jobid,JB.name as jobname,JB.work_addr,JB.wages,JB.edu,COM.name as comname,COM.logo")
    ->alias("CO")
    ->join("__JOBS__ as JB on CO.job_id = JB.id")
    ->join("__COMPANY__ as COM on JB.com_id = COM.id")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();
    // var_dump($list);
    // return;
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
   * 收藏
   * @id
   */
  public function doit(){
    if(empty($_GET["jobid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }

    $jobId = I("get.jobid/d");
    $model = M("Collection");
    $array = array(
      "uid"     =>$this->uid,
      "job_id"  =>$jobId
    );
    $collectionInfo = $model->field("id,status")->where($array)->find();
    if($collectionInfo) {
      $updateData = array(
        "status"=> intval(!$collectionInfo['status'])
      );
      $result = $model->where(array("id"=>$collectionInfo['id']))->data($updateData)->save();
    }else {
      $result = $model->data($array)->add();
    }
    if($result){
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

  /**
   * 取消收藏
   */
  public function cancel(){
    if(empty($_GET["jobid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $jobId = I("get.jobid/d");
    $condition = array(
      "uid"     =>$this->uid,
      "job_id"  =>$jobId
    );
    $result = $model->where($condition)->data(array("status"=>0))->save();
  }

}