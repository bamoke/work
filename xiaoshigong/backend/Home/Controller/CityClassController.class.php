<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 * 企业管理
 */
namespace Home\Controller;

use Home\Common\Auth;

class CityClassController extends Auth {
  public function vlist(){
    $mainModel = M("CityClass");
    
    $where = array(
      "parentid"  =>2
    );

    $list = $mainModel
    ->where($where)
    ->order("id asc")
    ->fetchSql(false)
    ->select();

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