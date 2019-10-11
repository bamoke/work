<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-10-08 13:40:37
 */
namespace Organization\Controller;
use Organization\Common\Auth;
class AccountController extends Auth {
  public function index(){
    $adminInfo = $this->userInfo;
    $condition = array(
      "id"  =>$adminInfo['org_id']
    );
    $orgInfo = M("OrgInfo")
    ->field("id,contract_start,contract_end,type,title,create_time")
    ->where($condition)
    ->fetchSql(false)
    ->find();

    $typeTxt = array("","财务机构","集团企业","个人代理");
    $orgInfo["typename"] = $typeTxt[$orgInfo['type']];
    $accountCondition = array(
      "id"  =>$adminInfo['id']
    );
    $accountInfo = M("OrgAdmin")
    ->field("id,username,create_time")
    ->where($accountCondition)
    ->find();

    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "org"  =>$orgInfo,
          "account"  =>$accountInfo
      )
    );
    $this->ajaxReturn($backData);
  }









  //==================//
}