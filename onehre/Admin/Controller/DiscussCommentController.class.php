<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-10 20:05:00 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 00:52:03
 */

namespace Admin\Controller;
use Admin\Common\Auth;
 class DiscussCommentController extends Auth {

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
    if(empty($_GET['discussid']) || empty($_GET['contentid'])) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussId = I("get.discussid");
    $contentId = I('get.contentid');
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
      "DC.content_id"=>$contentId
    );
    $total = M("DiscussComment")->alias("DC")->where($condition)->fetchSql(false)->count();
    $list = M("DiscussComment")
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
        "comment"  =>array(
          "page"  =>intval($page),
          "pageSize"  =>$pageSize,
          "total"   =>intval($total),
          "list"    =>$list
        )
      )
    );  
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
    $delResult = M("DiscussComment")->delete($id);
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










  //==============//
 }