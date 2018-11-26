<?php 
/*
 * 作业考试
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-21 23:42:10
 */
namespace Admin\Controller;
use Admin\Common\Auth;
// use Think\Controller;
class TestsController extends Auth {
  public function vlist(){
    if(empty($_GET['courseid'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "参数错误"    
      );
      $this->ajaxReturn($backData); 
    }
    $courseId = I("get.courseid");
    $pageSize = 15;
    $mainModel = M("Test");
    $page = I("get.page/d",1);
    $where = array(
      "course_id"  =>$courseId
    );
    if(!empty($_GET['keywords'])) {
      $where['title'] = array('like','%'.I("get.keywords").'%');
    }

    $list = $mainModel
    ->field("id,title,date(create_time) as date,status,is_released")
    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();

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



  // 编辑基本信息
  public function edit(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("Survey")->where(array('id'=>$id))->fetchSql(false)->find();
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
    $mainModel = M("Survey");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    if(isset($mainModel->id)){
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
    $del = M("Survey")->where(array("id"=>$id))->fetchSql(false)->save(array('is_deleted'=>1));
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