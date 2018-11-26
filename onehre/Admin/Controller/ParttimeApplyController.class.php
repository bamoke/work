<?php 
/*
 * 兼职项目成员
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 23:42:10
 */
namespace Admin\Controller;
use Admin\Common\Auth;
// use Think\Controller;


class ParttimeApplyController extends Auth {
  public function vlist(){
    if(empty($_GET["ptid"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $mainModel = M("ParttimeApply");
    $ptid = I("get.ptid");
    $condition = array(
      "PA.pt_id" =>$ptid
    );
    $page = I("get.p",1);
    $pageSize= 20;
    $list = $mainModel
    ->alias("PA")
    ->field("PA.*,R.realname,R.phone,R.email")
    ->join("__RESUME__ as R on R.id = PA.resume_id")
    ->where($condition)
    ->page($page,$pageSize)
    ->order("PA.id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->alias("PA")->where($condition)->count();
    if($list === false) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "系统错误"    
      );
      $this->ajaxReturn($backData);   
    }

    if(count($list)) {
      $statusInfoArr = $this->statusInfo();
      foreach($list as $key=>$val){
        $list[$key]['statusClass'] = $statusInfoArr[$val['status']]['className'];
        $list[$key]['statusName'] = $statusInfoArr[$val['status']]['name'];
      }
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "total" =>intval($total),
          "pageSize"  =>$pageSize,
          "page"    =>$page
      )
    );
    $this->ajaxReturn($backData);
  }

  protected function statusInfo(){
    return array(
      array(
        "name"=>"待审核",
        "className"=>''
      ),
      array(
        "name"=>"审核中",
        "className"=>'s-text-info'
      ),
      array(
        "name"=>"通过",
        "className"=>'s-text-success'
      ),
      array(
        "name"=>"不通过",
        "className"=>'s-text-error'
      )
    );
  } 

  // 申请审核
  public function verify(){
    if(empty($_GET['id']) || !isset($_GET['status'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);   
    }
    if($_SERVER['REQUEST_METHOD'] != 'GET') return;
    $applyId = I("get.id");
    $status = I("get.status");
    $condition = array(
      "id"  =>I("get.id")
    );
    $updateData = array(
      "status"  =>I("get.status")
    );

    // 开启事务
    $model = M();
    $model->startTrans();
    $result = M("ParttimeApply")->where($condition)->fetchSql(false)->save($updateData);
    $applyInfo = M("ParttimeApply")->where(array('id'=>$applyId))->find();

    $userInfo = M('Resume')
    ->field('realname,phone,uid,email')
    ->where(array('id'=>$applyInfo['resume_id']))
    ->find();
    $insertMemberResult = true;
    // 审核通过，将用户加入到项目成员中
    if($status == 2) {
      $insertMemberData = array(
        "pt_id"     =>$applyInfo['pt_id'],
        "uid"       =>$userInfo['uid'],
        "realname"  =>$userInfo['realname'],
        "phone"     =>$userInfo['phone']
      );
      $insertMemberResult = M("ParttimeMember")->data($insertMemberData)->add();
    }
    if($result !== false && $insertMemberResult ) {
      $model->commit();
      // 返回修改的投递记录
      $statusInfoArr = $this->statusInfo();
      $applyInfo['statusName'] = $statusInfoArr[$applyInfo['status']]['name'];
      $applyInfo['statusClass'] = $statusInfoArr[$applyInfo['status']]['className'];
      $applyInfo['realname'] = $userInfo['realname'];
      $applyInfo['phone'] = $userInfo['phone'];
      $applyInfo['email'] = $userInfo['email'];
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "data"      =>array(
          "info"    =>$applyInfo
        )    
      );
    }else {
      $model->rollback();
      $backData = array(
        'code'      => 13001,
        "msg"       => "操作失败"    
      );
    }
    $this->ajaxReturn($backData);
  }




  
  






  //==================//
}