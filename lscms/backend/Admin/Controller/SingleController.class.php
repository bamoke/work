<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-12 12:38:00 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-08-13 00:21:33
 */
namespace Admin\Controller;
use Admin\Common\Auth;
 class SingleController extends Auth {

  public function company(){
    $info = M("Single")->find(1);
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "info"  =>$info
      )
    );
    $this->ajaxReturn($backData);
  }

  public function team(){
    $info = M("Single")->find(2);
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "info"  =>$info
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * save
   */
  public function update(){
    if(!IS_POST){
      $backData = array(
        'code'      => 13000,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    
    $mainModel = M("Single");
    $postData = $this->requestData;
    $data = array(
      "content" => ($postData["content"])
    );
    $id = (int)$postData["id"];
    $result = $mainModel->where(array("id"=>$id))->data($data)->save();

    if($result !== false){
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "服务器错误",        
      );     
    }
    $this->ajaxReturn($backData);

  }


  

 }

