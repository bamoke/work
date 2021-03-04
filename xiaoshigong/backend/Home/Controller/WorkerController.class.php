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

class WorkerController extends Auth {
  public function vlist(){
    $mainModel = M("Worker");
    $pageSize = 15;
    $page = I("get.page/d",1);
    $where = array(
      "is_deleted" =>0
    );

    if(!empty($_GET['keyword'])){
      $where['name'] = array("like","%".I("get.keyword")."%");
    }
    if(isset($_GET['d_status'])) {
      $where["dispatch_status"] = I("get.d_status");
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

  public function info($id){
    $model = M('Worker');
    $result = $model
    ->field("*")
    ->where("id = $id")
    ->find();

    $itemWhere = array(
      "wid" =>$id
    );
    $workList = M("WorkerWork")
    ->where($itemWhere)
    ->select();
    $familyList = M("WorkerFamily")
    ->where($itemWhere)
    ->select();
    $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        'data'      => array(
            "info"  =>$result,
            "workList"  =>$workList,
            "familyList"  =>$familyList
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
    $model = M("Worker");
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

  /***
   * 单项删除
   */
  public function delete_item(){
    if(empty($_GET['id']) || empty($_GET["table"])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $tableName = "Worker".ucfirst(I("get.table"));

    $mainModel = M($tableName);
    $where = array(
      "id"  =>I("get.id")
    );


    $result = $mainModel->where($where)->delete();
    if($result === false) {
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




  // 资料基本信息
  public function save_base(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $requestData = $this->requestData;

    $mainModel = M("Worker");

    $dataResult = $mainModel->create($requestData);
    if(!$dataResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }
    // 时间转换
    $mainModel->birth = date_format(date_create($mainModel->birth),"Y-m-d");
    if(!empty($mainModel->graduation)){
      $mainModel->graduation = date_format(date_create($mainModel->graduation),"Y-m-d");
    }else {
      $mainModel->graduation = null;
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
      $saveResult = $mainModel->fetchSql(false)->add();
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


  public function save_item (){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $requestData = $this->requestData;
    $tableName = "Worker".ucfirst($requestData['table']);

    $mainModel = M($tableName);
    $dataResult = $mainModel->create($requestData);
    if(!$dataResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

   // 时间转换
   if($requestData["table"] == "work" ) {
     $mainModel->start_date = $requestData["start_date"] ?date_format(date_create($requestData["start_date"]),"Y-m-d") : null;
     $mainModel->end_date = $requestData["end_date"] ?date_format(date_create($requestData["end_date"]),"Y-m-d") : null;
   }
    if(isset($mainModel->id)){
      // update
      $curId = $mainModel->id;
      $saveResult = $mainModel->save();

    }else {

      // Insert
      $saveResult = $mainModel->fetchSql(false)->add();
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