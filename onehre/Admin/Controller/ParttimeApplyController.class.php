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
      foreach($list as $key=>$val){
        $list[$key]['statusClass'] = $this->statusInfo[$val['status']]['className'];
        $list[$key]['statusName'] = $this->statusInfo[$val['status']]['name'];
      }
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "total" =>intval($total),
          "pageSize"  =>$pageSize
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
        "className"=>'s-text-light-grey'
      )
    );
  } 

  // 申请审核
  public function check(){
    if(empty($_GET['id']) || empty($_GET['status'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);   
    }
    $condition = array(
      "id"  =>I("get.id")
    );
    $updateData = array(
      "status"  =>I("get.status")
    );
    $result = M("ParttimeApply")->where($condition)->save($updateData);
    if($result !== false) {
      $backData = array(
        'code'      => 200,
        "msg"       => "ok"    
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "操作失败"    
      );
    }
    $this->ajaxReturn($backData);
  }




  
  






  //==================//
}