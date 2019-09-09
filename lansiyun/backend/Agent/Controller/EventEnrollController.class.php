<?php 
/* 活动报名
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class EventEnrollController extends Auth {
  public function vlist(){
    if(empty($_GET['eventid'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $eventId = I("get.eventid/d");
    $page = I("get.page/d",1);
    $pageSize = 15;
    $mainModel = M("EventEnroll");
    $where = array(
      "event_id"=>$eventId
    );
    if(!empty($_GET['keywords'])){
      $where['realname'] = array("like","%".$_GET["keywords"]."%");
    }
    
    $eventInfo = M("Event")->field("id,title")->where(array("id"=>$eventId))->find();
    $list = $mainModel
    ->field("*")
    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
        "eventInfo" =>$eventInfo,
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

  /**
   * 报名审核
   */
  public function doverify(){
    if(empty($_GET['id']) || !isset($_GET['status'])) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "访问参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $condition = array(
      "id"  =>I("get.id/d")
    );
    $data = array(
      "status"  =>I("get.status")
    );
    $updateResult = M("EventEnroll")->where($condition)->data($data)->save();
    if($updateResult !== false) {
      $backData = array(
        'code'      => 200,
        "msg"       => "success"
      );
      $this->ajaxReturn($backData);
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据更新错误"
      );
      $this->ajaxReturn($backData);
    }
  }








  //==================//
}