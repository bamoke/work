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
          "banner"  =>C("OSS_BASE_URL")."/images/banner1.png",
          "list"  =>$list,
          "page"  =>$page,
          "total" =>$total,
          "hasMore" => $total - ($page*$pageSize) > 0
        )
      );
      $this->ajaxReturn($backData);  
    }

    /**
     * 课程详情
     */
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
      $isMember = 0;//是否已经是班级成员
      if(!empty($_SERVER["HTTP_X_ACCESS_TOKEN"])){
        $Account = A("Account");
        $sessionInfo = $Account->getSessionInfo();
        $uid =$sessionInfo['uid'];
        if($uid) {
          $isEnroll = M("CourseEnroll")
          ->where(array("uid"=>$uid,"course_id"=>$courseId))
          ->fetchSql(false)
          ->count();

          $memberWhere = array(
            'uid'=>$uid,
            "phone"=>$sessionInfo['phone'],
            "_logic"=>"OR"
          );
          $memberWhere2 = array(
            "course_id" =>$courseId,
            "_complex" =>$memberWhere
          );
          $isMember = M("CourseMember")
          ->where($memberWhere2)
          ->fetchSql(false)
          ->count();
        }
      }
      $backData = array(
          "code"      =>200,
          "msg"       =>"ok",
          "data"    => array(
            "isEnroll"  =>$isEnroll,
            "isMember"  =>$isMember,
            "courseInfo"  =>$courseInfo,
            "teacherInfo" =>$teacherInfo
          )
      );
      $this->ajaxReturn($backData);
    }





    /********************** */
}