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
    $uid = $this->uid;
    $page = I("get.page/d",1);
    $pageSize = 10;
    $customLat = I("get.lat");
    $customLng = I("get.lng");
    $condition = array(
      "W.status"  =>1
    );
    $orderType = I("get.type/d",1);
    $thumbBase = C("OSS_BASE_URL")."/";
    if(!empty($_GET["lat"])) {
      $fieldInfo = "W.id,W.title,W.tags,concat('$thumbBase',W.thumb) as thumb,(st_distance (point (W.longitude, W.latitude),point($customLng,$customLat) ) * 111195) AS distance";
    }else {
      $fieldInfo = "W.id,W.title,W.tags,concat('$thumbBase',W.thumb) as thumb, '0' as distance";
    }

    $fieldInfo .= ", C.title as coupon_title,C.id as coupon_id,R.id as hascoupon";
    $orderBy = "";
    switch($orderType) {
      case 1:
      $orderBy = "W.recommend desc,W.grade desc,W.id desc";
      break;
      case 2 :
      $orderBy = "distance ,W.recommend desc,W.grade desc,W.id desc";
      break;
      case 3 :
      $orderBy = "W.grade desc,W.recommend desc,W.id desc";
      break;
    }
    $total = M("Welfare")->alias("W")->where($condition)->count();
    $list = M("Welfare")
    ->alias("W")
    ->field($fieldInfo)
    ->join("__COUPON__ as C on C.b_id = W.id and C.status=1 and C.end_date >= CURDATE()")
    ->join("left join __COUPON_RECORD__ as R on R.coupon_id = C.id and R.stage=0 and R.uid=$uid")
    ->where($condition)
    ->page($page,$pageSize)
    ->order($orderBy)
    ->fetchSql(false)
    ->select();
    // var_dump($list);
    // exit();

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
    $thumbBase = C("OSS_BASE_URL")."/";
    $businessId = I("get.id/d");
    $info = M("Welfare")->find($businessId);
    $info["tags"] = explode(";",$info["tags"]);
    if($info["thumb"]) {
      $info["logo"] = $thumbBase.$info["thumb"];
    }else {
      $info["logo"] ="/static/images/tab-news.png";
    }
    $backData = array(
      "code"  =>200,
      "msg"   =>'success',
      "data"  =>array(
          "info"  =>$info
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 
   */
  

  /***============== */
}