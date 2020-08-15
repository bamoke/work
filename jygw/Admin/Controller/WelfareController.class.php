<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class WelfareController extends Auth {
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 15;
    $mainModel = M("Welfare");
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['title'] = array("like","%".$_GET["keywords"]."%");
    }
    $thumbBaseUrl = "http://".C("OSS_BUCKET").".".C("OSS_ENDPOINT")."/thumb/";
    $list = $mainModel
    ->field("id,title,status,addr,CONCAT('$thumbBaseUrl',thumb) as thumb")
    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();


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



  // 商家详情
  public function edit(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("Welfare")
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
    $mainModel = M("Welfare");
    $postData = $mainModel->create($this->requestData);
    if(!$postData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }

    // 修改前端传递的日期格式
    $mainModel->start_date = date("Y-m-d",date_timestamp_get(date_create($mainModel->start_date)));
    $mainModel->end_date = date("Y-m-d",date_timestamp_get(date_create($mainModel->end_date)));
    
    // 过滤内容中的style标签
    $replacePattner = '/<(style.*?)>(.*?)<(\/style.*?)>/si';
    // $mainModel->content = preg_replace($replacePattner,'',$mainModel->content);
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
    $result = M("Welfare")->fetchSql(false)->delete($id);
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