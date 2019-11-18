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
    $mainModel = M("AgentPrice");
    $adminInfo = $this->userInfo;
    $agentId = $adminInfo['agent_id'];
    $pageSize = 20;
    $page = I("get.p/d",1);
    $where = array(
      "PP.status" =>1
    );

    $total = M("PlatformProduct")->where("status=1")->count();
    $list = M("PlatformProduct")
    ->alias("PP")
    ->field("AP.id as price_id,AP.price as new_price,PP.id as product_id, PP.title,PP.description,PP.price as old_price")
    ->join("__AGENT_PRICE__ AP on AP.object_id= PP.id and AP.agent_id=$agentId and AP.type=1",'LEFT')
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
    $adminInfo = $this->userInfo;
    $agentId = $adminInfo['agent_id'];
    $pageSize = 15;
    $page = I("get.page/d",1);
    $where = array(
      "PM.status" =>1
    );

    $total = M("PlatformModule")->alias("PM")->where($where)->count();
    $list = M("PlatformModule")
    ->alias("PM")
    ->field("AP.id as price_id,AP.price as new_price,PM.pid,PM.id as module_id, PM.name,PM.description,PM.price as old_price")
    ->join("__AGENT_PRICE__ AP on AP.object_id= PM.id and AP.agent_id=$agentId and AP.type=2",'LEFT')
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
        if($v['pid'] == $val['module_id']) {
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


  public function dosave(){
    $postData = $this->requestData;
    $curModel = M("AgentPrice");
    if(!$postData['new_price']) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "价格不能为空"
      );
      $this->ajaxReturn($backData);
    }
    if($postData['price_id']) {
      $updateCondition = array(
        "id"  =>$postData['price_id']
      );
      $curModel->price = $postData['new_price'];
      $result = $curModel->where($updateCondition)->fetchSql(false)->save();

    }else {
      $acType = intval($postData['actype']);
      switch ($acType) {
        case 1:
        $objectId = $postData['product_id'];
        break;
        case 2:
        $objectId = $postData['module_id'];
        break;
      }
      $insertData = array(
        "type"  =>$acType,
        'agent_id'  =>$this->userInfo['agent_id'],
        "price" =>$postData['new_price'],
        "object_id" =>$objectId
      );
      $result = $curModel->data($insertData)->add();
    }
    if($result !== false) {
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "data"      =>array(
          "priceid" =>$result
        )
      );
      $this->ajaxReturn($backData);
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "保存失败"
      );
      $this->ajaxReturn($backData);
    }
  }









  //==================//
}