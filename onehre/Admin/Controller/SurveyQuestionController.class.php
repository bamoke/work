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
class SurveyQuestionController extends Auth {
  public function index(){
    if(empty($_GET['sid'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $questionCondition = array(
      "s_id"  =>I("get.sid")
    );
    $surveyId = I('get.sid');
    $surveyInfo = M("Survey")->where("id=$surveyId")->find();
    $questionList = array();
    $questionList = M("SurveyQuestion")
    ->where($questionCondition)
    ->order("sort,id")
    ->fetchSql(false)
    ->select();
    
    // 选取问题下的选择项
    if(count($questionList)){
      foreach($questionList as $key=>$val){
        $questionIdArr[] = $val['id']; 
      }
      $optionList = array();
      $questionIdStr = implode(",",$questionIdArr);
      $optionList = M("SurveyAnswer")->where(array('question_id'=>array('in',$questionIdStr)))->order("sort,id")->select();
      if(count($optionList)){
        $newQuestionList = array();
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
        "surveyInfo"  =>$surveyInfo,
        "list"  =>$questionList
      )
    );
    $this->ajaxReturn($backData);
  }



  // 编辑
  public function edit(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("SurveyQuestion")->where(array('id'=>$id))->fetchSql(false)->find();
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



  

  // 写入question
  public function insert(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $postData = $this->requestData;
    $acType = $postData['actype'];
    $mainData = $postData['data'];
    $questionConditon = array(
      "id"  =>$mainData['id']
    );
    $questionSaveData = array(
      "type"  =>$mainData['type'],
      "ask"   =>$mainData['ask'],
      "sort"  =>$mainData['sort']
    );
    $model = M();
    $model->startTrans();
    $questionUpdataResult = M('SurveyQuestion')->where($questionConditon)->save($questionSaveData);
    if($mainData['type'] == 3) {
      if($questionUpdataResult !== false) {
        $model->commit();
        $backData = array(
          'code'      => 200,
          "msg"       => "ok"    
        );
        $this->ajaxReturn($backData);
      }else {
        $model->rollback();
        $backData = array(
          'code'      => 13001,
          "msg"       => "数据保存失败"    
        );
        $this->ajaxReturn($backData);
      }
    }


    // 1.2修改option
    $optionData = $mainData['opt'];
    $optionModel = M("SurveyAnswer");
    $optionAllResult = true;
    if(count($optionData) > 0) {
      foreach($optionData as $key=>$val){
        $optionCondition = array(
          "id"  =>$val['id']
        );
        $optionSaveData = array(
          "content" =>$val['content'],
          "sort"    =>$val['sort']
        );
        $optionResult = $optionModel->where($optionCondition)->save($optionSaveData);
        if($optionResult === false) {
          $optionAllResult = true;
        }
      }
    }
    if($questionUpdataResult !== false && $optionAllResult) {
      $model->commit();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok"    
      );
      $this->ajaxReturn($backData);
    }else {
      $model->rollback();
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据保存失败"    
      );
      $this->ajaxReturn($backData);
    }
  }
  /**
   * update question and answer
   */
  public function update(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $postData = $this->requestData;
    $questionConditon = array(
      "id"  =>$postData['id']
    );
    $questionSaveData = array(
      "type"  =>$postData['type'],
      "ask"   =>$postData['ask'],
      "sort"  =>$postData['sort']
    );
    $model = M();
    $model->startTrans();
    $questionUpdataResult = M('SurveyQuestion')->where($questionConditon)->save($questionSaveData);

    // 若修改未填空查询该问题下是否有选择题，有则删除
    if($postData['type'] == 3) {
      $delResult = M("SurveyAnswer")->where(array('question_id'=>$postData['id']))->delete();
    }
    
    if($questionUpdataResult !== false && $delResult !== false) {
      $model->commit();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "data"      =>array(
          "info"    =>$postData
        )    
      );
      $this->ajaxReturn($backData);
    }else {
      $model->rollback();
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据保存失败"    
      );
      $this->ajaxReturn($backData);
    }
    
  }
  
  public function delone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = I("get.id");
    $del = M("SurveyQuestion")->delete($id);
    if($del !== false) {
      $backData = array(
        'code'      => 200,
        "msg"       => "ok"    
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "操作失败"    
      );
    }
    $this->ajaxReturn($backData);
  }






  //==================//
}