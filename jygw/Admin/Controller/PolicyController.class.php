<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class PolicyController extends Auth {
  public function getlist(){
    $pageSize = 15;
    $mainModel = M("Policy");
    $page = I("get.page/d",1);
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['N.title'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel
    ->field("N.id,N.cate_id,N.title,N.status,N.click,N.create_time,MC.name as catename,MC.parent_name as parent_cate")
    ->alias("N")
    ->join("__POLICY_CATE__ as MC on N.cate_id=MC.id")
    ->where($where)
    ->page($page,$pageSize)
    ->order("N.id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->alias("N")->where($where)->count();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'info'      => array(
          "list"  =>$list,
          "total" =>intval($total),
          "pageSize"  =>$pageSize
      )
    );
    $this->ajaxReturn($backData);
  }

  // 文章分类列表
  public function catelist(){
    $model = M("PolicyCate");
    $parentList = ["珠海市","金湾区"];
    $list = $model->field("id,parent_name,name")->where(array("status"=>1))->fetchSql(false)->select();
    $cateList = array();
    foreach($parentList as $parent) {
      $children = array();

      foreach($list as $key=>$val) {
        if($val["parent_name"] == $parent) {
          $children[] = array(
            "value"=>$val['id'],
            "label"=>$val["name"],
          );
        }
      }
      $cateList[] = array(
        "value"=>$parent,
        "label"=>$parent,
        "children"=>$children
      );
    }


    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$cateList
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
    $info = M("Policy")
    ->alias("P")
    ->field("P.*,CATE.name as cate_name,CATE.parent_name as parent_name")
    ->join("__POLICY_CATE__ as CATE on P.cate_id = CATE.id")
    ->where(array('P.id'=>$id))
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
    if($info['thumb']) {
      foreach($thumbList as $key=>$val){
        $temp = array(
          "name"  =>$val,
          "url"   =>"http://".C("OSS_BUCKET").".".C("OSS_ENDPOINT")."/".$val
        );
        array_push($newThumbList,$temp);
      }
    }

    $info["cate_selected"] = [$info["parent_name"],$info['cate_id']];

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
    $mainModel = M("Policy");
    $postData = $this->requestData;
    $fileInfo = explode('.',$postData['file']);

    $postData['cate_id'] = $postData["cate_selected"][1];
    $postData['type'] = $fileInfo[1];
    $createData = $mainModel->create($postData);
    if(!$createData) {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据创建错误"    
      );
      $this->ajaxReturn($backData);   
    }


    // 过滤内容中的style标签
    if($mainModel->content){
      $replacePattner = '/<(style.*?)>(.*?)<(\/style.*?)>/si';
      $mainModel->content = preg_replace($replacePattner,'',$mainModel->content);
    }
    if(isset($mainModel->id) && !is_null($mainModel->id)){
      $id = intval($mainModel->id);
      $result = $mainModel->where(array("id"=>$id))->fetchSql(false)->save();
    }else {
      $result = $mainModel->fetchSql(false)->add();
      // var_dump($result);
      // exit();
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
    $result = M("Policy")->fetchSql(false)->delete($id);
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