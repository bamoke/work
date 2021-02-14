<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class AdviserUserController extends Auth {
  public function index(){
    $pageSize = 15;
    $mainModel = M("AdviserUser");
    $page = I("get.page/d",1);
    $where = array();
    if(!empty($_GET['cateid'])) {
      $where["special"] = I("get.cateid");
    }
    if(!empty($_GET['keywords'])){
      $where['realname'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel
    ->where($where)
    ->field("id,realname,username,special,status,create_time")
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();
    $pageInfo = array(
        "pageSize"  =>$pageSize,
        "page"      =>$page,
        "total"     =>intval($total)
    );
    $cateList = $this->catelist("idkey");
    if($total > 0 ){
      foreach($list as $key=>$val) {
        if($val["special"]){
          $tempArr = explode(",",$val["special"]);
          $tempText = '';
          foreach($tempArr as $v){
            $tempText .= $cateList[$v]."/";
          }
          $list[$key]["belong_cate"] = trim($tempText,"/");
        }
      }
    }
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
        "list"  =>$list,
        "cateList"  =>$cateList,
        "pageInfo"  =>$pageInfo
    )
    );
    $this->ajaxReturn($backData);
  }

  // 顾问分类列表
  protected function catelist($type=""){
    $model = M("Adviser");
    $where = array(
      "isdelete"  =>0,
      "status"    =>1
    );
    if($type == 'idkey') {
      $list = $model
      ->where($where)
      ->fetchSql(false)
      ->order("sort,id desc")
      ->getField("id,title");
    }else {
      $list = $model
      ->field("id,title")
      ->where($where)
      ->fetchSql(false)
      ->order("sort,id desc")
      ->select();
    }
    return $list;
  }

  public function getCateList(){
    $list = $this->catelist();
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "list"      =>$list
      )
    );
    $this->ajaxReturn($backData);
  }

  // 类别详情
  public function edit(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("AdviserUser")
    ->field("id,realname,username,special,status")
    ->where(array('id'=>$id))
    ->find();
    if(!$info) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
      $this->ajaxReturn($backData);
    }
    if($info["special"]){
      $info["special"] = explode(",",$info["special"]);
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
    $mainModel = M("AdviserUser");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }
    if($mainModel->password){
      $mainModel->password = md5($this->requestData["password"]);
    }
    if($this->requestData["newpassword"]) {
      $mainModel->password = md5($this->requestData["newpassword"]);
    }
    if(count($this->requestData["special"]) > 0){
      $mainModel->special = implode(",",$this->requestData["special"]);
    }else {
      $mainModel->special = "";
    }
    if(isset($mainModel->id) && !is_null($mainModel->id)){
      $id = intval($mainModel->id);
      $result = $mainModel->where(array("id"=>$id))->fetchSql(false)->save();
    }else {
      $result = $mainModel->fetchSql(false)->add();
      $id = $result;
    }
    if($result !== false){
      $info = $mainModel->where(array("id"=>$id))->find();
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
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
    $result = M("Adviser")
    ->where("id=$id")
    ->data(array("isdelete"=>1))
    ->fetchSql(false)
    ->save();
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