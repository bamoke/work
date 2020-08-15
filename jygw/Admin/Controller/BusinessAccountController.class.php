<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class BusinessAccountController extends Auth {
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 15;
    $mainModel = M("BusinessUser");
    $where = array(
      "b_id"  =>I("get.bid")
    );
    
    $list = $mainModel
    ->field("*")
    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();


    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "pageInfo"  =>array(
            "total"   =>intval($total),
            "page"    =>$page,
            "pageSize"  =>$pageSize
          )
      )
    );
    $this->ajaxReturn($backData);
  }



  // 商家账号详情
  public function detail(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("BusinessUser")
    ->field("id,b_id,username,realname,status,create_time")
    ->where(array('id'=>$id))
    ->fetchSql(false)
    ->find();
    if(!$info) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
      $this->ajaxReturn($backData);
    }

    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "info"      =>$info 
      )
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
    $mainModel = M("BusinessUser");
    $requestData = $this->requestData;
    if(!$mainModel->create($this->requestData)) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }


    if(isset($mainModel->id) && !is_null($mainModel->id)){
      // 如果有提交新密码
      if($requestData['newpassword']) {
        $mainModel->password = md5($requestData['newpassword']);
      }
      $id = intval($mainModel->id);
      $result = $mainModel->where(array("id"=>$id))->fetchSql(false)->save();
    }else {
      // 检测两次密码是否一致
      if($requestData["password"] != $requestData["rpassword"]){
        $backData = array(
          'code'      => 13002,
          "msg"       => "两次密码不一致"    
        );
        $this->ajaxReturn($backData);  
      }
      // 新增检测用户名是否存在
      $existUsername = M("BusinessUser")->where(array("username"=>$mainModel->username))->count();
      if($existUsername) {
        $backData = array(
          'code'      => 13004,
          "msg"       => "用户名已存在"    
        );
        $this->ajaxReturn($backData);  
      }

      $mainModel->password = md5($mainModel->password);
      $result = $mainModel->fetchSql(false)->add();
      $id = $result;
    }
    if($result !== false){
      $info = $mainModel->where(array("id"=>$id))->find();
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


  public function deleteone(){
    if(empty($_GET['id'])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"
      );  
      return $this->ajaxReturn($backData);  
    }
    $id= I("get.id");
    $result = M("Welfare")->fetchSql(false)->delete($id);
    if($result !== false){
      $backData = array(
        'code'      => 200,
        "msg"       => "success"
      );    
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "删除失败"
      );  
    }
    $this->ajaxReturn($backData);   
  }




  //==================//
}