<?php
namespace Api\Controller;
use Think\Controller;
class CourseController extends Controller {
    public function index(){
      $page = I("get.p/d",1);
      $pageSize = 20;
      $condition = array(
        "status"  =>1
      );
      if(!empty($_GET['type'])) {
        $condition['type'] = I("get.type");
      }
      $total = M("Course")->where($condition)->count();
      $list = M("Course")->field("id,title,thumb,description,type")->where($condition)->page($page,$pageSize)->order("id desc")->select();
      if(count($list)){
          foreach($list as $k=>$v){
              if($v['thumb']){
                  $list[$k]['thumb'] = C("OSS_BASE_URL") ."/thumb/".$v['thumb'];
              }
          }
      }
  
      $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "banner"  =>"/common/images/banner1.png",
          "list"  =>$list,
          "page"  =>$page,
          "total" =>$total,
          "hasMore" => $total - ($page*$pageSize) > 0
        )
      );
      $this->ajaxReturn($backData);  
    }

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

      $isEnroll = 0;//是否已经有预约记录
      if(!empty($_SERVER["HTTP_X_ACCESS_TOKEN"])){
        $Account = A("Account");
        $uid =$Account->getMemberId();
        $isEnroll = M("Member")
        ->alias("M")
        ->join("__COURSE_ENROLL__ as C on C.phone = M.phone")
        ->where("M.id=$uid")
        ->fetchSql(true)
        ->count();
      }
      $backData = array(
          "code"      =>200,
          "msg"       =>"ok",
          "data"    => array(
            "isEnroll"  =>$isEnroll,
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