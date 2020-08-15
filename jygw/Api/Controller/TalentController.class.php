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

    $applyInfo = M("TalentApply")
    ->where($condition)
    ->fetchSql(false)
    ->find();

    if(!$applyInfo) {
      $backData = array(
        "code"  =>200,
        "msg"   =>'success',
        "data"  =>array(
          "info"  =>null
        )
      );
      $this->ajaxReturn($backData);
    }

    if($applyInfo['verify_status'] == 6) {
      $info = M("TalentCard")
      ->field("*,IF(end_date < CURDATE(),1,0) as expired")
      ->where($condition)
      ->fetchSql(false)
      ->find();
    }else {
      $info = $applyInfo;
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
    $talentType = I("post.talent_type");
    $idCard = I("post.papers_no");
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

    $transModel = M();
    $transModel->startTrans();
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
      if(($applyInfo["verify_status"] == 3 || $applyInfo["verify_status"] == 4 ) && $talentType != 1) {
        $backData = array(
          "code"  => 13001,
          "msg"   => "审核中数据不可修改"
        );  
        $this->ajaxReturn($backData);
      }
      $mainData["verify_status"] = 1;
      $mainData["reason"] = "";
      $result = $mainModel->where(array("uid"=>$this->uid))->data($mainData)->fetchSql(false)->save();

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
      $mainData["uid"]  = $this->uid;
      $result = $mainModel->data($mainData)->fetchSql(false)->add();
    }


    $hanleCardResult = true;
    $updateApplyResult = true;
    //  如果是产业人才调用接口查询结果
    $updateData = array();
    if($talentType == 1) {
      $cardInfo = $this->fetchTalentInfoApi($idCard);
      $updateData["verify_time"] = date("Y-m-d H:i:s",time());
      if($cardInfo["code"] == 0) {
        if($cardInfo["msg"] == "成功") {
          // 人才查询成功，保存到本地人才卡数据库
          $updateData["verify_status"] = 6;
          $updateData["reason"] = "";

          $oldCardInfo = M("TalentCard")->where(array("uid"=>$this->uid))->fetchSql(false)->find();

          $newCardData = array(
            "realname"  =>$cardInfo["data"]["name"],
            "type"      =>$talentType,
            "card_no"   =>$cardInfo["data"]["seq"],
            "start_date"  =>date_format(date_create($cardInfo["data"]["startdate"]),"Y-m-d"),
            "end_date"  =>date_format(date_create($cardInfo["data"]["enddate"]),"Y-m-d"),
            "level"     =>$cardInfo["data"]["level"],
            "score"     =>$cardInfo["data"]["score"],
            "update_time" =>date("Y-m-d H:i:s",time())
          );
          if($oldCardInfo) {
            $hanleCardResult = M("TalentCard")->where(array("uid"=>$this->uid))->fetchSql(false)->save($newCardData);
          }else {
            $newCardData["uid"] = $this->uid;
            $hanleCardResult = M("TalentCard")->data($newCardData)->add();
          }
        }else {
          $updateData["verify_status"] = 5;
          $updateData["reason"] = "人才系统反馈：".$cardInfo["msg"];
        }
      }else {
        $updateData["verify_status"] = 5;
        $updateData["reason"] = "人才系统内部错误";
      }
      $updateApplyResult = M("TalentApply")->where(array("uid"=>$this->uid))->data($updateData)->save();
    }


    if($result !== false && $hanleCardResult !== false && $updateApplyResult){
      $transModel->commit();
      $backData = array(
        "code"  => 200,
        "msg"   => "success"
      );  
      $this->ajaxReturn($backData);
    }else {
      $transModel->rollback();
      $backData = array(
        "code"  => 13001,
        "msg"   => "数据保存错误"
      );  
      $this->ajaxReturn($backData); 
    }
 

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
    $aipUrl = "http://183.57.22.41:8080/appController/TalentCard.json";
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