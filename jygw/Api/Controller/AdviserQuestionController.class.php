<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class AdviserQuestionController extends BaseController {


  /**
   * 我的提问
   */
  public function vlist(){
    $stage = I("get.type","all");

    $condition =array(
      "_string"=>"(Q.isopen = 1 AND Q.verify_status = 1) OR Q.questioner = ".$this->uid
    );
    if($stage != 'all'){
      $condition["Q.stage"] = $stage;
    }
    if(!empty($_GET["cateid"])) {
      $condition["Q.cate_id"] =I("get.cateid");
    }
    if(!empty($_GET['keywords'])) {
      $condition["Q.title"] =array("like","%".I("get.keywords")."%");
    }
    $mainModel = M("AdviserQuestion");
    $total = $mainModel->alias("Q")->where($condition)->count();
    $page = I("get.page/d",1);
    $pageSize = 15;
    $list = $mainModel
    ->field("Q.*,(select count(id) from x_adviser_answer where question_id= Q.id) as answer_num")
    ->alias("Q")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "list"  =>$list,
        "pageInfo" =>array(
          "total"   =>intval($total),
          "page"    =>$page,
          "pageSize"  =>$pageSize
        )
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 问题详情
   */
  public function detail(){
    if(empty($_GET['id']) || $_GET["id"] == 'undefined') {
      $backData = array(
        "code" =>10001,
        "msg"  =>'非法请求',
      );
      return $this->ajaxReturn($backData);
    }
    $questionId = I("get.id");
    // update view
    $updateView = M("AdviserQuestion")->where("id=$questionId")->setInc("view");

    $questionInfo =M("AdviserQuestion")->find($questionId);
    // update answer isread
    if($questionInfo["questioner"] ==  $this->uid) {
      $updateIsread = M("AdviserAnswer")
      ->where(array("question_id"=>$questionId))
      ->setField("is_read",1);
    }

    $answerWhere = array(
      "A.question_id" =>$questionId
    );
    $thumbBase = C("OSS_BASE_URL")."/";
    $answerList = M("AdviserAnswer")
    ->alias("A")
    ->field("A.*,U.realname as adviser_name,U.description as adviser_description,IF(U.avatar<>'',CONCAT('$thumbBase',U.avatar),CONCAT('$thumbBase','')) as adviser_avatar,
    IFNULL(LOG.satisfaction,0) as l_satisfaction,IFNULL(LOG.think,0) as l_think,IFNULL(LOG.dissatisfaction,0) as l_dissatisfaction
    ")
    ->join("__ADVISER_USER__ as U on U.id = A.respondent ")
    ->join("LEFT JOIN __ADVISER_OPERATION_LOG__ as LOG on A.id=LOG.answer_id and LOG.uid=$this->uid")
    ->where($answerWhere)
    ->fetchSql(false)
    ->select();
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "answerList"  =>$answerList,
        "questionInfo" =>$questionInfo
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 我的提问
   */
  public function myquestion(){
    $stage = I("get.type","all");
    $where = array(
      "Q.questioner"  =>$this->uid
    );
    if($stage != 'all'){
      $where["Q.stage"] = $stage;
    }
    $mainModel = M("AdviserQuestion");
    $total = $mainModel->alias("Q")->where($where)->count();
    $page = I("get.page/d",1);
    $pageSize = 15;
    $list = $mainModel
    ->field("Q.*,(select count(id) from x_adviser_answer where question_id= Q.id) as answer_num")
    ->alias("Q")
    ->where($where)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "list"  =>$list,
        "pageInfo" =>array(
          "total"   =>intval($total),
          "page"    =>$page,
          "pageSize"  =>$pageSize
        )
      )
    );
    $this->ajaxReturn($backData);

  }

  /**
   * 提交问题
   */
  public function doadd(){
    if(!IS_POST) {
      $backData = array(
        "code" =>10001,
        "msg"  =>'非法请求',
      );
      return $this->ajaxReturn($backData);
    }
    $mainModel = M("AdviserQuestion");
    $create = $mainModel->create($_POST);
    if(!$create) {
      $backData = array(
        "code" =>13001,
        "msg"  =>'数据错误',
      );
      return $this->ajaxReturn($backData);
    }
    $mainModel->questioner =  $this->uid;
    $result = $mainModel->add();
    if(!$result) {
      $backData = array(
        "code" =>13002,
        "msg"  =>'数据保存错误',
      );
      return $this->ajaxReturn($backData);
    }
    $backData = array(
      "code" =>200,
      "msg"  =>'success',
    );
    return $this->ajaxReturn($backData);
  }
 
  /***============== */
}