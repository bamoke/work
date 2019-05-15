<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class EventController extends BaseController {
  /**
   * Event 活动
   * @condition
   * @page
   */
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 10;
    $condition = array(
      "status"  =>1
    );
    $type = I("get.type/d");
    if($type !== 0) {
      $condition['type'] = $type;
    }
    $thumbBase = "http://www.bamoke.com/jygw/Uploads/images/thumb/";
    $fieldInfo = "id,title,concat('$thumbBase',thumb) as thumb,start_date,end_date";
    $total = M("Event")->where($condition)->count();
    $list = M("Event")
    ->field($fieldInfo)
    ->where($condition)
    ->page($page,$pageSize)
    ->order($orderBy)
    ->select();

    if(count($list)) {
      foreach($list as $key=>$val){
        if(strtotime($val['end_date']) < time()) {
          $stage = 2;
          $stageTxt = "已结束";
        }else {
          if(strtotime($val['start_date']) > time()) {
            $stage = 0;
            $stageTxt = "未开始";
          }else {
            $stage = 1;
            $stageTxt = "进行中";
          }
        }
        $list[$key]['stage'] = $stage;
        $list[$key]['stageTxt'] = $stageTxt;
      }
    }

    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list,
        "pageInfo"  =>array(
          "page"  =>$page,
          "pageSize"=>$pageSize,
          "total" =>intval($total),
          "hasMore" => intval($total) - ($page*$pageSize) > 0
        )
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