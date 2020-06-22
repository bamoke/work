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
    // 获取机构信息
    // $condition = array(
    //   "id"  =>$adminInfo['org_id']
    // );
    // $orgInfo = M("OrgInfo")
    // ->field("id,contract_start,contract_end,type,title,create_time")
    // ->where($condition)
    // ->fetchSql(false)
    // ->find();

    // $typeTxt = array("","财务机构","集团企业","个人代理");
    // $orgInfo["typename"] = $typeTxt[$orgInfo['type']];

    // 用户列表
    
    $pageSize = 15;
    $page = I("get.p/d",1);

    $accountCondition = array(
      "org_id"  =>$adminInfo['org_id']
    );
    $total = M("OrgAdmin")->where($accountCondition)->count();

    $accountInfo = M("OrgAdmin")
    ->alias("A")
    ->field("A.*,IF(A.department ==0,'未分配部门',D.title)")
    ->join("LEFT JOIN __ORG_DEPARTment_ as D on A.department = D.id")
    ->where($accountCondition)
    ->fetchSql(true)
    ->select();
    var_dump($total);
    exit();
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