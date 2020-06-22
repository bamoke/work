<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class TalentController extends BaseController {
  /**
   * 人才卡
   * @condition
   * @page
   */
   protected $talentType = array(
     "1"  =>"产业类",
     "2"  =>"农技类",
     "3"  =>"党政类",
     "4"  =>"社工类",
     "5"  =>"教育类",
     "6"  =>"卫生类"
   ); 

  public function index (){
    $condition = array(
      "uid" =>$this->uid
    );
    // 先查申请表，如果产业类，通过api获取数据
    $info  = null;
    $applyInfo = M("TalentApply")
    ->where($condition)
    ->fetchSql(false)
    ->find();
    if($applyInfo["type"] == 1) {
      $idCard = $applyInfo["papers_no"];
      $cardInfo = $this->fetchTalentInfoApi($idCard);
      if($cardInfo["code"] != 0) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "接口数据读取错误"
        );  
        $this->ajaxReturn($backData); 
      }
      if($cardInfo["msg"] == "查无此人") {
        $backData = array(
          "code"  => 13009,
          "msg"   => "暂无数据"
        );  
        $this->ajaxReturn($backData); 
      }
      $info = $cardInfo["data"];
      $info["type"] = 1;
      $info["card_no"] = $info["seq"];
      $info["end_date"] = date_format(date_create($info["enddate"]),"Y-m-d");
    }else {
      if($applyInfo['verify_status'] == 6) {
        $info = M("TalentCard")
        ->field("*,IF(end_date < CURDATE(),1,0) as expired")
        ->where($condition)
        ->fetchSql(false)
        ->find();
      }else {
        $info = $applyInfo;
      }
    }


    if($info['type']) {
      $info['type_txt'] = $this->talentType[$info['type']];
    }



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
   * 申请资料detail
   */
  public function apply_detail(){
    $uid = $this->uid;
    $imgBaseUrl = C("OSS_BASE_URL");
    $condition = array(
      "uid" =>$uid
    );
    $info = M("TalentApply")
    ->where($condition)
    ->find();

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
    $mainData["type"] = $mainData["talent_type"];
    $mainModel = M("TalentApply");

    // 检测是否已经申请过
    $condition = array(
      "uid"   =>$this->uid
    );
    $applyInfo = $mainModel
    ->where($condition)
    ->find();

    if($applyInfo) {
      // 更新记录
      // 更新记录判断手机号和证件号是否存在
      $phoneExist = $mainModel->where(array("phone"=>$mainData['phone'],"uid"=>array('neq',$this->uid)))->count();
      $paperExist = $mainModel->where(array("papers_no"=>$mainData["papers_no"],"uid"=>array('neq',$this->uid)))->count();
      if($phoneExist) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "手机号已经被使用"
        );  
        $this->ajaxReturn($backData);
      }
      if($paperExist) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "证件号已经被使用"
        );  
        $this->ajaxReturn($backData);
      }
      // 状态判断，非产业类人才审核中不可修改数据
      if(($applyInfo["verify_status"] != 2 && $applyInfo["verify_status"] != 5 && $applyInfo["type"] != 1)) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "审核中数据不可修改"
        );  
        $this->ajaxReturn($backData);
      }
      $mainData["verify_status"] = 1;
      $mainData["reason"] = "";
      if($mainData["talent_type"] == 1) {
        $mainData["verify_status"] = 4;
      }
      $result = $mainModel->where(array("uid"=>$this->uid))->data($mainData)->save();

    }else {
      // 插入记录
      // 新记录判断手机号和证件号
      $phoneExist = $mainModel->where(array("phone"=>$mainData['phone']))->count();
      $paperExist = $mainModel->where(array("papers_no"=>$mainData["papers_no"]))->count();
      if($phoneExist) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "手机号已经被使用"
        );  
        $this->ajaxReturn($backData);
      }
      if($paperExist) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "证件号已经被使用"
        );  
        $this->ajaxReturn($backData);
      }
      if($mainData["talent_type"] == 1) {
        $mainData["verify_status"] = 4;
      }
      $mainData["uid"]  = $this->uid;
      $result = $mainModel->data($mainData)->fetchSql(false)->add();
    }


    if($result === false){
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
    $info = M("TalentApply")
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

  /**
   * 获取产业人才类接口
   * @idcard  身份证
   */
  protected function fetchTalentInfoApi($idcard) {
    $aipUrl = "http://183.6.120.226:13283/jwrs/appController/TalentCard.json";
    $curHttp = new \Org\Net\Http();
    $data = array(
      "idCard"  =>$idcard,
      "license" =>"mc-license"
    );
    $resp = $curHttp->sendHttpRequest($aipUrl,"post",$data);
    return json_decode($resp,true);
  }
  /***============== */
}