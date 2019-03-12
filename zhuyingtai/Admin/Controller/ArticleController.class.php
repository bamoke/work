<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class ArticleController extends Auth {
  public function vlist(){
    $pageSize = 15;
    $mainModel = M("News");
    $page = empty($_GET["p"]) ? 1 : (int)$_GET["p"];
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['N.title'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel
    ->field("N.id,N.cid,N.title,N.status,N.view_num,N.create_time,NC.name as catename")
    ->alias("N")
    ->join("__NEWS_CATE__ as NC on N.cid=NC.id")
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
    $model = M("NewsCate");
    $list = $model->field("id,name")->where(array("status"=>1))->fetchSql(false)->select();
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'info'      => array(
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
    $info = M("News")->where(array('id'=>$id))->find();
    if($info) {
      $backData = array(
        'code'      => 200,
        "msg"       => "success",
        "info"      =>$info    
      );
    }else {
      $backData = array(
        'code'      => 13001,
        "msg"       => "数据获取异常"    
      );
    }
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
    $mainModel = M("News");
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
    $result = M("News")->fetchSql(false)->delete($id);
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