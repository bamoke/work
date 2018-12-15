<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class CollectionController extends BaseController {
  /**
   * exchange list
   * @condition
   * @page
   */
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 20;

    $condition = array(
      "E.uid" =>$this->uid
    );
    if(empty($_GET['type'])) {
      $condition['E.status'] = I("get.type");
    }
    $total = M("Exchange")->alias("E")->where($condition)->count();
    $list = M("Exchange")
    ->field("CARD.avatar,CARD.realname,CARD.partment,CARD.position,CARD.compnay")
    ->alias("E")
    ->join("__CARD__ as CARD on CARD.id = E.card_id")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();
    // var_dump($list);
    // return;
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list,
        "page"  =>$page,
        "total" =>$total,
        "hasMore" => $total - ($page*$pageSize) > 0
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * Handle 交换
   * @cardid
   */
  public function doexchange(){
    if(empty($_GET["cardid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }

    $cardId = I("get.cardid/d");
    $model = M("Exchange");
    $condition = array(
      "uid"     =>$this->uid,
      "card_id"  =>$cardId
    );
    $exchangeStatus = $model->where($condition)->getFiled("status");
    if(!$exchangeStatus) {
      $insertData = array(
        "uid"     =>$this->uid,
        "card_id" =>$card_id,
        "status"  =>1
      );
      $result = $model->data($insertData)->add();
      if($result){
        $backData = array(
          "code"      =>200,
          "msg"       =>"success"
        );
      }else {
        $backData = array(
          "code"      =>13001,
          "msg"       =>"操作失败"
        );
      }
      $this->ajaxReturn($backData);
    }

  }

  /**
   * 交换审核
   */
  public function varify(){
    if(empty($_GET["id"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $exchangeId = I("get.id");
    $status = I("get.status");
    $condition = array(
      "id"      =>$exchangeId
    );
    if($status == 3) {
      $result = M("Exchange")->where($condition)->data(array("status"=>$status))->save();
      if($result !== false){
        $backData = array(
          "code"      =>200,
          "msg"       =>"success"
        );
      }else {
        $backData = array(
          "code"      =>13001,
          "msg"       =>"操作失败"
        );
      }
      $this->ajaxReturn($backData);
    }else if($status == 2) {
      $exchangeInfo = M("Exchange")->where($condition)->find();
      $model = M();
      $model->startTrans();
      $updateExchange = M("Exchange")->where($condition)->data(array("status"=>$status))->save();
      $insertData = array(
        "uid"       => $exchangeInfo['uid'],
        "card_id"   =>$exchangeInfo['card_id']
      );
      $insertMycard = M("MycardFolder")->add();
      if($updateExchange && $insertMycard) {
        $model->commit();
        $backData = array(
          "code"      =>200,
          "msg"       =>"success"
        );
        $this->ajaxReturn($backData);
      }else {
        $model->rollback();
        $backData = array(
          "code"      =>13001,
          "msg"       =>"操作失败请稍后再试"
        );
        $this->ajaxReturn($backData);
      }
    }
  }

}