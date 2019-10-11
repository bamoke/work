<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-10-08 13:40:37
 */
namespace Agent\Controller;
use Agent\Common\Auth;
class AccountController extends Auth {
  public function index(){
    $adminInfo = $this->userInfo;
    $agentCondition = array(
      "I.id"  =>$adminInfo['agent_id']
    );
    $agentInfo = M("AgentInfo")
    ->alias("I")
    ->field("L.name as catename,I.id,I.name,I.agent_area,I.create_time,I.contract_start,I.contract_end")
    ->join("__AGENT_LEVEL__ as L on L.id= I.level")
    ->where($agentCondition)
    ->fetchSql(false)
    ->find();

    $accountCondition = array(
      "id"  =>$adminInfo['id']
    );
    $accountInfo = M("AgentAdmin")
    ->field("id,username,create_time")
    ->where($accountCondition)
    ->find();

    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "agent"  =>$agentInfo,
          "account"  =>$accountInfo
      )
    );
    $this->ajaxReturn($backData);
  }









  //==================//
}