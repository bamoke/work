<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-10 20:05:00 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 00:52:03
 */

namespace Admin\Controller;
use Admin\Common\Auth;
 class CourseController extends Auth {
    public function vlist(){
      $pageSize = 15;
      $mainModel = M("Course");
      $page = empty($_GET["p"]) ? 1 : (int)$_GET["p"];
      $where = array();
      if(!empty($_GET['keywords'])){
        $where['title'] = array("like","%".$_GET["keywords"]."%");
      }
      $list = $mainModel->field("id,type,title,status,create_time")->where($where)->page($page,$pageSize)->fetchSql(false)->select();
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

    // 讲师列表
    public function teacher(){
      $pageSize = 50;
      $mainModel = M("Teacher");
      $page = empty($_GET["p"]) ? 1 : (int)$_GET["p"];
      $where = array(
        "status"  =>1
      );

      $list = $mainModel
      ->field("id,fullname")
      ->where($where)
      ->page($page,$pageSize)
      ->fetchSql(false)
      ->select();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        'info'      => array(
            "list"  =>$list
        )
      );
      $this->ajaxReturn($backData);
  }

  public function edit(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 13000,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = $_GET['id'];
    $model = M("Course");
    $info = $model->where(array("id"=>$id))->find();
    if($info){
      $info['person_num'] = intval($info['person_num']);
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


  // 数据保存
  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 13000,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("Course");
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
        "msg"       => "服务器错误",        
      );     
    }
    $this->ajaxReturn($backData);
  }



  //==============//
 }