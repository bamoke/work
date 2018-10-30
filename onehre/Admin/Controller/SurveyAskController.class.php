<?php 
/*
 * 调查问卷
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-21 23:42:10
 */
namespace Admin\Controller;
use Admin\Common\Auth;
// use Think\Controller;
class SurveyAskController extends Auth {
  public function index(){
    if(empty($_GET['sid'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $condition = array(
      "s_id"  =>I("get.sid")
    );
    $mainModel = M("SurveyQuestion");
    $list = array();
    $list = $mainModel
    ->where($where)
    ->order("sort,id desc")
    ->fetchSql(false)
    ->select();
    if(count($list)){
      foreach ($list as $key=>$val) {
        $list[$key]['opt'] = unserialize($val['opt']);
      }
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list
      )
    );
    $this->ajaxReturn($backData);
  }



  // 编辑
  public function edit(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("SurveyQuestion")->where(array('id'=>$id))->fetchSql(false)->find();
    if($info) {
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "info"      =>$info
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
    }
    $this->ajaxReturn($backData);
  }


  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("SurveyQuestion");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    $mainModel->opt = serialize($postData['opt']);
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
        "msg"       => "服务器错误",        
      );     
    }
    $this->ajaxReturn($backData);
  }
  
  
  public function delone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = I("get.id");
    $del = M("SurveyQuestion")->delete($id);
    if($del !== false) {
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






  //==================//
}