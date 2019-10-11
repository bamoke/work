<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 * 服务商账号管理
 */
namespace Agent\Controller;
use Agent\Common\Auth;
class CustomerAccountController extends Auth {
  public function vlist(){
    if(empty($_GET['orgid'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $orgId = I("get.orgid");
    $orgInfo = M("OrgInfo")
    ->field("id,title,IF(contract_end < CURRENT_DATE,1,0) as isExpired")
    ->where("id=$orgId")
    ->find();
    $mainModel = M("OrgAdmin");
    $pageSize = 15;
    $page = I("get.p/d",1);
    $where = array(
      "is_delete" =>0,
      "org_id"    =>$orgId
    );
    if(!empty($_GET['keywords'])){
      $where['username'] = array("like","%".I("get.keywords")."%");
    }
    $list = $mainModel
    ->field("id,username,superadmin,create_time,status")
    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();

    $pageInfo = array(
      "page"  =>$page,
      "total" =>intval($total),
      "pageSize"  =>$pageSize
    );
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "orgInfo" =>$orgInfo,
          "list"  =>$list,
          "pageInfo"  =>$pageInfo
      )
    );
    $this->ajaxReturn($backData);
  }

  /***
   * 修改status
   */
  public function forbid(){
    if(empty($_GET['id']) && !isset($_GET["status"])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $model = M("OrgAdmin");
    $where = array(
      "id"  =>I("get.id")
    );
    $updateData = array(
      "status"  =>I("get.status")
    );

    $updateResult = $model->where($where)->data($updateData)->fetchSql(false)->save();
    if(!$updateResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "操作失败"
      );
      $this->ajaxReturn($backData);
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
    );
    $this->ajaxReturn($backData);
  }


   /***
   * 伪删除
   */
  public function deleteone(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $model = M("OrgAdmin");
    $where = array(
      "id"  =>I("get.id")
    );
    $updateData = array(
      "is_delete"  =>1
    );

    $updateResult = $model->where($where)->data($updateData)->fetchSql(false)->save();
    if(!$updateResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "操作失败"
      );
      $this->ajaxReturn($backData);
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
    );
    $this->ajaxReturn($backData);
  }


  /***
   * 重置密码
   */
  public function reset(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $strs="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
    $newPassword=substr(str_shuffle($strs),mt_rand(0,strlen($strs)-9),8);
    $model = M("OrgAdmin");
    $where = array(
      "id"  =>I("get.id")
    );
    $updateData = array(
      "password"  =>md5($newPassword)
    );

    $updateResult = $model->where($where)->data($updateData)->fetchSql(false)->save();
    if(!$updateResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "操作失败"
      );
      $this->ajaxReturn($backData);
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      "data"      =>array("info"=>$newPassword)
    );
    $this->ajaxReturn($backData);
  }



  // 数据保存
  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $requestData = $this->requestData;
    $orgId = $requestData['org_id'];
    $mainModel = M("OrgAdmin");

    // 查看是否已经到期
    $contracEndDate = M("OrgInfo")->where(array("id"=>$orgId))->fetchSql(false)->getField("contract_end");
 
    if(strtotime($contracEndDate) < time()) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "服务已到期，请先续费",        
      );  
      $this->ajaxReturn($backData); 
    }

 

    // 查找是否存在用户名
    $hasCondition = array(
      "username"  =>$requestData["username"]
    );
    $hasUser = $mainModel->where($hasCondition)->count();
    if($hasUser > 0) {
      $backData = array(
        'code'      => 13002,
        "msg"       => "用户名已存在",        
      );  
      $this->ajaxReturn($backData);   
    }

    // 检测密码
    if($requestData["password"] == '') {
      $backData = array(
        'code'      => 13002,
        "msg"       => "密码不能为空",        
      );  
      $this->ajaxReturn($backData);   
    }



    $dataResult = $mainModel->create($requestData);
    if(!$dataResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }



    $mainModel->superadmin = 1;
    $mainModel->password = md5($mainModel->password);
    $mainModel->agent_id = $this->userInfo["agent_id"];

    $insertId = $mainModel->fetchSql(false)->add();
    if($insertId){
      $info = $mainModel->where(array("id"=>$insertId))->find();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "data"      => array(
          "info"  =>$info
        )
      );
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "服务器错误",        
      );     
    }
    $this->ajaxReturn($backData);
  }








  //==================//
}