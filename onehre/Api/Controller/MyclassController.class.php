<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class MyclassController extends BaseController {


  /**
   * 
   * @condition
   * @page
   */
  public function index(){
    $sessionInfo = $this->sessionInfo;
    $page = I("get.p/d",1);
    $pageSize = 20;
    $condition = array(
      "CM.uid"     =>$this->uid,
      "CM.phone"   =>$sessionInfo['phone'],
      "_logic"  =>"OR"
    );
    $conditionMap = array(
      "_complex"  =>$condition,
      "CM.status"    =>1
    );
    $total = M("CourseMember")->alias("CM")->where($conditionMap)->count();

    $list = M("CourseMember")
    ->alias("CM")
    ->field("CM.*,CR.title as course_name")
    ->join("__COURSE__ as CR on CR.id=CM.course_id")
    ->where($conditionMap)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();


    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list,
        "page"  =>$page,
        "total" =>$total,
        "hasMore" => $total - ($page*$pageSize) > 0
      )
    );
    $this->ajaxReturn($backData);  
  }



  /**
   * Detail 我的班级详情
   * @courseid
   */
  public function detail(){
    if(empty($_GET["courseid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $sessionInfo = $this->sessionInfo;
    $courseId = I("get.courseid");
    // 检查是否是本班成员
    $memberInfo = M("CourseMember")->where(array('course_id'=>$courseId,'phone'=>$sessionInfo['phone']))->find();
    if(!$memberInfo) {
      $backData = array(
        "code"  => 14001,
        "msg"   => "不是本班成员"
      );  
      $this->ajaxReturn($backData);  
    }
    // 绑定用户ID
    if(!$memberInfo['uid']) {
      $updateMember = M("CourseMember")->where(array('id'=>$memberInfo['id']))->data(array('uid'=>$this->uid))->save();
    }
    // 更新签到
    if($memberInfo['is_signin']==0){
      $updateMember = M("CourseMember")->where(array('id'=>$memberInfo['id']))->data(array('is_signin'=>1))->fetchSql(false)->save();
    }
    $page = I("get.p/d",1);
    $pageSize=20;
    $dynamicCondition = array(
      "CD.course_id"  =>$courseId
    );
    $courseInfo = M("Course")->field("title")->where(array("id"=>$courseId))->find();
    $total = M("CourseDynamic")->alias("CD")->where($dynamicCondition)->count();
    $dynamicList = M("CourseDynamic")
    ->alias("CD")
    ->field("CD.*,CM.realname as membername")
    ->join("__COURSE_MEMBER__ as CM on CD.member_id= CM.id")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();
    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "title"=> $courseInfo['title'],
          "list"  =>$dynamicList,
          "page"  =>$page,
          "total" =>$total,
          "hasMore" => $total - ($page*$pageSize) > 0
        )
    );
    $this->ajaxReturn($backData);
  }

    /**
   * 班级动态获取
   */
  public function dynamic(){
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
    $total = M("CourseDynamic")->where($condition)->count();
    $list = M("CourseDynamic")
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
          "hasMore" => $total - ($page*$pageSize) > 0
        )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 班级成员
   */
  public function member(){
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
          "hasMore" => $total - ($page*$pageSize) > 0
        )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 笔记
   */
  public function notes(){
    if(empty($_GET["courseid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $courseId = I("get.courseid");
    $memberInfo = M("CourseMember")->where(array('uid'=>$this->uid))->find();
    $page = I("get.p/d",1);
    $pageSize=8;
    $condition = array(
      "course_id"   =>$courseId,
      "member_id"   =>$memberInfo['id']
    );
    $total = M("CourseNotes")->where($condition)->count();
    $list = M("CourseNotes")
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
          "hasMore" => $total - ($page*$pageSize) > 0
        )
    );
    $this->ajaxReturn($backData);
  }

  public function addnote(){
    if(!IS_POST){
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    $memberInfo = M("CourseMember")->where(array('uid'=>$this->uid))->find();
    $insertData = array(
      "course_id" =>I("post.courseid"),
      "member_id"       =>$memberInfo['id'],
      "content"   =>I("post.content")
    );
    $insertResult = M("CourseNotes")->data($insertData)->fetchSql(false)->add();

    if(!$insertResult) {
      $backData = array(
        "code"  => 13002,
        "msg"   => "保存失败"
      );  
      $this->ajaxReturn($backData); 
    }

    $info = M("CourseNotes")->where("id=$insertResult")->find();
    $backData = array(
      "code"  => 200,
      "msg"   => "ok",
      "data"  =>array(
        "info"  =>$info
      )
    );  
    $this->ajaxReturn($backData); 
  }

  /**
   * 点评
   */
  public function grade(){
    if(empty($_GET["courseid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $courseId = I("get.courseid");
    $memberInfo = M("CourseMember")->where(array('uid'=>$this->uid))->find();
    $courseCondition = array(
      "id"  =>$courseId
    );
    $courseInfo = M("Course")->field("title")->where($courseCondition)->find();
    $gradeCondition = array(
      "course_id" =>$courseId,
      "member_id"       =>$memberInfo['id']
    );
    $gradeInfo = M("CourseGrade")->where($gradeCondition)->find();
    $backData = array(
      "code"  => 200,
      "msg"   => "ok",
      "data"  =>array(
        "courseInfo"  =>$courseInfo,
        "gradeInfo"   =>$gradeInfo
      )
    );  
    $this->ajaxReturn($backData); 
  }

  public function savegrade(){
    if(!IS_POST){
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    $memberInfo = M("CourseMember")->where(array('uid'=>$this->uid))->find();
    $insertData = array(
      "course_id" =>I("post.courseid"),
      "member_id"       =>$memberInfo['id'],
      "grade"     =>I("post.grade/d"),
      "teacher_grade" =>I("post.teacher_grade/d"),
      "course_grade" =>I("post.course_grade/d"),
      "comment"   =>I("post.comment")
    );
    $insertResult = M("CourseGrade")->data($insertData)->fetchSql(false)->add();

    if(!$insertResult) {
      $backData = array(
        "code"  => 13002,
        "msg"   => "保存失败"
      );  
      $this->ajaxReturn($backData); 
    }

    $backData = array(
      "code"  => 200,
      "msg"   => "ok"
    );  
    $this->ajaxReturn($backData); 
  }


/************************ */
}