<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-10 20:05:00 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 00:52:03
 */

namespace Admin\Controller;
use Admin\Common\Auth;
 class DiscussContentController extends Auth {

  /**
   * node list
   */
  public function index(){
    if(empty($_GET['id'])) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussId = I('get.id');
    $list = M("DiscussNode")->where(array("dc_id"=>$discussId))->select();
    $backData = array(
      "code"  => 200,
      "msg"   => "success",
      "data"  =>array(
        "list"  =>$list
      )
    );  
    $this->ajaxReturn($backData);  
  }

  /**
   * content list
   */
  public function vlist(){
    if(empty($_GET['nodeid']) || empty($_GET['discussid'])) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussId = I("get.discussid");
    $nodeId = I('get.nodeid');
    $page = I("get.page/d",1);
    $pageSize=10;
    // 获取讨论组信息以便判断是来自课程还是项目
    $discussInfo = M("Discuss")->field('type,obj_id')->where(array('id'=>$discussId))->find();
    // 定位成员来源
    $memberTableName = '';
    if($discussInfo['type'] == 1) {
      $memberTableName = '__COURSE_MEMBER__';
    }else {
      $memberTableName = '__PARTTIME_MEMBER__';
    }
    $condition = array(
      "DC.node_id"=>$nodeId
    );
    $total = M("DiscussContent")->alias("DC")->where($condition)->count();
    $list = M("DiscussContent")
    ->alias("DC")
    ->field("DC.*,M.realname")
    ->join("__DISCUSS_MEMBER__ as DM on DC.member_id=DM.id")
    ->join($memberTableName." as M on M.id= DM.member_id")
    ->where($condition)
    ->page($page,$pageSize)
    ->order('id desc')
    ->select();
    $backData = array(
      "code"  => 200,
      "msg"   => "success",
      "data"  =>array(
        "content"  =>array(
          "page"  =>intval($page),
          "pageSize"  =>$pageSize,
          "total"   =>intval($total),
          "list"    =>$list
        )
      )
    );  
    $this->ajaxReturn($backData);  
  }











  //==============//
 }