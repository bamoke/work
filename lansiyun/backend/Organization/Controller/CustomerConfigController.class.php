<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 * 企业服务配置
 * 账号数目改为单独设置，不从产品那边设置
 */
namespace Organization\Controller;
use Organization\Common\Auth;
class CustomerConfigController extends Auth {

  protected $accountPrice = 5;//设置单个账号价格
  protected $billPrice = 100;//设置万条单据量价格

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
    $comName = M("CompanyInfo")
    ->where(array("id"=>$comId))
    ->getField('title');
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
        "configid" =>intval($configId),
        "comname" =>$comName
      )
    );
    $this->ajaxReturn($backData);
  }

  /**产品列表 */
  public function product(){

    $condition = array(
      "status"  =>1
    );
    $productList = M("PlatformProduct")
    ->field("title,bill_num,account_num,id,price")
    ->where($condition)
    ->order("price,id")
    ->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
        "list" =>$productList,
        "accountPrice"  =>$this->accountPrice,
        "billPrice"  =>$this->billPrice
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
    ->field("C.*,C.account_num + P.account_num as account_num,C.bill_num + P.bill_num as bill_num,P.title as product_name,P.module as product_module,A.price as product_price")
    ->join("__AGENT_PRICE__ A on A.id= C.product")
    ->join("__PLATFORM_PRODUCT__ as P on P.id = A.object_id")
    ->where(array("C.id"  =>$id))
    ->fetchSql(false)
    ->find();

    if(!$configInfo) {
      $newConfigInfo = array("id"=>null);
      $newModuleList = array();
    }else {

      // 获取模块信息
      $productModuleArr = explode(",",$configInfo["product_module"]);
      $configModuleArr = explode(",",$configInfo["module"]);
      $moduleArr = array_unique(array_merge($productModuleArr,$configModuleArr));
      $moduleCondition = array(
        "id"=>array("in",$moduleArr),
        "status"  =>1
      );
      $moduleList = M("PlatformModule")
      ->where($moduleCondition)
      ->order("sort,id")
      ->fetchSql(false)
      ->select();
      $newModuleList = $this->module_iteration($moduleList);

      // 计算剩余天数
      $restDays = date_diff(date_create(date("Y-m-d",$configInfo["product_end"])),\date_create());
      $newConfigInfo = array(
        "id"            =>$configInfo["id"],
        "productId"     =>$configInfo["product"],
        "productName"   =>$configInfo["product_name"],
        "product_deadline"      =>date("Y年m月d日 00:00:00",$configInfo["product_end"]),
        "product_start"      =>date("Y年m月d日",$configInfo["product_start"]),
        "product_expired"       =>$configInfo["product_end"] < time(),
        "product_price"       =>$configInfo["product_price"],
        "restDays"        =>$restDays->days,
        "accountNum"    =>intval($configInfo['account_num']),
        "accountPrice"  =>$this->accountPrice,
        "billNum"    =>intval($configInfo['bill_num']),
        "billPrice"  =>$this->billPrice,
        "module"  =>$newModuleList
      );

    }

    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
        "info"  =>$newConfigInfo,
        "orgInfo"=>$orgInfo
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

    $orgId = $this->userInfo['org_id'];
    $agentId = M("OrgInfo")->where("id=$orgId")->getField("agent_id");

    // 计算费用金额(先转分)
    $productCondition = array(
      "id"   =>$requestData["product"]
    );
    $productPrice = M("PlatformProduct")->where($productCondition)->getField("price");
    $accountPrice = $this->accountPrice;
    $billPrice = $this->billPrice;
    $totalAmount = ($productPrice*100 + intval($requestData["account_num"]) * $accountPrice*100 + intval($requestData["bill_num"]) * $billPrice*100) * $year;

    // 检测服务机构账户余额
    $balance = M("OrgInfo")->where(array("id"=>$this->userInfo['org_id']))->getField("balance");
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
    $mainModel->bill_num = $requestData["bill_num"];

    $mainModel->com_id = $comId;

    $mainModel->update_by = $this->userInfo["username"];
    $mainModel->update_time = date("y-m-d H:i:s",time());
    $mainModel->create_by = $this->userInfo["username"];
    
    
    M()->startTrans();
    // 账户更新
    $updateCompany = M("OrgInfo")->where(array("id"=>$orgId))->setField("balance",$newBalance);
    
    // 平台产品购买数更新
    $updateProduct = M("PlatformProduct")->where(array("id"=>$requestData["product"]))->setInc("buy_num",1);



    // Insert 配置信息
    $insertId = $mainModel->fetchSql(false)->add();

    // Insert Log
    $insertLog = $this->_capital_log();

    if($insertId && $updateCompany && $updateProduct &&  $insertLog){
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
          "price"   =>$val["price"],
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
   * 获取部分数据
   */
  public function getpartdata(){
    if(empty($_GET['configid']) || empty($_GET["type"])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $type=I("get.type");
    $configId = I("get.configid");
    $orgId = $this->userInfo['org_id'];
    $agentId = M("OrgInfo")->where("id=$orgId")->getField("agent_id");

    $configInfo = M("CompanyConfig")
    ->alias("C")
    ->field("C.*,P.module as product_module,A.price as product_price,P.account_num as product_account_num")
    ->join("__AGENT_PRICE__ A on A.id = C.product")
    ->join("__PLATFORM_PRODUCT__ as P on P.id = A.object_id")
    ->where(array("C.id"  =>$configId))
    ->fetchSql(false)
    ->find();

    if($type== "product") {
      // 获取当前产品价格，只选择比现在贵的产品
      $curProductPrice = $configInfo["product_price"];
      $productCondition = array(
        "A.id"  =>array("neq",$configInfo['product']),
        "A.price" =>array("gt",$curProductPrice)
      );
      $list = M("AgentPrice")
      ->field("A.id,A.price,P.title")
      ->alias("A")
      ->join("__PLATFORM_PRODUCT__ P on P.id=A.object_id")
      ->where($productCondition)
      ->order("A.price,A.id")
      ->select();
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "data"      =>array(
          "list"    =>$list
        )    
      );
      $this->ajaxReturn($backData);
    }elseif($type== "module") {

        // 获取正在使用的模块信息
        $curModuleStr = trim($configInfo["product_module"] . ',' . $configInfo["module"],',');
        $curModuleArr = array_unique(explode(",",$curModuleStr));

        // 获取系统模块
        $platformModule = M("PlatformModule")
        ->where(array("status"=>1))
        ->order("sort,id")
        ->select();

        // 代理商设置模块
        $agentModuleCondition = array(
          "agent_id"  =>$agentId,
          "type"      =>2
        );
        $agentModule = M("AgentPrice")
        ->where($agentModuleCondition)
        ->select();


        // 所有可用模块
        $allModuleList = array();
        foreach($platformModule as $key=>$val) {
          if($val['pid'] == 0 ){
            array_push($allModuleList,$val);
          }else {
            foreach($agentModule as $k=>$v) {
              $tempArr = $val;
              if($val['id'] == $v["object_id"]) {
                $tempArr["price"] = $v["price"];
                array_push($allModuleList,$tempArr);
              }
            }
          }
        }


        // var_dump($curModuleArr);
        // exit();
  

        // 过滤出未添加的模块
        $newModuleList = $this->module_iteration($allModuleList);
        $myList = array();
        
        foreach($newModuleList as $key=>$val) {
          $childTempArr = array();
          $item = $val;
          if(count($val['children'])) {
            foreach($val['children'] as $k=>$v) {
              if(!in_array($v["id"],$curModuleArr)) {
                array_push($childTempArr,$v);
              }
            }
          }
          if(count($childTempArr)) {
            $item["children"] = $childTempArr;
            $myList[] = $item;
          }
          
        }
        $backData = array(
          'code'      => 200,
          "msg"       => "success",
          "data"      =>array(
            "list"    =>$myList
          )    
        );
        $this->ajaxReturn($backData);


    }

  }


  /**
   * 数据部分更新
   */
  public function savepart(){
    $requestData = $this->requestData;
    $configId = $requestData['configid'];
    $orgId = $this->userInfo['org_id'];
    $agentId = M("OrgInfo")->where("id=$orgId")->getField("agent_id");
    $configModel = M("CompanyConfig");
    
    $configInfo = $configModel
    ->alias("C")
    ->field("C.*,P.module as product_module,P.price as product_price,P.account_num as product_account_num")
    ->join("__AGENT_PRICE__ A on A.object_id= C.product and A.type=1")
    ->join("__PLATFORM_PRODUCT__ as P on P.id = C.product")
    ->where(array("C.id"  =>$configId))
    ->fetchSql(false)
    ->find();

    // 计算剩余天数
    $restDayObkect = date_diff(date_create(date("Y-m-d",$configInfo["product_end"])),\date_create());
    $restDays = $restDayObkect->days;
    // 获取服务机构账户余额
    $balance = M("OrgInfo")->where(array("id"=>$this->userInfo['org_id']))->getField("balance");

    // product save
    if($requestData['type'] == "product") {
      $newProductInfo = M("PlatformProduct")->where(array("id"=>$requestData['productid']))->find();
      $newProductPrice = $newProductInfo["price"];
      $oldProductPrice = $configInfo["product_price"];
      //计算金额
      $amount = intval(($newProductPrice*100 - $oldProductPrice*100)/365)*$restDays;
      // 检测账户余额
      $newBalance = (floatval($balance) * 100 - $amount) /100;
      if($newBalance < 0 ) {
        $backData = array(
          'code'      => 13001,
          "msg"       => "账户余额不足"    
        );
        $this->ajaxReturn($backData);
      }



      M()->startTrans();
      // 账户更新
      $updateOrg = M("OrgInfo")->where(array("id"=>$orgId))->setField("balance",$newBalance);
      
      // 产品购买数更新
      $updateProduct = M("PlatformProduct")->where(array("id"=>$requestData['productid']))->setInc("buy_num",1);

      // 更新配置信息
      $configUpdateData = array(
        "product"   =>$requestData['productid']
      );
      $updateConfig = $configModel->where("id=$configId")->data($configUpdateData)->save();
      if($updateOrg && $updateProduct && $updateConfig) {
        M()->commit();

        // 获取模块信息
        $producModuleArr = explode(",",$newProductInfo["module"]);
        if($configInfo["module"]) {
          $configModuleArr = explode(",",$configInfo["module"]);
          $moduleArr = array_merge($producModuleArr,$configModuleArr);
        }else {
          $moduleArr = $producModuleArr;
        }
        $moduleCondition = array(
          "id"=>array("in",$moduleArr),
          "status"  =>1
        );
        $moduleList = M("PlatformModule")->where($moduleCondition)->order("sort,id")->fetchSql(false)->select();
        $newModuleList = $this->module_iteration($moduleList);

        // 计算账号数
        $newAccountNum = $newProductInfo['account_num'] + $configInfo["account_num"];
        $backData = array(
          'code'      => 200,
          "msg"       => "ok",
          "data"      => array(
            "info"  =>array(
              "productId" =>$newProductInfo["id"],
              "productName"   =>$newProductInfo["title"],
              "product_price" =>$newProductInfo["price"],
              "module"        =>$newModuleList,
              "accountNum"    =>$newAccountNum
            )
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

    /*======================================================*/

    }elseif($requestData['type'] == "account") {
        $addAccountNum = $requestData['num'];
        //计算金额
        $payAmount = intval($this->accountPrice * $addAccountNum * 100 / 365)*$restDays;
        // 检测账户余额
        $newBalance = (floatval($balance) * 100 - $payAmount) /100;
        if($newBalance < 0 ) {
          $backData = array(
            'code'      => 13001,
            "msg"       => "账户余额不足"    
          );
          $this->ajaxReturn($backData);
        }

        M()->startTrans();
        // 账户更新
        $updateOrg = M("OrgInfo")->where(array("id"=>$orgId))->setField("balance",$newBalance);
        
        // 更新配置信息
        $configUpdateData = array(
          "account_num"   =>array("exp","account_num + $addAccountNum"),
          "update_by"     =>$this->userInfo["username"],
          "update_time"     =>date("Y-m-d H:i:s",time())
        );
        $updateConfig = $configModel->where("id=$configId")->data($configUpdateData)->save();
        if($updateOrg && $updateConfig) {
          M()->commit();
          $backData = array(
            'code'      => 200,
            "msg"       => "ok"
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

    /*======================================================*/
    
    }elseif($requestData['type'] == "module") {

      // 检测数据
      if(!$requestData['module']) {
        $backData = array(
          'code'      => 13001,
          "msg"       => "请选择模块"    
        );
        $this->ajaxReturn($backData);
      }


      // 获取金额
      $newModule = array_unique(explode(",",$requestData['module']));
      $amountTotal = 0;
      $moduleList = M("AgentPrice")
      ->where(array("object_id"=>array("in",$newModule),"type"=>2,"agent_id"=>$agentId))
      ->select();
      foreach($moduleList as $key=>$val) {
        $amountTotal += $val["price"];
      }

      //计算金额
      $payAmount = floor($amountTotal * 100 / 365)*$restDays;
      // 检测账户余额
      $newBalance = (floatval($balance) * 100 - $payAmount) /100;
      if($newBalance < 0 ) {
        $backData = array(
          'code'      => 13001,
          "msg"       => "账户余额不足"    
        );
        $this->ajaxReturn($backData);
      }

      // 计算新模块
      
      if($configInfo["module"]) {
        $configModuleArr = explode(",",$configInfo["module"]);
        $moduleArr = array_merge($newModule,$configModuleArr);
      }else {
        $moduleArr = $newModule;
      }
      $moduleArr = array_unique($moduleArr);
      


      M()->startTrans();
      // 账户更新
      $updateOrg = M("OrgInfo")->where(array("id"=>$orgId))->setField("balance",$newBalance);
      
      // 更新配置信息
      $configUpdateData = array(
        "module"   =>implode(",",$moduleArr),
        "update_by"     =>$this->userInfo["username"],
        "update_time"     =>date("Y-m-d H:i:s",time())
      );
      $updateConfig = $configModel->where("id=$configId")->data($configUpdateData)->save();

      if($updateOrg && $updateConfig) {
        M()->commit();

        // 获取模块信息,产品模块 + 配置模块
        $producModuleArr = array_unique(explode(",",$configInfo["product_module"]));

        $moduleCondition = array(
          "id"=>array("in",array_merge($moduleArr,$producModuleArr)),
          "status"  =>1
        );
        $moduleList = M("PlatformModule")->where($moduleCondition)->order("sort,id")->fetchSql(false)->select();
        $newModuleList = $this->module_iteration($moduleList);

        $backData = array(
          'code'      => 200,
          "msg"       => "ok",
          "data"      =>array(
            "list"    =>$newModuleList
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

      /*======================================================*/
    }elseif($requestData['type'] == 'bill') {

      $addBillNum = $requestData['num'];
      //计算金额
      $payAmount = intval($this->billPrice * $addBillNum * 100 / 365)*$restDays;
      // 检测账户余额
      $newBalance = (floatval($balance) * 100 - $payAmount) /100;
      if($newBalance < 0 ) {
        $backData = array(
          'code'      => 13001,
          "msg"       => "账户余额不足"    
        );
        $this->ajaxReturn($backData);
      }

      M()->startTrans();
      // 账户更新
      $updateOrg = M("OrgInfo")->where(array("id"=>$orgId))->setField("balance",$newBalance);
      
      // 更新配置信息
      $configUpdateData = array(
        "bill_num"   =>array("exp","bill_num + $addBillNum"),
        "update_by"     =>$this->userInfo["username"],
        "update_time"     =>date("Y-m-d H:i:s",time())
      );
      $updateConfig = $configModel->where("id=$configId")->data($configUpdateData)->save();
      if($updateOrg && $updateConfig) {
        M()->commit();
        $backData = array(
          'code'      => 200,
          "msg"       => "ok"
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

  }
  /**
   * 费用记录
   * 服务商支出记录
   * 代理商收入记录
   * 平台收入记录
   */
  protected function _capital_log($billType){
    return true;
    // 订单
    $billData = array(
      "agent_id"  =>$agentId,
      "org_id"    =>$orgId,
      "bill_no"   =>$billNo,
      "trade_no"  =>$tradeNo,
      "channel_type"  =>$channelType,
      "type"      =>$billType,
      "goods_id"   =>$goodsId,
      "amount"      =>$amount,
      "create_time" =>time(),
      "create_by"   =>$createBy,
      "description" =>$description
    );
    $insertBill = M("PlatformBill")->data($billData)->add();

    // 服务商支出记录
    $insertOrgLog = M("OrgCapitalLog")->add();

    // 代理商收入记录
    $insertAgentLog = M("AgentCapitalLog")->add();

    // 平台收入记录
    $insertPlatformLog = M("PlatformCapitalLog")->add();

  }
  /**
   * 产品购买记录
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