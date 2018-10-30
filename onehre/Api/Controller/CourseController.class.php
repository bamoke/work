<?php
namespace Api\Controller;
use Think\Controller;
class CourseController extends Controller {
    public function detail(){
      if(empty($_GET["id"])){
        $backData = array(
          "code"  => 10002,
          "msg"   => "访问参数错误"
        );  
        $this->ajaxReturn($backData); 
      }

      $courseId = I("get.id/d");
      $courseInfo = M("Course")->where("id=$courseId")->fetchSql(false)->find();
      if($courseInfo['thumb']) {
        $courseInfo['thumb'] = C("OSS_BASE_URL") . "/thumb/" .$courseInfo['thumb'];
      }
      $teacherInfo = M("Teacher")->field("id,fullname as name,avatar,introduce")->where(array("id"=>$courseInfo['teacher_id']))->fetchSql(false)->find();
      $backData = array(
          "code"      =>200,
          "msg"       =>"ok",
          "data"    => array(
            "courseInfo"  =>$courseInfo,
            "teacherInfo" =>$teacherInfo
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
          "msg"   => "不能重复预约"
        );  
        $this->ajaxReturn($backData);         
      }

      $result = M("CourseEnroll")->create($_POST);
      if(!$result){
        $backData = array(
          "code"  => 13002,
          "msg"   => "服务器错误"
        );  
        $this->ajaxReturn($backData);       
      }
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