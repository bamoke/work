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

  public function vlist(){
    
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