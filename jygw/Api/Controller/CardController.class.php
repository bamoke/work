<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class CardController extends BaseController {
  /**
   * card list
   * @condition
   * @page
   */
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 20;
    $condition = array();
    if(empty($_GET['keywords'])) {
      $condition['C.realname'] = I("get.keywords");
    }
    $total = M("Card")->alias("C")->where($condition)->count();
    $cardList = M("Card")
    ->alias("C")
    ->field("C.id,C.realname,C.avatar,C.company,C.partment,C.position,E.status as exchangeStatus")
    ->join("__EXCHANGE__ as E on E.card_id = C.id and E.uid=".$this->uid,'LEFT')
    ->where($condition)
    ->page($page,$pageSize)
    ->order("id desc")
    ->select();

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
    // 1.1 是否已交换名片
    $exchangeCondition = array(
      "uid" =>$this->uid,
      "card_id" =>$cardId
    );
    $isExchanged = M("Exchange")->where($exchangeCondition)->getFiled("status");

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

    if($isExchanged == 2) {
      $cardInfo = M("Card")->where(array('id'=>$cardId))->find();
    }else {
      $cardInfo = M("Card")
      ->where("id=$cardId")
      ->filed('id,avatar,realname,("交换名片后可见") as phone,("交换名片后可见") as email,company,partment,position,province,city')
      ->find();
    }
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "exchangeStatus"  =>$isExchanged,
        "isCollected"     =>!!$isCollected,
        "isLike"          =>!!$isLike,
        "collectedTotal"  =>$collectionTotal,
        "likeTotal"       =>$likeTotal,
        "cardInfo"        =>$cardInfo
      )
    );
    $this->ajaxReturn($backData);
  }

  /***============== */
}