<?php 
/*
 * 调查问卷
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-21 23:42:10
 */
namespace Admin\Controller;
use Admin\Common\Auth;
// use Think\Controller;
class SurveyLogController extends Auth {

  /**
   * 记录
   */
  public function vlist(){
    if(empty($_GET['sid'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $page = I("get.page/d",1);
    $pageSize = 20;
    $logsCondition = array(
      "survey_id" =>I("get.sid")
    );
    $total = M("SurveyLogs")->where($logsCondition)->count();
    $logsList = M("SurveyLogs")->where($logsCondition)->page($page,$pageSize)->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "list"    =>$logsList,
        "hasMore" =>$total > $page*$pageSize,
        "total"   =>$total,
        "page"    =>$page
      )    
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 记录详情
   */
  public function logdetail(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $logId = I("get.id");
    $logInfo = M("SurveyLogs")->where(array('id'=>$logId))->find();
    $surveyInfo = M("Survey")->field("title")->where(array("id"=>$logInfo['survey_id']))->find();
    $questionList = M("SurveyQuestion")->where(array('s_id'=>$logInfo['survey_id']))->select();
    $selectedList = M("SurveyAnswer")
    ->where(array("id"=>array('in',$logInfo["content"])))
    ->select();
    $mainList = array();

    foreach($questionList as $key=>$question) {
      $mainList[$key]['question'] = $question;
      $mainList[$key]['fill'] = array();
      $mainList[$key]['selected'] = array();
      if($question['type'] == 3) {
        $mainList[$key]['fill'] = M("SurveyFill")->where(array('question_id'=>$question['id']))->find();
      }else {
        foreach($selectedList as $k=>$opt) {
          if($opt['question_id'] == $question['id']) {
            $mainList[$key]['selected'][]=$opt;
          }
        }
      }
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "list"    =>$mainList,
        "surveyInfo"  =>$surveyInfo,
        "logInfo" =>$logInfo
      )   
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 统计信息
   */
  public function statistics(){
    if(empty($_GET['sid'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }

    $surveyId = I("get.sid");
/*     $logsInfo = M("SurveyLogs")->where(array('survey_id'=>$surveyId))->find();
    $selectedOptArr = explode(",",$logsInfo['content']); */

    $questionCondition = array(
      "s_id"  =>$surveyId
    );
    $questionList = M("SurveyQuestion")
    ->where($questionCondition)
    ->order("sort,id")
    ->fetchSql(false)
    ->select();
    
    // 选取问题下的选择项
    $newQuestionList = array();
    if(count($questionList)){
      foreach($questionList as $key=>$val){
        $questionIdArr[] = $val['id']; 
        if($val['type'] == 3) {
          $fillTotal = M('SurveyFill')->where(array('question_id'=>$val['id']))->count();
          $newQuestionList[$key]['fill']['hasMore'] = $fillTotal > 10;
          $newQuestionList[$key]['fill']['list'] = M('SurveyFill')->where(array('question_id'=>$val['id']))->page(1,10)->select();
        }
      }

      $optionList = array();
      $questionIdStr = implode(",",$questionIdArr);
      $optionList = M("SurveyAnswer")->where(array('question_id'=>array('in',$questionIdStr)))->order("sort,id")->select();
      if(count($optionList)){
        
        foreach($questionList as $key=>$val){
          $option = array();
          foreach($optionList as $k=>$v) {
            if($v['question_id'] == $val['id']){
              array_push($option,$v);
            }
          }
          $newQuestionList[$key]['opt'] = $option;
          $newQuestionList[$key]['question'] = $val;
        }
        $questionList = $newQuestionList;
      }
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$questionList
      )
    );
    $this->ajaxReturn($backData);
  }



  /**
   * 加载更多填空记录
   * @params number questionid
   * @params number page
   * @return array
   */
  public function loadmorefill(){
    if(empty($_GET['questionid']) || empty($_GET['page'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "参数错误",
      );
      $this->ajaxReturn($backData);
    }
    $page = I("get.page/d");
    $fillMode = M("SurveyFill");
    $fillCondition = array("question_id"=>$questionId);
    $fillTotal = $fillMode->where($fillCondition)->count();
    $fillList = $fillMode->where($fillCondition)->page($page,10)->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "参数错误",
      "data"      =>array(
        "list"  =>$fillList,
        "hasMore"=>$fillTotal > $page*10,
        "page"  =>$page
      )
    );
    $this->ajaxReturn($backData);

  }
 





  //==================//
}