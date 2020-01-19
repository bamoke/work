<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-12 12:38:00 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-11-29 11:01:58
 */
namespace Admin\Controller;
use Admin\Common\Auth;
 class ServiceController extends Auth {

  public function vlist(){
    $pageSize = 15;
    $mainModel = M("Service");
    $page = empty($_GET["p"]) ? 1 : (int)$_GET["p"];
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['title'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel->field("id,title,description,status,create_time")->where($where)->page($page,$pageSize)->fetchSql(false)->select();
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
    $info = M("Service")->find($id);
    $thumbList = explode(";",$info['thumb']);
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
    $iconList = explode(";",$info['icon']);
    $newIconList = array();
    if(count($iconList)) {
      foreach($iconList as $key=>$val){
        if($val) {
          $temp = array(
            "name"  =>$val,
            "url"   =>__ROOT__."/Uploads/images/".$val
          );
          array_push($newIconList,$temp);
        }
      }
    }
    $backData = array(
      "code"  =>200,
      "msg"   =>"ok",
      "data"  =>array(
        "info"  =>$info,
        "thumbList" =>$newThumbList,
        "iconList"  =>$newIconList
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
      $mainModel = M("Service");
      $postData = $this->requestData;
      $data = array(
        "title"  =>$postData["title"],
        "description" => $postData["description"],
        "thumb"   =>$postData["thumb"],
        "icon"    =>$postData["icon"],
        "content" =>$postData["content"],
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
    $mainModel = M("Service");
    $id = I("get.id/d");
    $info = $mainModel->find($id);
    $deleteResult = $mainModel->delete($id);
    if($deleteResult !== false) {
      $thumb = ROOT_DIR."/Uploads/images/".$info['thumb'];
      $icon = ROOT_DIR."/Uploads/images/".$info['icon'];
      @unlink($thumb);
      @unlink($icon);
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

