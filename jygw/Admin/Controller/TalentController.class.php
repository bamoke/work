<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class TalentController extends Auth {
  protected $talentType = array(
    "1" =>"产业类",
    "2" =>"农技类",
    "3" =>"党政类",
    "4" =>"社工类",
    "5" =>"教育类",
    "6" =>"卫生类",
  );

  protected $verifyName = array(
    "1" =>array(
      "name"  =>"待平台审核",
      "style" =>"default"
    ),
    "2" =>array(
      "name"  =>"平台审核未通过",
      "style" =>"error"
    ),
    "3" =>array(
      "name"  =>"平台审核通过",
      "style" =>"info"
    ),
    "4" =>array(
      "name"  =>"待政府审核",
      "style" =>"info"
    ),
    "5" =>array(
      "name"  =>"政府审核未通过",
      "style" =>"error"
    ),
    "6" =>array(
      "name"  =>"审核通过",
      "style" =>"success"
    )
  );


  /***
   * 申请记录
   */
  public function log(){
    $page = I("get.page/d",1);
    $pageSize = 15;
    $mainModel = M("TalentCard");
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['realname'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel

    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();


    foreach($list as $key=>$val){
      $list[$key]['typename'] = $this->talentType[$val['type']];
      $list[$key]['verifyname'] = $this->verifyName[$val['verify_status']];
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


    /***
   * 申请记录
   */
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 15;
    $mainModel = M("TalentCard");
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['realname'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel

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