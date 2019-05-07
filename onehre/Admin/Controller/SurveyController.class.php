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
class SurveyController extends Auth {
  public function vlist(){
    $pageSize = 15;
    $mainModel = M("Survey");
    $page = empty($_GET["p"]) ? 1 : (int)$_GET["p"];
    $where = array(
      "is_deleted"  =>0
    );
    if(!empty($_GET['keywords'])) {
      $where['title'] = array('like','%'.I("get.keywords").'%');
    }
    if(!empty($_GET['courseid'])) {
      $where['course_id'] = I("get.courseid");
    }else {
      $where['type'] = 1;
    }
    $list = $mainModel
    ->field("id,title,date(create_time) as date,status,is_released")
    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'info'      => array(
          "list"  =>$list,
          "total" =>intval($total),
          "pageSize"  =>$pageSize
      )
    );
    $this->ajaxReturn($backData);
  }



  // 编辑基本信息
  public function edit(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("Survey")->where(array('id'=>$id))->fetchSql(false)->find();
    if($info) {
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "info"      =>$info
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
    }
    $this->ajaxReturn($backData);
  }


  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("Survey");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    if(isset($mainModel->id)){
      $id = (int)$mainModel->id;
      $result = $mainModel->where(array("id"=>$id))->save();
    }else {
      $result = $mainModel->fetchSql(false)->add();
      $id = $result;
    }
    if($result !== false){
      // $info = $mainModel->where(array("id"=>$id))->find();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "info"      => "success"
      );
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "服务器错误",        
      );     
    }
    $this->ajaxReturn($backData);
  }
  
  
  public function deleteone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = I("get.id");
    $isReleased = M("Survey")->where(array("id"=>$id))->getField("is_released");

    if($isReleased) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "已经过发布的问卷不可删除"    
      );
      $this->ajaxReturn($backData);       
    }

    $model = M();
    $model->startTrans();
    // delete option must be in first step
    $delOptSql = "delete from __SURVEY_ANSWER__ where question_id in (select id from __SURVEY_QUESTION__ where s_id=$id)";
    $delOpt = M()->execute($delOptSql);
    $delSurvey = M("Survey")->delete($id);
    $delQuestion = M("SurveyQuestion")->where(array("s_id"=>$id))->delete();

    if($delSurvey !== false && $delQuestion !== false && $delOpt !== false) {
      $model->commit();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok"    
      );
    }else {
      $model->rollback();
      $backData = array(
        'code'      => 13001,
        "msg"       => "操作失败"    
      );
    }
    $this->ajaxReturn($backData);
  }

  /**
   * copy survey
   */
  public function docopy(){
    if(empty($_GET['surveyid'])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);        
    }
    $surveyId = I("get.surveyid/d");
    $courseId = NULL;
    if(!empty($_GET['courseid'])){
      $courseId = I("get.courseid");
    }

    // 获取survey 信息
    $surveyInfo = M("Survey")->field("title,description")->where(array("id"=>$surveyId))->find();
    // question list
    $questionList = M("SurveyQuestion")->field("id,type,ask")->where(array("s_id"=>$surveyId))->select();

    $model = M();
    $model->startTrans();
    // insert survey
    $insertSurveyData = array(
      "type"  => $courseId ? 2 : 1,
      "course_id" =>$courseId,
      "title" => $surveyInfo['title']."的拷贝",
      "description" =>$surveyInfo['description']
    );
    $inserSurveyId = M("Survey")->data($insertSurveyData)->add();
    if($inserSurveyId === false) {
      $model->rollback();
      $backData = array(
        'code'      => 13001,
        "msg"       => "服务器错误"    
      );
      $this->ajaxReturn($backData);   
    }
    // insert question
    $oldQuestionId = array();
    $insertQuestionResult = true;
    // 循环插入question and option
    foreach($questionList as $key=>$val){
      $questionTempData = array(
        "s_id"  =>$inserSurveyId,
        "type"  =>$val['type'],
        "ask"   =>$val['ask']
      );
      $optData = M("SurveyAnswer")->field("content")->where(array("question_id"=>$val['id']))->select();
      $insertQuestionId = M("SurveyQuestion")->add($questionTempData);
      if(!$insertQuestionId) {
        $insertQuestionResult = false;
        break;
      }
      foreach($optData as $k=>$v){
        $optData[$k]['question_id'] = $insertQuestionId;
      }
      $insertOptResult = M("SurveyAnswer")->addAll($optData);
/*       if($insertOptResult === false) {
        $insertQuestionResult = false;
        break;
      } */
    }
    if($inserSurveyId && $insertQuestionResult) {
      $model->commit();
      $surveyInfo = M("Survey")
      ->field("id,title,date(create_time) as date,status,is_released")
      ->where(array("id"=>$inserSurveyId))
      ->find();
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "data"      =>array(
          "surveyInfo"  =>$surveyInfo
        )    
      );
      $this->ajaxReturn($backData);   
    }else {
      $model->rollback();
      $backData = array(
        'code'      => 13001,
        "msg"       => "服务器错误"    
      );
      $this->ajaxReturn($backData);   
    }

  }





  //==================//
}