<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class HomeworkController extends BaseController {

  /**
   * 获取在当前课程（班级）下的学员信息
   */
  protected function fetchMemberId($courseId){
    $memberId = null;
    $condition = array(
      "coourse_id"=>$courseId,
      "uid"   =>$this->uid
    );
    $courseMember = M("CourseMember")
    ->where($condition)
    ->find();
    return $courseMember;
  }
  /**
   * News list
   * @condition
   * @page
   */
  public function index(){
    if(empty($_GET["courseid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $courseId = I("get.courseid");
    $page = I("get.p/d",1);
    $pageSize = 20;
    $condition = array(
      "T.course_id"  =>$courseId,
      "T.type"      =>1,
      "T.status"    =>1
    );
    $total = M("Test")->alias("T")->where($condition)->count();
    $list = M("Test")
    ->alias("T")
    ->field("T.*")
    ->where($condition)
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
   * 检查是否已经完成过
   */
  public function checkcomplete(){
    if(empty($_GET["testid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $testId = I("get.testid");
    // 检查是否已完成
    $logsCondition = array(
      "test_id" =>$testId,
      "uid"       =>$this->uid
    );
    $isComplete = M("TestLogs")->where($logsCondition)->count();
    $backData = array(
      "code"  => 200,
      "msg"   => "ok",
      "data"  =>array("complete"=>$isComplete)
    );  
    $this->ajaxReturn($backData);
  }

  /**
   * Detail 作业详情
   * @testid
   */
  public function detail(){
    if(empty($_GET["testid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $testId = I("get.testid");
    
  // 检查是否已完成
    $logsCondition = array(
      "test_id" =>$testId,
      "uid"       =>$this->uid
    );
    $isComplete = M("TestLogs")->where($logsCondition)->count();
    if($isComplete) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "您已完成了本次作业"
      );  
      $this->ajaxReturn($backData);
    }

    $testCondition = array(
      "id" =>$testId
    );
    $testInfo = M("Test")->where($testCondition)->fetchSql(false)->find();

    $questionList = M("TestQuestion")
    ->where(array("test_id"=>$testId))
    ->fetchSql(false)
    ->select();

    if(count($questionList)) {
      foreach ($questionList as $key=>$val){
        $questionList[$key]['answer'] = unserialize($val['answer']);
      }
    }
    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "baseInfo"  =>$testInfo,
          "question"  =>$questionList
        )
    );
    $this->ajaxReturn($backData);
  }

    /**
   * 作业考试结果
   */
  public function result(){
    if(empty($_GET["testid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $testId = I("get.testid");
    $courseId = M("Test")->where(array("id"=>$testId))->getField("course_id");
    $page = I("get.p/d",1);
    $pageSize=10;
    $condition = array(
      "TL.test_id"  =>$testId
    );
    $total = M("TestLogs")->alias("TL")->where($condition)->count();

    $condition["CM.course_id"] = $courseId;
    $list = M("TestLogs")
    ->alias("TL")
    ->field("TL.*,CM.realname as membername")
    ->join("__COURSE_MEMBER__ as CM on TL.uid=CM.uid")
    ->where()
    ->where($condition)
    ->limit(10)
    ->order("score desc")
    ->select();
    
    $myRecod = M("TestLogs")->where(array('test_id'=>$testId,"uid"=>$this->uid))->find();

    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"      => array(
          "courseid"  =>$courseId,
          "myRecord" => $myRecod,
          "otherRecord"  =>$list
        )
    );
    $this->ajaxReturn($backData);
  }


  /**
   * 提交
   */
  public function submit(){
    if(!IS_POST) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    $testId = I("post.testid");
    $testInfo = M("Test")->field("course_id,title")->where(array("id"=>$testId))->find();
    $memberInfo = M("CourseMember")->field("id,realname")->where(array('course_id'=>$testInfo['course_id'],"uid"=>$this->uid))->find();
    $insertLogData = array(
      "test_id" =>$testId,
      "uid"     =>$this->uid,
      "score"   =>I("post.score"),
      "question_total"  =>I("post.total"),
      "error_total"     =>I("post.error"),
      "correct_total"   =>I("post.correct")
    );
    $insertDynamicData = array(
      "course_id"   =>$testInfo['course_id'],
      "member_id"   =>$memberInfo["id"],
      "content"     =>"完成了作业《".$testInfo['title']."》"
    );

    $model = M();
    $model->startTrans();
    $inserLog = M("TestLogs")->data($insertLogData)->add();
    $insertDynamic = M("CourseDynamic")->data($insertDynamicData)->fetchSql(false)->add();
    if(!$inserLog || !$insertDynamic) {
      $backData = array(
        "code"  => 13002,
        "msg"   => "保存错误"
      );  
      $model->rollback();
      $this->ajaxReturn($backData);     
    }

    $model->commit();
    $backData = array(
      "code"  => 200,
      "msg"   => "success"
    );  
    $this->ajaxReturn($backData);   
  }



/************************ */
}