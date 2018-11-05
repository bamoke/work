<?php
/***
 * 调查问卷
 * 
 */
namespace Api\Controller;
use Think\Controller;
class SurveyController extends Controller {

  public function index(){
    $mainModel = M("Survey");
    $condition = array(
      "status"        =>1,
      "is_released"  =>1
    );
    if(!empty($_GET['courseid'])){
      $condition['course_id'] = I('get.courseid');
    }else {
      $condition['type'] = 1;
    }
    if(!empty($_GET['keywords'])){
      $condition['title'] = array("like","%".I("get.keywords")."%");
    }
    $page = I("get.p/d",1);
    $pageSize = 15;
    $total = $mainModel->where($condition)->count();

    $list = $mainModel
    ->field("id,title,date(create_time) as date")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->order("id desc")
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

  /***Detail */
  public function detail(){
    if(empty($_GET["id"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }


    $surveyId = I("get.id/d");
    $Account = A("Account");
    $uid =$Account->getMemberId();
    // 检查是否已经参与过
    $surveyLog = M("SurveyLogs")->where(array('id'=>$surveyId,'uid'=>$uid))->count();
    if($surveyLog) {
      $backData = array(
        "code"  => 14001,
        "msg"   => "已经参与过了"
      );  
      $this->ajaxReturn($backData);  
    }

    $surveyInfo = M("Survey")->field('id,title,description')->where("id=$surveyId")->fetchSql(false)->find();
    $questionList = M("SurveyQuestion")->where(array("s_id"=>$surveyId))->order('sort,id')->select();
    $questionIdArr = array();
    foreach ($questionList as $key=>$val) {
      $questionIdArr[] = $val['id'];
    }
    $answerCondition = array(
      "question_id" =>array("in",implode(',',$questionIdArr))
    );

    $allAnswerList = M("SurveyAnswer")->field("id,content,question_id")->where($answerCondition)->order("sort,id")->select();

    $question = array();
    foreach($questionList as $key=>$val){
      $newArr = array(
        "id"  =>$val["id"],
        "ask" =>$val['ask'],
        "type"=>$val["type"],
        "selected"=>''
      
      );
      $answerArr = array();
      foreach($allAnswerList as $k=>$v) {
        if($val['id'] == $v["question_id"]) {
          $answerArr[] = $v;
        }
      }
      $newArr['answer'] = $answerArr;
      $question[] = $newArr;
    }

    $backData = array(
        "code"      =>200,
        "msg"       =>"ok",
        "data"    => array(
          "baseInfo"    =>$surveyInfo,
          "question"    =>$question
        )
    );
    $this->ajaxReturn($backData);
  }


  /**
   * baocun
   */
    public function save(){
      $resultData = json_decode($_POST['data']);
      $surveyId = I("post.surveyid");
      $seletctAnswer = array();
      $fillQuestion = array();

      // 获取用户id
      $Account = A("Account");
      $uid =$Account->getMemberId();
      // 
      foreach($resultData as $key=>$val) {
        if($val->type != 3){
          // 单选或多选，content里包含就是已选择的answer id
          array_push($seletctAnswer,$val->content);
        }else {
          $fillQuestion[] = array(
            "survey_id"   => $surveyId,
            "question_id" =>$val->id,
            "uid"       =>$uid,
            "content"   =>$val->content,
          );
        }
      }
      $model = M();
      $model->startTrans();
      // 更新答案poll数值,(选择题)
      $answerCondition = array(
        "id"  =>array("in",implode(",",$seletctAnswer))
      );
      $answerData = array(
        "poll"  =>array('exp',"poll+1")
      );
      $updateAnswer = M("SurveyAnswer")->where($answerCondition)->data($answerData)->save();

      // insert selection question logs
      $insertSelectionData = array(
        "survey_id" =>$surveyId,
        "uid"       =>$uid,
        "content"    =>implode(",",$seletctAnswer)
      );
      $insertSelection = M("SurveyLogs")->data($insertSelectionData)->add();

      // insert fill question
      $insertFillData = M("SurveyFill")->addAll($fillQuestion);

      if($updateAnswer && $insertSelection && $insertFillData) {
        $backData = array(
          "code"      =>200,
          "msg"       =>"ok"
        );
        $model->commit();
        $this->ajaxReturn($backData);
      }else {
        $backData = array(
          "code"      =>1301,
          "msg"       =>"数据保存错误",
        );
        $model->rollback();
        $this->ajaxReturn($backData);
      }
    }




    /********************** */
}