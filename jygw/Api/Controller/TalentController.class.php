<?php
namespace Api\Controller;
use Think\Controller;
use Api\Common\Controller\BaseController;
class TalentController extends Controller {
  /**
   * 人才卡
   * @condition
   * @page
   */
   protected $talentType = array(
     "0"  =>"请选择",
     "1"  =>"产业类",
     "2"  =>"农技类",
     "3"  =>"党政类",
     "4"  =>"社工类",
     "5"  =>"教育类",
     "6"  =>"卫生类"
   ); 
   protected $talentTypeArr = array(
     array(
       "key"  =>0,
       "name"=>"请选择"
     ),
     array(
      "key"  =>1,
      "name"=>"产业类"
     ),
    array(
      "key"  =>5,
      "name"=>"教育类"
    ),
    array(
      "key"  =>6,
      "name"=>"卫生类"
    )
    
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

    $idCard = $applyInfo["papers_no"];
    if($applyInfo['verify_status'] == 6) {
      if($applyInfo['type'] == 1) {
        $cardInfo = $this->fetchTalentInfoApi($applyInfo['papers_no'],1);
        $updateWhere = array(
          "uid" =>$this->uid
        );
        if($cardInfo["data"]["level"]) {
          $newCardData = array(
            "card_no"   =>$cardInfo["data"]["seq"] ? $cardInfo["data"]["seq"] : $idCard,
            "start_date"  =>date_format(date_create($cardInfo["data"]["startdate"]),"Y-m-d"),
            "end_date"  =>date_format(date_create($cardInfo["data"]["enddate"]),"Y-m-d"),
            "level"     =>$cardInfo["data"]["level"],
            "score"     =>$cardInfo["data"]["score"],
            "update_time" =>date("Y-m-d H:i:s",time())
          );
          $updateResult = M("TalentCard")->where(array("uid"=>$this->uid))->fetchSql(false)->save($newCardData);
        }else {
          $backData = array(
            "code"  =>13001,
            "msg"   =>'暂无此人才信息',
            "data"  =>array(
              "info"  =>null,
            )
          );
          $this->ajaxReturn($backData);
        }


      }
      
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
        "info"  =>$info,
        "talentRights" =>array(
          "1.专属人才顾问服务，特聘业内专家为您解答问题;",
          "2.获得周边福利消费优惠,领取福利商家专属优惠券即可;",
          "3.其他不定期福利活动;"
        )
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
        "imgbaseurl"=>$imgBaseUrl,
        "talentType"  =>$this->talentTypeArr
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
    $idCard = trim(I("post.papers_no"));
    $mainData = I("post.");
    $mainData["type"] = $talentType;
    $mainData["papers_no"] = $idCard;
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
      // $phoneExist = 0; // 临时去掉手机验证
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
      $mainData["create_time"] = date("Y-m-d H:i:s");
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
    
    //  人才信息查询结果
    $updateData = array();

    $cardInfo = $this->fetchTalentInfoApi($idCard,$talentType);





    $updateData["verify_time"] = date("Y-m-d H:i:s",time());
    if($cardInfo["code"] == 200) {
      if($cardInfo["data"]) {
        // 人才查询成功，保存到本地人才卡数据库
        $updateData["verify_status"] = 6;
        $updateData["reason"] = "";

        $oldCardInfo = M("TalentCard")->where(array("uid"=>$this->uid))->fetchSql(false)->find();

        $newCardData = array(
          "realname"  =>$cardInfo["data"]["name"],
          "type"      =>$talentType,
          "card_no"   =>$cardInfo["data"]["seq"] ? $cardInfo["data"]["seq"] : $idCard,
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
        // 更新本地人才库
        if($talentType== 5 || $talentType== 6) {
          $poolWhere = array(
            "paper_no"  =>$idCard
          );
          
          $updatePool = M("TalentPool")->where($poolWhere)-> setField("is_gain",1);
        }
      }else {
        $updateData["verify_status"] = 5;
        $updateData["reason"] = "暂无人才卡数据";
      }
    }else {
      $updateData["verify_status"] = 5;
      $updateData["reason"] = "人才系统内部错误";
    }
    $updateApplyResult = M("TalentApply")->where(array("uid"=>$this->uid))->data($updateData)->save();

 


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

  public function mytest(){
    $idCard = I("get.idcard");
    $result = $this->fetchTalentInfoApi($idCard);
    var_dump($result);
  }

  /**
   * 获取产业人才类接口
   * @idcard  身份证
   */
  protected function fetchTalentInfoApi($idCard,$talentType=1) {
    if($talentType==1) {
      // $aipUrl = "http://183.57.22.41:8080/appController/TalentCard.json";
      $aipUrl = "https://jwqzdl.jinwan.gov.cn:4449/fczj-service/api/v1/talentCard/info.json";//生产
      // $year = idate("Y");

      //  年份参数为手动调整 2022-01-06 by wang
      $year = 2021;
      // $aipUrl = "http://183.57.22.46:9081/fczj-service/api/v1/talentCard/info.json";//测试
      $aipUrl .= "?cardNumber=".$idCard."&year=".$year;
      $curHttp = new \Org\Net\Http();
      $data = array(
        "cardNumber"  =>$idCard,
      );
 

      $GateWay = new \Api\Common\Controller\TalentGateWay();
      $gateWayHeader = $GateWay->getHeader();


      
      $resResult = $curHttp->sendHttpRequest($aipUrl,"post",$data,$gateWayHeader);


      // var_dump($resResult);
      // exit();

      $resp =  json_decode($resResult,true);
      if($resp['data']) {
        $resp['data']['startdate'] = date("Y-m-d",($resp['data']['startdate'] /1000));
        $resp['data']['enddate'] = date("Y-m-d",($resp['data']['enddate'] /1000));
      }
      return $resp;

    }else{
      $where = array(
        "paper_no"  =>$idCard
      );

      $info = M("TalentPool")->where($where)->fetchSql(false)->find();

      if($info !== false) {
        if($info){
          $backInfo =array(
            "code" => 200,
            "msg" =>"成功",
            "data"  =>array(
              "name"  =>$info['realname'],
              "seq"  =>$info['card_no'],
              "startdate"  =>$info['start_date'],
              "enddate"  =>$info['end_date'],
              "level"  =>$info['level'],
              "score"  =>$info['score'],
            )
          );
        }else {
          $backInfo =array(
            
            "code" => 200,
            "msg" =>"人才库没有您的资料"
          );
        }

      }else {
        $backInfo =array(
          "code"=>10002
        );
      }
      return $backInfo;
    }
  }
  /***============== */
}