<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class ChoujiangController extends Auth {
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 15;
    $mainModel = M("Choujiang");
    $where = array(
      "isdeleted" =>0
    );
    if(!empty($_GET['keywords'])){
      $where['title'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel
    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();
 

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



  // 活动详情
  public function edit(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("Choujiang")
    ->find($id);
    if(!$info) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
      $this->ajaxReturn($backData);
    }
    $thumbList = explode(";",$info['thumb']);
    $newThumbList = array();
    if(count($thumbList)) {
      foreach($thumbList as $key=>$val){
        if($val) {
          $temp = array(
            "name"  =>$val,
            "url"   =>C("OSS_BASE_URL")."/".$val
          );
          array_push($newThumbList,$temp);
        }
      }
    }
    $awardConsition = array(
      "isdeleted" =>0,
      "cid"        =>$id
    );
    $awardInfo = M("ChoujiangAward")
    ->where($awardConsition)
    ->order("sort, id desc")
    ->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "info"      =>$info,
        "thumbList" =>$newThumbList,
        "awardInfo" =>$awardInfo    
      )
    );
    $this->ajaxReturn($backData);
  }

  // 基本数据保存
  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("Choujiang");
    $requestData = $this->requestData;
    $createResult = $mainModel->create($requestData);

    if(!$createResult) {
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

   // 奖项数据保存
   public function saveaward(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("ChoujiangAward");
    $requestData = $this->requestData;
    $createResult = $mainModel->create($requestData);

    if(!$createResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    // 过滤内容中的style标签
    if(!empty($mainModel->id) && !is_null($mainModel->id)){
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


  public function deleteone(){
    if(empty($_GET['id'])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"
      );  
      return $this->ajaxReturn($backData);  
    }
    $id= I("get.id");
    $type = I("get.type",'1');
    $tableName = $type == 1 ? "Choujiang":"ChoujiangAward";
    $result = M($tableName)->where("id=$id")->setField("isdeleted",1);
    if($result !== false){
      $backData = array(
        'code'      => 200,
        "msg"       => "success"
      );    
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "删除失败"
      );  
    }
    $this->ajaxReturn($backData);   
  }

/**
 * 抽奖结果
 */
  public function logs(){

    $where = array();
    if(!empty($_GET['keywords'])){
      $where['CL.realname'] = array("like","%".$_GET["keywords"]."%");
      $where['CL.phone'] = array("like","%".$_GET["keywords"]."%");
      $where["_logic"] = "OR";
      
    }
    $page = I("get.page/d",1);
    $pageSize = 15;
    $condition = array(
      "CL.prize_flag" =>1
    );
    $choujiangInfo = array();
    if(count($where) > 0){
      $condition["_complex"] = $where;
    }
    if(!empty($_GET['cid'])) {
      $curChoujiangId = I("get.cid");
      $condition["CL.cj_id"] = $curChoujiangId; 
      $choujiangInfo = M("Choujiang")->find($curChoujiangId);
      $list = M("ChoujiangLog")
      ->alias("CL")
      ->field("CL.*,'".$choujiangInfo['title']."' as cj_name")
      ->where($condition)
      ->page($page,$pageSize)
      ->fetchSql(false)
      ->select();
    }else {
      $list = M("ChoujiangLog")
      ->alias("CL")
      ->field("CL.*,C.title as cj_name")
      ->join("__CHOUJIANG__ as C on C.id= CL.cj_id")
      ->where($condition)
      ->page($page,$pageSize)
      ->order("CL.id desc")
      ->fetchSql(false)
      ->select();
    }
    $total = M("ChoujiangLog")->alias("CL")->where($condition)->fetchSql(false)->count();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "cjInfo"  =>$choujiangInfo,
          "pageInfo"  =>array(
            "total"   =>intval($total),
            "page"    =>$page,
            "pageSize"  =>$pageSize
          )
      )
    );
    $this->ajaxReturn($backData);

  }


   /**
   * doverify
   */
  public function doverify(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $result = M("ChoujiangLog")
    ->where("id=$id")
    ->setField("stage",I("get.stage"));
    if($result !== false){
      $backData = array(
        'code'      => 200,
        "msg"       => "success"
      );    
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "系统错误"
      );  
    }
    $this->ajaxReturn($backData);  
  }



  //==================//
}