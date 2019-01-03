<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-10 20:05:00 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 00:52:03
 */

namespace Admin\Controller;
use Admin\Common\Auth;
 class DiscussMemberController extends Auth {


  /**
   * member list
   */
  public function vlist(){
    if(empty($_GET['discussid'])) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussId = I("get.discussid");
    $page = I("get.page/d",1);
    $pageSize=20;
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
      "DM.dc_id"=>$discussId
    );
    if(!empty($_GET['keywords'])) {
      $condition['M.realname'] = array('like',"%".$_GET['keywords']."%");
    }
    $total = M("DiscussMember")
    ->alias("DM")
    ->field("DM.*,M.realname")
    ->join($memberTableName." as M on M.id= DM.member_id")
    ->where($condition)
    ->count();
    $list = M("DiscussMember")
    ->alias("DM")
    ->field("DM.*,M.realname")
    ->join($memberTableName." as M on M.id= DM.member_id")
    ->where($condition)
    ->page($page,$pageSize)
    ->order('DM.type desc,DM.id desc')
    ->select();
    $backData = array(
      "code"  => 200,
      "msg"   => "success",
      "data"  =>array(
        "page"  =>intval($page),
        "pageSize"  =>$pageSize,
        "total"   =>intval($total),
        "list"    =>$list
      )
    );  
    $this->ajaxReturn($backData);  
  }


  /**
   * 加入成员
   */
  public function add(){
    if(empty($_GET['discussid'])) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussId = I("get.discussid");
    $newId = json_decode($_GET['newid'],true);
    $insertData = array();
    foreach($newId as $val) {
      $insertData[] = array(
        "dc_id" =>$discussId,
        "member_id" =>intval($val)
      );
    }
    $insertResult = M("DiscussMember")->fetchSql(false)->addAll($insertData);
    if($insertResult !== false) {
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
        "DM.dc_id"     =>$discussId,
        "DM.member_id" =>array("in",$newId)
      );
      $memberInfo = M("DiscussMember")
      ->alias("DM")
      ->field("DM.*,M.realname")
      ->join($memberTableName." as M on M.id=DM.member_id")
      ->where($condition)
      ->select();
      $backData = array(
        "code"  =>200,
        "msg"   =>'success',
        "data"  =>array(
          "newMember" =>$memberInfo
        )
      );
    }else {
      $backData = array(
        "code"  =>13001,
        "msg"   =>'操作失败'
      );
    }
    $this->ajaxReturn($backData);  
  }
  /**
   * delete one
   */
  public function delone(){
    if(empty($_GET['id'])) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $id = I("get.id/d");
    $delResult = M("DiscussMember")->delete($id);
    if($delResult !==false) {
      $backData = array(
        "code"  =>200,
        "msg"   =>'success'
      );
    }else {
      $backData = array(
        "code"  =>13001,
        "msg"   =>'删除失败'
      );
    }
    $this->ajaxReturn($backData);  
  }


  /**
   * 获取其他成员
   */
  public function other_member(){
    if(empty($_GET['discussid'])) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussId = I("get.discussid");
    $page = I("get.page/d",1);
    $pageSize=20;

    //获取剩余成员的条件
    $memberCondition = array(
      'status'  =>1
    );
    // 获取讨论组信息以便判断是来自课程还是项目
    $discussInfo = M("Discuss")->field('type,obj_id')->where(array('id'=>$discussId))->find();
    // 定位成员来源
    $memberTableName = '';
    if($discussInfo['type'] == 1) {
      $memberTableName = 'CourseMember';
      $memberCondition['course_id'] = $discussInfo['obj_id'];
    }else {
      $memberTableName = 'ParttimeMember';
      $memberCondition['pt_id'] = $discussInfo['obj_id'];

    }
    // 获取该对象(课程or项目)下所有的讨论组,剔除已经加入讨论组的成员
    
    $allDiscussCondition = array(
      'obj_id'=>$discussInfo['obj_id'],
      "type"  =>$discussInfo['type']
    );
    $allDiscussList = M("Discuss")->field("id")->where($allDiscussCondition)->select();
    $allDiscussId = array();
    if(count($allDiscussList)) {
      foreach($allDiscussList as $key=>$val) {
        array_push($allDiscussId,$val['id']);
      }
    }
    if(count($allDiscussId)) {
      $tempCondition = array(
        "dc_id" =>array("in",$allDiscussId)
      );
      $isDiscussMember = M("DiscussMember")->where($tempCondition)->field("member_id")->select();
      if(count($isDiscussMember)) {
        $isDiscussMemberId = array();
        foreach($isDiscussMember as $key=>$val) {
          array_push($isDiscussMemberId,$val['member_id']);
        }
        // 剔除已经加入过讨论组的成员条件
        $memberCondition['id'] = array('not in',$isDiscussMemberId);
      }
    }

    // 获取剩余的成员
    $total = M($memberTableName)->where($memberCondition)->count();
    $list = M($memberTableName)->where($memberCondition)->page($page,$pageSize)->select();
    $backData = array(
      "code"  =>200,
      "msg"   =>"success",
      "data"  =>array(
        "info"  =>array(
          "page"=>$page,
          "pageSize"  =>$pageSize,
          "total"   =>intval($total),
          "list"    =>$list
        )
      )
    );
    $this->ajaxReturn($backData);

  }

  /**
   * 设为组长
   */
  public function set_headman(){
    if(empty($_GET['discussid']) || empty($_GET['id'])) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussId = I("get.discussid");
    $id = I("get.id");
    $curModel = M("DiscussMember");
    $curModel->startTrans();
    $updateAll = $curModel->where(array("dc_id"=>$discussId))->data("type=1")->save();
    $updateOne = $curModel->where(array("id"=>$id))->data("type=2")->save();
    if($updateAll !== false && $updateOne !== false){
      $curModel->commit();
      $backData = array(
        "code"  =>200,
        "msg"   =>'success'
      );
    }else {
      $curModel->rollback();
      $backData = array(
        "code"  =>13001,
        "msg"   =>'操作失败'
      );
    }
    $this->ajaxReturn($backData);  
  }







  //==============//
 }