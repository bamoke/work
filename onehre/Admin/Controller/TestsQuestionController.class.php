<?php 
/*
 * 作业考试-题目管理
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-21 23:42:10
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
    if($testInfo['question']) {
      $list = M("TestQuestion")->where(array("id"=>array("in",$testInfo['question'])))->select();
    }
    if(count($list)) {
      foreach($list as $key=>$val) {
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

    if(isset($mainModel->id)){
      $id = (int)$mainModel->id;
      $result = $mainModel->where(array("id"=>$id))->save();
    }else {
      $model = M();
      $model->startTrans();
      $mainModel->test_id = null;
      $insertResult = $mainModel->fetchSql(false)->add();
      $id = $insertResult;
      $testCondition = array(
        "id"  =>$testId
      );
      $testInfo = M("Test")->field("question")->where($testCondition)->find();
      $testQuestion = explode(",",$testInfo['question']);
      array_push($testQuestion,$id);
      $updateResult = M("Test")->where($testCondition)->data(array('question'=>implode(",",$testQuestion)))->save();
      if($insertResult && $updateResult) {
        $model->commit();
        $result = true;
      }else {
        $model->rollback();
        $result = false;
      }
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
  
  
  public function delone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = I("get.id");
    $model = M();
    $model->startTrans();
    $questionInfo = M("TestQuestion")->where(array('id'=>$id))->find();
    $delQuestion = true;
    if($questionInfo['is_lib'] == 0) {
      $delQuestion = M("TestQuestion")->delete($id);
    }
    // test update
    $testCondition = array(
      "id"  =>$questionInfo['test_id']
    );
    $testInfo = M("Test")->where($testCondition)->find();
    $testQUestion = explode(",",$testInfo['question']);
    $index = array_search($id,$testQUestion);
    array_splice($testQUestion,$index,1);
    $updateTest = M("Test")->where($testCondition)->data(array('question'=>implode(",",$testQUestion)))->save();
    if($updateTest !== false && $delQuestion !== false) {
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
   * 题库
   */
  public function libquestion(){
    $page = I("get.page/d",1);
    $pageSize = 20;
    $condition = array(
      'is_lib'  =>1
    );
    if(!empty($_GET['keywords'])) {
      $condition['title'] = array('like',"%".I("get.keywords")."%");
    }
    if(!empty($_GET['hasid'])) {
      $condition['id'] = array('notin',I("get.hasid"));
    }
    $questionList = array();
    $total = M("TestQuestion")->where($condition)->fetchSql(false)->count();
    $list = M("TestQuestion")->where($condition)->page($page,$pageSize)->select();
    if(count($list)) {
      foreach($list as $key=>$val) {
        $questionList[$key] = $val;
        $questionList[$key]['answer'] = unserialize($val['answer']);
      }
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      "data"      =>array(
        "list"    =>$questionList,
        "total"   =>intval($total),
        "pageSize"  =>intval($pageSize),
        "page"      =>intval($page)
      )    
    );
    $this->ajaxReturn($backData);

  }






  //==================//
}