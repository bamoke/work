<?php
/**
 * 我的名片模块
 */
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class MycardController extends BaseController {

  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 20;
    $condition = array(
      "MF.f_uid"  =>$this->uid,
      "MF.s_uid"  =>$this->uid,
      "_logic" =>"OR"
    );

    $total = M("MycardFolder")->alias("MF")->where($condition)->count();
    $cardList = M("MycardFolder")
    ->alias("MF")
    ->field("C.id,C.realname,C.avatar,C.company,C.partment,C.position")
    ->join("__CARD__ as C on (C.uid = MF.f_uid or C.uid=MF.s_uid) and C.uid <> ".$this->uid)
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
   * create
   * @condition
   * @page
   */
  public function create(){
    if(!IS_POST) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法操作"
      );  
      $this->ajaxReturn($backData);     
    }
    $model = M("Card");
    // 1.1 check phone
    $phone = I("post.phone");
    $phoneExist = $model->where(array('phone'=>$phone))->count();
    if($phoneExist) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "手机号已经被使用"
      );  
      $this->ajaxReturn($backData);  
    } 
    // 1.2 create data
    $creatResult = $model->create();
    if(!$creatResult){
      $backData = array(
        "code"  => 13002,
        "msg"   => "数据错误"
      );  
      $this->ajaxReturn($backData);  
    }
    $model->uid = $this->uid;
    $insertResult = $model->fetchSql(false)->add();
    if(!$insertResult) {
      $backData = array(
        "code"  => 13003,
        "msg"   => "保存失败请稍后再试"
      );  
      $this->ajaxReturn($backData);  
    }
    $backData = array(
      "code"  => 200,
      "msg"   => "success"
    );  
    $this->ajaxReturn($backData);  
  }

  public function bind(){
    $model = M("Card");
    // 1.1 check phone
    $phone = I("get.phone");
    $cardInfo = $model->where(array('phone'=>$phone))->find();
    if(!$cardInfo) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "没有此手机用户"
      );  
      $this->ajaxReturn($backData);  
    }

    if($cardInfo['uid']) {
      $backData = array(
        "code"  => 13002,
        "msg"   => "此手机号已经被绑定"
      );  
      $this->ajaxReturn($backData);       
    }
    // 1.2 create data
    $model->uid = $this->uid;
    $condition = array(
      "phone" =>$phone
    );
    $updateResult = $model->where($condition)->fetchSql(false)->save();

    // 1.3 update member type(2019-03-14)
    $memberCondition = array(
      "id"  =>$this->uid
    );
    $memberData = array(
      "type"  =>$cardInfo['type']
    );
    $updateMember = M("Member")->where($memberCondition)->data($memberData)->save();

    if(!$updateResult) {
      $backData = array(
        "code"  => 13003,
        "msg"   => "保存失败请稍后再试"
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
   * update
   */
  public function update(){
    if(!IS_POST) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "非法操作"
      );  
      $this->ajaxReturn($backData);     
    }
    $model = M("Card");

    // 1.1 update data
    $creatResult = $model->create();
    if($model->avatar == "null") {
      $model->avatar = NULL;
    }
    if(!$creatResult){
      $backData = array(
        "code"  => 13002,
        "msg"   => "数据错误"
      );  
      $this->ajaxReturn($backData);  
    }
    $updateResult = $model->where(array('id'=>I('post.id')))->fetchSql(false)->save();
    if($updateData !== false) {
      $backData = array(
        "code"  => 200,
        "msg"   => "success"
      );  
      $this->ajaxReturn($backData);  
    }else {
      $backData = array(
        "code"  => 13001,
        "msg"   => "保存失败请稍后再试"
      );  
      $this->ajaxReturn($backData);  
    }
  }

    /**
   * my card detail
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
    // update view num
    $updateResult = M("Card")->where(array("id"=>$cardId))->setInc('click');
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
  /**
   * my card detail
   */
  public function my(){
    $cardCondition = array(
      "uid" =>$this->uid
    );
    $cardInfo = M("Card")->where($cardCondition)->find();
    $backData = array(
      "code"  => 200,
      "msg"   => "success",
      "data"  =>$cardInfo
    );  
    $this->ajaxReturn($backData);  
  }



}