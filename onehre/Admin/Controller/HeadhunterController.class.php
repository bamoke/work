<?php 
/*
 * 猎头职位
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 23:42:10
 */
namespace Admin\Controller;
use Admin\Common\Auth;
// use Think\Controller;
class HeadhunterController extends Auth {
  public function vlist(){
    $pageSize = 15;
    $mainModel = M("Headhunter");
    $page = I("get.p/d",1);
    $where = array();
    if(!empty($_GET['keywords'])) {
      $where['title'] = array('like','%'.I("get.keywords").'%');
    }
    $list = $mainModel
    ->field("id,title,work_addr,wages,edu,comname,create_time,status")
    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();

    foreach($list as $key=>$val) {
      $list[$key]["work_wage"] = C("DATA_WAGE_NAME")[$val['wages']];
      $list[$key]["work_edu"] = C("DATA_EDU_NAME")[$val['edu']];
    }
    $pageInfo = array(
      "total" =>intval($total),
      "pageSize"  =>$pageSize,
      "page"    =>$page
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
   * data
   */
  public function fetch_data_arr (){
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"    =>array(
        "wageArr"      =>C("DATA_WAGE_NAME"),
        "eduArr"        =>C("DATA_EDU_NAME"),
        "expArr"      =>C("DATA_EXP_NAME")
      )
    );
    $this->ajaxReturn($backData);
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
    $info = M("Headhunter")->where(array('id'=>$id))->fetchSql(false)->find();
    $info["edu"] = intval($info['edu']);
    $info["wages"] = intval($info['wages']);
    $info["experience"] = intval($info['experience']);
    if($info) {
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "data"    =>array(
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


  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("Headhunter");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    if(isset($mainModel->id) && !is_null($mainModel->id)){
      $id = (int)$mainModel->id;
      $result = $mainModel->where(array("id"=>$id))->save();
    }else {
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
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = I("get.id");
    $del = M("Headhunter")->fetchSql(false)->delete($id);
    if($del !== false) {
      $backData = array(
        'code'      => 200,
        "msg"       => "ok"    
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "操作失败"    
      );
    }
    $this->ajaxReturn($backData);
  }


  /**
   * 联系方式
   */
  public function contact(){
    $info = M("HeadhunterContact")->find(1);
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "info"  =>$info
      )    
    );
    $this->ajaxReturn($backData);  
  }

  public function save_contact(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("HeadhunterContact");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }
    $updateResult = $mainModel->fetchSql(false)->save();
    if($updateResult !== false) {
      $backData = array(
        'code'      => 200,
        "msg"       => "ok"    
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "操作失败"    
      );
    }
    $this->ajaxReturn($backData);

  }




  //==================//
}