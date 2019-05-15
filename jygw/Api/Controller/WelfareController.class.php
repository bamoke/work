<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class WelfareController extends BaseController {
  /**
   * card list
   * @condition
   * @page
   */
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 20;
    $customLat = I("get.lat");
    $customLng = I("get.lng");
    $condition = array(
      "status"  =>1
    );
    $orderType = I("get.type/d",1);
    $thumbBase = "http://www.bamoke.com/jygw/Uploads/images/thumb/";
    $fieldInfo = "id,title,recommend,concat('$thumbBase',thumb) as thumb,tags,grade,addr,(st_distance (point (longitude, latitude),point($customLng,$customLat) ) *111195) AS distance";
    $orderBy = "";
    switch($orderType) {
      case 1:
      $orderBy = "recommend desc,grade desc,id desc";
      break;
      case 2 :
      $orderBy = "distance ,recommend desc,grade desc,id desc";
      break;
      case 3 :
      $orderBy = "grade desc,recommend desc,id desc";
      break;
    }
    $total = M("Welfare")->where($condition)->count();
    $list = M("Welfare")
    ->field($fieldInfo)
    ->where($condition)
    ->page($page,$pageSize)
    ->order($orderBy)
    ->fetchSql(false)
    ->select();

    // return;
    if(count($list)){
      foreach($list as $key=>$val){
        $gradeRatio = intval($val['grade']/50*100);
        $tags = explode(";",$val['tags']);
        $distanceNum = intval($val['distance']);
        $distance = "";
        if($distanceNum > 1000) {
          $distance = (ceil($distanceNum/100)/10) ."KM";
        }else {
          $distance = $distanceNum ."M";
        }
        $list[$key]["distance"] = $distance;
        $list[$key]["tags"] = $tags;
        $list[$key]["grade"] = number_format($val["grade"]/10,1);
        $list[$key]["gradeRatio"] = $gradeRatio;
      }
    }
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list,
        "pageInfo"  =>array(
          "page"  =>$page,
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