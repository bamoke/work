<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 * 企业管理
 */
namespace Home\Controller;

use Home\Common\Auth;

class IntroducerController extends Auth {
  public function vlist(){
    $mainModel = M("Introducer");
    $pageSize = 15;
    $page = I("get.page/d",1);
    $where = array(
      "is_deleted" =>0
    );

    if(!empty($_GET['keyword'])){
      $where['name'] = array("like","%".I("get.keyword")."%");
    }

    $list = $mainModel
    ->where($where)
    ->page($page,$pageSize)
    ->order("id asc")
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
          "list"  =>$list,
          "pageInfo"  =>$pageInfo
      )
    );
    $this->ajaxReturn($backData);
  }

  /**
   * 
   */
  public function all_list(){
    $mainModel = M("Introducer");
    $where = array(
      "is_deleted" =>0
    );

    if(!empty($_GET['keyword'])){
      $where['name'] = array("like","%".I("get.keyword")."%");
    }

    $list = $mainModel
    ->field("id,name")
    ->where($where)
    ->limit('1000')
    ->order("id asc")
    ->fetchSql(false)
    ->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list
      )
    );
    $this->ajaxReturn($backData);
  }

  public function info($id){
    $model = M('Introducer');
    $result = $model
    ->field("*")
    ->where("id = $id")
    ->find();
    $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        'data'      => array(
            "info"  =>$result
        )
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
    $model = M("Introducer");
    $where = array(
      "id"  =>I("get.id")
    );
    $updateData = array(
      "is_deleted"  =>1,
      "update_time" =>date("Y-m-d H:i:s",time()),
      "update_by" =>$this->uid
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

    $mainModel = M("Introducer");

    $dataResult = $mainModel->create($requestData);
    if(!$dataResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    if(isset($mainModel->id)){
      // update
      $curId = $mainModel->id;
      $mainModel->update_time = date("Y-m-d H:i:s",time());
      $mainModel->update_by = $this->uid;
      $saveResult = $mainModel->save();

    }else {

      // Insert
      $mainModel->create_by = $this->uid;
      $saveResult = $mainModel->add();
      $curId = $saveResult;
    }
    if($saveResult === false) {
      $backData = array(
        'code'      => 13002,
        "msg"       => "服务器错误",        
      ); 
      $this->ajaxReturn($backData);
    }

    $info = $mainModel
    ->where(array("id"=>$curId))
    ->find();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      "data"      => array(
        "info"  =>$info
      )
    );
    $this->ajaxReturn($backData);
  }








  //==================//
}