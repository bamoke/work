<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-10 20:05:00 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 00:52:03
 */

namespace Admin\Controller;
use Admin\Common\Auth;
 class ClassesMemberController extends Auth {


  /**
   * 班级成员
   */
  public function vlist(){
    if(empty($_GET["courseid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $courseId = I("get.courseid");
    $page = I("get.p/d",1);
    $pageSize=20;
    $condition = array(
      "course_id"  =>$courseId
    );
    if(!empty($_GET['keywords'])){
      $condition["realname"] = array("like","%".I('get.keywords')."%");
    }
    $total = M("CourseMember")->where($condition)->count();
    $list = M("CourseMember")
    ->where($condition)
    ->page($page,$pageSize)
    ->select();
 
    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "list"  =>$list,
          "page"  =>$page,
          "total" =>$total,
          "pageSize"=>$pageSize,
          "hasMore" => $total >($page*$pageSize) 
        )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * handle add member
   */
  public function doadd(){
    if(!IS_POST) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    $memberModel = M("CourseMember");
    $postData = $this->requestData;
    $condition = array(
      "course_id" =>$postData['courseid'],
      "phone"     =>$postData['phone']
    );
    $isExist = $memberModel->where($condition)->fetchSql(false)->count();
    if($isExist) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "手机号已经被占用"
      );  
      $this->ajaxReturn($backData);       
    }
    $insertData = array(
      "course_id" =>$postData['courseid'],
      "realname"  =>$postData['realname'],
      "phone"     =>$postData['phone'],
      "type"      =>$postData['type']
    );
    $insertResult = $memberModel->data($insertData)->add();
    if(!$insertResult) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "数据保存错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $memberInfo = $memberModel->where(array("id"=>$insertResult))->find();
    $backData = array(
      "code"  => 200,
      "msg"   => "success",
      "data"  =>array(
        "info"  =>$memberInfo
      )
    );  
    $this->ajaxReturn($backData); 
  }

  /**
   * handle update
   */

  public function update(){
    if(!IS_POST) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    $postData = $this->requestData;
    $memberId = $postData['id'];
    $updateData = array(
      "realname"  =>$postData['realname'],
      "phone"  =>$postData['phone'],
      "type"      =>$postData['type']
    );
    $memberModel = M("CourseMember");
    $condition = array(
      "id"  =>$memberId
    );
    $updateResult = $memberModel->where($condition)->data($updateData)->fetchSql(false)->save();
    if($updateResult === false) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "数据保存错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $memberInfo = $memberModel->where($condition)->find();
    $backData = array(
      "code"  => 200,
      "msg"   => "success",
      "data"  =>array(
        "info"  =>$memberInfo
      )
    );  
    $this->ajaxReturn($backData); 
  }

  /**
   * delelte
   */
  public function delone(){
    if(empty($_GET['id'])) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $memberId = I("get.id");
    $delResult = M("CourseMember")->delete($memberId);
    if($delResult === false) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "删除失败"
      );  
      $this->ajaxReturn($backData);  
    }
    $backData = array(
      "code"  => 200,
      "msg"   => "success"
    );  
    $this->ajaxReturn($backData);  
  }





  //==============//
 }