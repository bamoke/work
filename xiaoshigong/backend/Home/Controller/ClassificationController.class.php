<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 * 企业管理
 */
namespace Home\Controller;

use Think\Controller;

class ClassificationController extends Controller {
  
  protected function get_list($pid){
    $where = array(
      "parentid"  =>$pid
    );
    $list = M("Classification")
    ->where($where)
    ->order("id asc")
    ->fetchSql(false)
    ->select();
    return $list;
  }
  /**
   * 民族
   */

  public function get_nation(){
    $list = $this->get_list(205);
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * resume edu
   */
  public function get_edu(){
    $list = $this->get_list(197);
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * job type
   */
  public function get_jobtype(){
    $list = $this->get_list(193);
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list
      )
    );
    $this->ajaxReturn($backData);
  }









  //==================//
}