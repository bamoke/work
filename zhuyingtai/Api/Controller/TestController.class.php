<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class TestController extends BaseController {
  /**
   * list
   */
    public function vlist(){
      $page = I("get.p/d",1);
      $pageSize = 20;
      $condition = array(
        "is_released"  =>1
      );
      if(isset($_GET['keywords']) && I("get.keywords") != '') {
        $condition['title'] = array("like","%".I('get.keywords')."%");
      }
      $total = M("Test")->where($condition)->count();
  
      $list = M("Test")
      ->field("id,title,description,total")
      ->where($condition)
      ->page($page,$pageSize)
      ->order("sort,id desc")
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

    /***
     * detail
     */
    public function detail(){
      if(empty($_GET["id"])){
        $backData = array(
          "code"  => 10002,
          "msg"   => "访问参数错误"
        );  
        $this->ajaxReturn($backData); 
      }
      $testId = I("get.id");
      

  
      $testCondition = array(
        "id" =>$testId
      );
      $testInfo = M("Test")->where($testCondition)->fetchSql(false)->find();
  
      $questionList = M("TestQuestion")
      ->where(array("test_id"=>$testId))
      ->fetchSql(false)
      ->order("sort,id")
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
            "testInfo"  =>$testInfo,
            "question"  =>$questionList
          )
      );
      $this->ajaxReturn($backData);
    }

    /**
     * submit
     */
    public function result(){
      $testId = I("post.testid");
      $result = json_decode($_POST['result'],true);
      $questionList = M("TestQuestion")->where(array("test_id"=>$testId))->select();
      $isPass = true;
      foreach($questionList as $key=>$val){
        if(!$isPass) break;
        $correct = explode(",",$val['correct']);
        foreach($result as $v){
          if($val['id'] == $v["questionid"]){
            if(!in_array($v['answerindex'],$correct)) {
              $isPass = false;
            }
            break;
          }
        }
      }
      // insert log and update count
      $model = M();
      $model->startTrans();
      $insertData = array(
        "test_id" =>$testId,
        "member_id" =>$this->uid,
        "result"    =>serialize($result)
      );
      $insertResult = M("TestLogs")->data($insertData)->add();
      $updateResult = M("Test")->where(array("id"=>$testId))->setInc("total");
      if($insertResult && $updateResult){
        $model->commit();
        $backData = array(
          "code"      =>200,
          "msg"       =>"ok",
          "data"      => array(
            "passStatus"  =>$isPass
          )
        );
      }else {
        $model->rollback();
        $backData = array(
          "code"      =>13001,
          "msg"       =>"系统错误"
        );
      }
      $this->ajaxReturn($backData);
    }


     /**
   * paraphrase
   */
  public function paraphrase(){
    if(empty($_GET["questionid"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $questionId = I("get.questionid");
    $questionInfo = M("TestQuestion")->field("ask,paraphrase")->where(array("id"=>$questionId))->find();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      "data"      =>array(
        "questionInfo"  =>$questionInfo
      )    
    );
    $this->ajaxReturn($backData);
  }

    /********************** */
}