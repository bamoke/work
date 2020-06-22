<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-10-08 13:40:37
 */
namespace Organization\Controller;
use Organization\Common\Auth;
class MembersController extends Auth {
  public function vlist(){

    // 请求参数
    $dpid = I("get.dpid/d",0);//部门id
    
    // 用户基础信息
    $adminInfo = $this->userInfo;

    // 获取所有部门信息
    $departmentCondition = array(
      "org_id"  =>$adminInfo["org_id"]
    );
    $departmentList = M("OrgDepartment")->where($departmentCondition)->select();
    $department = array();
    foreach ($departmentList as $key=>$val) {
      if($val["pid"] == 0) {
        $tempArr = array(
          "id"  =>$val["id"],
          "pid" =>$val["pid"],
          "name"  =>$val["title"],
          "child" =>array()
        );
        foreach($departmentList as $k=>$v){
          if($v["pid"] == $val["id"]) {
            $tempArr["child"][] = array(
              "id"  =>$v["id"],
              "pid" =>$v["pid"],
              "name"  =>$v["title"]
            );
          }
        }
        array_push($department,$tempArr);
      }
    }


    // 用户列表
    
    $pageSize = 15;
    $page = I("get.p/d",1);

    $accountCondition = array(
      "A.org_id"  =>$adminInfo['org_id']
    );
    if(!empty($dpid)) {
      $accountCondition["A.department"] = $dpid;
    }
    $total = M("OrgAdmin")->alias("A")->where($accountCondition)->count();

    $memberList = M("OrgAdmin")
    ->alias("A")
    ->field("A.*,IF(A.department =0,'未分配部门',D.title) as department_name")
    ->join("LEFT JOIN __ORG_DEPARTMENT__ as D on A.department = D.id")
    ->where($accountCondition) 
    ->fetchSql(false)
    ->select();

    $pageInfo = array(
      "total"   =>intval($total),
      "pageSize"  =>$pageSize,
      "page"    =>$page
    );
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "members"        =>$memberList,
          "pageInfo"    =>$pageInfo,
          "department"  =>$department
      )
    );
    $this->ajaxReturn($backData);
  }


  public function do_add (){
      // 用户基础信息
      $adminInfo = $this->userInfo;
      $insertData = $this->requestData;
      $model = M("OrgAdmin");
      // 验证登录账号
      $accountConditon = array(
        // "org_id"     =>$adminInfo["org_id"],
        "username"   =>$insertData["username"]
      );
      $accountExist = $model->where($accountConditon)->count();
      if($accountExist > 0) {
        $backData = array(
          'code'      => 13001,
          "msg"       => "用户登录名已存在"    
        );
        $this->ajaxReturn($backData);   
      }

      // 验证手机号是否存在
      $accountConditon = array(
        // "org_id"  =>$adminInfo["org_id"],
        "phone"   =>$insertData["phone"]
      );
      $phoneExist = $model->where($accountConditon)->count();
      if($accountExist > 0) {
        $backData = array(
          'code'      => 13001,
          "msg"       => "手机号已经存在"    
        );
        $this->ajaxReturn($backData);   
      }
      $insertData["org_id"] = $adminInfo["org_id"];
      $insertData["password"] = md5($insertId["password"]);
      //

      $insertId = $model->data($insertData)->fetchSql(false)->add();
    
      if(!$insertId) {
        $backData = array(
          'code'      => 13001,
          "msg"       => "系统错误"    
        );
        $this->ajaxReturn($backData);  
      }

      $memberInfo = $model
      ->alias("A")
      ->field("A.*,IF(A.department =0,'未分配部门',D.title) as department_name")
      ->join("LEFT JOIN __ORG_DEPARTMENT__ as D on A.department = D.id")
      ->where("A.id=$insertId")
      ->find();
      $backData = array(
        'code'      => 200,
        "msg"       => "添加成功",
        'data'      => array(
            "info"        =>$memberInfo,

        )
      );
      $this->ajaxReturn($backData);
  }

  /**
   * 更新用户
   */
  public function do_modify(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);        
    }
    $model = M("OrgAdmin");
    $updateData = $this->requestData;
    $curId = $updateData["id"];
    if($updateData["role_id"]) {
      $updateData["role_id"] = implode(",",$updateData['cur_role']);
    }
    $updateResult = $model
    ->where("id = $curId")
    ->data($updateData)
    ->fetchSql(false)
    ->save();
    if($updateResult !== false) {
      $memberInfo = $model
      ->alias("A")
      ->field("A.*,IF(A.department =0,'未分配部门',D.title) as department_name")
      ->join("LEFT JOIN __ORG_DEPARTMENT__ as D on A.department = D.id")
      ->where("A.id=$curId")
      ->find();

      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        'data'      => array(
            "memberInfo"        =>$memberInfo,
  
        )
      );
      $this->ajaxReturn($backData);
    }

  }
  /**
   * 获取用户数据
   */
  public function edit(){
    $memberId = I("get.id/d"); 
    if(empty($memberId)) {
      $backData = array(
        'code'      => 10002,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);   
    }

    // 用户数据
    $memberInfo = M("OrgAdmin")
    ->field("id,org_id,realname,phone,department,role_id,work_no")
    ->fetchSql(false)
    ->find($memberId);
    $curRoleList = explode(",",$memberInfo['role_id']);
    
    // foreach($curRoleList as $k=>$v) {
    //   $curRoleList[$k] = intval($v);
    // }
    $memberInfo["cur_role"] = $curRoleList;
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      'data'      => array(
          "memberInfo"        =>$memberInfo,

      )
    );
    $this->ajaxReturn($backData);
  }


  /**
   * 
   */
  public function fetch_role () {
    // 角色列表
    $adminInfo = $this->userInfo;
    $roleCondition = array(
      "org_id"  =>$adminInfo['org_id'],
      "pid"     => array('neq',0) //暂时先取消分组
    );
    $roleInfo = M("OrgRole")
    ->where($roleCondition)
    ->fetchSql(false)
    ->select();

        // 角色列表格式化.暂时未作分组
    /*$roleList =array();
    foreach ($roleInfo as $key=>$val) {
      if($val["pid"] == 0) {
        $tempArr = array(
          "id"  =>$val["id"],
          "pid" =>$val["pid"],
          "title"  =>$val["title"],
          "child" =>array()
        );
        foreach($roleInfo as $k=>$v){
          if($v["pid"] == $val["id"]) {
            $tempArr["child"][] = array(
              "id"  =>$v["id"],
              "pid" =>$v["pid"],
              "title"  =>$v["title"]
            );
          }
        }
        array_push($roleList,$tempArr);
      }
    }*/

    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      'data'      => array(
          "roleList"  =>$roleInfo

      )
    );
    $this->ajaxReturn($backData);
  }





  //==================//
}