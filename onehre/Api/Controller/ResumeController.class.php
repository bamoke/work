<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-29 21:58:49 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-09-03 01:05:49
 */

 namespace Api\Controller;
 use Api\Common\Controller\BaseController;

 class ResumeController extends BaseController {
  public function index(){
    $condition = array(
      "uid" => $this->uid
    );
    $resumeInfo = M("Resume")->field("id,completion,attachment,default_set")->where($condition)->find();
    $backData = array(
      "code"    => 200,
      "msg"     => "ok",
      "info"    =>$resumeInfo
    );
    $this->ajaxReturn($backData);
  }

  /**
   * create resume
   */
  public function create_resume(){
    if(!IS_POST){
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    // $resumeId = M("Resume")->data($insertData)->add();
    $insertData = $_POST;
    $insertData['uid'] = $this->uid;
    $insertData['last_update'] = time();
    $model = M("Resume");
    $createResult = $model->create($insertData);
    if(!$createResult) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "非法数据"
      );  
      $this->ajaxReturn($backData); 
    }
    $insertResult = $model->fetchSql(false)->add();
    if($insertResult) {
      $insertData['id'] = $insertResult;
      $backData = array(
        "code"  => 200,
        "msg"   => "ok",
        "info"  => $insertData
      );
    }else {
      $backData = array(
        "code"  => 13001,
        "msg"   => "简历创建错误"
      );     
    }
    $this->ajaxReturn($backData);
  }
  /**
   * fetch resume detail
   */
  public function detail(){
    if(empty($_GET['id'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "请求参数错误"
      );  
      $this->ajaxReturn($backData);      
    }
    $resumeId = I("get.id");
    $condition = array(
      "rid"   =>$resumeId
    );
    $base = M("Resume")->field("id,realname,sex,birth,edu,experince,phone,email")->where("id=$resumeId")->find();
    $introduce = M("Resume")->where("id=$resumeId")->getField("introduce");
    $workExp = M("ResumeWork")->where($condition)->select();
    $edu = M("ResumeEdu")->where($condition)->select();
    // compute age
    $birthDateArr = date_parse($base['birth']);
    $nowDateArr = date_parse(date("Y-m"));
    $age = $nowDateArr['year'] - $birthDateArr['year'];
    if($nowDateArr['month'] - $birthDateArr['month'] < 0) {
      $age -= 1;
    }
    $base['age'] = $age;
    $backData = array(
      "code"  => 200,
      "msg"   => "ok",
      "info"  => array(
        "base"  =>$base,
        "work"   =>$workExp,
        "edu"   =>$edu,
        "introduce" =>$introduce
      )
    );  
    $this->ajaxReturn($backData); 
  }

  /**
   * fetch data
   */
  public function fetch_data ($type,$id) {
    switch ($type) {
      case 'base':
      $condition = array("id"=>$id);
      $result = M("Resume")->field("id,realname,sex,birth,edu,experince,phone,email")->where($condition)->find();
      break;
      case 'introduce':
      $condition = array("id"=>$id);
      $result = M("Resume")->field("id,introduce")->where($condition)->find();
      break; 
      case "edu":
      $condition = array("rid"=>$id);
      $result = M("ResumeEdu")->where($condition)->select();
      break;  
      case "work":
      $condition = array("rid"=>$id);
      $result = M("ResumeWork")->where($condition)->select();
      break;        
    }
    $backData = array(
      "code"    =>200,
      "msg"     => "ok",
      "info"    => $result
    );
    $this->ajaxReturn($backData);
  }

  /***
   * Add edu
   */
  public function add_edu(){
    $this->add_item("edu");
  }

  public function add_work(){
    $this->add_item("work");
  }
  protected function add_item($type){
    if(!IS_POST){
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    $modelName = "Resume".ucfirst($type);
    $model = M($modelName);
    $createResult = $model->create();
    if(!$createResult) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "非法数据"
      );  
      $this->ajaxReturn($backData);     
    }
    $insertResult = $model->add();
    if(!$insertResult) {
      $backData = array(
        "code"  => 13002,
        "msg"   => "数据更新错误"
      );  
      $this->ajaxReturn($backData);       
    }
    $backData = array(
      "code"  => 200,
      "msg"   => "ok"
    );  
    $this->ajaxReturn($backData);  
  }

  /**
   * delete item
   */
  public function delete_item(){
    if(empty($_GET['type']) || empty($_GET['id'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "请求参数错误"
      );  
      $this->ajaxReturn($backData);      
    }
    $type = I("get.type");
    $id = I("get.id/d");
    $condition = array("id"=>$id);
    switch ($type) {
      case "edu":
      $model = M("ResumeEdu");
      break;  
      case "work":
      $model = M("ResumeWork");
      break;        
    }
    $deleteResult = $model->delete($id);
    if($deleteResult !== false) {
      $backData = array(
        "code"  => 200,
        "msg"   => "ok"
      );  
    }else {
      $backData = array(
        "code"  => 13001,
        "msg"   => "删除失败;errorcode:13001"
      ); 
    }
    $this->ajaxReturn($backData); 
  }

  /***
   * Update 
   */
  public function save(){
    if(!IS_POST){
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    if(empty($_GET['type']) || empty($_GET['id'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "请求参数错误"
      );  
      $this->ajaxReturn($backData);      
    }

    $type = I("get.type");
    $id = I("get.id");
    $updateData = $_POST;
    $condition = array("id"=>$id);
    switch ($type) {
      case 'base':
      case "introduce":
      $updateModel = M("Resume");
      $resumeId = $id;
      break; 
      case "edu":
      $updateModel = M("ResumeEdu");
      $resumeId = I("post.rid");
      break;  
      case "work":
      $updateModel = M("ResumeWork");
      $resumeId = I("post.rid");
      break;        
    }
    $createResult = $updateModel->create();
    if(!$createResult) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "非法数据"
      );  
      $this->ajaxReturn($backData);     
    }

    $updateResult = $updateModel->where($condition)->save();
    $updateResume = M("Resume")->where("id=$resumeId")->data(array("last_update"=>time()))->save();
    if($updateResult === false){
      $backData = array(
        "code"  => 13002,
        "msg"   => "数据更新错误"
      );  
      $this->ajaxReturn($backData);        
    }
    $backData = array(
      "code"  => 200,
      "msg"   => "ok",
      "info"  =>$updateData
    );  
    $this->ajaxReturn($backData);     
  }



 }