<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Organization\Controller;
use Organization\Common\Auth;
class CustomerController extends Auth {
  public function vlist(){
    $mainModel = M("CompanyInfo");
    $adminInfo = $this->userInfo;

    $pageSize = 15;
    $page = I("get.p/d",1);
    $where = array(
      "INFO.org_id"  =>$adminInfo["org_id"]
    );
    if(!empty($_GET['keywords'])){
      $where['INFO.title'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel
    ->alias("INFO")
    ->field("INFO.*,CONF.id as config_id")
    ->join("__COMPANY_CONFIG__ as CONF on CONF.com_id = INFO.id","LEFT")
    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->alias("INFO")->where($where)->count();
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
   * 获取代理商品信息
   */
  public function product(){
    $model = M("PlatformProduct");
    $list = $model
    ->field("id,title,description,price")
    ->where(array("status"=>1))
    ->fetchSql(false)
    ->order("sort,id")
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
    $info = M("CompanyInfo")->where(array('id'=>$id))->find();
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
    $mainModel = M("CompanyInfo");
    $dataResult = $mainModel->create($this->requestData);
    if(!$dataResult) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }


    $mainModel->update_by = $this->userInfo["username"];
    $mainModel->update_time = date("y-m-d H:i:s",time());

    if(isset($mainModel->id) && !is_null($mainModel->id)){
      $id = intval($mainModel->id);
      $result = $mainModel->where(array("id"=>$id))->fetchSql(false)->save();
    }else {
      $objectId = date('ymdHis').str_pad($this->userInfo["id"],6,"0",STR_PAD_LEFT).rand(0,9);
      $mainModel->objectid = $objectId;
      $mainModel->org_id = $this->userInfo["org_id"];
      $mainModel->create_by = $this->userInfo["username"];
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







  //==================//
}