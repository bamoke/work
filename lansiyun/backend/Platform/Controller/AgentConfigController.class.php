<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 * 代理商账号管理
 */
namespace Platform\Controller;
use Platform\Common\Auth;
class AgentConfigController extends Auth {
  public function index(){
    if(empty($_GET['agentid'])) {
      $backData = array(
        'code'      => 10002,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("AgentConfig");
    $where = array(
      "agent_id" =>I("get.agentid")
    );

    $info = $mainModel
    ->field("id,agent_id,db_host,db_name,db_user,db_password,db_prefix,oss_id,oss_key,oss_endpoint,oss_bucket")
    ->where($where)
    ->find();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "info"  =>$info
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
    $mainModel = M("AgentConfig");

    $dataResult = $mainModel->create($requestData);
    if(!$dataResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }
    $mainModel->update_time = time();
    $mainModel->update_by = $this->userInfo['username'];
    if(isset($mainModel->id)){
      $id = (int)$mainModel->id;
      $result = $mainModel->where(array("id"=>$id))->fetchSql(false)->save();
    }else {
      $mainModel->create_by = $this->userInfo['username'];
      $result = $mainModel->fetchSql(false)->add();
      $id = $result;
    }

    if($result !== false){
      $info = $mainModel
      ->field("id,agent_id,db_host,db_name,db_user,db_password,db_prefix,oss_id,oss_key,oss_endpoint,oss_bucket")
      ->where(array("id"=>$id))
      ->find();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "data"      =>array(
          "info"      => $info
        )
      );
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "服务器错误",        
      );     
    }
    $this->ajaxReturn($backData);
  }








  //==================//
}