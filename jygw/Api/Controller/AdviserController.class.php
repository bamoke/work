<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class AdviserController extends BaseController {
  /**
   * 顾问服务
   * @condition
   * @page
   */
  public function index (){
    // 检测是否拥有人才卡

    $talentCondition = array(
      "uid" =>$this->uid
    );
    $hasTalent =true;
    $talentId = null;
    $talentInfo = M("TalentCard")
    ->field("id,end_date,verify_status")
    ->where($talentCondition)
    ->fetchSql(false)
    ->find();

    if(!$talentInfo) {
      $hasTalent = false;
    }else {
      $talentId = $talentInfo["id"];
    }
    if($talentInfo['verify_status'] != 6) {
      $hasTalent = false;
    }

    if(strtotime($talentInfo['end_date']) < time()) {
      $hasTalent = false;
    }

    $adviserCondition = array(
      "status"  =>1
    );
    $thumbBase = "https://www.bamoke.com/jygw/Uploads/images/thumb/";
    $list = M("Adviser")
    ->field("*,CONCAT('$thumbBase',thumb) as thumb")
    ->where($adviserCondition)
    ->order("sort,id")
    ->select();
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "list"  =>$list,
        "hasTalent" =>$hasTalent
      )
    );
    $this->ajaxReturn($backData);
  }
 
  /***============== */
}