<?php 
/*
 * 作业考试-题目管理
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-02-16 08:28:00
 */
namespace Admin\Controller;
use Admin\Common\Auth;
// use Think\Controller;
class TestsQuestionController extends Auth {

  public function index(){
    if(empty($_GET['testid'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $testId = I("get.testid");
    $testInfo = M("Test")->where(array('id'=>$testId))->find();
    $questionList = array();
    $tempQuestionList = M("TestQuestion")
    ->where(array("test_id"=>$testId))
    ->order("sort,id")
    ->select();
    if(count($tempQuestionList)) {
      foreach($tempQuestionList as $key=>$val) {
        $questionList[$key] = $val;
        $questionList[$key]['answer'] = unserialize($val['answer']);
      }
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "testInfo"      =>$testInfo,
        "questionList"  =>$questionList
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
    $info = M("TestQuestion")->where(array('id'=>$id))->fetchSql(false)->find();
    if($info) {
      $info['answer'] = unserialize($info['answer']);
      $info['correct'] = explode(",",$info['correct']);
      foreach($info['correct'] as $key=>$val) {
        $info['correct'][$key] = intval($val);
      }
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "data"      =>array(
          "info"  =>$info
        )
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
    $mainModel = M("TestQuestion");
    $saveData = $this->requestData;
    $testId = $saveData['test_id'];
    $saveData['correct'] = implode(",",$saveData['correct']);
    $saveData['answer'] = serialize($saveData['answer']);

    $createResult = $mainModel->create($saveData);
    if(!$createResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }
    $paraphrase = strip_tags($mainModel->paraphrase);
    if($paraphrase == '') {
      $mainModel->paraphrase = null;
    }
    // 过滤内容中的style标签
    $replacePattner = '/<(style.*?)>(.*?)<(\/style.*?)>/si';
    $mainModel->paraphrase = preg_replace($replacePattner,'',$mainModel->paraphrase);
    if(isset($mainModel->id)){
      $id = (int)$mainModel->id;
      $result = $mainModel->where(array("id"=>$id))->save();
    }else {
      //计算sort
      $total = M("TestQuestion")->where(array('test_id'=>$testId))->fetchSql(false)->count();
      $mainModel->sort = $total;
      $result = $mainModel->fetchSql(false)->fetchSql(false)->add();
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
  
  // 重新排序
  public function resort(){
    $requestData = json_decode($this->requestData['data'],true);
    
    $sql = 'UPDATE __TEST_QUESTION__ SET sort = CASE id';
    $questionId = array();
    foreach($requestData as $key=>$val){
      array_push($questionId,$val['questionid']);
      $sql .= ' WHEN '.$val["questionid"]. ' THEN '.$val['sort'];
    } 
    $sql .= ' END where id in ('.implode(",",$questionId).')';

    $updateResult = M("TestQuestion")->fetchSql(false)->execute($sql);
    if($updateResult !== false){
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
  
  
  public function delone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = I("get.id");
    $delQuestion = M("TestQuestion")->delete($id);
    if($delQuestion !== false) {
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