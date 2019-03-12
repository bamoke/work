<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-12 12:38:00 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-08-13 00:21:33
 */
namespace Admin\Controller;
use Admin\Common\Auth;
 class GroupsController extends Auth {

  public function vlist(){
    $pageSize = 15;
    $mainModel = M("Groups");
    $page = empty($_GET["p"]) ? 1 : (int)$_GET["p"];
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['name'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel->field("id,name,description,create_time")->where($where)->page($page,$pageSize)->fetchSql(false)->select();
    $total = $mainModel->where($where)->count();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'info'      => array(
          "list"  =>$list,
          "total" =>intval($total),
          "pageSize"  =>$pageSize
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * save
   */
  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 13000,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }else {
      $mainModel = M("Groups");
      $postData = $this->requestData;
      $data = array(
        "name"  =>$postData["name"],
        "description" => htmlspecialchars($postData["description"])
      );
      if(isset($postData["id"])){
        $id = (int)$postData["id"];
        $result = $mainModel->where(array("id"=>$id))->data($data)->save();
      }else {
        $result = $mainModel->data($data)->add();
        $id = $result;
      }
      if($result !== false){
        $info = $mainModel->field("id,name,description,create_time")->where(array("id"=>$id))->find();
        $backData = array(
          'code'      => 200,
          "msg"       => "ok",
          'info'      => $info
        );
      }else {
        $backData = array(
          'code'      => 13001,
          "msg"       => "服务器错误",        
        );     
      }
      $this->ajaxReturn($backData);
    }
  }

  /**
   * delete one data
   */
  public function deleteone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 13000,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = (int)$_GET["id"];
    $userhasTotal = M("User")->where(array("group_id"=>$id))->count();
    if($userhasTotal > 0 ){
      $backData = array(
        'code'      => 13002,
        "msg"       => "有用户关联此用户组，无法删除"    
      );
      $this->ajaxReturn($backData);          
    }

    $delete = M("Groups")->delete($id);
    $backData = array(
      'code'      => 200,
      "msg"       => "ok"    
    );
    $this->ajaxReturn($backData);    
  }
  

 }

