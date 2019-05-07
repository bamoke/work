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

    $accountInfo = $this->accountInfo;

    // 查看是否已经创建名片；未创建名片不显示
    $myCardInfo = M("Card")->where(array("uid"=>$this->uid))->find();
    if(!$myCardInfo){
      $backData = array(
        "code"  => 10002,
        "msg"   => "创建名片后可见"
      );  
      $this->ajaxReturn($backData); 
    }

    // 剔除我的好友的名片
    $myUid = $this->uid;
    $myFriendUid = array($this->uid);
    $friendCondition = array(
      "f_uid" =>$myUid,
      "s_uid" =>$myUid,
      "_logic"  =>"OR"
    );
    $myFriendList = M("MycardFolder")->field("IF(f_uid=".$myUid.",s_uid,f_uid) as friend_id")->where($friendCondition)->select();
    if(count($myFriendList)){
      foreach($myFriendList as $key=>$val) {
        $myFriendUid[] = $val['friend_id'];
      }
    }
    $condition = array(
      "C.uid" =>array('not in',implode(",",$myFriendUid)),
      "C.type"=>$accountInfo['type']
    );
    if(!empty($_GET['keywords'])) {
      $keywords = I("get.keywords");
      $condition['C.realname'] = array('like',"%".$keywords."%");
    }
    $total = M("Card")->alias("C")->where($condition)->fetchSql(false)->count();
    $cardList = M("Card")
    ->alias("C")
    ->field("C.id,C.realname,C.avatar,C.company,C.position,E.status as exchange_status")
    ->join("__EXCHANGE__ E on E.from_uid=C.uid and E.to_uid = ".$myUid,"LEFT")
    ->where($condition)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    // return;
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$cardList,
        "page"  =>$page,
        "total" =>intval($total),
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
    $cardUid = M("Card")->where(array('id'=>$cardId))->getField("uid");


    // 1.2 是否已交换名片
    $exchangeCondition = array(
      "from_uid" =>$this->uid,
      "to_uid" =>$cardUid
    );
    $exchangedStatus = M("Exchange")->where($exchangeCondition)->fetchSql(false)->getField("status");
 
 
    $isLike=false;
    $isCollected=false;
    $likeTotal=0;
    $collectedTotal=0;
    if($exchangedStatus == 2) {
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
      $cardInfo = M("Card")->where(array('id'=>$cardId))->find();
    }else {
      $cardInfo = M("Card")
      ->where("id=$cardId")
      ->field('id,avatar,realname,sex,("交换名片后可见")as phone,("交换名片后可见")as email,company,partment,position,province,city,interest')
      ->find();
    }
    // update view num
    $updateResult = M("Card")->where(array("id"=>$cardId))->setInc('click');
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
        "exchangeStatus"  =>$exchangedStatus,
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