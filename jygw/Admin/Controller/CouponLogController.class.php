<?php
namespace Admin\Controller;
use Admin\Common\Auth;

Class CouponLogController extends Auth {

    /**
     * 列表
     */
    public function vlist(){
      $page = I("get.page/d",1);
      $pageSize = 15;
      $mainModel = M("CouponRecord");
      $where = array();
      $couponId = I("get.cid/d");
      if($couponId) {
        $where['CL.coupon_id'] =$couponId;
      }
      // search 
      $stage = I("get.stage",'0');
      if($stage != 0) {
        $where["CL.stage"] = $stage-1;
      }
      $keywords = I("get.keywords",'');
      $keyType = I("get.skey");

      if($keywords) {
        if($keyType == 'code') {
          $where["CL.code"] = array("like","%".$keywords."%");
        }
        if($keyType == 'username') {
          $userWhere =array(
            "realname"  =>array("like","%$keywords%")
          );
          $userIdArr = M("TalentCard")->where($userWhere)->getField("uid",true);
          if(count($userIdArr)) {
            $where["CL.uid"] =array("in",$userIdArr);
          }else {
            $where["CL.uid"] = 0;
          }
        }
        if($keyType == 'businessname') {
          $businessWhere =array(
            "title"  =>array("like","%$keywords%")
          );
          $businessIdArr = M("Welfare")->where($businessWhere)->getField("id",true);
          if(count($businessIdArr)) {
            $where["CL.b_id"] =array("in",$businessIdArr);
          }else {
            $where["CL.b_id"] = 0;
          }
        }
      }
      $list = $mainModel
      ->field("CL.*,CARD.realname as username,IFNULL(B.title,'商家通用') as businessname")
      ->alias("CL")
      ->join("__TALENT_CARD__ as CARD on CARD.uid= CL.uid")
      ->join("LEFT JOIN __WELFARE__ as B on B.id= CL.b_id")
      ->where($where)
      ->page($page,$pageSize)
      ->order("CL.id desc")
      ->fetchSql(false)
      ->select();
      $total = $mainModel->alias("CL")->where($where)->count();
  
  
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        'data'      => array(
            "list"  =>$list,
            "pageInfo"  =>array(
              "total"   =>intval($total),
              "page"    =>$page,
              "pageSize"  =>$pageSize
            )
        )
      );
      $this->ajaxReturn($backData);
  }



  // 优惠券简情
  public function coupon_desc(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $where=array(
      "C.id"  =>I("get.id")
    );
    $info = M("Coupon")
    ->alias("C")
    ->field("C.title as couponname,IFNULL(B.title,'商家通用') as businessname")
    ->join("LEFT JOIN __WELFARE__ as B on B.id= C.b_id")
    ->where($where)
    ->find();
    if(!$info) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
      $this->ajaxReturn($backData);
    }

    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "info"      =>$info
      )
    );
    $this->ajaxReturn($backData);

  }


}