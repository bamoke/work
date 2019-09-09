<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2019-08-28 13:17:56 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-08-29 15:02:34
 * 平台模块管理
 */

namespace Platform\Controller;
use Platform\Common\Auth;
class MokuaiController extends Auth {
  public function vlist(){
    // $pageSize = 15;
    $mainModel = M("PlatformModule");

    $list = $mainModel
    ->order("sort,id")
    ->fetchSql(false)
    ->select();
    $newArr = $this->iteration($list);

    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$newArr
      )
    );
    $this->ajaxReturn($backData);
  }

  // 迭代器
  protected function iteration($array,$pid=0, $level=1, $max=3){
     $newArr = array();
    if($level >= $max) {return array();}
    if(!is_array($array) || count($array) === 0 ) return array();
    foreach($array as $key=>$val){
      if($val["pid"] == $pid) {
        $children = $this->iteration($array,$val['id'],$level+1);
        $parent = array(
          "id"      =>$val["id"],
          "pid"      =>$val["pid"],
          "title"   =>$val["name"],
          "sort"   =>$val["sort"],
          "expand"  =>false,
          "status"   =>$val["status"],
          "level"   =>$level,
          "children"   =>$children
        );
        array_push($newArr,$parent);
      }
    }
    return $newArr;
  }


  // 编辑
  public function edit(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("PlatformModule")->where(array('id'=>$id))->find();
    if($info) {
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "data"      =>array(
          "info"      =>$info    
        )
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
    }
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
    $mainModel = M("PlatformModule");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    if(isset($mainModel->id) && !is_null($mainModel->id)){
      $id = intval($mainModel->id);
      $result = $mainModel->where(array("id"=>$id))->fetchSql(false)->save();
    }else {
      $result = $mainModel->fetchSql(false)->add();
      $id = $result;
    }
    if($result !== false){
      $info = $mainModel->field("*,name as title")->where(array("id"=>$id))->find();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "data"      =>array(
          "info"      => $info
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
    $result = M("PlatformModule")->fetchSql(false)->delete($id);
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