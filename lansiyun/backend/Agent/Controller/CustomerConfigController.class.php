<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 * 企业服务配置
 * 账号数目改为单独设置，不从产品那边设置
 */
namespace Agent\Controller;
use Agent\Common\Auth;
class CustomerConfigController extends Auth {

  protected $accountPrice = 5;//设置单个账号价格

  public function index(){
    if(empty($_GET['comid'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $comId = I("get.comid");
    $configId = M("CompanyConfig")->where(array('com_id'=>$comId))->getField("id");
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
        "info" =>intval($configId)
      )
    );
    $this->ajaxReturn($backData);
  }

  /**产品列表 */
  public function product(){
    $productList = M("PlatformProduct")
    ->where(array("status"=>1))
    ->order("sort,id")
    ->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
        "list" =>$productList
      )
    );
    $this->ajaxReturn($backData);
  }
  /***
   * 配置详情
   */
  public function detail(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");

    $configInfo = M("CompanyConfig")
    ->alias("C")
    ->field("C.*,P.title as product_name,P.module as product_module")
    ->join("__PLATFORM_PRODUCT__ as P on P.id = C.product")
    ->where(array("C.id"  =>$id))
    ->fetchSql(false)
    ->find();
    // var_dump($configInfo);
    // exit();
    if(!$configInfo) {
      $newConfigInfo = array("id"=>null);
      $newModuleList = array();
    }else {

      // 获取模块信息
      $moduleArr = explode(",",$configInfo["product_module"]);
      // $moduleArr = explode(",",$configInfo["product_module"]);
      $moduleCondition = array(
        "id"=>array("in",$moduleArr),
        "status"  =>1
      );
      $moduleList = M("PlatformModule")->where($moduleCondition)->order("sort,id")->fetchSql(false)->select();
      $newModuleList = $this->module_iteration($moduleList);
      // var_dump($moduleArr);
      // exit();
      $newConfigInfo = array(
        "id"            =>$configInfo["id"],
        "productId"     =>$configInfo["product"],
        "productName"   =>$configInfo["product_name"],
        "product_deadline"      =>date("Y年m月d日 00:00:00",$configInfo["product_end"]),
        "product_start"      =>date("Y年m月d日",$configInfo["product_start"]),
        "product_expired"       =>$configInfo["product_end"] < time(),
        "accountNum"    =>intval($configInfo['account_num']),
        "account_deadline"      =>date("Y年m月d日",$configInfo["account_end"]),
        "account_expired"       =>$configInfo["account_end"] < time(),
        "module"  =>$newModuleList
      );

    }

    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
        "info"  =>$newConfigInfo
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
    $mainModel = M("CompanyConfig");
    $requestData = $this->requestData;
    $comId = $requestData["com_id"];
    $year = intval($requestData['year_num']);

    // 计算费用金额(先转分)
    $productPrice = M("PlatformProduct")->where(array("id"=>$requestData["product"]))->getField("price");
    $accountPrice = $this->accountPrice;
    $totalAmount = ($productPrice*100 + intval($requestData["account_num"]) * $accountPrice*100) * $year;
    $balance = M("CompanyInfo")->where(array("id"=>$comId))->getField("balance");
    $newBalance = (floatval($balance) * 100 - $totalAmount)/100 ;
    if($newBalance < 0 ) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "账户余额不足"    
      );
      $this->ajaxReturn($backData);
    }


    // 检测是否存在，不能重复添加
    $exist = $mainModel->where(array("com_id"=>$comId))->count();
    if($exist) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "不能重复创建"    
      );
      $this->ajaxReturn($backData);
    }

    // 计算业务期间
    $startTime = time();
    $endTime = strtotime("+ $year year");
    $mainModel->product = $requestData["product"];
    $mainModel->product_start = $startTime;
    $mainModel->product_end = $endTime;

    $mainModel->account_num = $requestData["account_num"];
    $mainModel->account_start = $startTime;
    $mainModel->account_end = $endTime;

    $mainModel->agent_id = $this->userInfo["agent_id"];
    $mainModel->com_id = $comId;

    $mainModel->update_by = $this->userInfo["username"];
    $mainModel->update_time = date("y-m-d H:i:s",time());
    $mainModel->create_by = $this->userInfo["username"];
    
    
    M()->startTrans();
    // 账户更新
    $updateCompany = M("CompanyInfo")->where(array("id"=>$comId))->setField("balance",$newBalance);
    
    // 产品购买数更新
    $updateProduct = M("PlatformProduct")->where(array("id"=>$requestData["product"]))->setInc("buy_num",1);

    // insert 配置信息
    $insertId = $mainModel->fetchSql(false)->add();
    // var_dump($insertId);
    // exit();
    if($insertId && $updateProduct && $updateProduct){
      M()->commit();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "data"      => array(
          "info"  =>intval($insertId)
        )
      );
      $this->ajaxReturn($backData);
    }else {
      M()->rollback();
      $backData = array(
        'code'      => 13002,
        "msg"       => "服务器错误",        
      );  
      $this->ajaxReturn($backData);   
    }
    
  }


  // 模块迭代器
  protected function module_iteration($array,$pid=0, $level=1, $max=3){
    $newArr = array();
    if($level >= $max) {return array();}
    if(!is_array($array) || count($array) === 0 ) return array();
    foreach($array as $key=>$val){
      if($val["pid"] == $pid) {
        $children = $this->module_iteration($array,$val['id'],$level+1);
        $parent = array(
          "id"      =>$val["id"],
          "pid"      =>$val["pid"],
          "title"   =>$val["name"],
          "sort"   =>$val["sort"],
          "expand"  =>true,
          "status"   =>$val["status"],
          "level"   =>$level,
          "children"   =>$children
        );
        array_push($newArr,$parent);
      }
    }
    return $newArr;
  }

  /**
   * 产品购买机构
   * type 1:开通服务;2:product;3:account
   * 
   */
  protected function product_log($data){
    
  }
  /**
   * 产品购买机构
   * amount
   * type +-
   * description
   * trad_no
   * datetime
   */
  protected function finance_log($data){

  }



  //==================//
}