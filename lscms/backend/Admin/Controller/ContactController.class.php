<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-12 12:38:00 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-11-29 10:59:37
 */
namespace Admin\Controller;
use Admin\Common\Auth;
 class ContactController extends Auth {

  public function vlist(){
    $pageSize = 15;
    $mainModel = M("Contact");
    $page = empty($_GET["p"]) ? 1 : (int)$_GET["p"];
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['title'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel->field("id,name,tel,phone,email,status,create_time")->where($where)->page($page,$pageSize)->fetchSql(false)->select();
    $total = $mainModel->where($where)->count();
    $pageInfo = array(
      "total" =>intval($total),
      "page"  =>$page,
      "pageSize"  =>$pageSize
    );
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "pageInfo" =>$pageInfo
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 
   */
  public function edit(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 13000,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = I("get.id/d");
    $info = M("Contact")->find($id);
    $thumbList = explode(";",$info['avatar']);
    $newThumbList = array();
    if(count($thumbList)) {
      foreach($thumbList as $key=>$val){
        if($val) {
          $temp = array(
            "name"  =>$val,
            "url"   =>__ROOT__."/Uploads/images/".$val
          );
          array_push($newThumbList,$temp);
        }
      }
    }
    $backData = array(
      "code"  =>200,
      "msg"   =>"ok",
      "data"  =>array(
        "info"  =>$info,
        "avatarList" =>$newThumbList
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
      $mainModel = M("Contact");
      $postData = $this->requestData;
      $data = array(
        "name"  =>$postData["name"],
        "tel" => $postData["tel"],
        "phone"   =>$postData["phone"],
        "email"    =>$postData["email"],
        "avatar" =>$postData["avatar"],
        "status"  =>$postData["status"]
      );
      if(isset($postData["id"])){
        $id = (int)$postData["id"];
        $result = $mainModel->where(array("id"=>$id))->data($data)->save();
      }else {
 
        $result = $mainModel->data($data)->add();
        $id = $result;
      }
      if($result !== false){
        $backData = array(
          'code'      => 200,
          "msg"       => "Success",
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
    $mainModel = M("Contact");
    $id = I("get.id/d");
    $info = $mainModel->find($id);
    $deleteResult = $mainModel->delete($id);
    if($deleteResult !== false) {
      $avatar = ROOT_DIR."/Uploads/images/".$info['avatar'];
      @unlink($avatar);
      $backData = array(
        'code'      => 200,
        "msg"       => "ok"    
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "服务器错误"    
      );
    }
    $this->ajaxReturn($backData);    
  }
  

 }

