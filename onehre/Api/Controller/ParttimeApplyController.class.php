<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class ParttimeApplyController extends BaseController {

  public function index(){
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





    /********************** */
}