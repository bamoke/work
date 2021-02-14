<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
class CouponController extends BaseController {
  /**
   * 我的优惠券
   * @condition
   * @page
   */
  public function vlist(){
    $uid = $this->uid;
    $page = I("get.page/d",1);
    $type = I("get.type/d",1);
    $pageSize = 10;
    $condition = array(
      "C.uid"  =>$uid
    );
    if($type == 1) {
      $condition["C.stage"] = 0;
      $condition["C.end_date"] = array("egt",date("Y-m-d",time()));
      $couponStatus = 1;
    }elseif($type == 2) {
      $condition["C.stage"] = 1;
      $couponStatus = 2;
    }else {
      $condition["C.end_date"] = array("lt",date("Y-m-d",time()));
      $couponStatus =3;
    }
    


    $total = M("CouponRecord")->alias("C")->where($condition)->count();
    $list = M("CouponRecord")
    ->alias("C")
    ->field("C.*,$couponStatus as coupon_status,IFNULL(W.title,'所有签约商家') as business_name")
    ->where($condition)
    ->join("LEFT JOIN __WELFARE__ as W on W.id = C.b_id ")
    ->page($page,$pageSize)
    ->order("C.id desc")
    ->fetchSql(false)
    ->select();
    // var_dump($list);
    // exit();


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
   * 商家优惠券
   */
  public function welfareCoupon(){
    $uid = $this->uid;
    if(empty($_GET['welfareid'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $welfareId = I("get.welfareid");
    $where = array(
      "C.status"  =>1,
      "C.end_date" =>array("EGT",date("Y-m-d",time())),
      "C.b_id"  =>$welfareId
    );
    $list = M("Coupon")
    ->alias("C")
    ->field("C.title as coupon_title,C.id as coupon_id,C.end_date,C.description,IF(R.id,1,0) as ishas,(C.num - C.receive_num) as surplus_num")
    ->join("LEFT JOIN __COUPON_RECORD__ as R on R.coupon_id = C.id and R.stage=0 and R.uid=$uid")
    ->where($where)
    ->order("coupon_title,coupon_id")
    ->fetchSql(false)
    ->select();
    $backData = array(
      "code"      =>200,
      "msg"       =>"ok",
      "data"      => array(
        "list"  =>$list
      )
    );
    $this->ajaxReturn($backData);
  }



  /**
   * 领取优惠券
   */
  public function receive(){
    if(empty($_GET['couponid'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $couponId = I("get.couponid/d");

    // 检测是否是人才卡用户
    $talentType = $this->is_talent_user();
    if($talentType <= 0) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "此优惠为人才卡用户专享"
      );  
      $this->ajaxReturn($backData); 
    }

    // 检测是否有领取过且未使用的优惠券
    $existWhere = array(
      "coupon_id"   =>$couponId,
      "uid"         =>$this->uid,
      "stage"       =>0
    );
    $exist = M("CouponRecord")->where($existWhere)->fetchSql(false)->count();
    if($exist) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "已经领取过了"
      );  
      $this->ajaxReturn($backData); 
    }

    // 检测优惠券状态
    $couponInfo = M("Coupon")->fetchSql(false)->find($couponId);

    if($couponInfo["status"] == 0) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "优惠券已下架"
      );  
      $this->ajaxReturn($backData); 
    }
    if(strtotime($couponInfo["end_date"]) <= time()) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "优惠券已过期"
      );  
      $this->ajaxReturn($backData); 
    }
    if($couponInfo["num"] - $couponInfo["receive_num"] == 0) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "优惠券已被领完"
      );  
      $this->ajaxReturn($backData); 
    }

 

    $transModel = M();
    $transModel->startTrans();
    // 添加入我的优惠券

    $insertData = array(
      "b_id"    =>$couponInfo["b_id"],
      "coupon_id" =>$couponId,
      "uid"     =>$this->uid,
      "title"       =>$couponInfo["title"],
      "description"       =>$couponInfo["description"],
      "start_date"  =>$couponInfo["start_date"],
      "end_date"  =>$couponInfo["end_date"],
    );
    $insertId = M("CouponRecord")->data($insertData)->fetchSql(false)->add();
 

    if(!$insertId) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "系统错误"
      );  
      $this->ajaxReturn($backData); 
    }

    $couponCode = $this->create_code(date("ymd"),time()).$this->create_code($insertId);
    $updateRecord = M("CouponRecord")
    ->data(array("code"=>$couponCode))
    ->where(array("id"=>$insertId))
    ->save();

    // 更新优惠券剩余
    $updateReset = M("Coupon")->where(array("id"=>$couponId))->setInc("receive_num");

    if($insertId && $updateRecord && $updateReset) {
      $transModel->commit();
      $backData = array(
        "code"  => 200,
        "msg"   => "success"
      );  
      $this->ajaxReturn($backData); 
    }else {
      $transModel->rollback();
      $backData = array(
        "code"  => 13001,
        "msg"   => "系统错误"
      );  
      $this->ajaxReturn($backData); 
    }


  }

  protected function create_code($num) {
    $num = intval($num);
    if ($num <= 0)
      return false;
    $charArr = array("0","1","2","3","4","5","6","7","8","9",'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $char = '';
    do {
      $key = ($num - 1) % 36;
      $char= $charArr[$key] . $char;
      $num = floor(($num - $key) / 36);
    } while ($num > 0);
    return $char;
  }
  

  /***============== */
}