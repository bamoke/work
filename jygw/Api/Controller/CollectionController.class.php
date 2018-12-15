<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class CollectionController extends BaseController {
  /**
   * collection list
   * @condition
   * @page
   */
  public function vlist(){
    $page = I("get.p/d",1);
    $pageSize = 20;
    $condition = array(
      "CO.status" =>1,
      "CO.uid"    =>$this.uid
    );
    $total = M("Collection")->alias("CO")->where($condition)->count();
    $list = M("Collection")
    ->field("CO.id,date(CO.create_time) as create_time,CARD.avatar,CARD.realname,CARD.partment,CARD.position,CARD.compnay")
    ->alias("CO")
    ->join("__CARD__ as CARD on CO.card_id = CARD.id")
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
   * Handle 收藏
   * @cardid
   */
  public function docollect(){
    if(empty($_GET["cardid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }

    $cardId = I("get.cardid/d");
    $model = M("Collection");
    $array = array(
      "uid"     =>$this->uid,
      "card_id"  =>$cardId
    );
    $collectionInfo = $model->field("id,status")->where($array)->find();
    if($collectionInfo) {
      $updateData = array(
        "status"=> intval(!$collectionInfo['status'])
      );
      $result = $model->where(array("id"=>$collectionInfo['id']))->data($updateData)->save();
    }else {
      $result = $model->data($array)->add();
    }
    if($result){
      $backData = array(
        "code"      =>200,
        "msg"       =>"ok"
      );
    }else {
      $backData = array(
        "code"      =>13001,
        "msg"       =>"操作失败"
      );
    }
    $this->ajaxReturn($backData);
  }

  /**
   * 取消收藏
   */
  public function cancel(){
    if(empty($_GET["cardid"])){
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $cardId = I("get.cardid/d");
    $condition = array(
      "uid"     =>$this->uid,
      "job_id"  =>$jobId
    );
    $result = $model->where($condition)->data(array("status"=>0))->save();
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
  }

}