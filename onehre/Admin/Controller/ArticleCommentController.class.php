<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 23:32:40
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class ArticleCommentController extends Auth {
  public function vlist(){
    $pageSize = 15;
    $mainModel = M("NewsComment");
    $page = empty($_GET["p"]) ? 1 : (int)$_GET["p"];
    $where = array();
    $list = $mainModel
    ->field("NC.*,M.username,N.title")
    ->alias("NC")
    ->join("__NEWS__ as N on NC.news_id=N.id")
    ->join("__MEMBER__ as M on NC.uid=M.id")
    ->where($where)
    ->page($page,$pageSize)
    ->order("N.id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->alias("NC")->where($where)->count();
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

  public function deleteone(){
    if(empty($_GET["id"])){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);     
    }
    $id = I("get.id");
    $del = M("NewsComment")->delete($id);
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






  //==================//
}