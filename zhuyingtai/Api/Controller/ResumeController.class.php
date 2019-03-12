<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-29 21:58:49 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-02-14 08:22:27
 */

 namespace Api\Controller;
 use Api\Common\Controller\BaseController;

 class ResumeController extends BaseController {
  public function index(){
    $eduArr = array("大专", "本科", "硕士", "博士", "其他");
    $condition = array(
      "uid" => $this->uid
    );
    $resumeInfo = M("Resume")->where($condition)->fetchSql(false)->find();
    $resumeInfo['update_time'] = date("Y-m-d h:i:s",$resumeInfo['last_update']);
    $resumeInfo['sex'] = $resumeInfo['sex']==1?"男":"女";
    $resumeInfo['edu'] = $eduArr[$resumeInfo['edu']];
    $backData = array(
      "code"    => 200,
      "msg"     => "ok",
      "data"    =>array(
        "info"    =>$resumeInfo
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * create resume
   */
  public function create(){
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
      $backData = array(
        "code"  => 200,
        "msg"   => "ok",
        "data"  =>array(
          "id"  => $insertResult
        )
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
    $resumeId = I("get.id/d");
    $base = M("Resume")
    ->field("id,realname,sex,birth,edu,school,major,phone,email,intend")
    ->where("id=$resumeId")->fetchSql(false)->find();

    $backData = array(
      "code"  => 200,
      "msg"   => "ok",
      "data"  => array(
        "info"  =>$base
      )
    );  
    $this->ajaxReturn($backData); 
  }

 /**
   * create resume
   */
  public function update(){
    if(empty($_GET['id'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "请求参数错误"
      );  
      $this->ajaxReturn($backData);      
    }
    $resumeId = I("get.id");
    $updateData = $_POST;
    $updateData['last_update'] = time();
    $model = M("Resume");
    $createResult = $model->create($updateData);
    if(!$createResult) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "非法数据"
      );  
      $this->ajaxReturn($backData); 
    }
    $result = $model->where("id=$resumeId")->fetchSql(false)->save();
    if($result !== false) {
      $backData = array(
        "code"  => 200,
        "msg"   => "ok"
      );
    }else {
      $backData = array(
        "code"  => 13001,
        "msg"   => "系统错误"
      );     
    }
    $this->ajaxReturn($backData);
  }



 }