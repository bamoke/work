<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-10 20:05:00 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 00:52:03
 */

namespace Admin\Controller;
use Admin\Common\Auth;
 class DiscussController extends Auth {

    /**
     * 获取班级动态
     */
    public function vlist(){
      if(empty($_GET["type"]) || empty($_GET['objid'])){
        $backData = array(
          'code'      => 13000,
          "msg"       => "非法请求"    
        );
        $this->ajaxReturn($backData);     
      }
      $type = I("get.type");
      $objId = I("get.objid");
      $page = I("get.page/d",1);
      $pageSize=20;
      $condition = array(
        "type"    =>$type,
        "obj_id"  =>$objId
      );
      if(!empty($_GET['keywords'])){
        $condition["title"] = array("like","%".I('get.keywords')."%");
      }
      $total = M("Discuss")->where($condition)->count();
      $list = M("Discuss")
      ->where($condition)
      ->page($page,$pageSize)
      ->fetchSql(false)
      ->order('id desc')
      ->select();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        'data'      => array(
            "list"  =>$list,
            "total" =>intval($total),
            "page"  =>$page,
            "pageSize"  =>$pageSize,
            "hasMore" =>$total > $page*$pageSize
        )
      );
      $this->ajaxReturn($backData);
    }

  /**
   * do add
   */
  public function doadd(){
    if(!IS_POST) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussModel = M("Discuss");
    $postData = $this->requestData;
    $insertData = array(
      "type"      =>$postData['type'],
      "obj_id"    =>$postData['objid'],
      "title"     =>$postData['title'],
      "status"     =>$postData['status'],
      "stage"     =>$postData['stage'],
    );
    $insertResult = $discussModel->data($insertData)->add();
    if(!$insertResult) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "数据保存错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussInfo = $discussModel->where(array("id"=>$insertResult))->find();
    $backData = array(
      "code"  => 200,
      "msg"   => "success",
      "data"  =>array(
        "info"  =>$discussInfo
      )
    );  
    $this->ajaxReturn($backData); 
  }

   /**
   * handle update
   */

  public function update(){
    if(!IS_POST) {
      $backData = array(
        "code"  => 10002,
        "msg"   => "非法请求"
      );  
      $this->ajaxReturn($backData); 
    }
    $postData = $this->requestData;
    $dicussId = $postData['id'];
    $updateData = array(
      "title"  =>$postData['title'],
      "status"      =>$postData['status'],
      "stage"      =>$postData['stage']
    );
    $mainModel = M("Discuss");
    $condition = array(
      "id"  =>$dicussId
    );
    $updateResult = $mainModel->where($condition)->data($updateData)->fetchSql(false)->save();
    if($updateResult === false) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "数据保存错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussInfo = $mainModel->where($condition)->find();
    $backData = array(
      "code"  => 200,
      "msg"   => "success",
      "data"  =>array(
        "info"  =>$discussInfo
      )
    );  
    $this->ajaxReturn($backData); 
  }

  /**
   * delelte
   */
  public function delone(){
    if(empty($_GET['id'])) {
      $backData = array(
        "code"  => 10001,
        "msg"   => "参数错误"
      );  
      $this->ajaxReturn($backData); 
    }
    $discussId = I("get.id");
    $mainModel = M("Discuss");
    $discussInfo = $mainModel->where(array('id'=>$discussId))->find();
    if($discussInfo['stage'] != 0) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "已经开始后的不能删除"
      );  
      $this->ajaxReturn($backData);  
    }

    $delResult = $mainModel->delete($discussId);
    if($delResult === false) {
      $backData = array(
        "code"  => 13001,
        "msg"   => "删除失败"
      );  
      $this->ajaxReturn($backData);  
    }
    $backData = array(
      "code"  => 200,
      "msg"   => "success"
    );  
    $this->ajaxReturn($backData);  
  }











  //==============//
 }