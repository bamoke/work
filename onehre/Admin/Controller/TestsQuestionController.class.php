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
  
  
  public function delone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = I("get.id");
    $del = M("Survey")->where(array("id"=>$id))->fetchSql(false)->save(array('is_deleted'=>1));
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