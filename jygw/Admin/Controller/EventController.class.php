<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class EventController extends Auth {
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 15;
    $mainModel = M("Event");
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['title'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel
    ->field("id,title,status,click,create_time,enroll_start_date,enroll_end_date,enroll_num")
    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();
    // 计算活动状态
    if(count($list)) {
      foreach($list as $key=>$val){
        if(strtotime($val['enroll_end_date']) < time()) {
          $stage = 2;
          $stageTxt = "已结束";
        }else {
          if(strtotime($val['enroll_start_date']) > time()) {
            $stage = 0;
            $stageTxt = "未开始";
          }else {
            $stage = 1;
            $stageTxt = "进行中";
          }
        }
        $list[$key]['stage'] = $stage;
        $list[$key]['stageTxt'] = $stageTxt;
      }
    }

    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "pageInfo"  =>array(
            "total"   =>intval($total),
            "page"    =>$page,
            "pageSize"  =>$pageSize
          )
      )
    );
    $this->ajaxReturn($backData);
  }



  // 活动详情
  public function edit(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("Event")
    ->where(array('id'=>$id))
    ->find();
    if(!$info) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
      $this->ajaxReturn($backData);
    }
    $thumbList = explode(";",$info['thumb']);
    $newThumbList = array();
    if(count($thumbList)) {
      foreach($thumbList as $key=>$val){
        if($val) {
          $temp = array(
            "name"  =>$val,
            "url"   =>"http://".C("OSS_BUCKET").".".C("OSS_ENDPOINT")."/".$val
          );
          array_push($newThumbList,$temp);
        }
      }
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
    $mainModel = M("Event");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    // 过滤内容中的style标签
    $replacePattner = '/<(style.*?)>(.*?)<(\/style.*?)>/si';
    $mainModel->content = preg_replace($replacePattner,'',$mainModel->content);
    if(isset($mainModel->id) && !is_null($mainModel->id)){
      $id = intval($mainModel->id);
      $result = $mainModel->where(array("id"=>$id))->fetchSql(false)->save();
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
    if(empty($_GET['id'])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"
      );  
      return $this->ajaxReturn($backData);  
    }
    $id= I("get.id");
    $result = M("Event")->fetchSql(false)->delete($id);
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