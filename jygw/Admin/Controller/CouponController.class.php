<?php
namespace Admin\Controller;
use Admin\Common\Auth;

Class CouponController extends Auth {

    /**
     * 列表
     */
    public function vlist(){
      $page = I("get.page/d",1);
      $pageSize = 15;
      $mainModel = M("Coupon");
      $where = array();
      $businessId = I("get.bid/d");
      if($businessId) {
        $where['C.b_id'] =$businessId;
      }
      $keywords = I("get.keywords");
      if(!empty($keywords)) {
        $businessIdArr = M("Welfare")->where(array('title'=>array('like','%'.$keywords.'%')))->getField("id",true);
        $where["C.b_id"] = array('in',$businessIdArr);
      }
      $list = $mainModel
      ->alias("C")
      ->join("LEFT JOIN __WELFARE__ as B on B.id = C.b_id")
      ->field("C.*,B.title as businessname")
      ->where($where)
      ->page($page,$pageSize)
      ->order("C.id desc")
      ->fetchSql(false)
      ->select();
      $total = $mainModel->alias("C")->where($where)->count();
  
  
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

    /**
     * 使用记录
     */
    public function record(){
        $page = I("get.page/d",1);
        $pageSize = 15;
        $mainModel = M("CouponRecord");
        $where = array();
        if(!empty($_GET['bid'])){
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

    // 数据保存
  public function save(){
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("Coupon");
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
        "msg"       => "ok",
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

  // 详情
  public function detail(){
    if(empty($_GET['id'])) {
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $id = I("get.id");
    $info = M("Coupon")
    ->find($id);
    if(!$info) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
      $this->ajaxReturn($backData);
    }
    $info["title"] = intval($info["title"]);
    $info["num"] = intval($info["num"]);
    $backData = array(
      'code'      => 200,
      "msg"       => "success",
      "data"      =>array(
        "info"      =>$info
      )
    );
    $this->ajaxReturn($backData);
  }


}