<?php
/**
 * 我的名片模块
 */
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class MycardController extends BaseController {
  /**
   * create
   * @condition
   * @page
   */
  public function create(){
    if(!IS_POST) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法操作"
      );  
      $this->ajaxReturn($backData);     
    }
    $model = M("Card");
    // 1.1 check phone
    $phone = I("post.phone");
    $phoneExist = $model->where(array('phone'=>$phone))->count();
    if($phoneExist) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "手机号已经被使用"
      );  
      $this->ajaxReturn($backData);  
    } 
    // 1.2 create data
    $creatResult = $model->create();
    if(!$creatResult){
      $backData = array(
        "code"  => 13002,
        "msg"   => "数据错误"
      );  
      $this->ajaxReturn($backData);  
    }
    $insertResult = $model->add();
    if(!$insertResult) {
      $backData = array(
        "code"  => 13003,
        "msg"   => "保存失败请稍后再试"
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
   * update
   */
  public function update(){
    if(!IS_POST) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法操作"
      );  
      $this->ajaxReturn($backData);     
    }
    $model = M("Card");

    // 1.1 update data
    $creatResult = $model->create();
    if(!$creatResult){
      $backData = array(
        "code"  => 13002,
        "msg"   => "数据错误"
      );  
      $this->ajaxReturn($backData);  
    }
    $updateResult = $model->where(array('id'=>I('post.id')))->save();
    if($updateData !== false) {
      $backData = array(
        "code"  => 200,
        "msg"   => "success"
      );  
      $this->ajaxReturn($backData);  
    }else {
      $backData = array(
        "code"  => 13001,
        "msg"   => "保存失败请稍后再试"
      );  
      $this->ajaxReturn($backData);  
    }
  }

  /**
   * my card detail
   */
  public function detail(){
    $cardCondition = array(
      "uid" =>$this->uid
    );
    $cardInfo = M("Card")->where($cardCondition)->find();
    $backData = array(
      "code"  => 200,
      "msg"   => "success",
      "data"  =>$cardInfo
    );  
    $this->ajaxReturn($backData);  
  }



}