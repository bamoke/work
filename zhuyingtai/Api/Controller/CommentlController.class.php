<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class CommentController extends BaseController {
    public function fetchdata($type){
      if(empty($_GET["type"])){
        $backData = array(
          "code"  => 10002,
          "msg"   => "访问参数错误"
        );  
        $this->ajaxReturn($backData); 
      }

      $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(

        )
      );
      $this->ajaxReturn($backData);  
    }

    // 课程预约
    public function save(){
      if(!IS_POST) {
        $backData = array(
          "code"  => 10001,
          "msg"   => "非法请求"
        );  
        $this->ajaxReturn($backData);  
      }
      $enrollModel = M("CourseEnroll");
      $condition = array(
        "course_id" =>I("post.course_id"),
        "phone"     =>I("post.phone")
      );
      $isExist = $enrollModel->where($condition)->find();
      if($isExist) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "手机号已经被使用"
        );  
        $this->ajaxReturn($backData);         
      }

      $result = $enrollModel->create($_POST);
      if(!$result){
        $backData = array(
          "code"  => 13002,
          "msg"   => "服务器错误"
        );  
        $this->ajaxReturn($backData);       
      }
      $enrollModel->uid = $this->uid;
      $insertResult = $enrollModel->add();
      if(!$insertResult) {
        $backData = array(
          "code"  => 13003,
          "msg"   => "保存数据出错"
        );  
        $this->ajaxReturn($backData);           
      }
      $backData = array(
        "code"  => 200,
        "msg"   => "success"
      );  
      $this->ajaxReturn($backData);   
    }


    /********************** */
}