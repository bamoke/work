<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class ExchangeController extends BaseController {
  /**
   * exchange list
   * @condition
   * @page
   */
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 20;


    $type = I("get.type");
    $condition = array(
      "E.to_uid" =>$this->uid
    );
    if($type == 1) {
      $condition['E.status'] = 1;
    }else {
      $condition['E.status'] = array('neq',1);
    }
    $total = M("Exchange")->alias("E")->where($condition)->count();
    $list = M("Exchange")
    ->field("E.id as exchangeid,E.status as exchange_status,CARD.id as cardid,CARD.avatar,CARD.realname,CARD.partment,CARD.position,CARD.company")
    ->alias("E")
    ->join("__CARD__ as CARD on CARD.uid = E.from_uid")
    ->where($condition)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();
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
   * Handle 申请交换
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
    $cardUid = M("Card")->where(array('id'=>$cardId))->getField("uid");
    $model = M("Exchange");
    $condition = array(
      "from_uid"      =>$this->uid,
      "to_uid"        =>$cardUid
    );
    $exchangeInfo = $model->where($condition)->find();


    if(!$exchangeInfo) {
      $insertData = array(
        "from_uid"     =>$this->uid,
        "to_uid"       =>$cardUid,
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
  public function verify(){
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
      if($exchangeInfo['from_uid'] > $exchangeInfo['to_uid']) {
        $firstUid = $exchangeInfo['to_uid'];
        $secondUid = $exchangeInfo['from_uid'];
      }else {
        $firstUid = $exchangeInfo['from_uid'];
        $secondUid = $exchangeInfo['to_uid'];
      }
      $friendCondition = array(
        "f_uid" =>$firstUid,
        "s_uid" =>$secondUid
      );
      $isFriend = M("MycardFolder")->where($friendCondition)->count();
      $model = M();
      $model->startTrans();
      $updateExchange = M("Exchange")->where($condition)->data(array("status"=>$status))->save();
      if($isFriend) {
        $insertMycard = true;
      }else {
        $insertData = array(
          "f_uid"       => $firstUid,
          "s_uid"   =>$secondUid
        );
        $insertMycard = M("MycardFolder")->add($insertData);
      }

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

  /**
   * detail
   */
  public function detail(){
    if(empty($_GET['id'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $cardId = I("get.id");
    $cardUid = M("Card")->where(array('id'=>$cardId))->getField("uid");
    $myUid = $this->uid;
    // 1.1 是否已经是好友
    if($cardUid > $myUid) {
      $firstUid = $myUid;
      $secondUid = $cardUid;
    }else {
      $firstUid = $cardUid;
      $secondUid = $myUid;
    }
    $friendCondition = array(
      "f_uid" =>$firstUid,
      "s_uid" =>$secondUid
    );
    $isFriend = M("MycardFolder")->where($friendCondition)->fetchSql(false)->count();
    $isLike=false;
    $isCollected=false;
    $likeTotal=0;
    $collectedTotal=0;
    if($isFriend) {
      // 1.2 是否已收藏
      $collectionCondition = array(
        "uid" =>$this->uid,
        "card_id" =>$cardId,
        "status"  =>1
      );
      $isCollected = M("Collection")->where($collectionCondition)->count();

      // 1.3 是否已点赞
      $likeCondition = array(
        "uid"     =>$this->uid,
        "card_id" =>$cardId
      );
      $isLike = M("Like")->where($likeCondition)->count();

      // 2.统计信息
      $totalCondition = array(
        "card_id" =>$cardId
      );
      // 2.1 收藏统计
      $collectionTotal = M("Collection")->where($totalCondition)->where("status=1")->count();
      // 2.2 like 统计
      $likeTotal = M("Like")->where($totalCondition)->count();      
    }
 
    // 2.1 交换信息
    $exchangeCondition = array(
      "from_uid"     =>$cardUid,
      "to_uid"        => $myUid
    );
    $exchangeStatus = M("Exchange")->where($exchangeCondition)->getField("status");

    $cardInfo = M("Card")->where(array('id'=>$cardId))->find();
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "isFriend"        =>!!$isFriend,
        "exchangeStatus"  =>intval($exchangeStatus),
        "isCollected"     =>!!$isCollected,
        "isLike"          =>!!$isLike,
        "collectedTotal"  =>$collectionTotal,
        "likeTotal"       =>$likeTotal,
        "cardInfo"        =>$cardInfo
      )
    );
    $this->ajaxReturn($backData);
  }

}