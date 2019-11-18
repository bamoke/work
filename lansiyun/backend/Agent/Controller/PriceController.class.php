<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2019-10-06 14:46:11 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-10-08 11:15:25
 * 价格管理
 */

namespace Agent\Controller;
use Agent\Common\Auth;
class PriceController extends Auth {
  public function product(){
    $pageSize = 20;
    $page = I("get.p/d",1);
    $where = array(
      "PP.status" =>1
    );

    $total = M("PlatformProduct")->where("status=1")->count();
    $list = M("PlatformProduct")
    ->alias("PP")
    ->field("PP.id, PP.title,PP.description,PP.price")
    ->where($where)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();
// var_dump($list);
// exit();
    $pageInfo = array(
      "page"  =>$page,
      "total" =>intval($total),
      "pageSize"  =>$pageSize
    );
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "pageInfo"  =>$pageInfo
      )
    );
    $this->ajaxReturn($backData);
  }

  public function mokuai(){

    $pageSize = 15;
    $page = I("get.page/d",1);
    $where = array(
      "PM.status" =>1
    );

    $total = M("PlatformModule")->alias("PM")->where($where)->count();
    $list = M("PlatformModule")
    ->alias("PM")
    ->field("PM.id,PM.pid, PM.name,PM.description,PM.price,0 as sell_num")
    ->where($where)
    ->page($page,$pageSize)
    ->fetchSql(false)
    ->select();
// var_dump($list);
// exit();
$newList = array();
if($total > 0) {
  foreach($list as $key=>$val) {
    if($val['pid'] == 0) {
      foreach($list as $k=>$v) {
        // $newList = array();
        if($v['pid'] == $val['id']) {
          $tempItem = $v;
          $tempItem['catename'] = $val['name'];
          $newList[] = $tempItem;
        }
      }
    }
  }
}
    $pageInfo = array(
      "page"  =>$page,
      "total" =>intval($total),
      "pageSize"  =>$pageSize
    );
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$newList,
          "pageInfo"  =>$pageInfo
      )
    );
    $this->ajaxReturn($backData);
  }












  //==================//
}