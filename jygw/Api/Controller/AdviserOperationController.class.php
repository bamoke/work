<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class AdviserOperationController extends BaseController {
  /**
   * 对答案的操作
   * @condition
   * @page
   */
  public function dooperation (){
    if(empty($_GET['questionid']) || empty($_GET["answerid"])) {
      $backData = array(
        "code" =>10001,
        "msg"  =>'非法请求',
      );
      return $this->ajaxReturn($backData);
    }
    $questionId = I("get.questionid");
    $answerId = I("get.answerid");
    $operationType = I("get.checked");
    $transModel = M();
    $transModel->startTrans();

    //如果是满意且操作人是提问者本人，修改问题的状态为已解决
    $questioner = M("AdviserQuestion")->where("id=$questionId")->getField("questioner");
    if($operationType =='satisfaction' && $questioner== $this->uid) {
      $updateQuestion = M("AdviserQuestion")->where("id=$questionId")->fetchSql(false)->setField("stage",1);
    }

    $answerInfo = M("AdviserAnswer")->find($answerId);
    // 更新当前回答
    $updateAnswer = M("AdviserAnswer")
    ->where("id=$answerId")
    ->fetchSql(false)
    ->setInc($operationType."_num");


    // 更新顾问成员统计数据
    $updateAdviserUser = M("AdviserUser")
    ->where(array("id"=>$answerInfo["respondent"]))
    ->setInc($operationType."_num");

    // 写入操作日志,判断当前回答的操作记录是否存在
    $logWhere = array(
      "answer_id" =>$answerId,
      "uid"       =>$this->uid
    );
    $logId = M("AdviserOperationLog")
    ->where($logWhere)
    ->getField("id");
    
    $logData = array(
      "$operationType"  => 1,
      $operationType."_time"  =>date("Y-m-d H:i:s",time())
    );
    if($logId) {
      $logOperationResult = M("AdviserOperationLog")
      ->where("id=$logId")
      ->data($logData)
      ->fetchSql(false)
      ->save();
    }else {
      $logData["question_id"] = $questionId;
      $logData["answer_id"] = $answerId;
      $logData["uid"] = $this->uid;
      $logOperationResult = M("AdviserOperationLog")
      ->data($logData)
      ->fetchSql(false)
      ->add();
      // var_dump($logOperationResult);
      // exit();
    }
  
    if($updateAnswer !== false && $updateAdviserUser !== false && $logOperationResult !== false) {
      $transModel->commit();
      $backData = array(
        "code"  =>200,
        "msg"   =>'success'
      );
      $this->ajaxReturn($backData);
    }else {
      $transModel->rollback();
      $backData = array(
        "code"  =>13001,
        "msg"   =>'error'
      );
      $this->ajaxReturn($backData);
    }

  }

 
  /***============== */
}