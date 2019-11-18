<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Platform\Controller;
use Platform\Common\Auth;
class AgentController extends Auth {
  public function vlist(){
    $mainModel = M("AgentInfo");
    $pageSize = 15;
    $page = I("get.p/d",1);
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['AI.name'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel
    ->field("AI.*,IF(AI.status=1,'正常','中止') as agent_status,AL.name as level_name")
    ->alias("AI")
    ->join("__AGENT_LEVEL__ as AL on AI.level=AL.id")
    ->where($where)
    ->page($page,$pageSize)
    ->order("AI.id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->alias("AI")->where($where)->count();
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

  // 文章分类列表
  public function catelist(){
    $model = M("AgentLevel");
    $list = $model->field("id,name")->where(array("status"=>1))->fetchSql(false)->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list
      )
    );
    $this->ajaxReturn($backData);
  }

  // 文章编辑
  public function edit(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("AgentInfo")->where(array('id'=>$id))->find();
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
        "info"      =>$info,
        "thumbList" =>$newThumbList    
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
    $mainModel = M("AgentInfo");
    $dataResult = $mainModel->create($this->requestData);
    if(!$dataResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    $mainModel->contract_start = date("Y-m-d",strtotime($mainModel->contract_start));
    $mainModel->contract_end = date("Y-m-d",strtotime($mainModel->contract_end));

    $mainModel->update_by = $this->userInfo["realname"];
    $mainModel->update_time = date("y-m-d H:i:s",time());

    if(isset($mainModel->id) && !is_null($mainModel->id)){
      $id = intval($mainModel->id);
      $result = $mainModel->where(array("id"=>$id))->fetchSql(false)->save();
    }else {
      $mainModel->create_by = $this->userInfo["realname"];
      $result = $mainModel->fetchSql(false)->add();
      $id = $result;
    }
    if($result !== false){
      // $info = $mainModel->where(array("id"=>$id))->find();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "info"      => "success"
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
/*     $result = M("Article")->fetchSql(false)->delete($id);
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
    $this->ajaxReturn($backData);   */ 
  }

  /**
   * 修改状态
   */
  public function changestatus(){
    if(empty($_GET['id'])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"
      );  
      return $this->ajaxReturn($backData);  
    }
    $id= I("get.id");
    $newStatus = I("get.status");
    $updateData = array(
      "status"  =>$newStatus
    );
    $updateResult = M("AgentInfo")->where("id=$id")->save($updateData);
    if($updateResult !== false){
      $backData = array(
        'code'      => 200,
        "msg"       => "success"
      );    
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "系统错误"
      );  
    }
    $this->ajaxReturn($backData);  
  }




  //==================//
}