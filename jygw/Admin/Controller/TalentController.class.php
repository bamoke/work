<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class TalentController extends Auth {
  protected $talentType = array(
    "1" =>"产业类",
    "2" =>"农技类",
    "3" =>"党政类",
    "4" =>"社工类",
    "5" =>"教育类",
    "6" =>"卫生类",
  );

  protected $verifyName = array(
    "1" =>array(
      "name"  =>"待平台审核",
      "style" =>"default"
    ),
    "2" =>array(
      "name"  =>"平台审核未通过",
      "style" =>"error"
    ),
    "3" =>array(
      "name"  =>"平台审核通过",
      "style" =>"info"
    ),
    "4" =>array(
      "name"  =>"待政府审核",
      "style" =>"info"
    ),
    "5" =>array(
      "name"  =>"政府审核未通过",
      "style" =>"error"
    ),
    "6" =>array(
      "name"  =>"审核通过",
      "style" =>"success"
    )
  );


  /***
   * 申请记录
   */
  public function log(){
    $page = I("get.page/d",1);
    $pageSize = 15;
    $mainModel = M("TalentApply");
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['realname'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel

    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();


    foreach($list as $key=>$val){
      $list[$key]['typename'] = $this->talentType[$val['type']];
      $list[$key]['verifyname'] = $this->verifyName[$val['verify_status']];
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "pageInfo"  =>array(
            "total"   =>intval($total),
            "page"    =>$page,
            "pageSize"  =>$pageSize
          )
      )
    );
    $this->ajaxReturn($backData);
  }


    /***
   * 人才卡列表
   */
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 15;
    $mainModel = M("TalentCard");
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['realname'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel

    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();

    if(count($list)) {
      foreach($list as $key=>$val){
        $list[$key]["typename"] = $this->talentType[$val["type"]];
      }
    }


    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "pageInfo"  =>array(
            "total"   =>intval($total),
            "page"    =>$page,
            "pageSize"  =>$pageSize
          )
      )
    );
    $this->ajaxReturn($backData);
  }


  // 申请资料查看
  public function apply_detail(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("TalentApply")
    ->alias("T")
    ->field("T.*,IFNULL(A.realname,'人社人才系统') as verifyuser")
    ->join("LEFT JOIN __ADMIN__ A on A.id=T.verify_user")
    ->where(array('T.id'=>$id))
    ->find();
    if(!$info) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
      $this->ajaxReturn($backData);
    }
    $thumbList = explode(",",trim($info['papers_img'],","));
    $newThumbList = array();
    if(count($thumbList)) {
      foreach($thumbList as $key=>$val){
        if($val) {
          $newThumbList[] = C("OSS_BASE_URL")."/".$val;
        }
      }
    }
    //  计算赋值
    $info["papers_list"] = $newThumbList;
    $info["typename"] = $this->talentType[$info['type']];
    $info["verifyname"] = $this->verifyName[$info['verify_status']];
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "info"      =>$info
      )
    );
    $this->ajaxReturn($backData);
  }

  // 数据保存
  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("Event");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    // 过滤内容中的style标签
    $replacePattner = '/<(style.*?)>(.*?)<(\/style.*?)>/si';
    $mainModel->content = preg_replace($replacePattner,'',$mainModel->content);
    if(isset($mainModel->id) && !is_null($mainModel->id)){
      $id = intval($mainModel->id);
      $result = $mainModel->where(array("id"=>$id))->fetchSql(false)->save();
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


  /**
   * 人才卡申请审核
   */
  public function verify(){

    $requestData = $this->requestData;
    if(empty($requestData['id'])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"
      );  
      return $this->ajaxReturn($backData);  
    }

    if(($requestData['status']==2 || $requestData['status'] ==5) && empty($requestData['reason'])) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "请填写未通过原因"
      );  
      return $this->ajaxReturn($backData); 
    }
    $transModel = M();
    $transModel->startTrans();

    $updateData = array(
      "verify_time" =>date("Y-m-d H:i:s",time()),
      "verify_user" =>$this->uid,
      "verify_status" =>$requestData['status'],
      "reason"      =>$requestData["reason"]
    );

    if($requestData['status'] == 3) {
      $updateData['verify_status']  =4;
    }
    if($requestData['status']== 3 || $requestData['status']== 6 ) {
      $updateData['reason']  = '';
    }


    $applyWhere = array(
      "id"  =>$requestData["id"]
    );
    $applyInfo = M("TalentApply")->where($applyWhere)->fetchSql(false)->find();
    $result = M("TalentApply")->where($applyWhere)->fetchSql(false)->save($updateData);

    $cardOperator = true;
    // 查看是否已有人才卡
    $existCardInfo = M("TalentCard")->field("id")->where(array('uid'=>$applyInfo["uid"]))->fetchSql(false)->find();
    if($requestData['status'] == 6) {
      $cardData = array(
        "uid" =>$applyInfo["uid"],
        "realname" =>$applyInfo["realname"],
        "type" =>$applyInfo["type"],
        "card_no" =>$requestData["card_no"],
        "start_date" =>$requestData["start_date"],
        "end_date" =>$requestData["end_date"],
        "level" =>$requestData["level"]?$requestData["level"]:'',
        "score" =>$requestData["score"]?$requestData["score"]:0,
        "love" =>$requestData["love"]?$requestData["love"]:0,
        "update_time" =>date("Y-m-d H:i:s",time())
      );
      if($existCardInfo) {
        $cardOperator = M("TalentCard")->where(array("id"=>$existCardInfo["id"]))->data($cardData)->save();
      }else {
        $cardOperator = M("TalentCard")->data($cardData)->fetchSql(false)->add();
      }
    }
    if($result !== false && $cardOperator !== false){
      $transModel->commit();
      $applyInfo = M("TalentApply")
      ->alias("T")
      ->field("T.*,A.realname as verifyuser")
      ->join("LEFT JOIN __ADMIN__ A on A.id=T.verify_user")
      ->where(array("T.id"=>$requestData["id"]))
      ->find();
      $applyInfo['typename'] = $this->talentType[$applyInfo['type']];
      $applyInfo['verifyname'] = $this->verifyName[$applyInfo['verify_status']];
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "data"      =>array(
          "info"    =>$applyInfo
        )
      );    
    }else {
      $transModel->rollback();
      $backData = array(
        'code'      => 13002,
        "msg"       => "操作失败"
      );  
    }
    $this->ajaxReturn($backData);   
  }






  //==================//
}