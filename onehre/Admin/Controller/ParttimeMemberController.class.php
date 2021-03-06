<?php 
/*
 * 兼职项目申请
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-15 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-15 23:42:10
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class ParttimeMemberController extends Auth {
  public function index(){
    if(empty($_GET["ptid"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $ptid = I("get.ptid");
    $condition = array(
      "pt_id" =>$ptid,
      "status"  =>1
    );
    $list = M("ParttimeMember")
    ->where($condition)
    ->order('type desc,id')
    ->limit(50)
    ->fetchSql(false)
    ->select();
    if($list !== false){
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "data"  =>array(
          "list"=>$list
          )    
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "系统错误"
      );
    }
    $this->ajaxReturn($backData);
  }

  // 添加 & 修改
  public function save(){
    if(!IS_POST) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("ParttimeMember");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    if(isset($mainModel->id) && !is_null($mainModel->id)){
      $id = (int)$mainModel->id;
      $result = $mainModel->where(array("id"=>$id))->save();
    }else {
      $result = $mainModel->fetchSql(false)->add();
      $id = $result;
    }
    if($result !== false){
      // $info = $mainModel->where(array("id"=>$id))->find();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "info"      => "success"
      );
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "操作失败",        
      );     
    }
    $this->ajaxReturn($backData);

  }

  // delete one member
  // 伪删除
  public function delone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id= I("get.id");
    $result = M("ParttimeMember")->where(array('id'=>$id))->data(array("status"=>0))->save();
    if($result !== false) {
      $backData = array(
        'code'      => 200,
        "msg"       => "ok"    
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "操作失败"    
      );
    }
    $this->ajaxReturn($backData);
  }


   /**
   * 设为管理员
   */
  public function set_manager(){
    if(empty($_GET['parttimeid']) || empty($_GET['id'])) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $parttimeId = I("get.parttimeid");
    $id = I("get.id");
    $curModel = M("ParttimeMember");
    $curModel->startTrans();
    $updateAll = $curModel->where(array("pt_id"=>$parttimeId))->data("type=1")->save();
    $updateOne = $curModel->where(array("id"=>$id))->data("type=2")->save();
    if($updateAll !== false && $updateOne !== false){
      $curModel->commit();
      $backData = array(
        "code"  =>200,
        "msg"   =>'success'
      );
    }else {
      $curModel->rollback();
      $backData = array(
        "code"  =>13001,
        "msg"   =>'操作失败'
      );
    }
    $this->ajaxReturn($backData);  
  }



  
  






  //==================//
}