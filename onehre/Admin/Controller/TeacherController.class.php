<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-17 12:06:22 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-08-17 12:34:37
 */
namespace Admin\Controller;
use Admin\Common\Auth;
 class TeacherController extends Auth {

  public function vlist(){
    $pageSize = 15;
    $mainModel = M("Teacher");
    $page = empty($_GET["p"]) ? 1 : (int)$_GET["p"];
    $where = array();
    if(!empty($_GET['keywords'])){
      $searchKey = I("get.searchkey");
      $where[$searchKey] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel->alias("T")->field("T.*,(select count(*) from o_course where teacher_id=T.id) as course_num")->where($where)->page($page,$pageSize)->fetchSql(false)->select();
    $total = $mainModel->where($where)->count();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'info'      => array(
          "list"  =>$list,
          "total" =>intval($total),
          "pageSize"  =>$pageSize
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * save
   */
  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 13000,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("Teacher");
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
      $result = $mainModel->add();
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

  /**
   * fetch data one
   */
  public function getone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 13000,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = $_GET['id'];
    $model = M("Teacher");
    $info = $model->field("id,fullname,avatar,position,introduce,remarks,status")->where(array("id"=>$id))->find();
    if($info){
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "info"      => $info
      );
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "服务器错误",        
      );     
    }
    $this->ajaxReturn($backData);
  }

  /**
   * delete one data
   */
  public function deleteone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 13000,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = (int)$_GET["id"];
    $coursehasTotal = M("Course")->where(array("teacher_id"=>$id))->count();
    if($coursehasTotal > 0 ){
      $backData = array(
        'code'      => 13002,
        "msg"       => "该讲师名下还有课程，无法删除"    
      );
      $this->ajaxReturn($backData);          
    }

    $delete = M("Teacher")->delete($id);
    $backData = array(
      'code'      => 200,
      "msg"       => "ok"    
    );
    $this->ajaxReturn($backData);    
  }
  

 }

