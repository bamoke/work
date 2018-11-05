<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class CourseEnrollController extends BaseController {
    public function index(){
      if(empty($_GET["courseid"])){
        $backData = array(
          "code"  => 10002,
          "msg"   => "访问参数错误"
        );  
        $this->ajaxReturn($backData); 
      }
      $where = array(
        "id"=>I('get.courseid')
      );
      $courseInfo = M("Course")->field("id,title,status,enroll_deadline,enroll_num,person_num")->where($where)->fetchSql(false)->find();

      if($courseInfo['status'] == 0) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "课程已下架"
        );  
        $this->ajaxReturn($backData); 
      }
      if($courseInfo['status'] == 2) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "课程已结束"
        );  
        $this->ajaxReturn($backData); 
      }
      if($courseInfo['enroll_deadline'] && $courseInfo['enroll_deadline'] < time()) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "报名已截至"
        );  
        $this->ajaxReturn($backData); 
      }
      if($courseInfo['person_num'] <= $courseInfo['enroll_num']) {
        $backData = array(
          "code"  => 13002,
          "msg"   => "报名人数已满"
        );  
        $this->ajaxReturn($backData);
      }

      $accountInfo = $this->fetchAccount();
      $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "coursename"  =>$courseInfo['title'],
          "phone"  =>$accountInfo['phone']
        )
      );
      $this->ajaxReturn($backData);  
    }

    // 课程预约
    public function do_enroll(){
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