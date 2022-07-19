<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class ChoujiangController extends BaseController {



  /**
   * 抽奖活动详情
   */
  public function detail(){
    if(empty($_GET['id']) || $_GET["id"] == 'undefined') {
      $backData = array(
        "code" =>10001,
        "msg"  =>'非法请求',
      );
      return $this->ajaxReturn($backData);
    }
    $choujiangId = I("get.id");

    
    // 抽奖项目信息
    $thumbBase = C("OSS_BASE_URL")."/";
    $choujiangInfo = M("Choujiang")
    ->field("*,IF(background<>'',CONCAT('$thumbBase',background),'') as background")
    ->find($choujiangId);

    if($choujiangInfo["status"] == 0) {
      $choujiangInfo['stageError'] ="抽奖活动已下架";
    }

    if(strtotime($choujiangInfo["start_date"]) > time()) {
      $choujiangInfo['stageError'] ="抽奖活动还未开始";
    }

    if(strtotime($choujiangInfo["end_date"]) < time()) {

      $choujiangInfo['stageError'] ="抽奖活动已过期";
    }
    
    // 获取人才卡信息
    $talentCardInfo = $this->checkTalentInfo($this->uid,2);


    $awardConsition = array(
      "isdeleted" =>0,
      "cid"        =>$choujiangId
    );
    $awardInfo = M("ChoujiangAward")
    ->where($awardConsition)
    ->order("sort, id desc")
    ->select();

    // 检测是否已经参与过
    $existCondition = array(
      "uid"   =>$this->uid,
      "cj_id" =>$choujiangId
    );
    if($choujiangInfo['join_type'] == 2) {
      $existCondition["create_time"] =array("gt",date("Y-m-d",time()));
    }
    $isJoined = M("ChoujiangLog")->where($existCondition)->count();
    


    // 每人只可以获取一次奖品
    $hasPrizeResult = 1;
    if($isJoined == 0) {
      $hasPrizeCondition = array(
        "uid"   =>$this->uid,
        "cj_id" =>$choujiangId,
        "prize_flag"  =>1
      );
      $hasPrizeResult = M("ChoujiangLog")->where($hasPrizeCondition)->fetchSql(false)->count();
    }
    if($isJoined ==1 || $hasPrizeResult ==1) {
      $remainingTime = 0;
    }else {
      $remainingTime = 1;
    }
    $choujiangInfo["remainingTime"] = $remainingTime;


    // 获取中奖者名单
    $winCondition = array(
      "C.cj_id"     =>$choujiangId,
      "C.prize_flag"  =>1
    );
    $WinUser = M("ChoujiangLog")
    ->alias("C")
    ->field("C.id,C.award as award_name,T.realname as user_name")
    ->join("__TALENT_CARD__ as T on T.uid = C.uid")
    ->where($winCondition)
    ->order("id desc")
    ->limit(10)
    ->select();
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "choujiangInfo" =>$choujiangInfo,
        "awardInfo" =>$awardInfo,
        "winUser"   =>$WinUser,
        "talentInfo"    =>$talentCardInfo
      )
    );
    $this->ajaxReturn($backData);
  }

 

  /**
   * 点击抽奖
   */
  public function doaward(){
    if(empty($_GET['cid'])) {
      $backData = array(
        "code" =>10001,
        "msg"  =>'非法请求',
      );
      return $this->ajaxReturn($backData);
    }


    //
    $choujiangId = I("get.cid");

    // 检测是否有人才卡
    $talentCardInfo = $this->checkTalentInfo($this->uid);

    // 检测抽奖信息
    $choujiangInfo = M("Choujiang")->find($choujiangId);
    if($choujiangInfo["status"] == 0) {
      $backData = array(
        "code" =>13001,
        "msg"  =>'抽奖活动已下架',
      );
      return $this->ajaxReturn($backData);
    }

    if(strtotime($choujiangInfo["start_date"]) > time()) {
      $backData = array(
        "code" =>13001,
        "msg"  =>'抽奖活动还未开始',
      );
      return $this->ajaxReturn($backData);
    }

    if(strtotime($choujiangInfo["end_date"]) < time()) {
      $backData = array(
        "code" =>13001,
        "msg"  =>'抽奖活动已过期',
      );
      return $this->ajaxReturn($backData);
    }

    // 奖品信息列表
    $awardConsition = array(
      "isdeleted" =>0,
      "cid"       =>$choujiangId,
      "_string" =>'received_num < num or num <0'
    );
    $awardInfo = M("ChoujiangAward")
    ->where($awardConsition)
    ->order("sort, id desc")
    ->fetchSql(false)
    ->select();


    // 检测是否已经参与过
    $existCondition = array(
      "uid"   =>$this->uid,
      "cj_id" =>$choujiangId
    );
    if($choujiangInfo['join_type'] == 2) {
      $existCondition["create_time"] =array("gt",date("Y-m-d",time()));
    }
    $isJoined = M("ChoujiangLog")->where($existCondition)->count();
    if($isJoined) {
      $backData = array(
        "code" =>13001,
        "msg"  =>'您今天已经参与过了',
      );
      return $this->ajaxReturn($backData);
    }



    // 计算抽奖结果
    $awardRandomToal = array_column($awardInfo,'random_num');
    $gainAwardIndex = $this->get_rand($awardRandomToal);
    $gainAwardInfo = $awardInfo[$gainAwardIndex];


    // 抽中没有的剩余的奖品
    // if($gainAwardInfo['num'] > 1 && $gainAwardInfo['received_num'] >= $gainAwardInfo['num']) {

    // }
    

    // 写入抽奖log
    $logData = array(
      "uid"   =>$this->uid,
      "cj_id" =>$choujiangId,
      "award"  =>$gainAwardInfo['name'],
      "award_id"  =>$gainAwardInfo['id'],
      "prize_flag"  =>$gainAwardInfo['num'] < 0 ? false : true
    );

    $logModel = M("ChoujiangLog");
    $insertId = $logModel->data($logData)->add();
    if(!$insertId) {
      $backData = array(
        "code" =>13002,
        "msg"  =>'数据保存错误',
      );
      return $this->ajaxReturn($backData);
    }
    $myPrizeInfo = $logData;
    $myPrizeInfo["id"] = $insertId;

    // 更新奖品信息
    $updateAwardResult = M("ChoujiangAward")
    ->where(array("id"=>$myPrizeInfo["award_id"]))
    ->setInc("received_num");

    // 更新抽奖参与人次
    $updateChoujiangResult = M("Choujiang")
    ->where(array("id"=>$choujiangId))
    ->setInc("join_num");

    $backData = array(
      "code" =>200,
      "msg"  =>'success',
      "data"  =>array(
        "awardInfo" =>$myPrizeInfo
      )
    );
    return $this->ajaxReturn($backData);
  }


  /**
   *
   * 获取我的抽奖记录 
   */
  public function mylog(){
    if(empty($_GET['cid'])) {
      $backData = array(
        "code" =>10001,
        "msg"  =>'非法请求',
      );
      return $this->ajaxReturn($backData);
    }
    $choujiangId = I("get.cid");
    $condition = array(
      "cj_id" =>$choujiangId,
      "uid"   =>$this->uid
    );
    $list = M("ChoujiangLog")
    ->field("id,award_id,award as award_name,create_time as time")
    ->where($condition)
    ->order("id desc")
    ->limit(50)
    ->select();
    $backData = array(
      "code" =>200,
      "msg"  =>'success',
      "data"  =>array(
        "list"  =>$list
      )
    );
    return $this->ajaxReturn($backData);

  }

  /**
   * 我的奖品，现在的模式一个活动一人只可以抽到一个奖品
   */
  public function myaward(){
    if(empty($_GET['cid'])) {
      $backData = array(
        "code" =>10001,
        "msg"  =>'非法请求',
      );
      return $this->ajaxReturn($backData);
    }
    $choujiangId = I("get.cid");
    $condition = array(
      "L.cj_id" =>$choujiangId,
      "L.uid"   =>$this->uid
    );
    $info = M("ChoujiangLog")
    ->alias("L")
    ->where($condition)
    ->find();
    if($info) {
      $info["infoCompleted"] = $info["realname"] =='' ? 'false':'true';
    }
    $backData = array(
      "code" =>200,
      "msg"  =>'success',
      "data"  =>array(
        "info"  =>$info
      )
    );
    return $this->ajaxReturn($backData);
  }


  /***
   * 保存领奖信息
   */
  public function doform(){
    if(!IS_POST) {
      $backData = array(
        "code" =>10001,
        "msg"  =>'非法请求',
      );
      return $this->ajaxReturn($backData);
    }
    $model = M("ChoujiangLog");
    $createResult = $model->create();
    if(!$createResult) {
      $backData = array(
        "code" =>13001,
        "msg"  =>'非法数据',
      );
      return $this->ajaxReturn($backData);
    }
    $result = $model->save();
    if($result !== false) {
      $backData = array(
        "code" =>200,
        "msg"  =>'success',
      );
      return $this->ajaxReturn($backData);
    }
    $backData = array(
      "code" =>13001,
      "msg"  =>'数据保存失败',
    );
    return $this->ajaxReturn($backData);
  }


  /**
   * 
   */
  protected function checkTalentInfo($uid,$dataType=1){
      // 检测是否拥有人才卡

      $talentCondition = array(
        "uid" =>$uid
      );

      $talentInfo = M("TalentCard")
      ->field("id,end_date")
      ->where($talentCondition)
      ->fetchSql(false)
      ->find();

      $backData = $talentInfo;
      if(!$talentInfo) {
        $backData = array(
          "code" =>13001,
          "msg"  =>'您还不是人才卡用户',
        );
        
      }elseif(strtotime($talentInfo['end_date']) < time()) {
        $backData = array(
          "code" =>13001,
          "msg"  =>'您的人才卡已过期',
        );
      }


      // 输出不同
      if($dataType == 2) {
        return $backData;
      }else {
        if(isset($backData["code"])) {
          return $this->ajaxReturn($backData);
        }else {
          return $backData;
        }
      }
       
  }

  /**
   * 抽奖算法
   */
  protected function get_rand($proArr) {
    $result = '';
 
    //概率数组的总概率精度
    $proSum = array_sum($proArr);
 
    //概率数组循环
    foreach ($proArr as $key => $proCur) {
        $randNum = mt_rand(1, $proSum);
        if ($randNum <= $proCur) {
            $result = $key;
            break;
        } else {
            $proSum -= $proCur;
        }
    }
    unset ($proArr);
 
    return $result;
  }
 
  /***============== */
}