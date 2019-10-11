<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class TalentController extends BaseController {
  /**
   * 人才卡
   * @condition
   * @page
   */
  public function index (){
    $condition = array(
      "uid" =>$this->uid
    );
    $info = M("TalentCard")
    ->field("id,realname,card_no,end_date,IF(end_date > CURDATE(),'0','1') as expired,verify_status")
    ->where($condition)
    ->fetchSql(false)
    ->find();
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "info"  =>$info
      )
    );
    $this->ajaxReturn($backData);
  }
  /**
   * detail
   */
  public function detail(){
    $uid = $this->uid;
    $imgBaseUrl = '';
    if(!empty($_GET["id"])) {
      $imgBaseUrl = C("OSS_BASE_URL");
      $talentId = I("get.id");
      $info = M("TalentCard")
      ->field("id,realname,phone,papers_type,papers_no,papers_img,verify_status")
      ->where("id=$talentId")
      ->fetchSql(false)
      ->find();
    }else {
      $info = M("Card")
      ->field("realname,phone")
      ->where("uid=$uid")
      ->fetchSql(false)
      ->find();
      
    }


    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "info"  =>$info,
        "imgbaseurl"=>$imgBaseUrl
      )
    );
    $this->ajaxReturn($backData);
  }



  /**
   * 申请
   */
  public function apply(){
    if(!IS_POST) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }

    $mainData = I("post.");
    $mainModel = M("TalentCard");
    if(isset($mainData['id'])) {
      $talentId = I("post.id");
      $mainData["verify_status"] = 1;
      $mainData["reason"] = "";
      $mainData["end_date"] = null;

      // 检测
      $talentInfo = $mainModel->where("id=$talentId")->find();
      if(($talentInfo["verify_status"] != 3 && $talentInfo["verify_status"] != 5) || strtotime($talentInfo["end_date"]) >= time()) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "数据不可修改"
        );  
        $this->ajaxReturn($backData);
      }
      // update
      $result = $mainModel->where("id=$talentId")->data($mainData)->save();
    }else {
      $mainData["uid"] = $this->uid;

      // check
      $talentCount = $mainModel->where(array("uid"=>$this->uid))->count();
      if($talentCount) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "已申请过了"
        );  
        $this->ajaxReturn($backData);
      }
      // insert
      $result = $mainModel->data($mainData)->fetchSql(false)->add();
    }
    if(!$result){
      $backData = array(
        "code"  => 13001,
        "msg"   => "数据保存错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $backData = array(
      "code"  => 200,
      "msg"   => "success"
    );  
    $this->ajaxReturn($backData); 

  }


  /**
   * result
   */
  public function result(){
    $uid = $this->uid;
    $imgBaseUrl = C("OSS_BASE_URL");
    $talentId = I("get.id");
    $info = M("TalentCard")
    ->field("id,verify_status,reason")
    ->where("uid=$uid")
    ->fetchSql(false)
    ->find();

    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "info"  =>$info
      )
    );
    $this->ajaxReturn($backData);
  }
  /***============== */
}